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
        
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        redirect('panel');
    }

    public function generarPdfEquipos()
    {
        $laboratorio_id = $this->session->userdata('laboratorio_id');
        $laboratorio_nombre = $this->session->userdata('laboratorio_nombre') ?: 
                             ($laboratorio_id == 1 ? 'Open Source' : 'Mac');
        
        $equipos = $this->inventario_model->obtener_equipos_por_laboratorio($laboratorio_id);

        if (empty($equipos)) {
            $this->session->set_flashdata('error', 'No hay equipos para generar PDF');
            redirect('panel/ver_inventario');
        }

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        
        $logo_path = APPPATH . 'libraries/fpdf/images/UPTlax_Logo.png';
        $sgc_path = APPPATH . 'libraries/fpdf/images/sgc.png';
        
        if (file_exists($logo_path)) {
            $pdf->Image($logo_path, 10, 6, 50);
        }
        
        if (file_exists($sgc_path)) {
            $pdf->Image($sgc_path, 240, 3, 50);
        }

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 4, utf8_decode("Subproceso de apoyo: Laboratorios"), 0, 1, 'C');
        $pdf->Cell(0, 4, "Formato: Existencia de materiales, equipos e insumos de laboratorios", 0, 1, 'C');
        $pdf->Cell(0, 4, utf8_decode("Fecha de aprobación: Noviembre 2023"), 0, 1, 'C');
        $pdf->Cell(0, 4, utf8_decode("Laboratorio: " . $laboratorio_nombre), 0, 1, 'C');

        $pdf->Ln();
        $pdf->Ln();
        
        // ===== ENCABEZADOS CON RELLENO GRIS CLARO =====
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(240, 240, 240); // Gris claro para los encabezados
        
        // ORDEN CORRECTO: No., Descripción del producto, Unidad, Código interno, Marca, Proveedor, Estado del equipo, Observaciones
        $pdf->Cell(10, 6, 'No.', 1, 0, 'C', 1);
        $pdf->Cell(45, 6, utf8_decode('Descripción del producto'), 1, 0, 'C', 1);
        $pdf->Cell(15, 6, 'Unidad', 1, 0, 'C', 1);
        $pdf->Cell(35, 6, utf8_decode('Código interno'), 1, 0, 'C', 1);
        $pdf->Cell(20, 6, 'Marca', 1, 0, 'C', 1);
        $pdf->Cell(30, 6, 'Proveedor', 1, 0, 'C', 1);
        $pdf->Cell(28, 6, utf8_decode('Estado del equipo'), 1, 0, 'C', 1);
        $pdf->Cell(55, 6, utf8_decode('Observaciones'), 1, 1, 'C', 1);

        $pdf->Ln(2); // Pequeño espacio después de los encabezados
        
        // ===== DATOS DE LOS EQUIPOS =====
        $pdf->SetFont('Arial', '', 8);
        $numero = 1;
        
        foreach ($equipos as $row) {
            $pdf->Cell(10, 6, $numero, 1, 0, 'C');
            $pdf->Cell(45, 6, utf8_decode($row->descripcion ?? $row->tipo ?? ''), 1);
            $pdf->Cell(15, 6, 'Pieza', 1, 0, 'C');
            
            // Código interno con fuente más pequeña si es muy largo
            $codigo = $row->codigo_interno ?? '';
            if (strlen($codigo) > 12) {
                $pdf->SetFont('Arial', '', 6); // Fuente más pequeña
                $pdf->Cell(35, 6, $codigo, 1, 0, 'C');
                $pdf->SetFont('Arial', '', 8); // Restaurar fuente
            } else {
                $pdf->Cell(35, 6, $codigo, 1, 0, 'C');
            }
            
            $pdf->Cell(20, 6, utf8_decode($row->marca ?? ''), 1);
            $pdf->Cell(30, 6, utf8_decode($row->proveedor ?? ''), 1);
            $pdf->Cell(28, 6, utf8_decode($row->estado ?? ''), 1, 0, 'C');
            $pdf->Cell(55, 6, utf8_decode($row->descripcion ?? ''), 1, 1);
            $numero++;
        }

        $pdf->Ln(15);
        $pdf->SetFont('Arial', '', 10);

        $margin = 50;
        $pdf->SetY(-62);
        $pdf->SetX($margin);

        $y_position = $pdf->GetY() - 3;
        $pdf->Line($margin, $y_position, 60 + $margin, $y_position);

        $pdf->Cell(100, 6, utf8_decode('Mtra. Eulalia Cortés F.'), 0, 0, 'L');
        $pdf->Cell(0, 6, '', 0, 1);
        $pdf->SetX($margin);

        $pdf->Cell(100, 6, utf8_decode('Jefe (a) de laboratorio de Ingeniería'), 0, 0, 'L');
        $pdf->Cell(0, 6, '', 0, 1);
        $pdf->SetX($margin);

        $pdf->Cell(100, 6, utf8_decode('Elaboró'), 0, 0, 'L');
        $pdf->SetX(100);

        $pdf->Cell(0, 6, 'Fecha: ' . date('d/m/Y'), 0, 1, 'R');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(192, 0, 0);

        $pdf->Ln();
        $pdf->Cell(0, 10, utf8_decode('Para uso de la Universidad Politécnica de Tlaxcala mediante su Sistema de Gestión de la Calidad'), 0, 1, 'C', 1);

        if (ob_get_level()) {
            ob_end_clean();
        }

        $pdf->Output('I', 'reporte_equipos_' . $laboratorio_nombre . '_' . date('Y-m-d') . '.pdf');
        exit;
    }
}