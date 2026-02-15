<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Login sin validación de laboratorio (solo credenciales)
     */
    public function login($username, $password)
    {
        // Verificar que los parámetros no estén vacíos
        if (empty($username) || empty($password)) {
            return false;
        }
        
        // Escapar el username para prevenir inyección SQL
        $username = $this->db->escape_str($username);
        
        // Consulta para verificar credenciales
        $this->db->where('username', $username);
        $this->db->where("password = SHA2('".$password."', 0)");
        $query = $this->db->get('users');
        
        // Verificar que la consulta fue exitosa
        if ($query === false) {
            return false;
        }
        
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        
        return false;
    }
    
    /**
     * Verificar si un usuario tiene acceso a un laboratorio específico
     */
    public function verificar_acceso_laboratorio($user_id, $laboratorio_id)
    {
        if (empty($user_id) || empty($laboratorio_id)) {
            return false;
        }
        
        // Verificar en la tabla users si tiene el laboratorio_id
        $this->db->where('id', $user_id);
        $this->db->where('laboratorio_id', $laboratorio_id);
        $query = $this->db->get('users');
        
        if ($query === false) {
            return false;
        }
        
        return $query->num_rows() > 0;
    }
    
    /**
     * Obtener el laboratorio de un usuario
     */
    public function get_user_laboratorio($user_id)
    {
        if (empty($user_id)) {
            return null;
        }
        
        $this->db->select('laboratorio_id');
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        
        if ($query === false || $query->num_rows() == 0) {
            return null;
        }
        
        $row = $query->row();
        return $row->laboratorio_id;
    }
    
    /**
     * Actualizar imagen de usuario
     */
    public function actualizar_imagen_usuario($id, $uri)
    {
        if (empty($id) || empty($uri) || !is_array($uri)) {
            return false;
        }
        
        $this->db->where('id', $id);
        return $this->db->update('users', $uri);
    }

    /**
     * Obtener imagen de usuario
     */
    public function obtenerImagen($id)
    {
        if (empty($id)) {
            return null;
        }
        
        $this->db->where('id', $id);
        $this->db->select('imagen');
        $query = $this->db->get('users');
        
        if ($query === false || $query->num_rows() == 0) {
            return null;
        }
        
        return $query->row();
    }
}