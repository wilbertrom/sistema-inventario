<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReporteServicios_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function obtener_reportes()
    {
        $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id'));
        $this->db->order_by('año', 'DESC');
        $query = $this->db->get('reporte_anual');
        return ($query === false) ? array() : $query->result();
    }

    public function obtener_reporte($id)
    {
        if (empty($id)) return null;
        $this->db->where('id', $id);
        $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id'));
        $query = $this->db->get('reporte_anual');
        if ($query === false || $query->num_rows() === 0) return null;
        return $query->row();
    }

    // ── NUEVO ────────────────────────────────────────────────────
    public function existe_reporte($año, $laboratorio_id)
    {
        $this->db->where('año', $año);
        $this->db->where('laboratorio_id', $laboratorio_id);
        return $this->db->count_all_results('reporte_anual') > 0;
    }

    public function crear_reporte($año, $laboratorio_id)
    {
        $data = array(
            'año'            => $año,
            'laboratorio_id' => $laboratorio_id,
        );
        return $this->db->insert('reporte_anual', $data);
    }

    public function eliminar_reporte($id)
    {
        // Eliminar registros mensuales asociados primero
        $this->db->where('reporte_id', $id);
        $this->db->delete('registro_mensual');
        // Eliminar el reporte
        $this->db->where('id', $id);
        $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id'));
        return $this->db->delete('reporte_anual');
    }
    // ─────────────────────────────────────────────────────────────

    public function obtener_servicios()
    {
        $query = $this->db->get('servicio');
        return ($query === false) ? array() : $query->result();
    }

    public function actualizar_servicio($reporte_id, $servicio_id, $mes, $status)
    {
        if (empty($reporte_id) || empty($servicio_id) || empty($mes) || $status === null) return false;

        $lab_id = $this->session->userdata('laboratorio_id');
        $data = array(
            'reporte_id'     => $reporte_id,
            'servicio_id'    => $servicio_id,
            'mes'            => $mes,
            'status'         => $status,
            'laboratorio_id' => $lab_id,
        );

        $this->db->where('reporte_id', $reporte_id);
        $this->db->where('servicio_id', $servicio_id);
        $this->db->where('mes', $mes);
        $this->db->where('laboratorio_id', $lab_id);
        $query = $this->db->get('registro_mensual');

        if ($query !== false && $query->num_rows() > 0) {
            $this->db->where('reporte_id', $reporte_id);
            $this->db->where('servicio_id', $servicio_id);
            $this->db->where('mes', $mes);
            $this->db->where('laboratorio_id', $lab_id);
            return $this->db->update('registro_mensual', $data);
        }
        return $this->db->insert('registro_mensual', $data);
    }

    public function obtener_estados_servicios($reporte_id, $mes)
    {
        if (empty($reporte_id) || empty($mes)) return array();

        $this->db->where('reporte_id', $reporte_id);
        $this->db->where('mes', $mes);
        $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id'));
        $query = $this->db->get('registro_mensual');

        if ($query === false) return array();

        $estados = array();
        foreach ($query->result() as $row) {
            if (isset($row->servicio_id, $row->status)) {
                $estados[$row->servicio_id] = $row->status;
            }
        }
        return $estados;
    }

    public function getDatosReporte($año)
    {
        if (empty($año)) return $this->db->get_where('registro_mensual', array('1' => '0'));

        $this->db->select('s.nombre_servicio, r.mes, r.status, c.nombre_categoria');
        $this->db->from('registro_mensual r');
        $this->db->join('servicio s', 'r.servicio_id = s.id');
        $this->db->join('categorias c', 's.categoria_id = c.id');
        $this->db->join('reporte_anual ra', 'r.reporte_id = ra.id');
        $this->db->where('ra.año', $año);
        $this->db->where('ra.laboratorio_id', $this->session->userdata('laboratorio_id'));
        $this->db->where('r.laboratorio_id', $this->session->userdata('laboratorio_id'));
        $query = $this->db->get();

        return ($query === false) ? $this->db->get_where('registro_mensual', array('1' => '0')) : $query;
    }
}