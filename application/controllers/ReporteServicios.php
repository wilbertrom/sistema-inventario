<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class ReporteServicios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ReporteServicios_model');
        $this->load->library('session');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $reportes = $this->ReporteServicios_model->obtener_reportes();
        if ($reportes === null) $reportes = array();

        $data['title']              = 'Reportes de Servicios';
        $data['reportes']           = $reportes;
        $data['laboratorio_nombre'] = $this->session->userdata('laboratorio_nombre');

        $this->load->view('templates/header', $data);
        $this->load->view('panel/ReporteAnual/vista_reportes', $data);
        $this->load->view('templates/footer', $data);
    }

    public function crear()
    {
        $año = (int) $this->input->post('año');

        if (empty($año) || $año < 2000 || $año > 2100) {
            $this->session->set_flashdata('error', 'Año inválido.');
            redirect('reporteservicios');
        }

        $existe = $this->ReporteServicios_model->existe_reporte(
            $año,
            $this->session->userdata('laboratorio_id')
        );

        if ($existe) {
            $this->session->set_flashdata('error', 'Ya existe un reporte para el año ' . $año . '.');
            redirect('reporteservicios');
        }

        $ok = $this->ReporteServicios_model->crear_reporte(
            $año,
            $this->session->userdata('laboratorio_id')
        );

        if ($ok) {
            $this->session->set_flashdata('success', 'Reporte ' . $año . ' creado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al crear el reporte.');
        }

        redirect('reporteservicios');
    }

    public function eliminar($id)
    {
        if (empty($id)) { show_404(); return; }

        $reporte = $this->ReporteServicios_model->obtener_reporte($id);
        if (empty($reporte)) { show_404(); return; }

        $this->ReporteServicios_model->eliminar_reporte($id);
        $this->session->set_flashdata('success', 'Reporte eliminado.');
        redirect('reporteservicios');
    }

    public function reporte($id)
    {
        if (empty($id)) { show_404(); return; }

        $data['title']   = 'Reporte';
        $data['reporte'] = $this->ReporteServicios_model->obtener_reporte($id);

        if (empty($data['reporte'])) { show_404(); return; }

        $this->load->view('templates/header', $data);
        $this->load->view('panel/ReporteAnual/vista_reporte', $data);
        $this->load->view('templates/footer', $data);
    }

    public function actualizar_mes($reporte_id, $mes)
    {
        if (empty($reporte_id) || empty($mes)) { show_404(); return; }

        $data['title']             = 'Actualizar mes';
        $data['reporte_id']        = $reporte_id;
        $data['mes']               = $mes;
        $data['servicios']         = $this->ReporteServicios_model->obtener_servicios()         ?: array();
        $data['estados_servicios'] = $this->ReporteServicios_model->obtener_estados_servicios($reporte_id, $mes) ?: array();

        $this->load->view('templates/header', $data);
        $this->load->view('panel/ReporteAnual/vista_actualizar_mes', $data);
        $this->load->view('templates/footer', $data);
    }

    public function actualizar_servicios()
    {
        $reporte_id = $this->input->post('reporte_id');
        $mes        = $this->input->post('mes');

        if (empty($reporte_id) || empty($mes)) {
            $this->session->set_flashdata('error', 'Faltan datos necesarios.');
            redirect('reporteservicios');
            return;
        }

        $servicios = $this->ReporteServicios_model->obtener_servicios();

        if (!empty($servicios)) {
            foreach ($servicios as $servicio) {
                if (is_object($servicio) && isset($servicio->id)) {
                    $status = $this->input->post('servicio_' . $servicio->id);
                    $this->ReporteServicios_model->actualizar_servicio($reporte_id, $servicio->id, $mes, $status);
                }
            }
        }

        $this->session->set_flashdata('success', 'Servicios actualizados correctamente.');
        redirect('reporteservicios');
    }

    public function generarReporte($año)
    {
        if (empty($año)) { show_404(); return; }

        // ================================================================
        // ENCARGADOS POR LABORATORIO
        // 1 => Open Source | 2 => Mac
        // Para agregar más: $encargados[3] = 'Nombre encargado';
        // ================================================================
        $laboratorio_id     = $this->session->userdata('laboratorio_id');
        $laboratorio_nombre = $this->session->userdata('laboratorio_nombre') ?: '';
        $programa_academico = $this->session->userdata('programa_academico') ?: '';
        $edificio           = $this->session->userdata('edificio') ?: 'UD4 UPTx';

        $encargados = [
            1 => 'Eulalia Cortés Flores',
            2 => 'Leandro Álvarez Sánchez',
        ];
        $nombre_encargado = $encargados[$laboratorio_id] ?? '';

        // Logos en base64
        $logo_path = APPPATH . 'libraries/fpdf/images/UPTlax_Logo.png';
        $sgc_path  = APPPATH . 'libraries/fpdf/images/sgc.png';
        $logo_b64  = file_exists($logo_path)
                   ? 'data:image/png;base64,' . base64_encode(file_get_contents($logo_path))
                   : '';
        $sgc_b64   = file_exists($sgc_path)
                   ? 'data:image/png;base64,' . base64_encode(file_get_contents($sgc_path))
                   : '';

        // Datos del reporte
        $datos_query = $this->ReporteServicios_model->getDatosReporte($año);
        $datos       = ($datos_query === null) ? [] : $datos_query->result_array();

        $datosAgrupados = [];
        foreach ($datos as $dato) {
            if (isset($dato['mes'], $dato['nombre_servicio'], $dato['status'], $dato['nombre_categoria'])) {
                $cat = $dato['nombre_categoria'];
                $srv = $dato['nombre_servicio'];
                if (!isset($datosAgrupados[$cat]))       $datosAgrupados[$cat]       = [];
                if (!isset($datosAgrupados[$cat][$srv])) $datosAgrupados[$cat][$srv] = array_fill(1, 12, '');
                $datosAgrupados[$cat][$srv][$dato['mes']] = $dato['status'];
            }
        }

        // Construir filas de datos
        $filas_datos = '';
        foreach ($datosAgrupados as $categoria => $servicios) {
            $filas_datos .= '
            <tr>
                <td colspan="13" class="cat-header">' . htmlspecialchars($categoria) . '</td>
            </tr>';
            foreach ($servicios as $servicio => $estados) {
                $filas_datos .= '<tr><td class="td-srv">' . htmlspecialchars($servicio) . '</td>';
                for ($i = 1; $i <= 12; $i++) {
                    $filas_datos .= '<td class="td-mes">' . htmlspecialchars($estados[$i] ?? '') . '</td>';
                }
                $filas_datos .= '</tr>';
            }
        }

        $html = '<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>

/* ── Página A4 portrait ── */
@page {
    size: A4 portrait;
    margin: 12mm 10mm 10mm 10mm;
}
body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 8.5pt;
    color: #000;
    margin: 0;
    padding: 0;
}

/* ── ENCABEZADO ── */
.header-wrap {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 6px;
}
.header-wrap td {
    padding: 0;
    vertical-align: middle;
}
.cell-logo-izq { width: 70px; text-align: left; }
.cell-logo-izq img { width: 65px; height: auto; }
.cell-texto {
    text-align: center;
    font-size: 9pt;
    line-height: 1.7;
}
.cell-logo-der { width: 70px; text-align: right; }
.cell-logo-der img { width: 60px; height: auto; }

/* ── INFO LABORATORIO ── */
.info-wrap {
    width: 100%;
    border-collapse: collapse;
    border: 0.2px dashed #000;
    margin-bottom: 6px;
}
.info-wrap td {
    border: 0.2px dashed #000;
   
    font-size: 8.5pt;
}
/* Labels con gris igual al de categorías */
.lbl { background: #e0e0e0; font-weight: normal; }

/* ── AÑO (CORREGIDO) ── */
.anio-row {
    text-align: center;
    font-size: 9pt;
    margin-bottom: 3px;
}

/* ── TABLA PRINCIPAL ── */
.tabla-main {
    width: 100%;
    border-collapse: collapse;
    font-size: 8pt;
    margin-bottom: 12px;
}
.tabla-main th {
    border: 1.5px solid #000;
    text-align: center;
    padding: 3px 1px;
    background: #fff;
    font-weight: normal;
    font-size: 8pt;
}
.tabla-main td {
    border: 1.5px solid #000;
    padding: 2px 3px;
    font-size: 8pt;
}
.th-srv  { width: 38%; text-align: center; }
.th-dia  { width: 38%; text-align: center; }
.th-num  { width: 5%;  text-align: center; }
.td-srv  { text-align: left; width: 38%; }
.td-mes  { text-align: center; width: 5%; }

/* Categoría — gris claro igual al original */
.cat-header {
    background: #e0e0e0;
    text-align: center;
    font-weight: normal;
    padding: 4px 3px;
    font-size: 8.5pt;
}

/* ── FIRMAS ── */
.firmas-wrap {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    margin-bottom: 6px;
}
.firmas-wrap td { padding: 0; }

.firma-box {
    width: 42%;
    border: 0.2px dashed #000;
    text-align: center;
    vertical-align: top;
}
.firma-label {
    border-bottom: 1.5px solid #00000000;
    padding: 3px 5px;
    font-size: 8pt;
    text-align: left;
}
.firma-espacio {
    height: 28px;
}
.firma-nombre {
    border-top: 1.5px solid #00000000;
    padding: 3px 5px;
    font-weight: bold;
    font-size: 8pt;
    text-align: center;
}
.firma-cargo {
    padding: 2px 5px;
    font-size: 7.5pt;
    text-align: center;
}
.firma-sep { width: 16%; }

/* ── PIE DE PÁGINA — franja roja ── */
.footer-bar {
    width: 100%;
    background-color: #8B1A10;
    color: #ffffff;
    font-size: 7.5pt;
    padding: 4px 8px;
    margin-top: 8px;
    /* dompdf: usar tabla para el fondo */
}
.footer-table {
    width: 100%;
    border-collapse: collapse;
    background-color: #8B1A10;
}
.footer-table td {
    background-color: #8B1A10;
    color: #ffffff;
    font-size: 7.5pt;
    padding: 4px 8px;
}

</style>
</head>
<body>

<!-- ══ ENCABEZADO ══ -->
<table class="header-wrap">
<tr>
    <td class="cell-logo-izq">
        ' . ($logo_b64 ? '<img src="' . $logo_b64 . '">' : '') . '
    </td>
    <td class="cell-texto">
        Subproceso de Apoyo: Laboratorios<br>
        Formato: <strong>Lista de Cotejo para Laboratorios</strong><br>
        Fecha de aprobaci&oacute;n: <strong>octubre 2023</strong>
    </td>
    <td class="cell-logo-der">
        ' . ($sgc_b64 ? '<img src="' . $sgc_b64 . '">' : '') . '
    </td>
</tr>
</table>

<!-- ══ INFO LABORATORIO ══ -->
<table class="info-wrap">
<tr>
    <td class="lbl" style="width:13%;">Laboratorio:</td>
    <td style="width:22%;">' . htmlspecialchars($laboratorio_nombre) . '</td>
    <td class="lbl" style="width:19%;">Programa Acad&eacute;mico</td>
    <td style="width:30%;">' . htmlspecialchars($programa_academico) . '</td>
    <td class="lbl" style="width:8%;">Edificio:</td>
    <td style="width:8%;">' . htmlspecialchars($edificio) . '</td>
</tr>
</table>

<!-- ══ AÑO (CORREGIDO) ══ -->
<div class="anio-row">&#60;' . $año . '&#62;</div>

<!-- ══ TABLA PRINCIPAL ══ -->
<table class="tabla-main">
<thead>
    <tr>
        <th class="th-srv">Mes</th>
        <th class="th-num">1</th><th class="th-num">2</th><th class="th-num">3</th>
        <th class="th-num">4</th><th class="th-num">5</th><th class="th-num">6</th>
        <th class="th-num">7</th><th class="th-num">8</th><th class="th-num">9</th>
        <th class="th-num">10</th><th class="th-num">11</th><th class="th-num">12</th>
    </tr>
    <tr>
        <th class="th-dia">Dia</th>
        <th class="th-num">&nbsp;</th><th class="th-num">&nbsp;</th><th class="th-num">&nbsp;</th>
        <th class="th-num">&nbsp;</th><th class="th-num">&nbsp;</th><th class="th-num">&nbsp;</th>
        <th class="th-num">&nbsp;</th><th class="th-num">&nbsp;</th><th class="th-num">&nbsp;</th>
        <th class="th-num">&nbsp;</th><th class="th-num">&nbsp;</th><th class="th-num">&nbsp;</th>
    </tr>
</thead>
<tbody>
    ' . $filas_datos . '
</tbody>
</table>

<!-- ══ FIRMAS ══ -->
<table class="firmas-wrap">
<tr>
    <td class="firma-box">
        <div class="firma-label">Elabor&oacute;:</div>
        <div class="firma-espacio"></div>
        <div class="firma-nombre">' . htmlspecialchars($nombre_encargado) . '</div>
        <div class="firma-cargo">Jefe de Laboratorio</div>
    </td>
    <td class="firma-sep"></td>
    <td class="firma-box">
        <div class="firma-label">Vo. Bo.:</div>
        <div class="firma-espacio"></div>
        <div class="firma-nombre">&nbsp;</div>
        <div class="firma-cargo">Director de Programa Educativo</div>
    </td>
</tr>
</table>

<!-- ══ PIE DE PÁGINA ══ -->
<table class="footer-table">
<tr>
    <td>Para uso de la Universidad Polit&eacute;cnica de Tlaxcala mediante su Sistema de Gesti&oacute;n de la Calidad</td>
</tr>
</table>

</body>
</html>';

        // ================================================================
        // GENERAR PDF CON DOMPDF
        // Para cambiar orientación: 'landscape' en lugar de 'portrait'
        // ================================================================
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        if (ob_get_level()) ob_end_clean();

        $dompdf->stream(
            'reporte_anual_' . $año . '.pdf',
            ['Attachment' => false] // false = abrir en navegador | true = descargar
        );
        exit;
    }
}