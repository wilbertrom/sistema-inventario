<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventario_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function index()
  {
    return;
  }

  public function registrar_inventario($data) 
  {
    if (empty($data) || !is_array($data)) {
        return false;
    }
    
    // Agregar laboratorio_id desde sesión
    $data['laboratorio_id'] = $this->session->userdata('laboratorio_id');
    
    $this->db->insert('equipos', $data);
    return $this->db->insert_id();
  }

  public function registrar_ccompu($data) 
  {
    if (empty($data) || !is_array($data)) {
        return false;
    }
    
    $this->db->insert('ccompu', $data);
    return $this->db->insert_id();
  }
  
  public function actualizar_inventario($data, $id) 
  {
    if (empty($data) || !is_array($data) || empty($id)) {
        return false;
    }
    
    $this->db->where('id_equipos', $id);
    $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    $this->db->update('equipos', $data);
    return $this->db->affected_rows() > 0;
  }

  public function actualizar_ccompu($data, $id) 
  {
    if (empty($data) || !is_array($data) || empty($id)) {
        return false;
    }
    
    $this->db->where('id_ccompus', $id);
    $this->db->update('ccompu', $data);
    return $this->db->affected_rows() > 0;
  }

  public function actualizar_estado($estado, $id)
  {
    if (empty($estado) || empty($id)) {
        return false;
    }
    
    $this->db->where('id_equipos', $id);
    $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    return $this->db->update('equipos', array('id_estados' => $estado));
  }

  public function registrar_marca($data) 
  {
    if (empty($data) || !is_array($data)) {
        return false;
    }
    
    return $this->db->insert('marcas', $data);
  }

  public function registrar_tipo($data) 
  {
    if (empty($data) || !is_array($data)) {
        return false;
    }
    
    return $this->db->insert('tipos', $data);
  }
  
  public function obtener_tipos()
  {
    $this->db->order_by('nombre', 'ASC');
    $query = $this->db->get('tipos');
    
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function obtener_estados()
  {
    $query = $this->db->get('estados');
    
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function obtener_marcas()
  {
    $this->db->order_by('nombre', 'ASC');
    $query = $this->db->get('marcas');
    
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function obtener_mantenimientos()
  {
    $query = $this->db->get('mantenimientos');
    
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function actualizar_imagen_equipo($id, $uri) 
  {
    if (empty($id) || empty($uri) || !is_array($uri)) {
        return false;
    }
    
    $this->db->where('id_equipos', $id);
    $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
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
    $this->db->where('equipos.laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro

    $query = $this->db->get();
    
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

 /**
 * Obtener equipos paginados (usando laboratorio de sesión)
 * @param int $limit Número de registros por página
 * @param int $start Desde qué registro empezar
 * @return array Lista de equipos
 */
public function obtener_equipos_paginados($limit, $start) 
{
    $laboratorio_id = $this->session->userdata('laboratorio_id');
    
    if (empty($laboratorio_id)) {
        return array();
    }
    
    $this->db->select('equipos.*, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado');
    $this->db->from('equipos');
    $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
    $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
    $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');
    $this->db->where('equipos.laboratorio_id', $laboratorio_id);
    $this->db->limit($limit, $start);
    $this->db->order_by('equipos.id_equipos', 'DESC');
    
    $query = $this->db->get();
    return $query->result();
}


  public function obtener_equipo_computo($id_equipos)
  {
    if (empty($id_equipos)) {
        return null;
    }
    
    $this->db->select('equipos.*, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado, ccompu.procesador, ccompu.tarjeta , ccompu.ram');
    $this->db->from('equipos');
    $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
    $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
    $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');
    $this->db->join('ccompu', 'equipos.id_ccompus = ccompu.id_ccompus', 'left');
    $this->db->where("equipos.id_equipos", $id_equipos);
    $this->db->where('equipos.laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    
    $query = $this->db->get();
    
    if ($query === false || $query->num_rows() === 0) {
        return null;
    }
    
    return $query->row();
  }

  public function obtener_info_equipo($id)
  {
    if (empty($id)) {
        return null;
    }
    
    $this->db->select('equipos.id_equipos, equipos.id_estados, equipos.modelo , equipos.cod_interno, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado');
    $this->db->from('equipos');
    $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
    $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
    $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');
    $this->db->where("equipos.id_equipos", $id);
    $this->db->where('equipos.laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    
    $query = $this->db->get();
    
    if ($query === false || $query->num_rows() === 0) {
        return null;
    }
    
    return $query->row();
  }

  public function obtener_id_ccompu($id_equipo)
  {
    if (empty($id_equipo)) {
        return null;
    }
    
    $this->db->select('equipos.id_ccompus');
    $this->db->from('equipos');
    $this->db->where("id_equipos", $id_equipo);
    $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    
    $query = $this->db->get();
    
    if ($query === false || $query->num_rows() === 0) {
        return null;
    }
    
    return $query->row();
  }

  public function eliminar_ccompu($id)
  {
    if (empty($id)) {
        return false;
    }
    
    $this->db->where('id_ccompus', $id);
    return $this->db->delete('ccompu');
  }

  public function eliminar_equipo($id)
  {
    if (empty($id)) {
        return false;
    }
    
    $this->db->where('id_equipos', $id);
    $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    return $this->db->delete('equipos');
  }

  public function obtenerNumeroEquipos()
  {
    $this->db->from("equipos");
    $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    $count = $this->db->count_all_results();
    
    return is_numeric($count) ? (int)$count : 0;
  }
  
  public function obtenerNumeroEquiposPorTipo($tipo_id) 
  {
    if (empty($tipo_id)) {
        return 0;
    }
    
    $this->db->where('id_tipos', $tipo_id);
    $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    $this->db->from('equipos');
    $count = $this->db->count_all_results();
    
    return is_numeric($count) ? (int)$count : 0;
  }

  public function obtener_equipos_por_tipo($tipo) 
  {
    if (empty($tipo)) {
        return array();
    }
    
    // Nota: Para procedimientos almacenados, necesitas pasar el laboratorio_id
    $query = $this->db->query("CALL obtener_equipos_por_tipo(?, ?)", array($tipo, $this->session->userdata('laboratorio_id')));
    
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }
  
  public function obtener_equipos_por_tipo_paginados($tipo, $limit, $start) 
  {
    if (empty($tipo)) {
        return array();
    }
    
    $limit = is_numeric($limit) ? (int)$limit : 10;
    $start = is_numeric($start) ? (int)$start : 0;
    
    $this->db->select('equipos.*, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado');
    $this->db->from('equipos');
    $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
    $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
    $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');
    $this->db->where('equipos.id_tipos', $tipo);
    $this->db->where('equipos.laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    $this->db->limit($limit, $start);

    $query = $this->db->get();
    
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function obtener_equipos_por_codigo($codigo_interno)
{
    if (empty($codigo_interno)) {
        return array();
    }
    
    $laboratorio_id = $this->session->userdata('laboratorio_id');
    
    $this->db->select('equipos.*, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado');
    $this->db->from('equipos');
    $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
    $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
    $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');
    $this->db->like('cod_interno', $codigo_interno);
    $this->db->where('equipos.laboratorio_id', $laboratorio_id);
    
    $query = $this->db->get();
    
    if ($query === false) {
        return array();
    }
    
    return $query->result();
}
  
  /**
   * Contar equipos (para dashboard)
   */
  public function contar_equipos()
  {
      $this->db->from('equipos');
      $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
      return $this->db->count_all_results();
  }
  /**
 * Obtener equipos filtrados por laboratorio (para Excel y PDF)
 */
public function obtener_equipos_por_laboratorio($laboratorio_id)
{
    if (empty($laboratorio_id)) {
        return array();
    }
    
    $this->db->select('equipos.*, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado');
    $this->db->from('equipos');
    $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
    $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
    $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');
    $this->db->where('equipos.laboratorio_id', $laboratorio_id);
    $this->db->order_by('equipos.id_equipos', 'DESC');
    
    $query = $this->db->get();
    return $query->result();
}

/**
 * Contar equipos por laboratorio
 */
public function contar_equipos_por_laboratorio($laboratorio_id)
{
    if (empty($laboratorio_id)) {
        return 0;
    }
    $this->db->where('laboratorio_id', $laboratorio_id);
    return $this->db->count_all_results('equipos');
}

/**
 * Obtener equipos por laboratorio con paginación
 */
public function obtener_equipos_por_laboratorio_paginados($laboratorio_id, $limit, $start)
{
    $this->db->select('equipos.*, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado');
    $this->db->from('equipos');
    $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
    $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
    $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');
    $this->db->where('equipos.laboratorio_id', $laboratorio_id);
    $this->db->limit($limit, $start);
    
    $query = $this->db->get();
    return $query->result();
}

}

/* End of file Inventario_model.php */
/* Location: ./application/models/Inventario_model.php */