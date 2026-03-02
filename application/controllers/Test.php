<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
    
    public function index() {
        echo "Controlador Test funcionando";
    }
    
    public function perfil() {
        $this->load->model('user_model');
        $user_id = 1; // ID de prueba
        
        $usuario = $this->user_model->get_user_by_id($user_id);
        echo "<pre>";
        print_r($usuario);
        echo "</pre>";
        
        $imagen = $this->user_model->obtenerImagen($user_id);
        echo "<pre>";
        print_r($imagen);
        echo "</pre>";
    }
}