<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReporteServicios_model extends CI_Model {

    public function __construct() { parent::__construct(); }

    public function obtener_reportes() {
        $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id'));
        $this->db->order_by('año', 'DESC');
        $query = $this->db->get('reporte_anual');
        return ($query === false) ? array() : $query->result();
    }

    public function obtener_reporte($id) {
        if (empty($id)) return null;
        $this->db->where('id', $id);
        $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id'));
        $query = $this->db->get('reporte_anual');
        if ($query === false || $query->num_rows() === 0) return null;
        return $query->row();
    }

    public function existe_reporte($año, $laboratorio_id) {
        $this->db->where('año', $año)->where('laboratorio_id', $laboratorio_id);
        return $this->db->count_all_results('reporte_anual') > 0;
    }

    public function crear_reporte($año, $laboratorio_id) {
        return $this->db->insert('reporte_anual', ['año' => $año, 'laboratorio_id' => $laboratorio_id]);
    }

    public function eliminar_reporte($id) {
        $this->db->where('reporte_id', $id)->delete('registro_mensual');
        $this->db->where('id', $id)->where('laboratorio_id', $this->session->userdata('laboratorio_id'));
        return $this->db->delete('reporte_anual');
    }

    // ── NUEVO: guardar fecha, observaciones y firmantes del reporte ──
    public function actualizar_reporte($id, $data) {
        $this->db->where('id', $id)
                 ->where('laboratorio_id', $this->session->userdata('laboratorio_id'));
        return $this->db->update('reporte_anual', $data);
    }

    // ── NUEVO: obtener fecha guardada de un mes específico ──
    public function obtener_fecha_mes($reporte_id, $mes) {
        $this->db->select('fecha')->where('reporte_id', $reporte_id)
                 ->where('mes', $mes)->where('laboratorio_id', $this->session->userdata('laboratorio_id'))
                 ->limit(1);
        $q = $this->db->get('registro_mensual');
        if ($q && $q->num_rows() > 0) return $q->row()->fecha ?? '';
        return '';
    }

    public function obtener_servicios() {
        // JOIN con categorias para agrupar en la vista
        $this->db->select('s.*, c.nombre_categoria')
                 ->from('servicio s')
                 ->join('categorias c', 's.categoria_id = c.id', 'left')
                 ->order_by('c.id, s.id');
        $query = $this->db->get();
        return ($query === false) ? array() : $query->result();
    }

    public function actualizar_servicio($reporte_id, $servicio_id, $mes, $status, $fecha = null) {
        if (empty($reporte_id) || empty($servicio_id) || empty($mes) || $status === null) return false;
        $lab_id = $this->session->userdata('laboratorio_id');

        $data = [
            'reporte_id'     => $reporte_id,
            'servicio_id'    => $servicio_id,
            'mes'            => $mes,
            'status'         => $status,
            'laboratorio_id' => $lab_id,
            'fecha'          => $fecha,
        ];

        $this->db->where('reporte_id', $reporte_id)->where('servicio_id', $servicio_id)
                 ->where('mes', $mes)->where('laboratorio_id', $lab_id);
        $q = $this->db->get('registro_mensual');

        if ($q !== false && $q->num_rows() > 0) {
            $this->db->where('reporte_id', $reporte_id)->where('servicio_id', $servicio_id)
                     ->where('mes', $mes)->where('laboratorio_id', $lab_id);
            return $this->db->update('registro_mensual', $data);
        }
        return $this->db->insert('registro_mensual', $data);
    }

    public function obtener_estados_servicios($reporte_id, $mes) {
        if (empty($reporte_id) || empty($mes)) return array();
        $this->db->where('reporte_id', $reporte_id)->where('mes', $mes)
                 ->where('laboratorio_id', $this->session->userdata('laboratorio_id'));
        $query = $this->db->get('registro_mensual');
        if ($query === false) return array();
        $estados = array();
        foreach ($query->result() as $row) {
            if (isset($row->servicio_id, $row->status)) $estados[$row->servicio_id] = $row->status;
        }
        return $estados;
    }

    public function getDatosReporte($año) {
        if (empty($año)) return $this->db->get_where('registro_mensual', ['1'=>'0']);
        $this->db->select('s.nombre_servicio, r.mes, r.status, r.fecha, c.nombre_categoria')
                 ->from('registro_mensual r')
                 ->join('servicio s', 'r.servicio_id = s.id')
                 ->join('categorias c', 's.categoria_id = c.id')
                 ->join('reporte_anual ra', 'r.reporte_id = ra.id')
                 ->where('ra.año', $año)
                 ->where('ra.laboratorio_id', $this->session->userdata('laboratorio_id'))
                 ->where('r.laboratorio_id', $this->session->userdata('laboratorio_id'));
        $query = $this->db->get();
        return ($query === false) ? $this->db->get_where('registro_mensual', ['1'=>'0']) : $query;
    }

    // ── NUEVO: obtener fechas por mes para el PDF ──
    public function getFechasPorMes($año) {
        $this->db->select('r.mes, r.fecha')
                 ->from('registro_mensual r')
                 ->join('reporte_anual ra', 'r.reporte_id = ra.id')
                 ->where('ra.año', $año)
                 ->where('ra.laboratorio_id', $this->session->userdata('laboratorio_id'))
                 ->where('r.fecha IS NOT NULL', null, false)
                 ->group_by('r.mes');
        $q = $this->db->get();
        $fechas = [];
        if ($q) foreach ($q->result() as $row) $fechas[$row->mes] = $row->fecha;
        return $fechas;
    }
}