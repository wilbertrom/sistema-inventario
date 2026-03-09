<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'libraries/fpdf/fpdf.php';

class Pdf extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('inventario_model');
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) { redirect('login'); }
    }

    public function index() { redirect('panel'); }

    public function generarPdfEquipos()
    {
        $laboratorio_id     = $this->session->userdata('laboratorio_id');
        $laboratorio_nombre = $this->session->userdata('laboratorio_nombre') ?:
                             ($laboratorio_id == 1 ? 'Open Source' : 'Mac');

        $nombre_encargado = $this->session->userdata('encargado_inventario') ?? '';

        $equipos = $this->inventario_model->obtener_equipos_por_laboratorio($laboratorio_id);
        if (empty($equipos)) {
            $this->session->set_flashdata('error', 'No hay equipos para generar PDF');
            redirect('panel/ver_inventario');
        }

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        $logo_path = APPPATH . 'libraries/fpdf/images/UPTlax_Logo.png';
        $sgc_path  = APPPATH . 'libraries/fpdf/images/sgc.png';

        $margen_tabla = 10;
        $ancho_total  = 277;
        $col_logo_izq = 55;
        $col_texto    = 167;
        $col_logo_der = 55;
        $y_enc = 5;
        $h_enc = 25;

        $pdf->Rect($margen_tabla, $y_enc, $ancho_total, $h_enc);
        $pdf->Line($margen_tabla + $col_logo_izq, $y_enc,
                   $margen_tabla + $col_logo_izq, $y_enc + $h_enc);
        $pdf->Line($margen_tabla + $col_logo_izq + $col_texto, $y_enc,
                   $margen_tabla + $col_logo_izq + $col_texto, $y_enc + $h_enc);

        if (file_exists($logo_path)) {
            $logo_w = 54;
            $logo_x = $margen_tabla + ($col_logo_izq - $logo_w) / 2;
            $pdf->Image($logo_path, $logo_x, $y_enc + 2, $logo_w);
        }
        if (file_exists($sgc_path)) {
            $sgc_w = 47;
            $sgc_x = $margen_tabla + $col_logo_izq + $col_texto + ($col_logo_der - $sgc_w) / 2;
            $pdf->Image($sgc_path, $sgc_x, $y_enc + 1, $sgc_w);
        }

        $x_texto = $margen_tabla + $col_logo_izq;
        $pdf->SetXY($x_texto, $y_enc + 5);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($col_texto, 5, utf8_decode('Subproceso de Apoyo: Laboratorios'), 0, 1, 'C');
        $pdf->SetX($x_texto);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($col_texto, 5, utf8_decode('Formato: Existencia de Materiales e Insumos de Laboratorios'), 0, 1, 'C');
        $pdf->SetX($x_texto);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($col_texto, 5, utf8_decode('Fecha de aprobación: octubre 2023'), 0, 1, 'C');

        $pdf->SetXY($margen_tabla, $y_enc + $h_enc + 4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(52, 6, utf8_decode('Nombre del Laboratorio:'), 0, 0, 'L');
        $x_linea_ini = $margen_tabla + 52;
        $x_linea_fin = $margen_tabla + $ancho_total;
        $y_linea     = $pdf->GetY() + 5;
        $pdf->Line($x_linea_ini, $y_linea, $x_linea_fin, $y_linea);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY($x_linea_ini, $y_enc + $h_enc + 4);
        $pdf->Cell($x_linea_fin - $x_linea_ini, 6, utf8_decode($laboratorio_nombre), 0, 1, 'C');

        $pdf->Ln(3);

        $ancho_cols         = 10 + 70 + 15 + 35 + 25 + 30 + 28 + 55;
        $margen_tabla_datos = ($pdf->GetPageWidth() - $ancho_cols) / 2;

        $pdf->SetX($margen_tabla_datos);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(10,  6, 'No.',                                   1, 0, 'C', true);
        $pdf->Cell(70,  6, utf8_decode('Descripción del producto'), 1, 0, 'C', true);
        $pdf->Cell(15,  6, 'Unidad',                                1, 0, 'C', true);
        $pdf->Cell(35,  6, utf8_decode('Código interno'),           1, 0, 'C', true);
        $pdf->Cell(25,  6, 'Marca',                                 1, 0, 'C', true);
        $pdf->Cell(30,  6, 'Proveedor',                             1, 0, 'C', true);
        $pdf->Cell(28,  6, utf8_decode('Estado del equipo'),        1, 0, 'C', true);
        $pdf->Cell(55,  6, 'Observaciones',                         1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 8);
        $numero = 1;
        foreach ($equipos as $row) {
            $pdf->SetX($margen_tabla_datos);
            $pdf->Cell(10, 6, $numero, 1, 0, 'C');
            $pdf->Cell(70, 6, utf8_decode($row->descripcion_producto ?? ''), 1, 0, 'L');
            $pdf->Cell(15, 6, utf8_decode($row->unidad ?? 'Pieza'), 1, 0, 'C');
            $codigo = $row->codigo_interno ?? '';
            if (strlen($codigo) > 14) {
                $pdf->SetFont('Arial', '', 6);
                $pdf->Cell(35, 6, $codigo, 1, 0, 'C');
                $pdf->SetFont('Arial', '', 8);
            } else {
                $pdf->Cell(35, 6, $codigo, 1, 0, 'C');
            }
            $pdf->Cell(25, 6, utf8_decode($row->marca         ?? ''), 1, 0, 'L');
            $pdf->Cell(30, 6, utf8_decode($row->proveedor     ?? ''), 1, 0, 'L');
            $pdf->Cell(28, 6, utf8_decode($row->estado        ?? ''), 1, 0, 'C');
            $pdf->Cell(55, 6, utf8_decode($row->observaciones ?? ''), 1, 1, 'L');
            $numero++;
        }

        // ================================================================
        // SECCIÓN FIRMAS
        //
        // Orden vertical (de arriba a abajo):
        //   nombre  → $y_base - 5  (justo encima, pegado a la línea)
        //   línea   → $y_base
        //   Elaboró → $y_base + 2
        //
        // Para ajustar distancia nombre↔línea:
        //   más pegado  → cambia -5 por -4
        //   más espacio → cambia -5 por -7
        // ================================================================
        $pdf->SetY(-40);
        $margen_firma = $margen_tabla_datos + 60;
        $margen_fecha = $margen_tabla_datos + 180;
        $y_base = $pdf->GetY();

        // Nombre ENCIMA — pegado a la línea
        $pdf->SetXY($margen_firma, $y_base - 5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(60, 5, utf8_decode($nombre_encargado), 0, 0, 'C');

        // Línea gruesa de firma
        $pdf->SetLineWidth(0.8);
        $pdf->Line($margen_firma, $y_base, $margen_firma + 60, $y_base);
        $pdf->SetLineWidth(0.2);

        // "Elaboró" debajo
        $pdf->SetXY($margen_firma, $y_base + 2);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(60, 5, utf8_decode('Elaboró'), 0, 0, 'C');

        // Cuadro de fecha
        $meses = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio',
                  'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $fecha_txt = 'Fecha de inventario: ' . date('d') . ' de '
                   . $meses[(int)date('n')] . ' de ' . date('Y');
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.8);
        $pdf->Rect($margen_fecha, $y_base - 5, 80, 10);
        $pdf->SetLineWidth(0.2);
        $pdf->SetXY($margen_fecha + 2, $y_base - 5 + 2);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(76, 6, utf8_decode($fecha_txt), 0, 0, 'L');

        if (ob_get_level()) ob_end_clean();

        $pdf->Output('I', 'reporte_equipos_' . $laboratorio_nombre . '_' . date('Y-m-d') . '.pdf');
        exit;
    }
}