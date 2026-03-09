<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
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

        $nombre_encargado = $this->session->userdata('encargado_inventario') ?? '';

        $equipos = $this->Inventario_model->obtener_equipos_por_laboratorio($laboratorio_id);

        if (empty($equipos)) {
            $this->session->set_flashdata('error', 'No hay equipos para exportar');
            redirect('panel/ver_inventario');
        }

        $reader      = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load("recursos-panel/reports/base/xlsx base reporte.xlsx");

        $spreadsheet->setActiveSheetIndex(0);
        $hojaActiva = $spreadsheet->getActiveSheet();

        $hojaActiva->setCellValue('F6', $laboratorio_nombre);
        $hojaActiva->getStyle('F6')->getFont()->setName('Arial')->setSize(10)->setBold(true);
        $hojaActiva->getStyle('F6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

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

        // ── Datos ────────────────────────────────────────────────
        $fila = 9;
        foreach ($equipos as $index => $equipo) {

            $hojaActiva->setCellValue('B' . $fila, $index + 1);
            $hojaActiva->getStyle('B' . $fila)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $hojaActiva->mergeCells('C' . $fila . ':E' . $fila);
            $hojaActiva->setCellValue('C' . $fila, $equipo->descripcion_producto ?? '');

            $hojaActiva->setCellValue('F' . $fila, $equipo->unidad ?? 'Pieza');
            $hojaActiva->getStyle('F' . $fila)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $hojaActiva->setCellValue('G' . $fila, $equipo->codigo_interno ?? '');
            $hojaActiva->getStyle('G' . $fila)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $hojaActiva->setCellValue('H' . $fila, $equipo->marca ?? '');
            $hojaActiva->setCellValue('I' . $fila, $equipo->proveedor ?? '');

            $hojaActiva->setCellValue('J' . $fila, $equipo->estado ?? '');
            $hojaActiva->getStyle('J' . $fila)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $hojaActiva->mergeCells('K' . $fila . ':L' . $fila);
            $hojaActiva->setCellValue('K' . $fila, $equipo->observaciones ?? '');

            $fila++;
        }

        // Bordes tabla de datos
        $rangoDatos = 'B8:L' . ($fila - 1);
        $hojaActiva->getStyle($rangoDatos)->applyFromArray([
            'font'    => ['name' => 'Arial', 'size' => 8],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);

        // ================================================================
        // SECCIÓN FIRMAS — fila mínima 12 para que no quede muy pegado
        // Si hay muchos equipos, se coloca 2 filas después del último dato
        //
        // fila_nombre → nombre encargado (negritas, centrado, VERTICAL_BOTTOM)
        // fila_linea  → borde inferior grueso = línea de firma
        // fila_cargo  → "Responsable del laboratorio"
        // ================================================================
        $fila_nombre = max($fila + 1, 12); // mínimo fila 12
        $fila_linea  = $fila_nombre + 1;
        $fila_cargo  = $fila_nombre + 2;

        // Altura reducida para que el nombre quede pegado a la línea
        $hojaActiva->getRowDimension($fila_nombre)->setRowHeight(11);

        // Nombre — negritas, centrado, pegado abajo de la celda
        $hojaActiva->mergeCells('C' . $fila_nombre . ':G' . $fila_nombre);
        $hojaActiva->setCellValue('C' . $fila_nombre, $nombre_encargado);
        $hojaActiva->getStyle('C' . $fila_nombre)->getFont()
            ->setName('Arial')->setSize(9)->setBold(true);
        $hojaActiva->getStyle('C' . $fila_nombre)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_BOTTOM);

        // Línea de firma = borde inferior MEDIUM en fila_linea (altura mínima)
        $hojaActiva->getRowDimension($fila_linea)->setRowHeight(4);
        $hojaActiva->mergeCells('C' . $fila_linea . ':G' . $fila_linea);
        $hojaActiva->getStyle('C' . $fila_linea . ':G' . $fila_linea)
            ->getBorders()->getBottom()
            ->setBorderStyle(Border::BORDER_MEDIUM);

        // "Responsable del laboratorio"
        $hojaActiva->mergeCells('C' . $fila_cargo . ':G' . $fila_cargo);
        $hojaActiva->setCellValue('C' . $fila_cargo, 'Responsable del laboratorio');
        $hojaActiva->getStyle('C' . $fila_cargo)->getFont()
            ->setName('Arial')->setSize(9)->setBold(true);
        $hojaActiva->getStyle('C' . $fila_cargo)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Cuadro de fecha — mismo rango vertical
        $meses = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio',
                  'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $fecha_texto = 'Fecha de inventario: ' . date('d') . ' de ' . $meses[(int)date('n')] . ' ' . date('Y');

        $hojaActiva->mergeCells('J' . $fila_nombre . ':L' . $fila_cargo);
        $hojaActiva->setCellValue('J' . $fila_nombre, $fecha_texto);
        $hojaActiva->getStyle('J' . $fila_nombre)->getFont()->setName('Arial')->setSize(9);
        $hojaActiva->getStyle('J' . $fila_nombre)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);
        $hojaActiva->getStyle('J' . $fila_nombre . ':L' . $fila_cargo)
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);

        // ── Salida ───────────────────────────────────────────────
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