<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramaAnualDetalle_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtener meses por programa
     */
    public function getMesesByPrograma($programa_id)
    {
        if (empty($programa_id)) {
            return array();
        }
        
        return $this->db
            ->where('programa_id', $programa_id)
            ->order_by('mes', 'ASC')
            ->get('programa_anual_mantenimiento_detalle')
            ->result();
    }

    /**
     * Obtener detalle por programa y mes
     */
    public function getByProgramaMes($programa_id, $mes)
    {
        if (empty($programa_id) || empty($mes)) {
            return null;
        }
        
        return $this->db
            ->where('programa_id', $programa_id)
            ->where('mes', $mes)
            ->get('programa_anual_mantenimiento_detalle')
            ->row();
    }

    /**
     * Marcar/Actualizar mes
     */
    public function marcarMes($programa_id, $mes, $estatus = 'PLANEADO', $observaciones = null)
    {
        if (empty($programa_id) || empty($mes)) {
            return false;
        }
        
        // Validar estatus
        $estatus_validos = ['PLANEADO', 'EN_PROCESO', 'COMPLETADO', 'CANCELADO', 'PENDIENTE'];
        if (!in_array($estatus, $estatus_validos)) {
            $estatus = 'PLANEADO';
        }
        
        $data = [
            'estatus' => $estatus,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if ($observaciones !== null) {
            $data['observaciones'] = $observaciones;
        }
        
        $existe = $this->getByProgramaMes($programa_id, $mes);
        
        if ($existe) {
            $this->db->where('id', $existe->id)->update('programa_anual_mantenimiento_detalle', $data);
            return $existe->id;
        } else {
            $data['programa_id'] = $programa_id;
            $data['mes'] = $mes;
            $data['created_at'] = date('Y-m-d H:i:s');
            
            $this->db->insert('programa_anual_mantenimiento_detalle', $data);
            return $this->db->insert_id();
        }
    }

    /**
     * Marcar múltiples meses a la vez
     */
    public function marcarMesesBatch($programa_id, $meses, $estatus = 'PLANEADO')
    {
        if (empty($programa_id) || empty($meses)) {
            return false;
        }
        
        $resultados = array();
        foreach ($meses as $mes) {
            $resultados[] = $this->marcarMes($programa_id, $mes, $estatus);
        }
        
        return $resultados;
    }

    /**
     * Obtener resumen de estatus por programa
     */
    public function getResumenEstatus($programa_id)
    {
        if (empty($programa_id)) {
            return array();
        }
        
        $this->db->select('estatus, COUNT(*) as total');
        $this->db->where('programa_id', $programa_id);
        $this->db->group_by('estatus');
        
        $query = $this->db->get('programa_anual_mantenimiento_detalle');
        
        $resumen = array(
            'PLANEADO' => 0,
            'EN_PROCESO' => 0,
            'COMPLETADO' => 0,
            'CANCELADO' => 0,
            'PENDIENTE' => 0,
            'TOTAL' => 0
        );
        
        foreach ($query->result() as $row) {
            $resumen[$row->estatus] = (int)$row->total;
            $resumen['TOTAL'] += (int)$row->total;
        }
        
        return $resumen;
    }

    /**
     * Eliminar detalle
     */
    public function deleteDetalle($id)
    {
        if (empty($id)) {
            return false;
        }
        
        $this->db->where('id', $id);
        return $this->db->delete('programa_anual_mantenimiento_detalle');
    }

    /**
     * Eliminar todos los detalles de un programa
     */
    public function deleteByPrograma($programa_id)
    {
        if (empty($programa_id)) {
            return false;
        }
        
        $this->db->where('programa_id', $programa_id);
        return $this->db->delete('programa_anual_mantenimiento_detalle');
    }
}