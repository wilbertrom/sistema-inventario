<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laboratorio_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all()
    {
        $query = $this->db->get('laboratorios');
        
        if ($query === false) {
            return array();
        }
        
        return $query->result();
    }
    
    public function get_by_id($id)
    {
        if (empty($id)) {
            return null;
        }
        
        $this->db->where('id', $id);
        $query = $this->db->get('laboratorios');
        
        if ($query === false || $query->num_rows() == 0) {
            return null;
        }
        
        return $query->row();
    }
}