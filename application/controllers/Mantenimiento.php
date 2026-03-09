<?php
/**
 * CONTROLADOR: Mantenimiento.php
 * UBICACIÓN: application/controllers/Mantenimiento.php
 *
 * PROPÓSITO: Maneja la exportación del Programa Anual de Mantenimiento de Laboratorios a PDF.
 *
 * REQUISITOS:
 *   - DOMPDF instalado via Composer (vendor/dompdf/dompdf)
 *   - Logos en: assets/img/logos/
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// ─── PASO 1: Cargar DOMPDF ────────────────────────────────────────────────────
// Asegúrate de tener en application/config/autoload.php:
//   $autoload['helper'] = array('url', 'html');
// Y en composer.json:
//   "require": { "dompdf/dompdf": "^2.0" }
// Luego ejecuta: composer install

require_once APPPATH . '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Mantenimiento extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Carga el modelo si necesitas datos de BD
        // $this->load->model('Mantenimiento_model');
    }

    // ─── MÉTODO PRINCIPAL: Muestra el formulario ──────────────────────────────
    public function index() {
        $this->load->view('mantenimiento/formulario');
    }

    // ─── MÉTODO: Exportar PDF ─────────────────────────────────────────────────
    /**
     * CÓMO LLAMAR DESDE FORMULARIO:
     *   <form method="POST" action="<?= site_url('mantenimiento/exportar_pdf') ?>">
     *
     * RECIBE por POST:
     *   - anio          : Año del programa (ej. 2025)
     *   - laboratorio   : Nombre del laboratorio
     *   - edificio      : Edificio / Campus
     *   - responsable   : Nombre del responsable
     *   - revisor       : Nombre del revisor
     *   - autorizo      : Nombre de quien autorizó
     *   - actividades[] : Array de actividades (máx. 8)
     *     Cada actividad:
     *       - numero        : Número de la actividad
     *       - laboratorio   : Nombre del sub-laboratorio
     *       - actividad     : Descripción de la actividad
     *       - meses_planeado[]: Array con meses marcados (1-12)
     *       - meses_realizado[]: Array con meses marcados (1-12)
     *       - observaciones : Observaciones
     */
    public function exportar_pdf() {

        // ── 1. Recopilar datos del POST ────────────────────────────────────────
        $datos = [
            'anio'        => $this->input->post('anio')        ?? date('Y'),
            'laboratorio' => $this->input->post('laboratorio') ?? '',
            'edificio'    => $this->input->post('edificio')    ?? '',
            'responsable' => $this->input->post('responsable') ?? '',
            'revisor'     => $this->input->post('revisor')     ?? '',
            'autorizo'    => $this->input->post('autorizo')    ?? '',
            'actividades' => $this->input->post('actividades') ?? [],
        ];

        // ── 2. Limitar a máximo 8 actividades ─────────────────────────────────
        $datos['actividades'] = array_slice($datos['actividades'], 0, 8);

        // ── 3. Convertir logos a Base64 (CRÍTICO para DOMPDF) ─────────────────
        // DOMPDF no carga imágenes por ruta relativa cuando genera PDF en memoria.
        // La solución es convertir las imágenes a base64 y embeber en el HTML.
        //
        // DÓNDE COLOCAR LOS LOGOS:
        //   assets/img/logos/logo_uptlax.png   ← Logo izquierdo UPTLAX
        //   assets/img/logos/logo_sgc.png      ← Logo derecho SGC
        //
        // RUTA FÍSICA DESDE CI3:
        //   FCPATH . 'assets/img/logos/logo_uptlax.png'
        //   donde FCPATH = ruta absoluta al index.php del proyecto
        $datos['logo_uptlax_b64'] = $this->_imagen_a_base64(
            FCPATH . 'assets/img/logos/logo_uptlax.png'
        );
        $datos['logo_sgc_b64'] = $this->_imagen_a_base64(
            FCPATH . 'assets/img/logos/logo_sgc.png'
        );

        // ── 4. Generar el HTML de la vista ────────────────────────────────────
        // load->view() con tercer parámetro TRUE retorna el HTML como string
        $html = $this->load->view('mantenimiento/pdf_template', $datos, TRUE);

        // ── 5. Configurar DOMPDF ───────────────────────────────────────────────
        $opciones = new Options();
        $opciones->set('isHtml5ParserEnabled', true);   // Parser moderno HTML5
        $opciones->set('isPhpEnabled', false);           // Seguridad: no ejecutar PHP
        $opciones->set('defaultFont', 'Arial');          // Fuente por defecto
        $opciones->set('defaultPaperSize', 'letter');    // Tamaño carta
        $opciones->set('defaultPaperOrientation', 'landscape'); // Horizontal (más columnas)

        $dompdf = new Dompdf($opciones);

        // ── 6. Cargar HTML y renderizar ───────────────────────────────────────
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('letter', 'landscape'); // Orientación horizontal
        $dompdf->render();

        // ── 7. Forzar descarga del PDF ────────────────────────────────────────
        $nombre_archivo = 'Programa_Anual_Mantenimiento_' . $datos['anio'] . '.pdf';

        // Limpiar el buffer de salida antes de enviar el PDF
        if (ob_get_length()) ob_clean();

        $dompdf->stream($nombre_archivo, [
            'Attachment' => true, // TRUE = descarga, FALSE = abre en navegador
        ]);
        exit;
    }

    // ─── MÉTODO PRIVADO: Convertir imagen a Base64 ────────────────────────────
    /**
     * PROPÓSITO: Convierte una imagen PNG/JPG a string Base64 para embeber en HTML.
     * Esto resuelve el problema más común de DOMPDF: las imágenes no cargan
     * cuando se usa src con rutas relativas o URLs.
     *
     * @param  string $ruta_absoluta  Ruta física completa a la imagen
     * @return string                 String listo para usar en <img src="...">
     */
    private function _imagen_a_base64($ruta_absoluta) {
        if (!file_exists($ruta_absoluta)) {
            // Si el logo no existe, retorna string vacío (no rompe el PDF)
            log_message('error', 'Logo no encontrado: ' . $ruta_absoluta);
            return '';
        }

        $extension = strtolower(pathinfo($ruta_absoluta, PATHINFO_EXTENSION));
        $mime_types = [
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif'  => 'image/gif',
        ];
        $mime = $mime_types[$extension] ?? 'image/png';

        $datos_imagen = file_get_contents($ruta_absoluta);
        $base64       = base64_encode($datos_imagen);

        return 'data:' . $mime . ';base64,' . $base64;
    }
}
