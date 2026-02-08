<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Model Requisiciones_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    
 * @link      
 * @param     ...
 * @return    ...
 *
 */

class Requisiciones_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function index()
  {
    // 
  }

  // ------------------------------------------------------------------------
  // Crear una nueva requisición
  public function create_requisition($data) {
    $this->db->insert('requisiciones', $data);
    return $this->db->insert_id();
}

// Agregar ítems a una requisición
public function add_requisition_items($items) {
    return $this->db->insert_batch('items_requisiciones', $items);
}

// Obtener todas las requisiciones con sus ítems
public function get_requisitions() {
  $this->db->select('requisiciones.*, GROUP_CONCAT(items_requisiciones.nombre SEPARATOR ", ") as items')
  ->from('requisiciones')
  ->join('items_requisiciones', 'items_requisiciones.id_req = requisiciones.id_req', 'left')
  ->group_by('requisiciones.id_req');
    return $this->db->get()->result();
  }

// Obtener una requisición específica con sus ítems
public function get_requisition($id_req) {
  $this->db->select('requisiciones.*, items_requisiciones.nombre, items_requisiciones.cantidad')
   ->from('requisiciones')
   ->join('items_requisiciones', 'items_requisiciones.id_req = requisiciones.id_req', 'left')
   ->where('requisiciones.id_req', $id_req);
  return $this->db->get()->result();
}

}

/* End of file Requisiciones_model.php */
/* Location: ./application/models/Requisiciones_model.php */