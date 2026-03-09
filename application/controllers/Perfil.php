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

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function editar()
    {
        $user_id = $this->session->userdata('user_id');

        if (empty($user_id)) { redirect('login'); return; }

        $usuario = $this->user_model->get_user_by_id($user_id);

        $data['username']          = $usuario->username          ?? $this->session->userdata('username');
        $data['email']             = $usuario->email             ?? $this->session->userdata('email');
        $data['laboratorio_id']    = $usuario->laboratorio_id    ?? $this->session->userdata('laboratorio_id');
        $data['laboratorio_nombre']= $this->session->userdata('laboratorio_nombre');
        $data['rol']               = $usuario->rol               ?? 'usuario';
        $data['title']             = 'Mi Perfil';

        $default_images = [1 => 'tux.png', 2 => 'apple.png'];
        $default_image  = $default_images[$data['laboratorio_id']] ?? 'default.png';

        $imagen_obj = $this->user_model->obtenerImagen($user_id);

        if ($imagen_obj && !empty($imagen_obj->imagen)) {
            $ruta = FCPATH . 'recursos-panel/images/usuario/' . $imagen_obj->imagen;
            $data['imagen'] = file_exists($ruta) ? $imagen_obj->imagen : $default_image;
        } else {
            $data['imagen'] = $default_image;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('usuario/perfil', $data);
        $this->load->view('templates/footer');
    }

    // ================================================================
    // ACTUALIZAR IMAGEN DE PERFIL
    // ================================================================
    // Recibe el archivo del input name="imagen-perfil"
    // Lo guarda en: recursos-panel/images/usuario/
    // Nombre del archivo: user_{id}.{ext}  (ej: user_5.jpg)
    // Actualiza la columna 'imagen' en la tabla users
    //
    // Para cambiar la carpeta destino: modifica 'upload_path'
    // Para cambiar tipos permitidos:   modifica 'allowed_types'
    // Para cambiar tamaño máximo:      modifica 'max_size' (en KB)
    // ================================================================
    public function actualizar_imagen()
    {
        $user_id = $this->session->userdata('user_id');

        if (empty($user_id)) { redirect('login'); return; }

        // Verificar que se envió un archivo
        if (empty($_FILES['imagen-perfil']['name'])) {
            $this->session->set_flashdata('error_img', 'No seleccionaste ningún archivo.');
            redirect('perfil/editar');
            return;
        }

        // Crear carpeta si no existe
        $upload_path = FCPATH . 'recursos-panel/images/usuario/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        // Obtener extension del archivo
        $ext = strtolower(pathinfo($_FILES['imagen-perfil']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];

        if (!in_array($ext, $allowed)) {
            $this->session->set_flashdata('error_img', 'Solo se permiten imágenes JPG o PNG.');
            redirect('perfil/editar');
            return;
        }

        // Nombre del archivo: user_{id}.{ext}
        $nuevo_nombre = 'user_' . $user_id . '.' . $ext;
        $destino      = $upload_path . $nuevo_nombre;

        // Mover el archivo
        if (!move_uploaded_file($_FILES['imagen-perfil']['tmp_name'], $destino)) {
            $this->session->set_flashdata('error_img', 'Error al subir la imagen. Verifica permisos de la carpeta.');
            redirect('perfil/editar');
            return;
        }

        // Guardar en BD — columna imagen en tabla users
        $this->db->where('id', $user_id);
        $ok = $this->db->update('users', ['imagen' => $nuevo_nombre]);

        if ($ok) {
            $this->session->set_flashdata('success_img', 'Foto de perfil actualizada correctamente.');
        } else {
            $this->session->set_flashdata('error_img', 'Imagen subida pero no se pudo guardar en la base de datos.');
        }

        redirect('perfil/editar');
    }

    public function actualizar_datos()
    {
        $user_id = $this->session->userdata('user_id');

        if (empty($user_id)) { redirect('login'); return; }

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