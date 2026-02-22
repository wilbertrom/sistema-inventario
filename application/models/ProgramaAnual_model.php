<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramaAnual_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getByLaboratorioAnio($laboratorio_id, $anio)
    {
        $this->db->where('laboratorio_id', $laboratorio_id);
        $this->db->where('anio', $anio);
        $this->db->order_by('id', 'ASC');
        return $this->db->get('programa_anual_mantenimiento')->result();
    }

    public function getById($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('programa_anual_mantenimiento')->row();
    }

    public function insertPrograma($data)
    {
        $this->db->insert('programa_anual_mantenimiento', $data);
        return $this->db->insert_id();
    }

    // ── Actualizar firmas y edificio ────────────────────────────
    public function updateFirmas($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('programa_anual_mantenimiento', $data);
    }

    public function deletePrograma($id)
    {
        $this->db->where('programa_id', $id);
        $this->db->delete('programa_anual_mantenimiento_detalle');
        $this->db->where('id', $id);
        return $this->db->delete('programa_anual_mantenimiento');
    }

    public function getAniosDisponibles($laboratorio_id)
    {
        $this->db->select('anio');
        $this->db->where('laboratorio_id', $laboratorio_id);
        $this->db->distinct();
        $this->db->order_by('anio', 'DESC');
        $query = $this->db->get('programa_anual_mantenimiento');

        $anios = [];
        foreach ($query->result() as $row) {
            $anios[] = $row->anio;
        }
        $anio_actual = date('Y');
        if (!in_array($anio_actual, $anios)) {
            $anios[] = $anio_actual;
        }
        sort($anios);
        return $anios;
    }
}














