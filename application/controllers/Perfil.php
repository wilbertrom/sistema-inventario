<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Perfil
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    
 * @author    
 * @link      
 * @param     ...
 * @return    ...
 *
 */

class Perfil extends MY_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->library('session');
    $this->load->model('user_model');


    // Verificar si el usuario está logueado
    if (!$this->session->userdata('logged_in')) {
        // Redirigir al usuario a la página de login
        redirect('login');
    }
  }

  public function editar()
  {
    $data['title'] = ucfirst("Usuario");
    
    // Obtener datos de la sesión con verificación
    $data['user'] = $this->session->userdata('username');
    $data['email'] = $this->session->userdata('email');
    
    $id = $this->session->userdata('user_id');
    
    // Verificar que el ID exista
    if (empty($id)) {
        redirect('login');
        return;
    }
    
    $data['userimg'] = $this->user_model->obtenerImagen($id);
    
    // Si no hay imagen, establecer un valor por defecto
    if (empty($data['userimg'])) {
        $data['userimg'] = 'default.png'; // O cualquier imagen por defecto que tengas
    }

    $this->load->view('templates/header', $data);
    $this->load->view('usuario/perfil', $data);
    $this->load->view('templates/footer');
  }

  public function actualizar()
  {
    $user_id = $this->session->userdata('user_id');
    
    // Verificar que el usuario esté logueado
    if (empty($user_id)) {
        redirect('login');
        return;
    }

    // Verificar si se subió un archivo
    if (empty($_FILES['imagen-perfil']['name'])) {
        // Si no hay archivo, redirigir de vuelta al perfil
        $this->session->set_flashdata('error', 'No se seleccionó ninguna imagen.');
        redirect('perfil/editar');
        return;
    }

    // Manejar la carga de la imagen
    $config['upload_path'] = './recursos-panel/images/usuario/'; // Directorio donde se guardarán las imágenes
    $config['allowed_types'] = 'jpg|jpeg|png'; // Tipos de archivos permitidos
    $config['max_size'] = 4096;
    $config['file_name'] = $user_id;
    $config['overwrite'] = true; // Sobrescribir archivo existente

    $this->load->library('upload', $config);

    // Verificar y eliminar archivos existentes con diferentes extensiones
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    foreach ($allowed_extensions as $ext) {
        $existing_file_path = $config['upload_path'] . $user_id . '.' . $ext;
        if (file_exists($existing_file_path)) {
            unlink($existing_file_path);
        }
    }

    if ($this->upload->do_upload('imagen-perfil')) {
        $upload_data = $this->upload->data();
        $path_img = $upload_data['file_name'];
        
        $data_update = array(
            'imagen' => $path_img
        );
        
        // Actualizar en la base de datos
        if ($this->user_model->actualizar_imagen_usuario($user_id, $data_update)) {
            // Actualizar sesión
            $this->session->set_userdata('img', $path_img);
            
            // Mensaje de éxito
            $this->session->set_flashdata('success', 'Imagen actualizada correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al actualizar la imagen en la base de datos.');
        }
        
        // Redirigir a una página de éxito
        redirect('perfil/editar');
    } else {
        // Error en la subida
        $error = $this->upload->display_errors();
        $this->session->set_flashdata('error', 'Error al subir la imagen: ' . $error);
        redirect('perfil/editar');
    }
  }
}

/* End of file Perfil.php */
/* Location: ./application/controllers/Perfil.php */