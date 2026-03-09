<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Firmantes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Obtener todos los firmantes activos
    public function getAll() {
        return $this->db->where('activo', 1)->order_by('rol, nombre')->get('firmantes')->result();
    }

    // Obtener por rol (para los dropdowns)
    public function getByRol($rol) {
        return $this->db->where('activo', 1)->where('rol', $rol)->order_by('nombre')->get('firmantes')->result();
    }

    // Obtener por rol y laboratorio (jefes de lab tienen laboratorio_id)
    public function getByRolLab($rol, $laboratorio_id = null) {
        $this->db->where('activo', 1)->where('rol', $rol);
        if ($laboratorio_id) {
            $this->db->group_start()
                     ->where('laboratorio_id', $laboratorio_id)
                     ->or_where('laboratorio_id', null)
                     ->group_end();
        }
        return $this->db->order_by('nombre')->get('firmantes')->result();
    }

    // Obtener uno por ID
    public function getById($id) {
        return $this->db->where('id', $id)->get('firmantes')->row();
    }

    // Insertar nuevo firmante
    public function insert($data) {
        $this->db->insert('firmantes', $data);
        return $this->db->insert_id();
    }

    // Actualizar firmante
    public function update($id, $data) {
        return $this->db->where('id', $id)->update('firmantes', $data);
    }

    // Eliminar (soft delete)
    public function delete($id) {
        return $this->db->where('id', $id)->update('firmantes', ['activo' => 0]);
    }

    // Para el endpoint JSON (dropdowns dinámicos)
    public function getListaJSON($rol, $laboratorio_id = null) {
        $this->db->select('id, nombre, cargo')->where('activo', 1)->where('rol', $rol);
        if ($laboratorio_id) {
            $this->db->group_start()
                     ->where('laboratorio_id', $laboratorio_id)
                     ->or_where('laboratorio_id IS NULL', null, false)
                     ->group_end();
        }
        return $this->db->order_by('nombre')->get('firmantes')->result();
    }
}