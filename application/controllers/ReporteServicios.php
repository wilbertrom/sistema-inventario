<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'libraries/fpdf/fpdf.php';




/**
 *
 * Controller ReporteServicios
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  
 * @author    
 * @author    
 * @link      
 * @param     ...
 * @return    ...
 *
 */

class ReporteServicios extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model('ReporteServicios_model');
  }

 

  public function index(){
    $reportes =$this->ReporteServicios_model->obtener_reportes();
    $data['title'] = "Reportes";
    $data['reportes'] = $reportes;
    
    $this->load->view('templates/header', $data);
    $this->load->view('panel/ReporteAnual/vista_reportes', $data);
    $this->load->view('templates/footer', $data);
  }
  
  public function reporte($id){
    $data['title'] = 'Reporte'; 
    $data['reporte'] = $this->ReporteServicios_model->obtener_reporte($id);

    $this->load->view('templates/header', $data);
    $this->load->view('panel/ReporteAnual/vista_reporte', $data);
    $this->load->view('templates/footer', $data);
  }

  public function actualizar_mes($reporte_id, $mes){
    $data['title'] = 'Actualizar mes'; 
    $data['reporte_id'] = $reporte_id; 
    $data['mes'] = $mes; 

    $data['servicios'] = $this->ReporteServicios_model->obtener_servicios();
    $data['estados_servicios'] = $this->ReporteServicios_model->obtener_estados_servicios($reporte_id, $mes);


    $this->load->view('templates/header', $data);
    $this->load->view('panel/ReporteAnual/vista_actualizar_mes', $data);
    $this->load->view('templates/footer', $data);
  }

  public function actualizar_servicios() {
      $reporte_id = $this->input->post('reporte_id');
      $mes = $this->input->post('mes');
      $servicios = $this->ReporteServicios_model->obtener_servicios();
  
      foreach ($servicios as $servicio) {
          $status = $this->input->post('servicio_' . $servicio->id);
          $this->ReporteServicios_model->actualizar_servicio($reporte_id, $servicio->id, $mes, $status);
      }
  
      // Redirigir a una página de éxito o mostrar un mensaje de éxito
      redirect('ReporteServicios/index');
  }

  public function generarReporte($año)
    {
        $pdf = new FPDF();

        $pdf->AliasNbPages();

        $pdf->AddPage();
    
        $pdf->SetFont('Arial', '', 11);
        
        $pdf->Image(APPPATH.'libraries/fpdf/images/UPTlax_Logo.png',10,9,37);
        $pdf->Image(APPPATH.'libraries/fpdf/images/sgc.png',160,6.5,33);
        
        // Moverse al centro para el título
        $pdf->SetY(5); // Establecer la posición Y del título
        $pdf->Cell(0, 10, 'Subproceso de Apoyo: Laboratorios', 0, 0, 'C');
        $pdf->SetY(10);
        $pdf->Cell(0, 10, 'Formato: Lista de Cotejo para Laboratorios', 0, 0, 'C');
        $pdf->SetY(15);
        $pdf->Cell(0, 10, utf8_decode('Fecha de aprobación: octubre 2023'), 0, 0, 'C');
        
        
        // Definir el ancho de las columnas
        $lineHeight = 5;

        $pdf->SetLeftMargin(10);
        $pdf->SetRightMargin(10);
        $margin = 20;

        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFillColor(224, 224, 224); // Color gris
        $pdf->SetX($margin);
        $pdf->SetX($margin);

        $pdf->Cell(32, $lineHeight, 'Laboratorio:', 1,0, null, true);
        $pdf->Cell(78, $lineHeight, 'Open source', 1);

        $pdf->Cell(30, $lineHeight, 'Edificio / Campus:', 1, 0, null, true);
        $pdf->Cell(32, $lineHeight, 'UD-4', 1);

        $pdf->ln();
        $pdf->ln();
        $pdf->SetX($margin);
        $pdf->SetX($margin);
        $pdf->Cell(70, 5.5, 'Mes', 1, null, 'C');
        for($i=1; $i<=12; $i++){

            $pdf->Cell(8.5, 5.5, $i, 1);
        }
        $pdf->ln();
        $pdf->SetX($margin);
        $pdf->SetX($margin);
        $pdf->Cell(70, 9, 'Dia', 1, null, 'C');
        for($i=1; $i<=12; $i++){

            $pdf->Cell(8.5, 9, '', 1);
        }

        $pdf->Ln();
        
        // Obtener los datos del reporte
    // Obtener los datos del reporte
    $datos = $this->ReporteServicios_model->getDatosReporte($año)->result_array();

    // Crear un array para almacenar los datos agrupados por categoría y servicio
    $datosAgrupados = [];
    $categorias = [];

    foreach ($datos as $dato) {
        $mes = $dato['mes'];
        $servicio = $dato['nombre_servicio'];
        $status = $dato['status'];
        $categoria = $dato['nombre_categoria'];

        if (!isset($datosAgrupados[$categoria])) {
            $datosAgrupados[$categoria] = [];
        }

        if (!isset($datosAgrupados[$categoria][$servicio])) {
            $datosAgrupados[$categoria][$servicio] = array_fill(1, 12, ''); // Inicializa con valores vacíos para cada mes
        }

        // Almacenar el estatus del servicio en el mes correspondiente
        $datosAgrupados[$categoria][$servicio][$mes] = $status;
    }

    // Definir altura de la fila
    $lineHeight = 5;
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetX($margin);
    
    foreach ($datosAgrupados as $categoria => $servicios) {
        $pdf->SetX($margin);
        // Imprimir la fila de la categoría
        $pdf->SetFillColor(224, 224, 224); // Color amarillo claro para la categoría
        $pdf->Cell(172, 10,  utf8_decode($categoria), 1, 0, 'C', true);
        
        $pdf->Ln();

        foreach ($servicios as $servicio => $estados) {
            // Calcular la altura de la fila basada en el contenido de MultiCell
            $pdf->SetX($margin);
            $pdf->SetFillColor(255, 255, 255); // Color blanco

            // Temporarily save the X and Y position
            $xStart = $pdf->GetX();
            $yStart = $pdf->GetY();

            // Imprimir la celda del servicio usando MultiCell
            $pdf->MultiCell(70, $lineHeight, utf8_decode($servicio), 1, 'L', false);

            // Calculate the height of the current row
            $yEnd = $pdf->GetY();
            $lineHeight = $yEnd - $yStart; // New height of the cell

            // Adjust X position for the rest of the columns
            $pdf->SetXY($xStart + 70, $yStart); 

            // Imprimir los estados de los meses
            for ($i = 1; $i <= 12; $i++) {
                $pdf->Cell(8.5, $lineHeight, $estados[$i], 1);
            }
            $pdf->Ln();

        }
        
    }
    $pdf->Ln(10); // Espacio antes de las celdas de firma

// Celdas para firmas
$pdf->SetX(30);

// Celdas de firma vacías
$pdf->Cell(64, 17, '', 1, 0, 'C');

// Espacio en blanco para ajustar la segunda celda a la derecha
$pdf->Cell(24, 17, '', 0, 0); // Crea un espacio vacío para ajustar el ancho

// Segunda celda de firma vacía
$pdf->Cell(64, 17, '', 1, 0, 'C');
$pdf->Ln();

// Coloca las etiquetas "Elaboró:" y "Vo. Bo." debajo de las celdas
$pdf->SetX(30);
$pdf->Cell(64, 10, utf8_decode('Elaboró:'), 0, 0, 'C');
$pdf->Cell(24, 10, '', 0, 0); // Espacio en blanco para centrar las etiquetas
$pdf->Cell(64, 10, 'Vo. Bo.:', 0, 0, 'C');
$pdf->Ln();

// Coloca los nombres "Jefe de Laboratorio" y "Director de Programa Educativo" debajo de las etiquetas
$pdf->SetX(30);
$pdf->Cell(64, 2, 'Jefe de Laboratorio', 0, 0, 'C');
$pdf->Cell(24, 10, '', 0, 0); // Espacio en blanco para centrar las etiquetas
$pdf->Cell(64, 2, utf8_decode('Director de Programa Educativo'), 0, 0, 'C');
$pdf->Ln(15);


// Establecer el color del texto en rojo
$pdf->SetFillColor(255, 0, 0);
$pdf->SetTextColor(255, 255, 255); // Cambiar el color del texto a blanco

// Establecer la fuente
$pdf->SetFont('Arial', 'I', 8);

// Agregar el texto centrado en el pie de página
$pdf->Cell(0, 10, utf8_decode('Para uso de la Universidad Politécnica de Tlaxcala mediante su Sistema de Gestión de la Calidad'), 0, 0, 'C', true);

        
        $pdf->Output();
    }

}



/* End of file ReporteServicios.php */
/* Location: ./application/controllers/ReporteServicios.php */