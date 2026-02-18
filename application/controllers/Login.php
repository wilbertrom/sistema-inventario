<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('user_model');
        $this->load->model('laboratorio_model');

        $this->form_validation->set_message('required', 'El campo %s es obligatorio.');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('panel');
        }
        $this->load->view('usuario/login');
    }

    public function do_login() 
    {
        $this->form_validation->set_rules('username', 'Usuario', 'required');
        $this->form_validation->set_rules('password', 'Contraseña', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('usuario/login');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->user_model->login($username, $password);

            if ($user) {
                // OBTENER EL LABORATORIO_ID DEL USUARIO DESDE LA BASE DE DATOS
                $laboratorio_id = $user['laboratorio_id'] ?? 1; // Por defecto 1 si no tiene
                
                // Obtener nombre del laboratorio
                $lab = $this->laboratorio_model->get_by_id($laboratorio_id);
                $laboratorio_nombre = $lab ? $lab->nombre : ($laboratorio_id == 1 ? 'Open Source' : 'Mac');
                
                $session_data = array(
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'rol' => $user['rol'] ?? 'usuario',
                    'laboratorio_id' => $laboratorio_id,        // <-- AHORA SÍ SE GUARDA
                    'laboratorio_nombre' => $laboratorio_nombre, // <-- NOMBRE TAMBIÉN
                    'email' => $user['email'] ?? '',
                    'img' => $user['imagen'] ?? 'default.png',
                    'logged_in' => TRUE
                );
                
                $this->session->set_userdata($session_data);
                
                // Depuración - Ver qué se guardó
                log_message('debug', 'Login exitoso - Usuario: ' . $username . ', Lab ID: ' . $laboratorio_id);
                
                redirect('panel');
            } else {
                $data['error'] = 'Usuario o contraseña incorrectos.';
                $this->load->view('usuario/login', $data);
            }
        }
    }

    public function logout() 
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}