<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdenMantenimiento_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Obtener todas las órdenes por laboratorio
     */
    public function getByLaboratorio($laboratorio_id)
    {
        $this->db->where('laboratorio_id', $laboratorio_id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('ordenes_mantenimiento');
        return $query->result();
    }
    
    /**
     * Obtener una orden por ID
     */
    public function getById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('ordenes_mantenimiento');
        return $query->row();
    }
    
    /**
     * Insertar nueva orden
     */
    public function insert($data)
    {
        $this->db->insert('ordenes_mantenimiento', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Actualizar orden
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('ordenes_mantenimiento', $data);
    }
    
    /**
     * Eliminar orden
     */
    public function delete($id)
    {
        // Eliminar trabajos asociados primero
        $this->db->where('orden_id', $id);
        $this->db->delete('orden_trabajo_mantenimiento');
        
        // Eliminar orden
        $this->db->where('id', $id);
        return $this->db->delete('ordenes_mantenimiento');
    }
}