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

class Perfil extends CI_Controller
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
    $data['user'] = $this->session->userdata('username');
    $data['email'] = $this->session->userdata('email');
    $id = $this->session->userdata('user_id');
    $data['userimg'] = $this->user_model->obtenerImagen($id);

    $this->load->view('templates/header', $data);
    $this->load->view('usuario/perfil', $data);
    $this->load->view('templates/footer');
}

  public function actualizar()
  {
    $user_id = $this->session->userdata('user_id');

      // Manejar la carga de la imagen
        $config['upload_path'] = './recursos-panel/images/usuario/'; // Directorio donde se guardarán las imágenes
        $config['allowed_types'] = 'jpg|jpeg|png'; // Tipos de archivos permitidos
        $config['max_size'] = 4096; 
        $config['file_name'] = $user_id;

        $this->load->library('upload', $config);

        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        foreach ($allowed_extensions as $ext) {
            $existing_file_path = $config['upload_path'] . $user_id . '.' . $ext;
            if (file_exists($existing_file_path)) {
                unlink($existing_file_path);
            }
        }

        
        if($this->upload->do_upload('imagen-perfil')){
          $data =  $this->upload->data();
          $path_img = $data['file_name'];  
          $data = array(
            'imagen' => $path_img
          );
          $this->user_model->actualizar_imagen_usuario($user_id, $data);
          $this->session->set_userdata('img', $path_img);
          // Redirigir a una página de éxito
          redirect('panel/ver_inventario');

        }else{
          $error = array('error' => $this->upload->display_errors());
        }
}

}


/* End of file Perfil.php */
/* Location: ./application/controllers/Perfil.php */