<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use Mpdf\Mpdf;

class Uptx_pdf {
    
    protected $ci;
    protected $mpdf;
    
    public function __construct() {
        $this->ci =& get_instance();
        
        try {
            // Configuración específica para formato institucional A4 horizontal
            $config = [
                'mode' => 'utf-8',
                'format' => 'A4-L',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 25,
                'margin_bottom' => 20,
                'margin_header' => 10,
                'margin_footer' => 10,
                'default_font' => 'arial',
                'tempDir' => sys_get_temp_dir() . '/mpdf'
            ];
            
            $this->mpdf = new Mpdf($config);
            
            // Metadatos
            $this->mpdf->SetTitle('Programa Anual de Mantenimiento UPTx');
            $this->mpdf->SetAuthor('UPTx - Laboratorios');
            $this->mpdf->SetCreator('Sistema de Gestión de Laboratorios');
            
            // Estilos globales
            $this->setGlobalStyles();
            
        } catch (\Mpdf\MpdfException $e) {
            log_message('error', 'Error inicializando MPDF: ' . $e->getMessage());
            show_error('Error al inicializar el generador de PDF');
        }
    }
    
    private function setGlobalStyles() {
        $styles = '
            body {
                font-family: arial, helvetica, sans-serif;
                font-size: 10pt;
                color: #222;
            }
            .header {
                width: 100%;
                border-bottom: 3px solid #a52119;
                margin-bottom: 15px;
                padding-bottom: 10px;
            }
            .header table {
                width: 100%;
                border-collapse: collapse;
            }
            .header td {
                border: none;
                vertical-align: middle;
            }
            .header img {
                max-height: 60px;
                max-width: 100px;
            }
            .title {
                text-align: center;
                font-weight: bold;
                font-size: 16pt;
                color: #a52119;
                margin: 15px 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 15px 0;
            }
            th {
                background-color: #a52119;
                color: white;
                font-weight: bold;
                padding: 8px 4px;
                text-align: center;
                border: 1px solid #8a1a14;
                font-size: 9pt;
            }
            td {
                border: 1px solid #666;
                padding: 6px 4px;
                vertical-align: middle;
                font-size: 9pt;
            }
            .text-center { text-align: center; }
            .estatus-planeado {
                background-color: #f5d7d5;
                font-weight: bold;
                color: #a52119;
            }
            .estatus-realizado {
                background-color: #c9e6d3;
                font-weight: bold;
                color: #2d6a4f;
            }
            .check-mark {
                color: #a52119;
                font-weight: bold;
                font-size: 12pt;
            }
            .firmas table {
                border: none;
                margin-top: 30px;
            }
            .firmas td {
                border: none;
                text-align: center;
                vertical-align: bottom;
                padding: 10px 5px;
            }
            .firma-linea {
                border-top: 2px solid #a52119;
                width: 90%;
                margin: 5px auto;
                padding-top: 5px;
            }
            .footer {
                text-align: center;
                font-size: 8pt;
                color: #666;
                border-top: 1px solid #ccc;
                margin-top: 30px;
                padding-top: 10px;
            }
            .instructivo {
                margin-top: 30px;
            }
            .instructivo h4 {
                color: #a52119;
                border-bottom: 2px solid #a52119;
                padding-bottom: 5px;
            }
        ';
        
        $this->mpdf->WriteHTML($styles, \Mpdf\HTMLParserMode::HEADER_CSS);
    }
    
    public function generate($html, $filename = 'documento') {
        try {
            // Limpiar cualquier salida previa
            while (ob_get_level()) {
                ob_end_clean();
            }
            
            // Escribir el HTML
            $this->mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
            
            // Salida del PDF
            $this->mpdf->Output($filename . '.pdf', 'I');
            exit;
            
        } catch (\Mpdf\MpdfException $e) {
            log_message('error', 'Error generando PDF: ' . $e->getMessage());
            show_error('Error al generar el PDF: ' . $e->getMessage());
        }
    }
}