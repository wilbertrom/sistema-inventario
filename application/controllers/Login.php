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
        
        $lab = $this->input->get('lab');
        $data['laboratorio_seleccionado'] = $lab;
        
        $this->load->view('usuario/login', $data);
    }

    public function do_login() 
    {
        $this->form_validation->set_rules('username', 'Usuario', 'required');
        $this->form_validation->set_rules('password', 'Contraseña', 'required');
        
        $laboratorio_id = $this->input->post('laboratorio');
        
        // Si no viene por POST, intentar por GET
        if (empty($laboratorio_id)) {
            $lab = $this->input->get('lab');
            if ($lab === 'opensource') {
                $laboratorio_id = 1;
            } elseif ($lab === 'mac') {
                $laboratorio_id = 2;
            }
        }

        if ($this->form_validation->run() == FALSE) {
            $data['laboratorio_seleccionado'] = $this->input->get('lab');
            $this->load->view('usuario/login', $data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->user_model->login($username, $password);

            if ($user !== null && is_array($user) && !empty($user)) {
                
                // Verificar acceso al laboratorio
                $tiene_acceso = $this->user_model->verificar_acceso_laboratorio($user['id'], $laboratorio_id);
                
                if ($tiene_acceso) {
                    
                    $session_data = array(
                        'user_id' => $user['id'],
                        'username' => $user['username'],
                        'rol' => $user['rol'] ?? 'usuario',
                        'laboratorio_id' => $laboratorio_id,
                        'email' => $user['email'] ?? '',
                        'img' => $user['imagen'] ?? 'default.png',
                        'logged_in' => TRUE
                    );
                    
                    $lab = $this->laboratorio_model->get_by_id($laboratorio_id);
                    $session_data['laboratorio_nombre'] = $lab ? $lab->nombre : ($laboratorio_id == 1 ? 'Open Source' : 'Mac');
                    
                    $this->session->set_userdata($session_data);
                    
                    // Redirigir según laboratorio
                    if ($laboratorio_id == 1) {
                        $this->session->set_flashdata('success', 'Bienvenido al Laboratorio Open Source');
                    } else {
                        $this->session->set_flashdata('success', 'Bienvenido al Laboratorio Mac');
                    }
                    
                    redirect('panel');
                    
                } else {
                    // Mensaje específico según laboratorio
                    $lab_nombre = ($laboratorio_id == 1) ? 'Open Source' : 'Mac';
                    $user_lab = ($user['laboratorio_id'] == 1) ? 'Open Source' : 'Mac';
                    
                    $data['error'] = "⚠️ Acceso denegado: El usuario '$username' pertenece al laboratorio <strong>$user_lab</strong>, no puede acceder al laboratorio <strong>$lab_nombre</strong>.";
                    $data['laboratorio_seleccionado'] = $this->input->get('lab');
                    $this->load->view('usuario/login', $data);
                }
            } else {
                $data['error'] = '❌ Usuario o contraseña incorrectos. Verifica tus credenciales.';
                $data['laboratorio_seleccionado'] = $this->input->get('lab');
                $this->load->view('usuario/login', $data);
            }
        }
    }

    public function logout() 
    {
        $this->session->sess_destroy();
        redirect('portal/acerca_de');
    }
}