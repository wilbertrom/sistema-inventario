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
    // Método vacío
    return;
  }

  // ------------------------------------------------------------------------
  
  // Crear una nueva requisición
  public function create_requisition($data) 
  {
    // Verificar que los datos no estén vacíos y sean un array
    if (empty($data) || !is_array($data)) {
        return false;
    }
    
    $this->db->insert('requisiciones', $data);
    return $this->db->insert_id();
  }

  // Agregar ítems a una requisición
  public function add_requisition_items($items) 
  {
    // Verificar que los items no estén vacíos y sean un array
    if (empty($items) || !is_array($items)) {
        return false;
    }
    
    return $this->db->insert_batch('items_requisiciones', $items);
  }

  // Obtener todas las requisiciones con sus ítems
  public function get_requisitions() 
  {
    $this->db->select('requisiciones.*, GROUP_CONCAT(items_requisiciones.nombre SEPARATOR ", ") as items')
      ->from('requisiciones')
      ->join('items_requisiciones', 'items_requisiciones.id_req = requisiciones.id_req', 'left')
      ->group_by('requisiciones.id_req');
    
    $query = $this->db->get();
    
    // Verificar que la consulta fue exitosa
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  // Obtener una requisición específica con sus ítems
  public function get_requisition($id_req) 
  {
    // Verificar que el ID no esté vacío
    if (empty($id_req)) {
        return array();
    }
    
    $this->db->select('requisiciones.*, items_requisiciones.nombre, items_requisiciones.cantidad')
      ->from('requisiciones')
      ->join('items_requisiciones', 'items_requisiciones.id_req = requisiciones.id_req', 'left')
      ->where('requisiciones.id_req', $id_req);
    
    $query = $this->db->get();
    
    // Verificar que la consulta fue exitosa
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }
}

/* End of file Requisiciones_model.php */
/* Location: ./application/models/Requisiciones_model.php */