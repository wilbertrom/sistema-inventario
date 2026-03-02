<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupo_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtener todas las mesas
     */
    public function obtenerMesas()
    {
        $query = $this->db->get('mesas');
        return $query->result();
    }

    /**
     * Obtener grupos por ID de mesa
     */
    public function obtenerGrupos($id_mesa)
    {
        if (empty($id_mesa)) {
            return array();
        }
        
        $this->db->where('id_mesas', $id_mesa);
        $query = $this->db->get('grupos');
        return $query->result();
    }

    /**
     * Obtener equipos por ID de grupo
     */
    public function getEquipos($id_grupo)
    {
        if (empty($id_grupo)) {
            return array();
        }
        
        $this->db->select('equipos.*, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado');
        $this->db->from('equipos');
        $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
        $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
        $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');
        $this->db->where('equipos.id_grupos', $id_grupo);
        $this->db->where('equipos.laboratorio_id', $this->session->userdata('laboratorio_id')); // FILTRO LABORATORIO
        $this->db->order_by('equipos.id_tipos', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Obtener equipos por tipo (CORREGIDO con nombre correcto del método)
     */
    public function obtenerEquiposPorTipo($tipo)
    {
        if (empty($tipo)) {
            return array();
        }
        
        $this->db->select('equipos.id_tipos, equipos.codigo_interno, equipos.modelo, equipos.id_equipos, marcas.nombre as marca, tipos.nombre as tipo');
        $this->db->where('equipos.id_tipos', $tipo);
        $this->db->where('equipos.laboratorio_id', $this->session->userdata('laboratorio_id')); // FILTRO LABORATORIO
        $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
        $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
        
        $query = $this->db->get('equipos');
        
        if ($query === false) {
            return array();
        }
        
        return $query->result();
    }

    /**
     * Obtener equipos asignados a un grupo
     */
    public function obtenerEquipoAsignado($id_grupo, $tipo_equipo)
    {
        if (empty($id_grupo) || empty($tipo_equipo)) {
            return array();
        }
        
        $this->db->where('equipos.id_grupos', $id_grupo);
        $this->db->where('equipos.id_tipos', $tipo_equipo);
        $this->db->where('equipos.laboratorio_id', $this->session->userdata('laboratorio_id')); // FILTRO LABORATORIO
        $this->db->select('equipos.*, marcas.nombre as marca, tipos.nombre as tipo, estados.nombre as estado, ccompu.procesador, ccompu.tarjeta , ccompu.ram');
        $this->db->from('equipos');
        $this->db->join('marcas', 'equipos.id_marcas = marcas.id_marcas', 'left');
        $this->db->join('tipos', 'equipos.id_tipos = tipos.id_tipos', 'left');
        $this->db->join('estados', 'equipos.id_estados = estados.id_estados', 'left');
        $this->db->join('ccompu', 'equipos.id_ccompus = ccompu.id_ccompus', 'left');
        
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Obtener ID de equipo asignado
     */
    public function obtenerIdAsignado($id_grupo, $tipo_equipo)
    {
        if (empty($id_grupo) || empty($tipo_equipo)) {
            return null;
        }
        
        $this->db->select('equipos.id_equipos');
        $this->db->where('equipos.id_grupos', $id_grupo);
        $this->db->where('equipos.id_tipos', $tipo_equipo);
        $this->db->where('equipos.laboratorio_id', $this->session->userdata('laboratorio_id')); // FILTRO LABORATORIO
        
        $query = $this->db->get('equipos');
        
        if ($query->num_rows() == 0) {
            return null;
        }
        
        return $query->row();
    }

    /**
     * Asignar grupo a equipo
     */
    public function asignarGrupo($id_equipo, $datos)
    {
        if (empty($id_equipo) || empty($datos)) {
            return false;
        }
        
        $this->db->where('id_equipos', $id_equipo);
        $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // FILTRO LABORATORIO
        return $this->db->update('equipos', $datos);
    }
    
    /**
     * Eliminar equipo de grupo
     */
    public function eliminarEquipoGrupo($id_tipo, $id_grupo)
    {
        if (empty($id_tipo) || empty($id_grupo)) {
            return false;
        }
        
        $this->db->where('id_tipos', $id_tipo);
        $this->db->where('id_grupos', $id_grupo);
        $this->db->where('laboratorio_id', $this->session->userdata('laboratorio_id')); // FILTRO LABORATORIO
        return $this->db->update('equipos', array('id_grupos' => null));
    }
}

/* End of file Grupo_model.php */
/* Location: ./application/models/Grupo_model.php */