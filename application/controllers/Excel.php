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

        // ================================================================
        // NOMBRE DEL ENCARGADO SEGÚN LABORATORIO
        // laboratorio_id == 1 => Open Source => Mtra. Eulalia Cortés Flores
        // laboratorio_id == 2 => Mac         => Ing. Leandro Álvarez Sánchez
        // Para agregar más laboratorios: agrega más casos al array
        // ================================================================
        $encargados = [
            1 => 'Mtra. Eulalia Cortés Flores',
            2 => 'Ing. Leandro Álvarez Sánchez',
        ];
        $nombre_encargado = $encargados[$laboratorio_id] ?? '';

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
        // NOMBRE DEL LABORATORIO en F6
        // ================================================================
        $hojaActiva->setCellValue('F6', $laboratorio_nombre);
        $hojaActiva->getStyle('F6')->getFont()->setName('Arial')->setSize(10)->setBold(true);
        $hojaActiva->getStyle('F6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // ================================================================
        // ENCABEZADOS DE TABLA (fila 8)
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
        // ================================================================
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

        // ================================================================
        // BORDES de toda la tabla de datos
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
        // Fila +3: nombre del encargado (centrado, con línea superior como firma)
        // Fila +4: "Responsable del laboratorio" (negritas)
        // Fila +5: "Elaboró"
        //
        // Para cambiar nombres: modifica el array $encargados arriba
        // Para cambiar posición: modifica los +3, +4, +5
        // ================================================================

        // Nombre del encargado con línea de firma encima
        $hojaActiva->mergeCells('C' . ($fila + 3) . ':G' . ($fila + 3));
        $hojaActiva->setCellValue('C' . ($fila + 3), $nombre_encargado);
        $hojaActiva->getStyle('C' . ($fila + 3))->getFont()->setName('Arial')->setSize(9);
        $hojaActiva->getStyle('C' . ($fila + 3))->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // Línea superior simulando firma
        $hojaActiva->getStyle('C' . ($fila + 3) . ':G' . ($fila + 3))
            ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);

        // "Responsable del laboratorio" en negritas
        $hojaActiva->mergeCells('C' . ($fila + 4) . ':G' . ($fila + 4));
        $hojaActiva->setCellValue('C' . ($fila + 4), 'Responsable del laboratorio');
        $hojaActiva->getStyle('C' . ($fila + 4))->getFont()->setName('Arial')->setSize(9)->setBold(true);
        $hojaActiva->getStyle('C' . ($fila + 4))->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // ================================================================
        // FECHA DE INVENTARIO — derecha con borde
        // Formato: "Fecha de inventario: 29 de Mayo 2025"
        // Para cambiar formato: modifica date() y el texto
        // ================================================================
        $meses = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio',
                  'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $fecha_texto = 'Fecha de inventario: ' . date('d') . ' de ' . $meses[(int)date('n')] . ' ' . date('Y');

        // Fecha: 2 filas x 3 columnas (J hasta L, filas +3 y +4) combinadas
        $hojaActiva->mergeCells('J' . ($fila + 3) . ':L' . ($fila + 4));
        $hojaActiva->setCellValue('J' . ($fila + 3), $fecha_texto);
        $hojaActiva->getStyle('J' . ($fila + 3))->getFont()->setName('Arial')->setSize(9);
        $hojaActiva->getStyle('J' . ($fila + 3))->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);
        $hojaActiva->getStyle('J' . ($fila + 3) . ':L' . ($fila + 4))
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);


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