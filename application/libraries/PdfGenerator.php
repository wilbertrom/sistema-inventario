<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/fpdf/fpdf.php';

class PdfGenerator {
    
    protected $ci;
    
    public function __construct() {
        $this->ci =& get_instance();
    }
    
    public function generate($html, $filename = 'documento', $orientation = 'P', $format = 'Letter') {
        // Crear PDF personalizado con formato UPTx
        $pdf = new PDF_UPTx($orientation, 'mm', $format);
        $pdf->SetTitle($filename);
        $pdf->AddPage();
        
        // Convertir HTML a PDF (versión simplificada)
        $pdf->WriteHTML($html);
        
        // Salida del PDF
        $pdf->Output($filename . '.pdf', 'I');
    }
}

// Clase PDF personalizada con header y footer de UPTx
class PDF_UPTx extends FPDF {
    
    function Header() {
        // Logo
        $this->Image(APPPATH . 'libraries/fpdf/images/UPTlax_Logo.png', 10, 6, 40);
        $this->Image(APPPATH . 'libraries/fpdf/images/sgc.png', 160, 6, 30);
        
        // Título
        $this->SetY(15);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'UNIVERSIDAD POLITÉCNICA DE TLAXCALA', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, 'Subproceso de Apoyo: Laboratorios', 0, 1, 'C');
        $this->Cell(0, 5, 'Formato: Programa Anual de Mantenimiento', 0, 1, 'C');
        $this->Ln(10);
    }
    
    function Footer() {
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(0, 10, 'Para uso de la Universidad Politécnica de Tlaxcala mediante su Sistema de Gestión de la Calidad', 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
    
    function WriteHTML($html) {
        // Versión simplificada - Convierte HTML básico a PDF
        $html = strip_tags($html, '<p><br><b><i><u><h1><h2><h3><table><tr><td><th><strong><em>');
        $this->Write(5, $html);
    }
}