// application/libraries/PdfPlantillaGenerator.php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/fpdf/fpdf.php';
require_once APPPATH . 'libraries/fpdi/src/autoload.php';

use setasign\Fpdi\Fpdi;

class PdfPlantillaGenerator extends Fpdi {
    
    protected $ci;
    
    public function __construct() {
        parent::__construct();
        $this->ci =& get_instance();
    }
    
    public function generarProgramaAnual($data, $filename = 'programa_anual') {
        // Ruta a tu plantilla
        $plantilla = APPPATH . 'libraries/fpdf/plantillas/programa_anual.pdf';
        
        if (!file_exists($plantilla)) {
            show_error('Plantilla no encontrada');
            return;
        }
        
        // Importar plantilla
        $pageCount = $this->setSourceFile($plantilla);
        $templateId = $this->importPage(1);
        $this->AddPage();
        $this->useTemplate($templateId);
        
        // Aquí posicionas los textos en las coordenadas exactas de tu plantilla
        // Ejemplo: Laboratorio
        $this->SetFont('Arial', '', 10);
        $this->SetXY(50, 40); // Ajusta coordenadas según tu plantilla
        $this->Write(0, $data['laboratorio_nombre']);
        
        // Actividad
        $this->SetXY(50, 50);
        $this->Write(0, $data['programa']->actividad);
        
        // Año
        $this->SetXY(150, 40);
        $this->Write(0, $data['programa']->anio);
        
        // Meses (posiciones según diseño)
        $posiciones_meses = [
            1 => ['x' => 30, 'y' => 70],   // Enero
            2 => ['x' => 60, 'y' => 70],   // Febrero
            // ... etc
        ];
        
        foreach($data['detalles'] as $detalle) {
            if (isset($posiciones_meses[$detalle->mes])) {
                $pos = $posiciones_meses[$detalle->mes];
                $this->SetXY($pos['x'], $pos['y']);
                
                // Marcar según estatus (X, ✓, etc)
                $marca = $detalle->estatus == 'COMPLETADO' ? '✓' : 
                        ($detalle->estatus == 'PLANEADO' ? '○' : '✗');
                $this->Write(0, $marca);
            }
        }
        
        // Firmas
        $this->SetXY(40, 220);
        $this->Write(0, 'Mtra. Eulalia Cortés F.');
        $this->SetXY(130, 220);
        $this->Write(0, 'Vo. Bo.');
        
        // Salida
        $this->Output($filename . '.pdf', 'I');
    }
}