<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requisiciones_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    return;
  }
  
  public function create_requisition($data) 
  {
    if (empty($data) || !is_array($data)) {
        return false;
    }
    
    // Agregar laboratorio_id desde sesión
    $data['laboratorio_id'] = $this->session->userdata('laboratorio_id');
    
    $this->db->insert('requisiciones', $data);
    return $this->db->insert_id();
  }

  public function add_requisition_items($items) 
  {
    if (empty($items) || !is_array($items)) {
        return false;
    }
    
    return $this->db->insert_batch('items_requisiciones', $items);
  }

  public function get_requisitions() 
  {
    $this->db->select('requisiciones.*, GROUP_CONCAT(items_requisiciones.nombre SEPARATOR ", ") as items')
      ->from('requisiciones')
      ->join('items_requisiciones', 'items_requisiciones.id_req = requisiciones.id_req', 'left')
      ->where('requisiciones.laboratorio_id', $this->session->userdata('laboratorio_id')) // Filtro
      ->group_by('requisiciones.id_req');
    
    $query = $this->db->get();
    
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function get_requisition($id_req) 
  {
    if (empty($id_req)) {
        return array();
    }
    
    $this->db->select('requisiciones.*, items_requisiciones.nombre, items_requisiciones.cantidad')
      ->from('requisiciones')
      ->join('items_requisiciones', 'items_requisiciones.id_req = requisiciones.id_req', 'left')
      ->where('requisiciones.id_req', $id_req)
      ->where('requisiciones.laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    
    $query = $this->db->get();
    
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }
  /**
 * Contar requisiciones por laboratorio
 */
public function contar_requisiciones_por_laboratorio($laboratorio_id)
{
    if (empty($laboratorio_id)) {
        return 0;
    }
    $this->db->where('laboratorio_id', $laboratorio_id);
    return $this->db->count_all_results('requisiciones');
}

/**
 * Obtener requisiciones por laboratorio
 */
public function obtener_requisiciones_por_laboratorio($laboratorio_id)
{
    $this->db->where('laboratorio_id', $laboratorio_id);
    $query = $this->db->get('requisiciones');
    return $query->result();
}
}

/* End of file Requisiciones_model.php */
/* Location: ./application/models/Requisiciones_model.php */