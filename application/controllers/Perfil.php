<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perfil extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('user_model');

        // Verificar si el usuario está logueado
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function editar()
{
    $user_id = $this->session->userdata('user_id');
    
    if (empty($user_id)) {
        redirect('login');
        return;
    }
    
    // Obtener datos del usuario
    $usuario = $this->user_model->get_user_by_id($user_id);
    
    $data['username'] = $usuario->username ?? $this->session->userdata('username');
    $data['email'] = $usuario->email ?? $this->session->userdata('email');
    $data['laboratorio_id'] = $usuario->laboratorio_id ?? $this->session->userdata('laboratorio_id');
    $data['laboratorio_nombre'] = $this->session->userdata('laboratorio_nombre');
    $data['rol'] = $usuario->rol ?? 'usuario';
    $data['title'] = ucfirst("Mi Perfil");
    
    // Definir imagen por defecto según laboratorio
    $default_images = [
        1 => 'tux.png',      // Open Source - Pingüino Tux
        2 => 'apple.png'     // Mac - Logo de Apple
    ];
    
    $default_image = $default_images[$data['laboratorio_id']] ?? 'default.png';
    
    // Obtener imagen del usuario
    $imagen_obj = $this->user_model->obtenerImagen($user_id);
    
    if ($imagen_obj && isset($imagen_obj->imagen) && !empty($imagen_obj->imagen)) {
        $ruta_imagen = FCPATH . 'recursos-panel/images/usuario/' . $imagen_obj->imagen;
        if (file_exists($ruta_imagen)) {
            $data['imagen'] = $imagen_obj->imagen;
        } else {
            // Imagen no existe físicamente, usar la del laboratorio
            $data['imagen'] = $default_image;
        }
    } else {
        // No hay imagen en BD, usar la del laboratorio
        $data['imagen'] = $default_image;
    }

    $this->load->view('templates/header', $data);
    $this->load->view('usuario/perfil', $data);
    $this->load->view('templates/footer');
}

    public function actualizar_datos()
    {
        $user_id = $this->session->userdata('user_id');
        
        if (empty($user_id)) {
            redirect('login');
            return;
        }

        $this->form_validation->set_rules('email', 'Correo electrónico', 'valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error_datos', validation_errors());
        } else {
            $data_update = array();
            
            $email = $this->input->post('email');
            if (!empty($email) && $email != $this->session->userdata('email')) {
                $data_update['email'] = $email;
            }
            
            if (!empty($data_update)) {
                $this->db->where('id', $user_id);
                if ($this->db->update('users', $data_update)) {
                    // Actualizar sesión
                    if (isset($data_update['email'])) {
                        $this->session->set_userdata('email', $data_update['email']);
                    }
                    $this->session->set_flashdata('success_datos', 'Datos actualizados correctamente.');
                } else {
                    $this->session->set_flashdata('error_datos', 'Error al actualizar los datos.');
                }
            } else {
                $this->session->set_flashdata('info_datos', 'No hay cambios para guardar.');
            }
        }
        
        redirect('perfil/editar');
    }

    private function hash_password($password)
    {
        return hash('sha256', $password);
    }
}