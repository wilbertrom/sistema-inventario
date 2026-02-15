<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Model Inventario_model
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

class Inventario_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  // ------------------------------------------------------------------------

  // ------------------------------------------------------------------------
  public function index()
  {
    // Método vacío
    return;
  }

  // ------------------------------------------------------------------------

  public function registrar_inventario($data) 
  {
    // Verificar que los datos no estén vacíos
    if (empty($data) || !is_array($data)) {
        return false;
    }
    
    $this->db->insert('equipos', $data);
    return $this->db->insert_id();
  }

  public function registrar_ccompu($data) 
  {
    // Verificar que los datos no estén vacíos
    if (empty($data) || !is_array($data)) {
        return false;
    }
    
    $this->db->insert('ccompu', $data);
    return $this->db->insert_id(); // Devuelve el ID insertado
  }
  
  public function actualizar_inventario($data, $id) 
  {
    // Verificar que los parámetros no estén vacíos
    if (empty($data) || !is_array($data) || empty($id)) {
        return false;
    }
    
    $this->db->where('id_equipos', $id);
    $this->db->update('equipos', $data);
    return $this->db->affected_rows() > 0;
  }

  public function actualizar_ccompu($data, $id) 
  {
    // Verificar que los parámetros no estén vacíos
    if (empty($data) || !is_array($data) || empty($id)) {
        return false;
    }
    
    $this->db->where('id_ccompus', $id);
    $this->db->update('ccompu', $data);
    return $this->db->affected_rows() > 0;
  }

  public function actualizar_estado($estado, $id)
  {
    // Verificar que los parámetros no estén vacíos
    if (empty($estado) || empty($id)) {
        return false;
    }
    
    $this->db->where('id_equipos', $id);
    return $this->db->update('equipos', array('id_estados' => $estado));
  }

  public function registrar_marca($data) 
  {
    // Verificar que los datos no estén vacíos
    if (empty($data) || !is_array($data)) {
        return false;
    }
    
    return $this->db->insert('marcas', $data);
  }

  public function registrar_tipo($data) 
  {
    // Verificar que los datos no estén vacíos
    if (empty($data) || !is_array($data)) {
        return false;
    }
    
    return $this->db->insert('tipos', $data);
  }
  
  public function obtener_tipos()
  {
    $this->db->order_by('nombre', 'ASC');
    $query = $this->db->get('tipos');
    
    // Verificar que la consulta fue exitosa
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function obtener_estados()
  {
    $query = $this->db->get('estados');
    
    // Verificar que la consulta fue exitosa
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function obtener_marcas()
  {
    $this->db->order_by('nombre', 'ASC');
    $query = $this->db->get('marcas');
    
    // Verificar que la consulta fue exitosa
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function obtener_mantenimientos()
  {
    $query = $this->db->get('mantenimientos');
    
    // Verificar que la consulta fue exitosa
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function actualizar_imagen_equipo($id, $uri) 
  {
    // Verificar que los parámetros no estén vacíos
    if (empty($id) || empty($uri) || !is_array($uri)) {
        return false;
    }
    
    $this->db->where('id_equipos', $id);
    $this->db->update('equipos', $uri);
    return $this->db->affected_rows() > 0;
  }
  
  public function obtener_equipos()
  {
    $this->db->select('equipos.*, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado');
    $this->db->from('equipos');
    $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
    $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
    $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');

    $query = $this->db->get();
    
    // Verificar que la consulta fue exitosa
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function obtener_equipos_paginados($limit, $start) 
  {
    // Verificar que los parámetros sean válidos
    $limit = is_numeric($limit) ? (int)$limit : 10;
    $start = is_numeric($start) ? (int)$start : 0;
    
    $this->db->select('equipos.*, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado');
    $this->db->from('equipos');
    $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
    $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
    $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');
    $this->db->limit($limit, $start);

    $query = $this->db->get();
    
    // Verificar que la consulta fue exitosa
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function obtener_equipo_computo($id_equipos)
  {
    // Verificar que el ID no esté vacío
    if (empty($id_equipos)) {
        return null;
    }
    
    $this->db->select('equipos.*, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado, ccompu.procesador, ccompu.tarjeta , ccompu.ram');
    $this->db->from('equipos');
    $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
    $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
    $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');
    $this->db->join('ccompu', 'equipos.id_ccompus = ccompu.id_ccompus', 'left');
    $this->db->where("id_equipos", $id_equipos);
    
    $query = $this->db->get();
    
    // Verificar que la consulta fue exitosa
    if ($query === false || $query->num_rows() === 0) {
        return null;
    }
    
    return $query->row();
  }

  public function obtener_info_equipo($id)
  {
    // Verificar que el ID no esté vacío
    if (empty($id)) {
        return null;
    }
    
    $this->db->select('equipos.id_equipos, equipos.id_estados, equipos.modelo , equipos.cod_interno, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado');
    $this->db->from('equipos');
    $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
    $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
    $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');
    $this->db->where("id_equipos", $id);
    
    $query = $this->db->get();
    
    // Verificar que la consulta fue exitosa
    if ($query === false || $query->num_rows() === 0) {
        return null;
    }
    
    return $query->row();
  }

  public function obtener_id_ccompu($id_equipo)
  {
    // Verificar que el ID no esté vacío
    if (empty($id_equipo)) {
        return null;
    }
    
    $this->db->select('equipos.id_ccompus');
    $this->db->from('equipos');
    $this->db->where("id_equipos", $id_equipo);
    
    $query = $this->db->get();
    
    // Verificar que la consulta fue exitosa
    if ($query === false || $query->num_rows() === 0) {
        return null;
    }
    
    return $query->row();
  }

  public function eliminar_ccompu($id)
  {
    // Verificar que el ID no esté vacío
    if (empty($id)) {
        return false;
    }
    
    $this->db->where('id_ccompus', $id);
    return $this->db->delete('ccompu');
  }

  public function eliminar_equipo($id)
  {
    // Verificar que el ID no esté vacío
    if (empty($id)) {
        return false;
    }
    
    $this->db->where('id_equipos', $id);
    return $this->db->delete('equipos');
  }

  public function obtenerNumeroEquipos()
  {
    $this->db->from("equipos");
    $count = $this->db->count_all_results();
    
    return is_numeric($count) ? (int)$count : 0;
  }
  
  public function obtenerNumeroEquiposPorTipo($tipo_id) 
  {
    // Verificar que el tipo_id no esté vacío
    if (empty($tipo_id)) {
        return 0;
    }
    
    $this->db->where('id_tipos', $tipo_id);
    $this->db->from('equipos');
    $count = $this->db->count_all_results();
    
    return is_numeric($count) ? (int)$count : 0;
  }

  public function obtener_equipos_por_tipo($tipo) 
  {
    // Verificar que el tipo no esté vacío
    if (empty($tipo)) {
        return array();
    }
    
    $query = $this->db->query("CALL obtener_equipos_por_tipo(?)", array($tipo));
    
    // Verificar que la consulta fue exitosa
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }
  
  public function obtener_equipos_por_tipo_paginados($tipo, $limit, $start) 
  {
    // Verificar que el tipo no esté vacío
    if (empty($tipo)) {
        return array();
    }
    
    // Verificar que los parámetros sean válidos
    $limit = is_numeric($limit) ? (int)$limit : 10;
    $start = is_numeric($start) ? (int)$start : 0;
    
    $this->db->select('equipos.*, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado');
    $this->db->from('equipos');
    $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
    $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
    $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');
    $this->db->where('equipos.id_tipos', $tipo);
    $this->db->limit($limit, $start);

    $query = $this->db->get();
    
    // Verificar que la consulta fue exitosa
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function obtener_equipos_por_codigo($codigo_interno)
  {
    // Verificar que el código no esté vacío
    if (empty($codigo_interno)) {
        return array();
    }
    
    $this->db->select('equipos.*, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado');
    $this->db->from('equipos');
    $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
    $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
    $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');
    $this->db->like('cod_interno', $codigo_interno);
    
    $query = $this->db->get();
    
    // Verificar que la consulta fue exitosa
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }
}

/* End of file Inventario_model.php */
/* Location: ./application/models/Inventario_model.php */