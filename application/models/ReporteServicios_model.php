<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Model ReporteServicios_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    
 * @link      
 * @param  
 * @return    ...
 *
 */

class ReporteServicios_model extends CI_Model {

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

  public function obtener_reportes()
  {
    $query = $this->db->get('reporte_anual');
    
    // Verificar que la consulta fue exitosa
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }
  
  public function obtener_reporte($id)
  {
    // Verificar que el ID no esté vacío
    if (empty($id)) {
        return null;
    }
    
    $this->db->where('id', $id);
    $query = $this->db->get('reporte_anual');
    
    // Verificar que la consulta fue exitosa
    if ($query === false || $query->num_rows() === 0) {
        return null;
    }
    
    return $query->row();
  }
  
  public function obtener_servicios()
  {
    $query = $this->db->get('servicio');
    
    // Verificar que la consulta fue exitosa
    if ($query === false) {
        return array();
    }
    
    return $query->result();
  }

  public function actualizar_servicio($reporte_id, $servicio_id, $mes, $status) 
  {
    // Verificar que los parámetros no estén vacíos
    if (empty($reporte_id) || empty($servicio_id) || empty($mes) || $status === null) {
        return false;
    }
    
    $data = array(
        'reporte_id' => $reporte_id,
        'servicio_id' => $servicio_id,
        'mes' => $mes,
        'status' => $status
    );

    // Verifica si ya existe un registro para este reporte, servicio y mes
    $this->db->where('reporte_id', $reporte_id);
    $this->db->where('servicio_id', $servicio_id);
    $this->db->where('mes', $mes);
    
    $query = $this->db->get('registro_mensual');

    if ($query !== false && $query->num_rows() > 0) {
        // Si existe, actualiza el registro
        $this->db->where('reporte_id', $reporte_id);
        $this->db->where('servicio_id', $servicio_id);
        $this->db->where('mes', $mes);
        return $this->db->update('registro_mensual', $data);
    } else {
        // Si no existe, inserta un nuevo registro
        return $this->db->insert('registro_mensual', $data);
    }
  }

  public function obtener_estados_servicios($reporte_id, $mes) 
  {
    // Verificar que los parámetros no estén vacíos
    if (empty($reporte_id) || empty($mes)) {
        return array();
    }
    
    $this->db->where('reporte_id', $reporte_id);
    $this->db->where('mes', $mes);
    
    $query = $this->db->get('registro_mensual');
    
    // Verificar que la consulta fue exitosa
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
    // Verificar que el año no esté vacío
    if (empty($año)) {
        // Retornar un objeto de consulta vacío en lugar de null
        return $this->db->get_where('registro_mensual', array('1' => '0'));
    }
    
    // Consulta para obtener los datos del reporte
    $this->db->select('s.nombre_servicio, r.mes, r.status, c.nombre_categoria');
    $this->db->from('registro_mensual r');
    $this->db->join('servicio s', 'r.servicio_id = s.id');
    $this->db->join('categorias c', 's.categoria_id = c.id');
    $this->db->join('reporte_anual ra', 'r.reporte_id = ra.id');
    $this->db->where('ra.año', $año);
    
    $query = $this->db->get();

    // Verificar que la consulta fue exitosa
    if ($query === false) {
        // Retornar un objeto de consulta vacío
        return $this->db->get_where('registro_mensual', array('1' => '0'));
    }

    return $query;
  }
}

/* End of file ReporteServicios_model.php */
/* Location: ./application/models/ReporteServicios_model.php */