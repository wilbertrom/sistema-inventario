<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'libraries/fpdf/fpdf.php';


/**
 *
 * Controller Pdf
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author  
 * @author    
 * @link      
 * @param     ...
 * @return    ...
 *
 */

class Pdf extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('inventario_model');
    }

    public function index()
    {
        // Método vacío - añadido para claridad
        return;
    }

    /**
     * Nota: Los métodos Header() y Footer() están comentados porque no se usan directamente.
     * Si se necesitan, deben ser públicos o protegidos, no privados, ya que FPDF los llama.
     * Además, estos métodos pertenecen a la clase FPDF, no a CI_Controller.
     * Por ahora, los mantendré comentados para evitar conflictos.
     */
    
    /*
    private function Header() {
        // Logo
        $this->Image(base_url('/libraries/fpdf/images/UPTlax_Logo.png'),10,6,30); // Cambia 'logo_encabezado.png' por la ruta a tu logo
        // Arial bold 15
        $this->SetFont('ArialUnicode', '', 15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30,10,'Titulo del Documento',0,0,'C');
        // Salto de línea
        $this->Ln(20);
    }

    private function Footer() {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Para uso ',0,0,'C');
    }
    */

    public function generarPdfEquipos()
    {
        $equipos = $this->inventario_model->obtener_equipos();

        // Verificar que $equipos no sea null
        if ($equipos === null) {
            $equipos = array(); // Inicializar como array vacío si es null
        }

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        
        // Verificar que los archivos de imagen existan antes de intentar cargarlos
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

        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(10, 6, 'No.', 1);
        $pdf->Cell(35, 6, 'Nombre', 1);
        $pdf->Cell(20, 6, 'Cantidad', 1);
        $pdf->Cell(15, 6, 'Unidad', 1);
        $pdf->Cell(70, 6, 'Codigo Interno', 1);
        $pdf->Cell(35, 6, 'Marca', 1);
        $pdf->Cell(35, 6, 'Estado', 1);
        $pdf->Cell(55, 6, 'Observaciones', 1);

        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
        $numero = 1;
        
        // Verificar que $equipos sea iterable
        if (is_array($equipos) || is_object($equipos)) {
            foreach ($equipos as $row) {
                // Verificar que $row sea un objeto y tenga las propiedades necesarias
                if (is_object($row)) {
                    $pdf->Cell(10, 6, $numero, 1);
                    $pdf->Cell(35, 6, isset($row->tipo) ? $row->tipo : '', 1);
                    $pdf->Cell(20, 6, '1', 1);
                    $pdf->Cell(15, 6, 'Pieza', 1);
                    $pdf->Cell(70, 6, isset($row->cod_interno) ? $row->cod_interno : '', 1);
                    $pdf->Cell(35, 6, isset($row->marca) ? $row->marca : '', 1);
                    $pdf->Cell(35, 6, isset($row->estado) ? $row->estado : '', 1);
                    $pdf->Cell(55, 6, isset($row->descripcion) ? $row->descripcion : '', 1);
                    $pdf->Ln();
                    $numero++;
                }
            }
        }

        $availableSpace = $pdf->GetY();

        if ($availableSpace > 130) { // Si estamos muy abajo en la página, agregar una nueva página
            $pdf->AddPage();
        } else {
            $pdf->Ln(15); // Añadir un espacio adicional si hay espacio suficiente
        }
        
        // Espacio para la firma y la fecha
        $pdf->Ln(15);
        $pdf->SetFont('Arial', '', 10);

        $margin = 50;
        // Firma a la izquierda
        $pdf->SetY(-62);
        $pdf->SetX($margin);

        // Dibujar línea para firma
        $y_position = $pdf->GetY() - 3;
        $pdf->Line($margin, $y_position, 60 + $margin, $y_position);

        $pdf->Cell(100, 6, utf8_decode('Mtra. Eulalia Cortés F.'), 0, 0, 'L');
        $pdf->Cell(0, 6, '', 0, 1); // Nueva línea
        $pdf->SetX($margin);

        $pdf->Cell(100, 6, utf8_decode('Jefe (a) de laboratorio de Ingeniería'), 0, 0, 'L');
        $pdf->Cell(0, 6, '', 0, 1); // Nueva línea
        $pdf->SetX($margin);

        $pdf->Cell(100, 6, utf8_decode('Elaboró'), 0, 0, 'L');
        // Fecha actual a la derecha
        $pdf->SetX(100);

        $pdf->Cell(0, 6, 'Fecha: ' . date('d/m/Y'), 0, 1, 'R');

        // Pie de página con subrayado rojo
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(192, 0, 0);

        $pdf->Ln();
        $pdf->Cell(0, 10, utf8_decode('Para uso de la Universidad Politécnica de Tlaxcala mediante su Sistema de Gestión de la Calidad'), 0, 1, 'C', 1);

        // Limpiar cualquier salida previa que pueda interferir con los headers
        if (ob_get_level()) {
            ob_end_clean();
        }

        // Configurar headers para la descarga del PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="reporte_equipos_pdf_' . date('Y-m-d_H-i-s') . '.pdf"');
        header('Cache-Control: max-age=0');
        
        $pdf->Output('I', 'reporte_equipos_pdf_' . date('Y-m-d_H-i-s') . '.pdf');
        exit;
    }
}

/* End of file Pdf.php */
/* Location: ./application/controllers/Pdf.php */