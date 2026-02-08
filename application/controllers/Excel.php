<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;



defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'libraries/phpspreadsheet/vendor/autoload.php';

/**
 *
 * Controller Excel
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

class Excel extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Inventario_model');
  }

  public function index()
  {
    $equipos = $this->Inventario_model->obtener_equipos();

    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
    $spreadsheet = $reader->load("recursos-panel/reports/base/xlsx base reporte.xlsx");

     
    $spreadsheet->setActiveSheetIndex(0);
    $hojaActiva = $spreadsheet->getActiveSheet();
    
    $hojaActiva->getStyle('A1')->getFont()->setName('Arial')->setSize('8');
  
    $fila = 10; // Empezar después de los encabezados
    foreach ($equipos as $index => $equipo) {
      $estado = $equipo->estado;

      $hojaActiva->setCellValue('B' . $fila, $index + 1);
      $hojaActiva->mergeCells('C'.($fila).':E'.($fila));
      $hojaActiva->setCellValue('C' . $fila, $equipo->tipo);
      $hojaActiva->setCellValue('F' . $fila, "1");
      $hojaActiva->setCellValue('G' . $fila, "Pieza");
      $hojaActiva->setCellValue('H' . $fila, $equipo->cod_interno);
      $hojaActiva->setCellValue('I' . $fila, $equipo->marca);
      if($estado == "En servicio"){

        $hojaActiva->setCellValue('J' . $fila, $estado);
      }else{
        $hojaActiva->setCellValue('K' . $fila, $estado);
      }
      
      $hojaActiva->mergeCells('L'.($fila).':M'.($fila));
      $hojaActiva->setCellValue('L' . $fila, $equipo->descripcion);
      $fila++;
    }


    $rangoDatos = 'B10:M' . ($fila - 1);

    // Aplicar todos los bordes al rango de celdas
    $hojaActiva->getStyle($rangoDatos)->applyFromArray([
        'font' => [
          'size' => 8,  // Establece el tamaño de letra
      ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
            ],
        ],
    ]);

    $hojaActiva->getStyle('A1')->getFont()->setName('Arial');
    // footer
    $hojaActiva->mergeCells('C'. ($fila+5).':G'.($fila+5));
    $hojaActiva->setCellValue('C'.($fila+5), "Mtra.  Eulalia Cortés F.");

    $hojaActiva->mergeCells('C'. ($fila+6).':G'.($fila+6));
    $hojaActiva->getStyle('C'. ($fila+5))->getFont()->setBold(true);
    $hojaActiva->getStyle('C'. ($fila+5).':G'.($fila+5))->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
    $hojaActiva->setCellValue('C'.($fila+6), "Jefe (a) de laboratorio de Ingeniería");
    
    $hojaActiva->mergeCells('D'. ($fila+7).':G'.($fila+7));
    $hojaActiva->setCellValue('D'.($fila+7), "Elaboró");
    
    $hojaActiva->mergeCells('I'. ($fila+5).':K'.($fila+5));
    $hojaActiva->getStyle('I'. ($fila+5).':K'.($fila+5))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);
    $hojaActiva->getStyle('I'. ($fila+5).':K'.($fila+5))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
    $hojaActiva->setCellValue('I'.($fila+5), date('d-m-Y'));
    
    $hojaActiva->mergeCells('B'. ($fila+10).':M'.($fila+10));
    $hojaActiva->getStyle('B'. ($fila+10))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('c00000');
    $hojaActiva->getStyle('B'. ($fila+10))->getFont()->getColor()->setRGB("ffffff");
    $hojaActiva->getStyle('B'. ($fila+10))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $hojaActiva->setCellValue('B'. ($fila+10), 'Para uso de la Universidad Politécnica de Tlaxcala mediante su Sistema de Gestión de la Calidad');
    
    // Nombre del archivo
    $file_name = 'reporte_equipos_pdf_' . date('Y-m-d_H-i-s') . '.xlsx';


    //pasar el archivo al navegador
    /*
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: inline; filename="' . $file_name . '"');
    header('Cache-Control: max-age=0');
*/

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: inline; filename="' . $file_name . '"');
    header('Cache-Control: max-age=0');
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    //$writer->save('recursos-panel/reports/'.$file_name);
    $writer->save('php://output');
  
    
  }

}


/* End of file Excel.php */
/* Location: ./application/controllers/Excel.php */