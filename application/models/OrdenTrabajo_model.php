<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdenTrabajo_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Obtener trabajos por orden
     */
    public function getByOrden($orden_id)
    {
        $this->db->where('orden_id', $orden_id);
        $query = $this->db->get('orden_trabajo_mantenimiento');
        return $query->result();
    }
    
    /**
     * Insertar trabajo
     */
    public function insert($data)
    {
        $this->db->insert('orden_trabajo_mantenimiento', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Eliminar trabajos por orden
     */
    public function deleteByOrden($orden_id)
    {
        $this->db->where('orden_id', $orden_id);
        return $this->db->delete('orden_trabajo_mantenimiento');
    }
}