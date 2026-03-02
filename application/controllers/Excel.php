<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH.'libraries/phpspreadsheet/vendor/autoload.php';

class Excel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Inventario_model');
        $this->load->library('session');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $laboratorio_id     = $this->session->userdata('laboratorio_id');
        $laboratorio_nombre = $this->session->userdata('laboratorio_nombre') ?:
                             ($laboratorio_id == 1 ? 'Open Source' : 'Mac');

        $equipos = $this->Inventario_model->obtener_equipos_por_laboratorio($laboratorio_id);

        if (empty($equipos)) {
            $this->session->set_flashdata('error', 'No hay equipos para exportar');
            redirect('panel/ver_inventario');
        }

        $reader      = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load("recursos-panel/reports/base/xlsx base reporte.xlsx");

        $spreadsheet->setActiveSheetIndex(0);
        $hojaActiva = $spreadsheet->getActiveSheet();

        // ================================================================
        // ENCABEZADO: celda E1:J4 — texto institucional centrado
        // ================================================================
        $hojaActiva->mergeCells('E1:J4');
        $hojaActiva->getStyle('E1:J4')->getFont()->setName('Arial')->setSize(10);
        $hojaActiva->getStyle('E1:J4')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        // ================================================================
        // LABORATORIO en I6
        // Para cambiar la celda: modifica 'I6'
        // Para cambiar el estilo: setBold(true/false), setSize(10)
        // ================================================================
        $hojaActiva->setCellValue('I6', $laboratorio_nombre);
        $hojaActiva->getStyle('I6')->getFont()->setName('Arial')->setSize(10)->setBold(true);

        // ================================================================
        // ENCABEZADOS DE TABLA (fila 8)
        // Para cambiar posicion de un encabezado: modifica la celda
        // Para cambiar el texto: modifica el segundo parametro de setCellValue
        // ================================================================
        $hojaActiva->setCellValue('B8', 'No.');
        $hojaActiva->getStyle('B8')->getFont()->setName('Arial')->setSize(8)->setBold(true);
        $hojaActiva->getStyle('B8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $hojaActiva->mergeCells('C8:E8');
        $hojaActiva->setCellValue('C8', 'Descripción del producto');
        $hojaActiva->getStyle('C8:E8')->getFont()->setName('Arial')->setSize(8)->setBold(true);
        $hojaActiva->getStyle('C8:E8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $hojaActiva->setCellValue('F8', 'Unidad');
        $hojaActiva->getStyle('F8')->getFont()->setName('Arial')->setSize(8)->setBold(true);
        $hojaActiva->getStyle('F8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $hojaActiva->setCellValue('G8', 'Código interno');
        $hojaActiva->getStyle('G8')->getFont()->setName('Arial')->setSize(8)->setBold(true);
        $hojaActiva->getStyle('G8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $hojaActiva->setCellValue('H8', 'Marca');
        $hojaActiva->getStyle('H8')->getFont()->setName('Arial')->setSize(8)->setBold(true);
        $hojaActiva->getStyle('H8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $hojaActiva->setCellValue('I8', 'Proveedor');
        $hojaActiva->getStyle('I8')->getFont()->setName('Arial')->setSize(8)->setBold(true);
        $hojaActiva->getStyle('I8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $hojaActiva->setCellValue('J8', 'Estado del equipo');
        $hojaActiva->getStyle('J8')->getFont()->setName('Arial')->setSize(8)->setBold(true);
        $hojaActiva->getStyle('J8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $hojaActiva->mergeCells('K8:L8');
        $hojaActiva->setCellValue('K8', 'Observaciones');
        $hojaActiva->getStyle('K8:L8')->getFont()->setName('Arial')->setSize(8)->setBold(true);
        $hojaActiva->getStyle('K8:L8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // ================================================================
        // DATOS — empiezan en fila 9
        // Para cambiar qué campo va en cada columna:
        //   modifica $equipo->NOMBRE_CAMPO en cada setCellValue
        // Campos disponibles según BD:
        //   codigo_interno, descripcion_producto, unidad, marca (nombre),
        //   proveedor, estado (nombre), observaciones
        // ================================================================
        $fila = 9;
        foreach ($equipos as $index => $equipo) {

            // Columna B: número de fila
            $hojaActiva->setCellValue('B' . $fila, $index + 1);
            $hojaActiva->getStyle('B' . $fila)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Columna C:E — Descripción del producto
            $hojaActiva->mergeCells('C' . $fila . ':E' . $fila);
            $hojaActiva->setCellValue('C' . $fila, $equipo->descripcion_producto ?? '');

            // Columna F — Unidad
            // Para cambiar "Pieza" por el campo real: $equipo->unidad ?? 'Pieza'
            $hojaActiva->setCellValue('F' . $fila, $equipo->unidad ?? 'Pieza');
            $hojaActiva->getStyle('F' . $fila)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Columna G — Código interno
            $hojaActiva->setCellValue('G' . $fila, $equipo->codigo_interno ?? '');
            $hojaActiva->getStyle('G' . $fila)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Columna H — Marca
            $hojaActiva->setCellValue('H' . $fila, $equipo->marca ?? '');

            // Columna I — Proveedor
            $hojaActiva->setCellValue('I' . $fila, $equipo->proveedor ?? '');

            // Columna J — Estado del equipo
            $hojaActiva->setCellValue('J' . $fila, $equipo->estado ?? '');
            $hojaActiva->getStyle('J' . $fila)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Columna K:L — Observaciones
            // CORREGIDO: antes usaba descripcion_producto, ahora usa observaciones
            $hojaActiva->mergeCells('K' . $fila . ':L' . $fila);
            $hojaActiva->setCellValue('K' . $fila, $equipo->observaciones ?? '');

            $fila++;
        }

        // ================================================================
        // BORDES de toda la tabla de datos
        // Para cambiar estilo: BORDER_THIN, BORDER_MEDIUM, BORDER_DASHED
        // ================================================================
        $rangoDatos = 'B8:L' . ($fila - 1);
        $hojaActiva->getStyle($rangoDatos)->applyFromArray([
            'font'    => ['name' => 'Arial', 'size' => 8],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);

        // ================================================================
        // SECCION DE FIRMAS
        // ================================================================
        // Firma izquierda: nombre del responsable
        // Para cambiar el nombre: modifica el string en setCellValue
        // Para cambiar la posicion: modifica las celdas ($fila+5, $fila+6, etc.)
        // ================================================================
        $hojaActiva->mergeCells('C' . ($fila + 5) . ':G' . ($fila + 5));
        // NOMBRE DEL RESPONSABLE — cambia aqui el nombre o usa variable de sesion
        // Para dejarlo en blanco: ''
        $hojaActiva->setCellValue('C' . ($fila + 5), '');
        $hojaActiva->getStyle('C' . ($fila + 5))->getFont()->setBold(true);
        $hojaActiva->getStyle('C' . ($fila + 5) . ':G' . ($fila + 5))
            ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);

        $hojaActiva->mergeCells('C' . ($fila + 6) . ':G' . ($fila + 6));
        $hojaActiva->setCellValue('C' . ($fila + 6), 'Responsable del laboratorio');

        $hojaActiva->mergeCells('D' . ($fila + 7) . ':G' . ($fila + 7));
        $hojaActiva->setCellValue('D' . ($fila + 7), 'Elaboró');

        // ================================================================
        // FECHA DE INVENTARIO — celda derecha con borde
        // Para cambiar formato de fecha: modifica date('d-m-Y')
        // Para cambiar posicion: modifica las celdas I, K
        // ================================================================
        $hojaActiva->mergeCells('I' . ($fila + 5) . ':K' . ($fila + 5));
        $hojaActiva->getStyle('I' . ($fila + 5) . ':K' . ($fila + 5))
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);
        $hojaActiva->getStyle('I' . ($fila + 5) . ':K' . ($fila + 5))
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // Texto de la fecha — para cambiar el prefijo modifica 'Fecha de inventario: '
        $hojaActiva->setCellValue('I' . ($fila + 5), 'Fecha de inventario: ' . date('d-m-Y'));

        // ================================================================
        // PIE DE PAGINA — franja roja con texto blanco
        // ================================================================
        // Color de fondo: setRGB('8B1A10') = rojo oscuro institucional
        //   Para rojo vivo: setRGB('FF0000')
        //   Para cambiar: modifica los 6 caracteres hexadecimales
        //
        // Posicion: B hasta M en fila ($fila+10)
        //   Para subir el pie: cambia +10 por +8 o +9
        //   Para bajar el pie: cambia +10 por +12 o +14
        //
        // Texto: modifica el string en setCellValue
        // Alineacion: HORIZONTAL_CENTER = centrado, HORIZONTAL_LEFT = izquierda
        // ================================================================
        $hojaActiva->mergeCells('B' . ($fila + 10) . ':M' . ($fila + 10));
        $hojaActiva->getStyle('B' . ($fila + 10))
            ->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('8B1A10'); // rojo oscuro institucional
        $hojaActiva->getStyle('B' . ($fila + 10))
            ->getFont()->getColor()->setRGB('ffffff');
        $hojaActiva->getStyle('B' . ($fila + 10))
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $hojaActiva->setCellValue(
            'B' . ($fila + 10),
            'Para uso de la Universidad Politécnica de Tlaxcala mediante su Sistema de Gestión de la Calidad'
        );

        // ================================================================
        // SALIDA DEL ARCHIVO
        // ================================================================
        $file_name = 'reporte_equipos_' . date('Y-m-d_H-i-s') . '.xlsx';

        if (ob_get_level()) ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Cache-Control: max-age=0');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}