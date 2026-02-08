<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Model User_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    
 * @link      
 * @param     ...
 * @return    ...
 *
 */

class User_model extends CI_Model {

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

public function login($username, $password) {
    // Consulta para verificar el usuario en la base de datos
    $this->db->where('username', $username);
    $this->db->where("password = SHA2('".$password."', 0)");
    $query = $this->db->get('users');

    if ($query->num_rows() == 1) {
        return $query->row_array();
    } else {
        return false;
    }
}  

public function actualizar_imagen_usuario($id, $uri){
  $this->db->where('id', $id);
  return $this->db->update('users', $uri);
}

public function obtenerImagen($id){
  $this->db->where('id', $id);
  $this->db->select('users.imagen');
  $query = $this->db->get('users');
  return $query->row();
}


}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */