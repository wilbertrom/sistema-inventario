<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReporteServicios_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    return;
  }

  public function obtener_reportes()
  {
    $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    $query = $this->db->get('reporte_anual');
    
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }
  
  public function obtener_reporte($id)
  {
    if (empty($id)) {
        return null;
    }
    
    $this->db->where('id', $id);
    $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    $query = $this->db->get('reporte_anual');
    
    if ($query === false || $query->num_rows() === 0) {
        return null;
    }
    
    return $query->row();
  }
  
  public function obtener_servicios()
  {
    $query = $this->db->get('servicio');
    
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function actualizar_servicio($reporte_id, $servicio_id, $mes, $status) 
  {
    if (empty($reporte_id) || empty($servicio_id) || empty($mes) || $status === null) {
        return false;
    }
    
    $data = array(
        'reporte_id' => $reporte_id,
        'servicio_id' => $servicio_id,
        'mes' => $mes,
        'status' => $status,
        'laboratorio_id' => $this->session->userdata('laboratorio_id') // Agregar filtro
    );

    $this->db->where('reporte_id', $reporte_id);
    $this->db->where('servicio_id', $servicio_id);
    $this->db->where('mes', $mes);
    $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    
    $query = $this->db->get('registro_mensual');

    if ($query !== false && $query->num_rows() > 0) {
        $this->db->where('reporte_id', $reporte_id);
        $this->db->where('servicio_id', $servicio_id);
        $this->db->where('mes', $mes);
        $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
        return $this->db->update('registro_mensual', $data);
    } else {
        return $this->db->insert('registro_mensual', $data);
    }
  }

  public function obtener_estados_servicios($reporte_id, $mes) 
  {
    if (empty($reporte_id) || empty($mes)) {
        return array();
    }
    
    $this->db->where('reporte_id', $reporte_id);
    $this->db->where('mes', $mes);
    $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    
    $query = $this->db->get('registro_mensual');
    
    if ($query === false) {
        return array();
    }
    
    $result = $query->result();
    $estados = array();
    
    if (!empty($result) && is_array($result)) {
        foreach ($result as $row) {
            if (is_object($row) && isset($row->servicio_id, $row->status)) {
                $estados[$row->servicio_id] = $row->status;
            }
        }
    }

    return $estados;
  }

  public function getDatosReporte($año) 
  {
    if (empty($año)) {
        return $this->db->get_where('registro_mensual', array('1' => '0'));
    }
    
    $this->db->select('s.nombre_servicio, r.mes, r.status, c.nombre_categoria');
    $this->db->from('registro_mensual r');
    $this->db->join('servicio s', 'r.servicio_id = s.id');
    $this->db->join('categorias c', 's.categoria_id = c.id');
    $this->db->join('reporte_anual ra', 'r.reporte_id = ra.id');
    $this->db->where('ra.año', $año);
    $this->db->where('ra.laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro
    $this->db->where('r.laboratorio_id', $this->session->userdata('laboratorio_id')); // Filtro adicional
    
    $query = $this->db->get();

    if ($query === false) {
        return $this->db->get_where('registro_mensual', array('1' => '0'));
    }

    return $query;
  }
}

/* End of file ReporteServicios_model.php */
/* Location: ./application/models/ReporteServicios_model.php */