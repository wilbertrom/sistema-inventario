<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 *
 * Controller Login
 *

 */

class Login extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    // Carga la biblioteca de formularios y el modelo de usuarios
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->load->model('user_model');

    // Configurar mensajes de error personalizados
    $this->form_validation->set_message('required', 'El campo %s es obligatorio.');
    $this->form_validation->set_message('required', 'El campo %s es obligatorio.');
  }

  public function index()
  {
    $this->load->view('usuario/login');
  }

  public function do_login() {
    // Validación del formulario
    $this->form_validation->set_rules('username', 'Usuario', 'required');
    $this->form_validation->set_rules('password', 'Contraseña', 'required');

    if ($this->form_validation->run() == FALSE) {
        $this->load->view('usuario/login');
    } else {
        // Obtener datos del formulario
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Verificar credenciales en la base de datos
        $user = $this->user_model->login($username, $password);

        if ($user) {
            // Iniciar sesión
            $session_data = array(
              'user_id' => $user['id'],
              'username' => $user['username'],
              'email' => $user['email'],
              'img' => $user['imagen'],
              'logged_in' => TRUE
          );
            $this->session->set_userdata($session_data);
            redirect('panel'); // Redirige a la página de dashboard o inicio
        } else {
            // Error de login
            $data['error'] = 'Usuario o contraseña incorrectos.';
            $this->load->view('usuario/login', $data);
        }
    }
}

public function logout() {
    // Cerrar sesión
    $this->session->sess_destroy();
    redirect('portal/acerca_de');
}

}


/* End of file Login.php */
/* Location: ./application/controllers/Login.php */