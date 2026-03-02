<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function login($username, $password)
    {
        if (empty($username) || empty($password)) {
            return false;
        }
        
        $username = $this->db->escape_str($username);
        
        $this->db->where('username', $username);
        $this->db->where("password = SHA2('".$password."', 0)");
        $query = $this->db->get('users');
        
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
        
        return false;
    }
    
    public function verificar_acceso_laboratorio($user_id, $laboratorio_id)
    {
        if (empty($user_id) || empty($laboratorio_id)) {
            return false;
        }
        
        $this->db->where('id', $user_id);
        $this->db->where('laboratorio_id', $laboratorio_id);
        $query = $this->db->get('users');
        
        if ($query === false) {
            return false;
        }
        
        return $query->num_rows() > 0;
    }
    
    /**
     * Obtener usuario por ID
     */
    public function get_user_by_id($id)
    {
        if (empty($id)) {
            return null;
        }
        
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        
        if ($query === false || $query->num_rows() == 0) {
            return null;
        }
        
        return $query->row();
    }
    
    public function get_user_by_username($username)
    {
        if (empty($username)) {
            return null;
        }
        
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        
        if ($query === false || $query->num_rows() == 0) {
            return null;
        }
        
        return $query->row();
    }
    
    public function actualizar_imagen_usuario($id, $uri)
    {
        if (empty($id) || empty($uri) || !is_array($uri)) {
            return false;
        }
        
        $this->db->where('id', $id);
        return $this->db->update('users', $uri);
    }

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