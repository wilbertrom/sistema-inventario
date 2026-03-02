<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdenMantenimiento_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAll()
    {
        return $this->db->order_by('created_at', 'DESC')->get('ordenes_mantenimiento')->result();
    }

    public function getByLaboratorio($laboratorio_id)
    {
        $this->db->where('laboratorio_id', $laboratorio_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('ordenes_mantenimiento')->result();
    }

    public function getById($id)
    {
        return $this->db->get_where('ordenes_mantenimiento', ['id' => $id])->row();
    }

    public function insert($data)
    {
        $this->db->insert('ordenes_mantenimiento', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('ordenes_mantenimiento', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('ordenes_mantenimiento');
    }

    public function contar_por_laboratorio($laboratorio_id)
    {
        $this->db->where('laboratorio_id', $laboratorio_id);
        return $this->db->count_all_results('ordenes_mantenimiento');
    }
}