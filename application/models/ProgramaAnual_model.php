<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramaAnual_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtener programas por laboratorio y año
     */
    public function getByLaboratorioAnio($laboratorio_id, $anio)
    {
        if (empty($laboratorio_id) || empty($anio)) {
            return array();
        }
        
        return $this->db
            ->where('laboratorio_id', $laboratorio_id)
            ->where('anio', $anio)
            ->order_by('id', 'DESC')
            ->get('programa_anual_mantenimiento')
            ->result();
    }

    /**
     * Obtener un programa por ID
     */
    public function getById($id)
    {
        if (empty($id)) {
            return null;
        }
        
        return $this->db
            ->where('id', $id)
            ->get('programa_anual_mantenimiento')
            ->row();
    }

    /**
     * Obtener programas por laboratorio (todos los años)
     */
    public function getByLaboratorio($laboratorio_id)
    {
        if (empty($laboratorio_id)) {
            return array();
        }
        
        return $this->db
            ->where('laboratorio_id', $laboratorio_id)
            ->order_by('anio DESC, id DESC')
            ->get('programa_anual_mantenimiento')
            ->result();
    }

    /**
     * Insertar nuevo programa
     */
    public function insertPrograma($data)
    {
        if (empty($data) || !is_array($data)) {
            return false;
        }
        
        // Asegurar laboratorio_id
        if (!isset($data['laboratorio_id'])) {
            $data['laboratorio_id'] = $this->session->userdata('laboratorio_id');
        }
        
        // Fecha de creación
        $data['created_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert('programa_anual_mantenimiento', $data);
        return $this->db->insert_id();
    }

    /**
     * Actualizar programa
     */
    public function updatePrograma($id, $data)
    {
        if (empty($id) || empty($data)) {
            return false;
        }
        
        $this->db->where('id', $id);
        return $this->db->update('programa_anual_mantenimiento', $data);
    }

    /**
     * Eliminar programa (con sus detalles)
     */
    public function deletePrograma($id)
    {
        if (empty($id)) {
            return false;
        }
        
        // Primero eliminar detalles
        $this->db->where('programa_id', $id);
        $this->db->delete('programa_anual_mantenimiento_detalle');
        
        // Luego eliminar programa
        $this->db->where('id', $id);
        return $this->db->delete('programa_anual_mantenimiento');
    }

    /**
     * Verificar si ya existe un programa con la misma actividad y año
     */
    public function existePrograma($laboratorio_id, $anio, $actividad, $excluir_id = null)
    {
        $this->db->where('laboratorio_id', $laboratorio_id);
        $this->db->where('anio', $anio);
        $this->db->where('actividad', $actividad);
        
        if ($excluir_id) {
            $this->db->where('id !=', $excluir_id);
        }
        
        return $this->db->get('programa_anual_mantenimiento')->num_rows() > 0;
    }

    /**
     * Obtener años disponibles para un laboratorio
     */
    public function getAniosDisponibles($laboratorio_id)
    {
        if (empty($laboratorio_id)) {
            return array();
        }
        
        $this->db->select('anio');
        $this->db->where('laboratorio_id', $laboratorio_id);
        $this->db->distinct();
        $this->db->order_by('anio', 'DESC');
        
        $query = $this->db->get('programa_anual_mantenimiento');
        
        $resultados = array();
        foreach ($query->result() as $row) {
            $resultados[] = $row->anio;
        }
        
        // Siempre incluir año actual
        $anio_actual = date('Y');
        if (!in_array($anio_actual, $resultados)) {
            $resultados[] = $anio_actual;
        }
        
        sort($resultados);
        return $resultados;
    }
}