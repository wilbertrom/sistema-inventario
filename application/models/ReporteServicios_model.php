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
    // 
  }

  // ------------------------------------------------------------------------

  public function obtener_reportes(){
    $query = $this->db->get('reporte_anual');
    return $query->result();
  }
  public function obtener_reporte($id){
    $this->db->where('id', $id);
    $query = $this->db->get('reporte_anual');
    return $query->row();
  }
  public function obtener_servicios(){
    $query = $this->db->get('servicio');
    return $query->result();
  }

  public function actualizar_servicio($reporte_id, $servicio_id, $mes, $status) {
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

    if ($query->num_rows() > 0) {
        // Si existe, actualiza el registro
        $this->db->where('reporte_id', $reporte_id);
        $this->db->where('servicio_id', $servicio_id);
        $this->db->where('mes', $mes);
        $this->db->update('registro_mensual', $data);
    } else {
        // Si no existe, inserta un nuevo registro
        $this->db->insert('registro_mensual', $data);
    }
}

public function obtener_estados_servicios($reporte_id, $mes) {
    $this->db->where('reporte_id', $reporte_id);
    $this->db->where('mes', $mes);
    $query = $this->db->get('registro_mensual');
    $result = $query->result();

    $estados = array();
    foreach ($result as $row) {
        $estados[$row->servicio_id] = $row->status;
    }

    return $estados;
}

public function getDatosReporte($año) {
  // Consulta para obtener los datos del reporte
  $this->db->select('s.nombre_servicio, r.mes, r.status, c.nombre_categoria');
  $this->db->from('registro_mensual r');
  $this->db->join('servicio s', 'r.servicio_id = s.id');
  $this->db->join('categorias c', 's.categoria_id = c.id');
  $this->db->join('reporte_anual ra', 'r.reporte_id = ra.id');
  $this->db->where('ra.año', $año);  // Cambia 1 por el ID del reporte que quieras consultar
  $query = $this->db->get();

  return $query;
}


}

/* End of file ReporteServicios_model.php */
/* Location: ./application/models/ReporteServicios_model.php */