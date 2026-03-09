<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/fpdf/fpdf.php';

class ProgramaAnualPdf extends FPDF {
    
    protected $anio;
    protected $laboratorio_nombre;
    protected $laboratorio_id;
    
    public function __construct($orientation = 'L', $unit = 'mm', $size = 'Letter') {
        parent::__construct($orientation, $unit, $size);
    }
    
    public function Header() {
        // Logos - Verificar que existan
        $logo1 = APPPATH . 'libraries/fpdf/images/UPTlax_Logo.png';
        $logo2 = APPPATH . 'libraries/fpdf/images/sgc.png';
        
        if (file_exists($logo1)) {
            $this->Image($logo1, 10, 6, 40);
        }
        if (file_exists($logo2)) {
            $this->Image($logo2, 210, 6, 30);
        }
        
        // Título principal
        $this->SetY(15);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'UNIVERSIDAD POLITÉCNICA DE TLAXCALA', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, 'Subproceso de Apoyo: Laboratorios', 0, 1, 'C');
        $this->Cell(0, 5, 'Programa Anual de Mantenimiento', 0, 1, 'C');
        $this->Ln(5);
        
        // Año
        if (isset($this->anio)) {
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(0, 10, $this->anio, 0, 1, 'C');
            $this->Ln(5);
        }
    }
    
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(0, 10, 'Para uso de la Universidad Politécnica de Tlaxcala mediante su Sistema de Gestión de la Calidad', 0, 0, 'C');
        $this->Ln(4);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
    
    public function generar($programas, $anio, $laboratorio_nombre, $edificio = 'UD-4', $campus = 'Campus Principal') {
        $this->anio = $anio;
        $this->laboratorio_nombre = $laboratorio_nombre;
        
        $this->AddPage();
        
        // Información del laboratorio
        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 6, 'Laboratorio:', 0, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(80, 6, $laboratorio_nombre, 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 6, 'Edificio / Campus:', 0, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 6, $edificio . ' - ' . $campus, 0, 1);
        $this->Ln(5);
        
        // Tabla principal
        $this->generarTablaProgramas($programas);
        
        // Tabla de firmas
        $this->generarTablaFirmas();
        
        // Instructivo en nueva página
        $this->AddPage();
        $this->generarInstructivo();
    }
    
    protected function generarTablaProgramas($programas) {
        // Encabezados de la tabla
        $this->SetFont('Arial', 'B', 8);
        
        // Primera fila de encabezados
        $this->Cell(10, 10, 'N°', 1, 0, 'C');
        $this->Cell(25, 10, 'Laboratorio', 1, 0, 'C');
        $this->Cell(35, 10, 'Actividad a realizar', 1, 0, 'C');
        $this->Cell(15, 10, 'Estatus', 1, 0, 'C');
        
        // Guardar posición para los meses
        $x = $this->GetX();
        $this->Cell(96, 5, 'Meses', 1, 1, 'C');
        
        // Segunda fila de meses (subencabezados)
        $this->SetX($x - 96); // Retroceder para la segunda fila
        $this->Cell(85, 5, '', 0, 0); // Espacio para las columnas anteriores
        for ($m = 1; $m <= 12; $m++) {
            $this->Cell(8, 5, $this->getMesAbrev($m), 1, 0, 'C');
        }
        $this->Cell(20, 5, 'Observaciones', 1, 1, 'C');
        
        // Filas de datos
        $this->SetFont('Arial', '', 8);
        $contador = 1;
        
        if (empty($programas)) {
            // Si no hay programas, mostrar fila vacía
            $this->Cell(10, 6, '1', 1, 0, 'C');
            $this->Cell(25, 6, $this->laboratorio_nombre, 1, 0, 'L');
            $this->Cell(35, 6, 'Sin actividades', 1, 0, 'L');
            $this->Cell(15, 6, 'Planeado', 1, 0, 'C');
            for ($m = 1; $m <= 12; $m++) {
                $this->Cell(8, 6, '', 1, 0, 'C');
            }
            $this->Cell(20, 6, '', 1, 1, 'L');
            
            // Fila de Realizado
            $this->Cell(10, 6, '', 1, 0, 'C');
            $this->Cell(25, 6, '', 1, 0, 'L');
            $this->Cell(35, 6, '', 1, 0, 'L');
            $this->Cell(15, 6, 'Realizado', 1, 0, 'C');
            for ($m = 1; $m <= 12; $m++) {
                $this->Cell(8, 6, '', 1, 0, 'C');
            }
            $this->Cell(20, 6, '', 1, 1, 'L');
        } else {
            foreach ($programas as $programa) {
                // Por cada programa, dos filas: Planeado y Realizado
                for ($estatus = 0; $estatus <= 1; $estatus++) {
                    $tipo_estatus = $estatus == 0 ? 'Planeado' : 'Realizado';
                    
                    // Número (solo en primera fila)
                    if ($estatus == 0) {
                        $this->Cell(10, 6, $contador, 1, 0, 'C');
                    } else {
                        $this->Cell(10, 6, '', 1, 0, 'C');
                    }
                    
                    // Laboratorio (solo en primera fila)
                    if ($estatus == 0) {
                        $this->Cell(25, 6, $this->laboratorio_nombre, 1, 0, 'L');
                    } else {
                        $this->Cell(25, 6, '', 1, 0, 'L');
                    }
                    
                    // Actividad (solo en primera fila)
                    if ($estatus == 0) {
                        $actividad = strlen($programa->actividad) > 25 ? substr($programa->actividad, 0, 22) . '...' : $programa->actividad;
                        $this->Cell(35, 6, $actividad, 1, 0, 'L');
                    } else {
                        $this->Cell(35, 6, '', 1, 0, 'L');
                    }
                    
                    // Estatus (Planeado/Realizado)
                    $this->Cell(15, 6, $tipo_estatus, 1, 0, 'C');
                    
                    // Meses - Obtener detalles del programa
                    $detalles = isset($programa->detalles) ? $programa->detalles : array();
                    $meses_marcados = array();
                    foreach ($detalles as $d) {
                        if ($estatus == 0 && $d->estatus == 'PLANEADO') {
                            $meses_marcados[$d->mes] = 'X';
                        } elseif ($estatus == 1 && $d->estatus == 'COMPLETADO') {
                            $meses_marcados[$d->mes] = 'X';
                        }
                    }
                    
                    for ($m = 1; $m <= 12; $m++) {
                        if (isset($meses_marcados[$m])) {
                            $this->Cell(8, 6, 'X', 1, 0, 'C');
                        } else {
                            $this->Cell(8, 6, '', 1, 0, 'C');
                        }
                    }
                    
                    // Observaciones (solo en primera fila)
                    if ($estatus == 0) {
                        $obs = isset($programa->observaciones) ? $programa->observaciones : '';
                        $obs = strlen($obs) > 15 ? substr($obs, 0, 12) . '...' : $obs;
                        $this->Cell(20, 6, $obs, 1, 1, 'L');
                    } else {
                        $this->Cell(20, 6, '', 1, 1, 'L');
                    }
                }
                $contador++;
            }
        }
        
        $this->Ln(10);
    }
    
    protected function generarTablaFirmas() {
        $this->SetFont('Arial', 'B', 8);
        
        // Encabezados de firmas
        $this->Cell(45, 8, 'Responsable', 1, 0, 'C');
        $this->Cell(45, 8, 'Revisó', 1, 0, 'C');
        $this->Cell(45, 8, 'Autorizó', 1, 0, 'C');
        $this->Cell(45, 8, 'Primer', 1, 0, 'C');
        $this->Cell(45, 8, 'Segundo', 1, 1, 'C');
        
        // Segunda fila de encabezados
        $this->Cell(45, 6, '', 1, 0, 'C');
        $this->Cell(45, 6, 'Director de', 1, 0, 'C');
        $this->Cell(45, 6, 'Secretaría', 1, 0, 'C');
        $this->Cell(45, 6, 'cuatrimestre', 1, 0, 'C');
        $this->Cell(45, 6, 'cuatrimestre', 1, 1, 'C');
        
        // Tercera fila
        $this->Cell(45, 6, 'Nombre y', 1, 0, 'C');
        $this->Cell(45, 6, 'Programa', 1, 0, 'C');
        $this->Cell(45, 6, 'Académica', 1, 0, 'C');
        $this->Cell(45, 6, 'cuatrimestre', 1, 0, 'C');
        $this->Cell(45, 6, 'cuatrimestre', 1, 1, 'C');
        
        // Cuarta fila
        $this->Cell(45, 6, 'firma del', 1, 0, 'C');
        $this->Cell(45, 6, 'Educativo', 1, 0, 'C');
        $this->Cell(45, 6, '', 1, 0, 'C');
        $this->Cell(45, 6, 'Nombre, firma', 1, 0, 'C');
        $this->Cell(45, 6, 'Nombre, firma', 1, 1, 'C');
        
        // Quinta fila
        $this->Cell(45, 6, 'Área', 1, 0, 'C');
        $this->Cell(45, 6, '', 1, 0, 'C');
        $this->Cell(45, 6, '', 1, 0, 'C');
        $this->Cell(45, 6, 'y sello', 1, 0, 'C');
        $this->Cell(45, 6, 'y sello', 1, 1, 'C');
        
        // Espacio para firmas
        $this->Cell(45, 15, '', 1, 0, 'C');
        $this->Cell(45, 15, '', 1, 0, 'C');
        $this->Cell(45, 15, '', 1, 0, 'C');
        $this->Cell(90, 15, 'Nombre, firma y sello de la Dirección de Programa Educativo', 1, 1, 'C');
        
        $this->Ln(10);
    }
    
    protected function generarInstructivo() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'INSTRUCTIVO DE LLENADO', 0, 1, 'C');
        $this->Ln(5);
        
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(40, 8, 'Leyenda', 1, 0, 'C');
        $this->Cell(0, 8, 'Descripción', 1, 1, 'C');
        
        $this->SetFont('Arial', '', 9);
        $instrucciones = [
            '<año>' => 'Indicar el año del programa anual de mantenimiento que está presentando.',
            'Laboratorio o Taller' => 'Escribir el nombre del laboratorio o taller que presenta el programa anual.',
            'Edificio / campus' => 'Anotar la clave del edificio al que se dará mantenimiento y escriba el nombre del campus de ubicación.',
            'No.' => 'Anotar en número consecutivo entero cada una de las actividades programáticas.',
            'Actividad a realizar' => 'Describir concisamente la actividad que se va a realizar.',
            'Estatus' => 'Cuando se haya realizado la actividad planeada, deberá marcar en este recuadro para llevar un control.',
            'Meses' => 'Marcar exactamente en el recuadro del mes en el que se va a realizar la actividad planeada.',
            'Observaciones' => 'Si se tuviera alguna observación o comentario podrá ser anotado en este espacio.',
            'Responsable' => 'Nombre y firma del responsable que presenta el programa anual de mantenimiento.',
            'Revisó' => 'Nombre y firma del titular en turno del Programa Educativo correspondiente.',
            'Autorizó' => 'Nombre y firma del titular en turno de la Secretaría Académica de la UPTx.',
            'Primer cuatrimestre' => 'Nombre, firma y sello de la Dirección de Programa Educativo responsable de efectuar las revisiones cuatrimestrales.',
            'Segundo cuatrimestre' => 'Nombre, firma y sello de la Dirección de Programa Educativo responsable de efectuar las revisiones cuatrimestrales.',
            'Tercer cuatrimestre' => 'Nombre, firma y sello de la Dirección de Programa Educativo responsable de efectuar las revisiones cuatrimestrales.'
        ];
        
        foreach ($instrucciones as $leyenda => $descripcion) {
            $this->Cell(40, 10, $leyenda, 1, 0, 'L');
            $this->Cell(0, 10, $descripcion, 1, 1, 'L');
        }
    }
    
    protected function getMesAbrev($mes) {
        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 
                  'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        return $meses[$mes - 1];
    }
}