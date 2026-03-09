<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdenTrabajo_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getByOrden($orden_id)
    {
        $this->db->where('orden_id', $orden_id);
        $this->db->order_by('id', 'ASC');
        return $this->db->get('orden_trabajo_mantenimiento')->result();
    }

    public function getById($id)
    {
        return $this->db->get_where('orden_trabajo_mantenimiento', ['id' => $id])->row();
    }

    public function insert($data)
    {
        $this->db->insert('orden_trabajo_mantenimiento', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('orden_trabajo_mantenimiento', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('orden_trabajo_mantenimiento');
    }

    public function deleteByOrden($orden_id)
    {
        $this->db->where('orden_id', $orden_id);
        return $this->db->delete('orden_trabajo_mantenimiento');
    }
}