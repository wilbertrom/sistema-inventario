<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Controller Login
 *
 */

class Login extends MY_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    // Carga la biblioteca de formularios y el modelo de usuarios
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->load->model('user_model');
    $this->load->model('laboratorio_model');

    // Configurar mensajes de error personalizados
    $this->form_validation->set_message('required', 'El campo %s es obligatorio.');
  }

  public function index()
  {
    // Verificar si ya hay una sesión activa
    if ($this->session->userdata('logged_in')) {
        redirect('panel');
    }
    
    // Obtener el laboratorio seleccionado de la URL (si viene)
    $lab = $this->input->get('lab');
    $data['laboratorio_seleccionado'] = $lab;
    
    // Obtener todos los laboratorios para el selector (por si acaso)
    $data['laboratorios'] = $this->laboratorio_model->get_all();
    
    $this->load->view('usuario/login', $data);
  }

  public function do_login() 
  {
    // Validación del formulario
    $this->form_validation->set_rules('username', 'Usuario', 'required');
    $this->form_validation->set_rules('password', 'Contraseña', 'required');
    
    // El laboratorio puede venir del formulario o de la URL
    $laboratorio_id = $this->input->post('laboratorio');
    if (empty($laboratorio_id)) {
        $laboratorio_id = $this->input->get('lab');
        // Convertir texto a ID si es necesario
        if ($laboratorio_id === 'opensource') {
            $laboratorio_id = 1; // ID para Open Source
        } elseif ($laboratorio_id === 'mac') {
            $laboratorio_id = 2; // ID para Mac
        }
    }

    if ($this->form_validation->run() == FALSE) {
        // Si la validación falla, cargar la vista con los errores
        $data['laboratorios'] = $this->laboratorio_model->get_all();
        $this->load->view('usuario/login', $data);
    } else {
        // Obtener datos del formulario
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Verificar credenciales en la base de datos
        $user = $this->user_model->login($username, $password);

        if ($user !== null && is_array($user) && !empty($user)) {
            
            // Verificar que el usuario tenga acceso al laboratorio seleccionado
            $tiene_acceso = $this->user_model->verificar_acceso_laboratorio($user['id'], $laboratorio_id);
            
            if ($tiene_acceso) {
                
                // Preparar datos de sesión con los nuevos campos
                $session_data = array();
                
                if (isset($user['id'])) {
                    $session_data['user_id'] = $user['id'];
                }
                
                if (isset($user['username'])) {
                    $session_data['username'] = $user['username'];
                }
                
                if (isset($user['rol'])) {
                    $session_data['rol'] = $user['rol'];
                } else {
                    $session_data['rol'] = 'usuario';
                }
                
                // Guardar el laboratorio en sesión
                $session_data['laboratorio_id'] = $laboratorio_id;
                
                // Obtener nombre del laboratorio
                $lab = $this->laboratorio_model->get_by_id($laboratorio_id);
                $session_data['laboratorio_nombre'] = $lab ? $lab->nombre : '';
                
                if (isset($user['email'])) {
                    $session_data['email'] = $user['email'];
                }
                
                if (isset($user['imagen'])) {
                    $session_data['img'] = $user['imagen'];
                } else {
                    $session_data['img'] = 'default.png';
                }
                
                $session_data['logged_in'] = TRUE;
                
                $this->session->set_userdata($session_data);
                redirect('panel');
                
            } else {
                // El usuario no tiene acceso a este laboratorio
                $data['error'] = 'No tienes acceso a este laboratorio.';
                $data['laboratorios'] = $this->laboratorio_model->get_all();
                $this->load->view('usuario/login', $data);
            }
        } else {
            // Error de login
            $data['error'] = 'Usuario o contraseña incorrectos.';
            $data['laboratorios'] = $this->laboratorio_model->get_all();
            $this->load->view('usuario/login', $data);
        }
    }
  }

  public function logout() 
  {
    // Cerrar sesión
    $this->session->sess_destroy();
    
    // Verificar si hay un referer válido para redirigir
    $referer = $this->input->server('HTTP_REFERER');
    if (!empty($referer) && strpos($referer, base_url()) === 0) {
        redirect($referer);
    } else {
        redirect('portal/acerca_de');
    }
  }
  
  /**
   * Método para obtener los laboratorios disponibles (para el formulario de login)
   */
  public function get_laboratorios()
  {
      $laboratorios = $this->laboratorio_model->get_all();
      return $laboratorios;
  }
  
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */