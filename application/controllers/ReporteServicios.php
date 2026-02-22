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

    // ── NUEVO: crear reporte ─────────────────────────────────────
    public function crear()
    {
        $año = (int) $this->input->post('año');

        if (empty($año) || $año < 2000 || $año > 2100) {
            $this->session->set_flashdata('error', 'Año inválido.');
            redirect('reporteservicios');
        }

        // Verificar si ya existe uno para ese año en este laboratorio
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

    // ── NUEVO: eliminar reporte ──────────────────────────────────
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
        $pdf->Cell(32, $lineHeight, 'Laboratorio:', 1, 0, null, true);
        $pdf->Cell(78, $lineHeight, 'Open source', 1);
        $pdf->Cell(30, $lineHeight, 'Edificio / Campus:', 1, 0, null, true);
        $pdf->Cell(32, $lineHeight, 'UD-4', 1);

        $pdf->Ln(); $pdf->Ln();
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
        $pdf->Cell(64, 17, '', 1, 0, 'C');
        $pdf->Cell(24, 17, '', 0, 0);
        $pdf->Cell(64, 17, '', 1, 0, 'C');
        $pdf->Ln();
        $pdf->SetX(30);
        $pdf->Cell(64, 10, utf8_decode('Elaboró:'), 0, 0, 'C');
        $pdf->Cell(24, 10, '', 0, 0);
        $pdf->Cell(64, 10, 'Vo. Bo.:', 0, 0, 'C');
        $pdf->Ln();
        $pdf->SetX(30);
        $pdf->Cell(64, 2, 'Jefe de Laboratorio', 0, 0, 'C');
        $pdf->Cell(24, 10, '', 0, 0);
        $pdf->Cell(64, 2, utf8_decode('Director de Programa Educativo'), 0, 0, 'C');
        $pdf->Ln(15);

        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, utf8_decode('Para uso de la Universidad Politécnica de Tlaxcala mediante su Sistema de Gestión de la Calidad'), 0, 0, 'C', true);

        if (ob_get_level()) ob_end_clean();
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="reporte_anual_' . $año . '.pdf"');
        header('Cache-Control: max-age=0');
        $pdf->Output();
        exit;
    }
}