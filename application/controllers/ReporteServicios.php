<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'libraries/fpdf/fpdf.php';

class ReporteServicios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ReporteServicios_model');
        $this->load->library('session');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $reportes = $this->ReporteServicios_model->obtener_reportes();
        if ($reportes === null) $reportes = array();

        $data['title']              = 'Reportes de Servicios';
        $data['reportes']           = $reportes;
        $data['laboratorio_nombre'] = $this->session->userdata('laboratorio_nombre');

        $this->load->view('templates/header', $data);
        $this->load->view('panel/ReporteAnual/vista_reportes', $data);
        $this->load->view('templates/footer', $data);
    }

    public function crear()
    {
        $año = (int) $this->input->post('año');

        if (empty($año) || $año < 2000 || $año > 2100) {
            $this->session->set_flashdata('error', 'Año inválido.');
            redirect('reporteservicios');
        }

        $existe = $this->ReporteServicios_model->existe_reporte(
            $año,
            $this->session->userdata('laboratorio_id')
        );

        if ($existe) {
            $this->session->set_flashdata('error', 'Ya existe un reporte para el año ' . $año . '.');
            redirect('reporteservicios');
        }

        $ok = $this->ReporteServicios_model->crear_reporte(
            $año,
            $this->session->userdata('laboratorio_id')
        );

        if ($ok) {
            $this->session->set_flashdata('success', 'Reporte ' . $año . ' creado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al crear el reporte.');
        }

        redirect('reporteservicios');
    }

    public function eliminar($id)
    {
        if (empty($id)) { show_404(); return; }

        $reporte = $this->ReporteServicios_model->obtener_reporte($id);
        if (empty($reporte)) { show_404(); return; }

        $this->ReporteServicios_model->eliminar_reporte($id);
        $this->session->set_flashdata('success', 'Reporte eliminado.');
        redirect('reporteservicios');
    }

    public function reporte($id)
    {
        if (empty($id)) { show_404(); return; }

        $data['title']   = 'Reporte';
        $data['reporte'] = $this->ReporteServicios_model->obtener_reporte($id);

        if (empty($data['reporte'])) { show_404(); return; }

        $this->load->view('templates/header', $data);
        $this->load->view('panel/ReporteAnual/vista_reporte', $data);
        $this->load->view('templates/footer', $data);
    }

    public function actualizar_mes($reporte_id, $mes)
    {
        if (empty($reporte_id) || empty($mes)) { show_404(); return; }

        $data['title']             = 'Actualizar mes';
        $data['reporte_id']        = $reporte_id;
        $data['mes']               = $mes;
        $data['servicios']         = $this->ReporteServicios_model->obtener_servicios()         ?: array();
        $data['estados_servicios'] = $this->ReporteServicios_model->obtener_estados_servicios($reporte_id, $mes) ?: array();

        $this->load->view('templates/header', $data);
        $this->load->view('panel/ReporteAnual/vista_actualizar_mes', $data);
        $this->load->view('templates/footer', $data);
    }

    public function actualizar_servicios()
    {
        $reporte_id = $this->input->post('reporte_id');
        $mes        = $this->input->post('mes');

        if (empty($reporte_id) || empty($mes)) {
            $this->session->set_flashdata('error', 'Faltan datos necesarios.');
            redirect('reporteservicios');
            return;
        }

        $servicios = $this->ReporteServicios_model->obtener_servicios();

        if (!empty($servicios)) {
            foreach ($servicios as $servicio) {
                if (is_object($servicio) && isset($servicio->id)) {
                    $status = $this->input->post('servicio_' . $servicio->id);
                    $this->ReporteServicios_model->actualizar_servicio($reporte_id, $servicio->id, $mes, $status);
                }
            }
        }

        $this->session->set_flashdata('success', 'Servicios actualizados correctamente.');
        redirect('reporteservicios');
    }

    public function generarReporte($año)
    {
        if (empty($año)) { show_404(); return; }

        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 11);

        $logo_path = APPPATH . 'libraries/fpdf/images/UPTlax_Logo.png';
        $sgc_path  = APPPATH . 'libraries/fpdf/images/sgc.png';

        if (file_exists($logo_path)) $pdf->Image($logo_path, 10, 9, 37);
        if (file_exists($sgc_path))  $pdf->Image($sgc_path, 160, 6.5, 33);

        $pdf->SetY(5);  $pdf->Cell(0, 10, 'Subproceso de Apoyo: Laboratorios', 0, 0, 'C');
        $pdf->SetY(10); $pdf->Cell(0, 10, 'Formato: Lista de Cotejo para Laboratorios', 0, 0, 'C');
        $pdf->SetY(15); $pdf->Cell(0, 10, utf8_decode('Fecha de aprobación: octubre 2023'), 0, 0, 'C');

        $lineHeight = 5;
        $pdf->SetLeftMargin(10);
        $pdf->SetRightMargin(10);
        $margin = 20;

        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(); $pdf->Ln();
        $pdf->SetFillColor(224, 224, 224);
        $pdf->SetX($margin);

        // ================================================================
        // FILA: Laboratorio | Programa Academico | Edificio
        // ================================================================
        // Anchos actuales (total ~172mm):
        //   Laboratorio label : 22mm
        //   Laboratorio valor : 35mm  <- sube para mas espacio
        //   Prog. Acad. label : 32mm
        //   Prog. Acad. valor : 55mm  <- sube para mas espacio
        //   Edificio label    : 18mm
        //   Edificio valor    : 10mm  <- sube para mas espacio
        // Para cambiar valor de Programa Academico:
        //   $this->session->userdata('programa_academico')
        //   O fijo: utf8_decode('Ingenieria en Software')
        // ================================================================
        $pdf->Cell(22, $lineHeight, 'Laboratorio:', 1, 0, 'L', true);
        $pdf->Cell(35, $lineHeight, utf8_decode($this->session->userdata('laboratorio_nombre') ?: ''), 1);
        $pdf->Cell(32, $lineHeight, utf8_decode('Programa Academico:'), 1, 0, 'L', true);
        $pdf->Cell(40, $lineHeight, utf8_decode($this->session->userdata('programa_academico') ?: ''), 1);
        $pdf->Cell(18, $lineHeight, 'Edificio:', 1, 0, 'L', true);
        $pdf->Cell(25, $lineHeight, utf8_decode($this->session->userdata('edificio') ?: 'UD4 UPTx'), 1);

        // ================================================================
        // ANIO AUTOMATICO centrado debajo de la fila de laboratorio
        // ================================================================
        // Para cambiar tamano fuente del anio: SetFont('Arial', 'B', 10)
        // Para cambiar margen superior: Ln(8) sube o baja el numero
        // ================================================================
        $pdf->Ln(7);
        $pdf->SetX($margin);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(172, 6, $año, 0, 0, 'C');
        $pdf->SetFont('Arial', '', 9);

        $pdf->Ln(5); $pdf->Ln(0);
        $pdf->SetX($margin);
        $pdf->Cell(70, 5.5, 'Mes', 1, null, 'C');
        for ($i = 1; $i <= 12; $i++) $pdf->Cell(8.5, 5.5, $i, 1);
        $pdf->Ln();
        $pdf->SetX($margin);
        $pdf->Cell(70, 9, 'Dia', 1, null, 'C');
        for ($i = 1; $i <= 12; $i++) $pdf->Cell(8.5, 9, '', 1);
        $pdf->Ln();

        $datos_query = $this->ReporteServicios_model->getDatosReporte($año);
        $datos = ($datos_query === null) ? array() : $datos_query->result_array();

        $datosAgrupados = [];
        foreach ($datos as $dato) {
            if (isset($dato['mes'], $dato['nombre_servicio'], $dato['status'], $dato['nombre_categoria'])) {
                $cat = $dato['nombre_categoria'];
                $srv = $dato['nombre_servicio'];
                if (!isset($datosAgrupados[$cat])) $datosAgrupados[$cat] = [];
                if (!isset($datosAgrupados[$cat][$srv])) $datosAgrupados[$cat][$srv] = array_fill(1, 12, '');
                $datosAgrupados[$cat][$srv][$dato['mes']] = $dato['status'];
            }
        }

        $pdf->SetFont('Arial', '', 9);
        foreach ($datosAgrupados as $categoria => $servicios) {
            $pdf->SetX($margin);
            $pdf->SetFillColor(224, 224, 224);
            $pdf->Cell(172, 10, utf8_decode($categoria), 1, 0, 'C', true);
            $pdf->Ln();
            foreach ($servicios as $servicio => $estados) {
                $pdf->SetX($margin);
                $pdf->SetFillColor(255, 255, 255);
                $xStart = $pdf->GetX(); $yStart = $pdf->GetY();
                $pdf->MultiCell(70, $lineHeight, utf8_decode($servicio), 1, 'L', false);
                $yEnd = $pdf->GetY();
                $rowHeight = $yEnd - $yStart;
                $pdf->SetXY($xStart + 70, $yStart);
                for ($i = 1; $i <= 12; $i++) {
                    $pdf->Cell(8.5, $rowHeight, isset($estados[$i]) ? $estados[$i] : '', 1);
                }
                $pdf->Ln();
            }
        }

        $pdf->Ln(10);
$pdf->SetX(30);

// Parte superior: label con borde LTR
$pdf->Cell(64, 5, utf8_decode('Elaboró:'), 'LTR', 0, 'C');
$pdf->Cell(24, 5, '', 0, 0);
$pdf->Cell(64, 5, 'Vo. Bo.:', 'LTR', 0, 'C');
$pdf->Ln();
$pdf->SetX(30);

// Parte media: espacio para firma con solo bordes laterales
$pdf->Cell(64, 12, '', 'LR', 0, 'C');
$pdf->Cell(24, 12, '', 0, 0);
$pdf->Cell(64, 12, '', 'LR', 0, 'C');
$pdf->Ln();
$pdf->SetX(30);

// Parte inferior: cierra el cuadro con borde LBR
$pdf->Cell(64, 1, '', 'LBR', 0, 'C');
$pdf->Cell(24, 1, '', 0, 0);
$pdf->Cell(64, 1, '', 'LBR', 0, 'C');
$pdf->Ln(5);
$pdf->SetX(30);

// Labels debajo del cuadro
$pdf->Cell(64, 4, 'Jefe de Laboratorio', 0, 0, 'C');
$pdf->Cell(24, 4, '', 0, 0);
$pdf->Cell(64, 4, utf8_decode('Director de Programa Educativo'), 0, 0, 'C');
$pdf->Ln(12);

        // ================================================================
        // PIE DE PAGINA - franja roja con texto blanco
        // ================================================================
        // Color de fondo: SetFillColor(R, G, B)
        //   Rojo actual:   255, 0, 0
        //   Rojo oscuro:   139, 26, 16  (color institucional UPTLAX)
        //   Para cambiar: modifica los 3 numeros RGB
        //
        // Altura de la franja: Cell(0, 10, ...) <- el 10 es la altura en mm
        //   Para hacerla mas delgada: cambia 10 por 7 o 6
        //   Para hacerla mas alta:    cambia 10 por 14 o 16
        //
        // Tamano de letra: SetFont('Arial', 'I', 8)
        //   El 8 es el tamano en puntos
        //   Para letra mas grande: cambia 8 por 9 o 10
        //   Para letra mas pequena: cambia 8 por 7 o 6
        //   'I' = italica, 'B' = negrita, '' = normal
        //
        // Alineacion del texto: 'C' = centrado, 'L' = izquierda
        //
        // Texto: modifica el utf8_decode('...') para cambiar el texto
        // ================================================================
        $pdf->SetFillColor(139, 26, 16);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Ln(15);
$pdf->SetX(20);
$pdf->Cell(145, 6, utf8_decode('Para uso de la Universidad Politécnica de Tlaxcala mediante su Sistema de Gestión de la Calidad'), 0, 0, 'L', true);
        // ================================================================

        if (ob_get_level()) ob_end_clean();
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="reporte_anual_' . $año . '.pdf"');
        header('Cache-Control: max-age=0');
        $pdf->Output();
        exit;
    }
}