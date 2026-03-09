<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramaAnualDetalle_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getActividades($programa_id)
    {
        $this->db->select('actividad_id, actividad_nombre, observaciones');
        $this->db->where('programa_id', $programa_id);
        $this->db->group_by('actividad_id');
        $this->db->order_by('actividad_id', 'ASC');
        $query = $this->db->get('programa_anual_mantenimiento_detalle');
        return $query->result();
    }

    public function getMesesByActividad($programa_id, $actividad_id, $estatus)
    {
        $this->db->select('mes');
        $this->db->where('programa_id', $programa_id);
        $this->db->where('actividad_id', $actividad_id);
        $this->db->where('estatus', $estatus);
        $query = $this->db->get('programa_anual_mantenimiento_detalle');
        
        $meses = array();
        foreach ($query->result() as $row) {
            $meses[] = $row->mes;
        }
        return $meses;
    }

    /**
     * NUEVO MÉTODO: Obtener resumen de estatus
     */
    public function getResumenEstatus($programa_id)
    {
        $this->db->select('estatus, COUNT(*) as total');
        $this->db->where('programa_id', $programa_id);
        $this->db->group_by('estatus');
        $query = $this->db->get('programa_anual_mantenimiento_detalle');
        
        $resumen = array(
            'PLANEADO' => 0,
            'REALIZADO' => 0,
            'TOTAL' => 0
        );
        
        foreach ($query->result() as $row) {
            $resumen[$row->estatus] = (int)$row->total;
            $resumen['TOTAL'] += (int)$row->total;
        }
        
        return $resumen;
    }

    public function guardarActividad($programa_id, $actividad_id, $actividad_nombre, $meses_planeados, $meses_realizados, $observaciones)
    {
        $this->db->where('programa_id', $programa_id);
        $this->db->where('actividad_id', $actividad_id);
        $this->db->delete('programa_anual_mantenimiento_detalle');
        
        $insertados = 0;
        
        if (!empty($meses_planeados)) {
            foreach ($meses_planeados as $mes) {
                $data = array(
                    'programa_id' => $programa_id,
                    'actividad_id' => $actividad_id,
                    'actividad_nombre' => $actividad_nombre,
                    'mes' => $mes,
                    'estatus' => 'PLANEADO',
                    'observaciones' => $observaciones
                );
                if ($this->db->insert('programa_anual_mantenimiento_detalle', $data)) {
                    $insertados++;
                }
            }
        }
        
        if (!empty($meses_realizados)) {
            foreach ($meses_realizados as $mes) {
                $this->db->where('programa_id', $programa_id);
                $this->db->where('actividad_id', $actividad_id);
                $this->db->where('mes', $mes);
                $this->db->where('estatus', 'PLANEADO');
                $existe = $this->db->get('programa_anual_mantenimiento_detalle')->row();
                
                if (!$existe) {
                    $data = array(
                        'programa_id' => $programa_id,
                        'actividad_id' => $actividad_id,
                        'actividad_nombre' => $actividad_nombre,
                        'mes' => $mes,
                        'estatus' => 'REALIZADO',
                        'observaciones' => $observaciones
                    );
                    if ($this->db->insert('programa_anual_mantenimiento_detalle', $data)) {
                        $insertados++;
                    }
                }
            }
        }
        
        return $insertados > 0;
    }

    public function eliminarActividad($programa_id, $actividad_id)
    {
        $this->db->where('programa_id', $programa_id);
        $this->db->where('actividad_id', $actividad_id);
        return $this->db->delete('programa_anual_mantenimiento_detalle');
    }
}