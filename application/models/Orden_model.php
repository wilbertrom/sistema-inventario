<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orden_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    return;
  }

  public function registrar_orden($data)
  {
    if (empty($data) || !is_array($data)) {
        return false;
    }
    
    // Agregar laboratorio_id desde sesión
    $data['laboratorio_id'] = $this->session->userdata('laboratorio_id');
    
    $this->db->insert('mantenimientos', $data);
    return $this->db->insert_id();
  }

  public function obtenerOrdenesEquipo($id)
  {
    if (empty($id)) {
        return array();
    }
    
    $this->db->where('id_equipos', $id);
    $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    $query = $this->db->get('mantenimientos');
    
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
    $this->db->where('mantenimientos.laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro

    $query = $this->db->get();
    
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function obtenerNumeroMantenimientos()
  {
    $this->db->from("mantenimientos");
    $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    $count = $this->db->count_all_results();
    
    return is_numeric($count) ? (int)$count : 0;
  }
  
  public function obtenerNumeroReq()
  {
    $this->db->from("requisiciones");
    $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    $count = $this->db->count_all_results();
    
    return is_numeric($count) ? (int)$count : 0;
  }
  /**
 * Contar mantenimientos por laboratorio
 */
public function contar_mantenimientos_por_laboratorio($laboratorio_id)
{
    if (empty($laboratorio_id)) {
        return 0;
    }
    $this->db->where('laboratorio_id', $laboratorio_id);
    return $this->db->count_all_results('mantenimientos');
}

/**
 * Obtener mantenimientos por laboratorio
 */
public function obtener_mantenimientos_por_laboratorio($laboratorio_id)
{
    $this->db->where('laboratorio_id', $laboratorio_id);
    $query = $this->db->get('mantenimientos');
    return $query->result();
}
}

/* End of file Orden_model.php */
/* Location: ./application/models/Orden_model.php */