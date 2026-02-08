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
    // 
  }

  // ------------------------------------------------------------------------

  public function registrar_orden($data){
    $this->db->insert('mantenimientos', $data);
    return $this->db->insert_id();
  }

  public function obtenerOrdenesEquipo($id){
    $this->db->where('id_equipos', $id);
    $query = $this->db->get('mantenimientos');
    return $query->result();
  }
  public function   obtenerTodosMantenimientos(){
    $this->db->select('mantenimientos.*, equipos.cod_interno');
    $this->db->from('mantenimientos');
    $this->db->join('equipos', 'mantenimientos.id_equipos=equipos.id_equipos', 'left');

    $query = $this->db->get();
    return $query->result();
  }

  public function obtenerNumeroMantenimientos(){
    $this->db->select("mantenimentos");
    return $this->db->count_all_results();
  }
  public function obtenerNumeroReq(){
    $this->db->select("requisiciones");
    return $this->db->count_all_results();
  }
}

/* End of file Orden_model.php */
/* Location: ./application/models/Orden_model.php */