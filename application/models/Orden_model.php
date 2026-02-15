<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Model Orden_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Orden_model extends CI_Model {

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

  public function registrar_orden($data)
  {
    // Verificar que los datos no estén vacíos y sean un array
    if (empty($data) || !is_array($data)) {
        return false;
    }
    
    $this->db->insert('mantenimientos', $data);
    return $this->db->insert_id();
  }

  public function obtenerOrdenesEquipo($id)
  {
    // Verificar que el ID no esté vacío
    if (empty($id)) {
        return array();
    }
    
    $this->db->where('id_equipos', $id);
    $query = $this->db->get('mantenimientos');
    
    // Verificar que la consulta fue exitosa
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }
  
  public function obtenerTodosMantenimientos()
  {
    $this->db->select('mantenimientos.*, equipos.cod_interno');
    $this->db->from('mantenimientos');
    $this->db->join('equipos', 'mantenimientos.id_equipos = equipos.id_equipos', 'left');

    $query = $this->db->get();
    
    // Verificar que la consulta fue exitosa
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function obtenerNumeroMantenimientos()
  {
    // Corregido: estaba usando "mantenimentos" (mal escrito)
    $this->db->from("mantenimientos");
    $count = $this->db->count_all_results();
    
    return is_numeric($count) ? (int)$count : 0;
  }
  
  public function obtenerNumeroReq()
  {
    $this->db->from("requisiciones");
    $count = $this->db->count_all_results();
    
    return is_numeric($count) ? (int)$count : 0;
  }
}

/* End of file Orden_model.php */
/* Location: ./application/models/Orden_model.php */