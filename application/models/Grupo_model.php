<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Model Grupo_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    ac.id>
 * @link      
 * @param     ...
 * @return    ...
 *
 */

class Grupo_model extends CI_Model {

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

  public function obtenerMesas(){
    $query = $this->db->get('mesas');
    return $query->result();
  }

  public function obtenerGrupos($id_mesa){
    $this->db->where('id_mesas', $id_mesa);
    $query = $this->db->get('grupos');
    return $query->result();
  }

  public function getEquipos($id_grupo){
    $this->db->select('equipos.*, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado');
    $this->db->from('equipos');
    $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
    $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
    $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');

    $this->db->where('id_grupos', $id_grupo);
    $this->db->order_by('equipos.id_tipos', 'ASC');
    $query = $this->db->get();
    return $query->result();
  }

  public function obtenerEquiporPorTipo($tipo){
    $this->db->select('equipos.id_tipos, equipos.cod_interno, equipos.modelo, equipos.id_equipos, marcas.nombre as marca, tipos.nombre as tipo');
    $this->db->where('equipos.id_tipos', $tipo);
    $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
    $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
    $query = $this->db->get('equipos');
    return $query->result();
  }

  public function obtenerEquipoAsignado($id_grupo, $tipo_equipo){
    $this->db->where('id_grupos', $id_grupo);
    $this->db->where('equipos.id_tipos', $tipo_equipo);
    $this->db->select('equipos.*, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado, ccompu.procesador, ccompu.tarjeta , ccompu.ram');
  $this->db->from('equipos');
  $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
  $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
  $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');
  $this->db->join('ccompu', 'equipos.id_ccompus = ccompu.id_ccompus', 'left');
    
    $query = $this->db->get();

    return $query->result();
  }

  public function obtenerIdAsignado($id_grupo, $tipo_equipo){
    $this->db->select('equipos.id_equipos');
    $this->db->where('id_grupos', $id_grupo);
    $this->db->where('id_tipos', $tipo_equipo);
    $query = $this->db->get('equipos');

    return $query->row();
  }

  public function asignarGrupo($id_equipo, $datos){
    $this->db->where('id_equipos', $id_equipo);
    return $this->db->update('equipos', $datos);
  }
  
  public function eliminarEquipoGrupo($id_tipo, $id_grupo){
    $this->db->where('id_tipos', $id_tipo);
    $this->db->where('id_grupos', $id_grupo);
    return $this->db->update('equipos', array('id_grupos' => null));
  }
}

/* End of file Grupo_model.php */
/* Location: ./application/models/Grupo_model.php */