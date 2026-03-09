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
        $this->load->model('Firmantes_model');
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

        $reporte = $this->ReporteServicios_model->obtener_reporte($reporte_id);
        if (!$reporte) { show_404(); return; }

        $laboratorio_id = $this->session->userdata('laboratorio_id');

        $data['title']             = 'Actualizar mes';
        $data['reporte_id']        = $reporte_id;
        $data['mes']               = $mes;
        $data['servicios']         = $this->ReporteServicios_model->obtener_servicios() ?: array();
        $data['estados_servicios'] = $this->ReporteServicios_model->obtener_estados_servicios($reporte_id, $mes) ?: array();
        $data['fecha_mes']         = $this->ReporteServicios_model->obtener_fecha_mes($reporte_id, $mes);
        $data['observaciones']     = $reporte->observaciones ?? '';
        $data['elaboro']           = $reporte->elaboro ?? '';
        $data['vobo']              = $reporte->vobo ?? '';
        $data['firmantes_elaboro'] = $this->Firmantes_model->getByRolLab('jefe_laboratorio', $laboratorio_id);
        $data['firmantes_vobo']    = $this->Firmantes_model->getByRol('vo_bo');

        $this->load->view('templates/header', $data);
        $this->load->view('panel/ReporteAnual/vista_actualizar_mes', $data);
        $this->load->view('templates/footer', $data);
    }

    public function actualizar_servicios()
    {
        $reporte_id    = $this->input->post('reporte_id');
        $mes           = $this->input->post('mes');
        $fecha_mes     = $this->input->post('fecha_mes') ?: null;
        $observaciones = $this->input->post('observaciones') ?: '';
        $elaboro       = $this->input->post('elaboro') ?: '';
        $vobo          = $this->input->post('vobo') ?: '';

        if (empty($reporte_id) || empty($mes)) {
            $this->session->set_flashdata('error', 'Faltan datos necesarios.');
            redirect('reporteservicios');
            return;
        }

        $this->db->where('id', $reporte_id);
        $this->db->update('reporte_anual', [
            'observaciones' => $observaciones,
            'elaboro'       => $elaboro,
            'vobo'          => $vobo,
        ]);

        $servicios = $this->ReporteServicios_model->obtener_servicios();
        if (!empty($servicios)) {
            foreach ($servicios as $servicio) {
                if (is_object($servicio) && isset($servicio->id)) {
                    $status = $this->input->post('servicio_' . $servicio->id);
                    $this->ReporteServicios_model->actualizar_servicio($reporte_id, $servicio->id, $mes, $status, $fecha_mes);
                }
            }
        }

        $this->session->set_flashdata('success', 'Servicios actualizados correctamente.');
        redirect('reporteservicios');
    }

    public function guardar_info()
    {
        $laboratorio_id     = $this->session->userdata('laboratorio_id');
        $programa_academico = $this->input->post('programa_academico') ?: '';
        $edificio           = $this->input->post('edificio') ?: '';

        $this->db->where('id', $laboratorio_id);
        $this->db->update('laboratorios', [
            'programa_academico' => $programa_academico,
            'edificio'           => $edificio,
        ]);

        $this->session->set_userdata('programa_academico', $programa_academico);
        $this->session->set_userdata('edificio', $edificio);

        $this->session->set_flashdata('success', 'Información actualizada correctamente.');
        redirect('reporteservicios');
    }

    public function generarReporte($año)
    {
        if (empty($año)) { show_404(); return; }

        $laboratorio_id     = $this->session->userdata('laboratorio_id');
        $laboratorio_nombre = $this->session->userdata('laboratorio_nombre') ?: '';
        $programa_academico = $this->session->userdata('programa_academico') ?: '';
        $edificio           = $this->session->userdata('edificio') ?: 'UD4 UPTx';

        // Firmantes desde BD
        $reportes_lista = $this->ReporteServicios_model->obtener_reportes();
        $reporte_actual = null;
        foreach ((array)$reportes_lista as $r) {
            if ($r->año == $año) { $reporte_actual = $r; break; }
        }

        $nombre_encargado = $reporte_actual->elaboro ?? '';
        if (empty($nombre_encargado)) {
            $jefe = $this->Firmantes_model->getByRolLab('jefe_laboratorio', $laboratorio_id);
            $nombre_encargado = !empty($jefe) ? $jefe[0]->nombre : '';
        }

        $nombre_vobo = $reporte_actual->vobo ?? '';
        if (empty($nombre_vobo)) {
            $vobo_list = $this->Firmantes_model->getByRol('vo_bo');
            $nombre_vobo = !empty($vobo_list) ? $vobo_list[0]->nombre : '';
        }

        $observaciones  = $reporte_actual->observaciones ?? '';
        $fechas_por_mes = $this->ReporteServicios_model->getFechasPorMes($año);

        // Logos en base64 (TAMAÑO AUMENTADO)
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
                $srv = str_replace('Lavaojos', 'Lava ojos', $dato['nombre_servicio']);
                if (!isset($datosAgrupados[$cat]))       $datosAgrupados[$cat]       = [];
                if (!isset($datosAgrupados[$cat][$srv])) $datosAgrupados[$cat][$srv] = array_fill(1, 12, '');
                $datosAgrupados[$cat][$srv][$dato['mes']] = $dato['status'];
            }
        }

        // Fila Dia con fecha en formato dd/mm/aa resaltada en amarillo
        $fila_dias = '<tr><td class="td-srv" style="text-align:center;">Dia</td>';
        for ($i = 1; $i <= 12; $i++) {
            $fecha = $fechas_por_mes[$i] ?? '';
            $dia   = '';
            if (!empty($fecha)) {
                $partes = explode('-', $fecha);
                if (count($partes) === 3) {
                    $dia = sprintf('%02d/%02d/%02d', (int)$partes[2], (int)$partes[1], (int)substr($partes[0], 2));
                }
            }
            $bg = !empty($dia) ? 'background:#fef08a;font-weight:bold;font-size:6pt;' : '';
            $fila_dias .= '<td class="td-mes" style="' . $bg . '">' . htmlspecialchars($dia) . '</td>';
        }
        $fila_dias .= '</tr>';

        $filas_datos = $fila_dias;
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
/* ── OBSERVACIONES ── */
.obs-wrap {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    margin-bottom: 20px;
}

.obs-wrap td {
    border: 1.5px solid #000;
    height: 55px;           /* ALTURA DEL RECUADRO */
    vertical-align: top;
    padding: 6px;
    font-size: 8pt;
}

.obs-label {
    font-weight: normal;
}
/* ── Página A4 portrait ── */
@page {
    size: A4 portrait;
    margin: 5mm 30mm 5mm 30mm; /* AUMENTADO: top:20mm, right:15mm, bottom:15mm, left:15mm */
}
body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 8.5pt;
    color: #000;
    margin: 0;
    padding: 0;
}

/* ── ENCABEZADO CON LOGOS MÁS GRANDES ── */
.header-wrap {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 8px;
}
.header-wrap td {
    padding: 0;
    vertical-align: middle;
}
.cell-logo-izq { width: 90px; text-align: left; } /* AUMENTADO */
.cell-logo-izq img { width: 150px; height: auto; } /* AUMENTADO de 65px a 85px */
.cell-texto {
    text-align: center;
    font-size: 9pt;
    line-height: 1.7;
}
.cell-logo-der { width: 90px; text-align: right; } /* AUMENTADO */
.cell-logo-der img { width: 130px; height: auto; } /* AUMENTADO de 60px a 80px */

/* ── INFO LABORATORIO ── */
.info-wrap {
    width: 100%;
    border-collapse: collapse;
    border: 0.2px dashed #000;
    margin-bottom: 20px; /* AUMENTADO */
    margin-top: 24px;     /* ← AGREGA ESTA LÍNEA para espacio ANTES */
}
.info-wrap td {
    border: 0.2px dashed #000;
    font-size: 8.0pt;
    height: 5px; /* ← CAMBIA ESTE VALOR para ajustar la altura */

}
/* Labels con gris igual al de categorías */
.lbl { background: #e0e0e0; font-weight: normal; }

/* ── AÑO (CORREGIDO) ── */
.anio-row {
    text-align: center;
    font-size: 9pt;
    margin-bottom: -2px; /* AUMENTADO */
}

/* ── TABLA PRINCIPAL ── */
.tabla-main {
    width: 100%;
    border-collapse: collapse;
    font-size: 8pt;
    margin-bottom: 5px; /* AUMENTADO */
}
.tabla-main th {
    border: 1.5px solid #000;
    text-align: center;
    
    background: #fff;
    font-weight: normal;
    font-size: 8pt;
}
.tabla-main td {
    border: 1.5px solid #000;
   
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
    padding: 5px 4px; /* AUMENTADO */
    font-size: 8.5pt;
}

/* ── FIRMAS ── */
.firmas-wrap {
    width: 100%;
    border-collapse: collapse;
    margin-top: 50px;
    margin-bottom: 50px;
}

.firma-box {
    height: 90px;
    border: 0.8px dashed #000;
    text-align: center;
    padding-top: 6px;
}

.firma-label {
    font-size: 8pt;
    margin-bottom: 35px; /* espacio para firma */
}

.firma-nombre {
    font-weight: bold;
    font-size: 8pt;
    margin-top: 65px;
}

.firma-cargo {
    margin-top: 5px;
    font-size: 7.5pt;
    text-align: center;
}

.firma-sep {
    width: 16%;
}
}
/* ── PIE DE PÁGINA — franja roja ── */
.footer-bar {
    width: 100%;
    background-color: #8B1A10;
    color: #ffffff;
    font-size: 7.5pt;
    padding: 5px 10px; /* AUMENTADO */
   
}
.footer-table {
    width: 100%;
    border-collapse: collapse;
    background-color: #8B1A10;
    margin-top: 160px; /* AUMENTADO */
    
}
.footer-table td {
    background-color: #8B1A10;
    color: #ffffff;
    font-size: 8.5pt;
    
    text-align: center;

}

</style>
</head>
<body>

<!-- ══ ENCABEZADO CON LOGOS MÁS GRANDES ══ -->
<table class="header-wrap">
<tr>
    <td class="cell-logo-izq">
        ' . ($logo_b64 ? '<img src="' . $logo_b64 . '">' : '') . '
    </td>
    <td class="cell-texto">
        Subproceso de Apoyo:<strong> Laboratorios </strong><br>
        Formato: <strong>Lista de Cotejo para Laboratorios</strong><br>
        Fecha de aprobaci&oacute;n: <strong>octubre 2023</strong>
    </td>
    <td class="cell-logo-der">
        ' . ($sgc_b64 ? '<img src="' . $sgc_b64 . '">' : '') . '
    </td>A
</tr>
</table>

<!-- ══ INFO LABORATORIO ══ -->
<table class="info-wrap">
<tr>
    <td class="lbl" style="width:13%;">Laboratorio:</td>
    <td style="width:16%;"><strong>' . htmlspecialchars($laboratorio_nombre) . '</strong></td>
    <td class="lbl" style="width:19%;">Programa Acad&eacute;mico</td>
    <td style="width:20%;"><strong>' . htmlspecialchars($programa_academico) . '</strong></td>
    <td class="lbl" style="width:8%;">Edificio:</td>
    <td style="width:20%;"><strong>' . htmlspecialchars($edificio) . '</strong></td>
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
</thead>
<tbody>
    ' . $filas_datos . '
</tbody>
</table>
<!-- ══ OBSERVACIONES ══ -->
<table class="obs-wrap">
<tr>
    <td>
        <span class="obs-label">Observaciones:</span>
        <div style="margin-top:4px;font-size:8pt;">' . htmlspecialchars($observaciones) . '</div>
    </td>
</tr>
</table>
<table class="firmas-wrap">
<tr>
    <td style="width:42%; text-align:center;">
        <div class="firma-box">
            <div class="firma-label"><strong>Elaboró</strong></div>
            <div class="firma-nombre"><strong>' . htmlspecialchars($nombre_encargado) . '</strong></div>
        </div>
        <div class="firma-cargo"><strong>Jefe de Laboratorio</div>
    </strong></td>

    <td class="firma-sep"></td>

    <td style="width:42%; text-align:center;">
        <div class="firma-box">
            <div class="firma-label"><strong>Vo. Bo.</strong></div>
            <div class="firma-nombre"><strong>' . htmlspecialchars($nombre_vobo) . '</strong></div>
        </div>
        <div class="firma-cargo"><strong>Director de Programa Educativo</div>
    </strong></td>
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
            ['Attachment' => false]
        );
        exit;
    }
}