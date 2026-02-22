<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventario extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Inventario_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('idEncrypt');
    }

    public function registrar()
    {
        $this->form_validation->set_rules('marca',       'Marca',          'required');
        $this->form_validation->set_rules('cod_interno', 'Código Interno', 'required|trim');
        $this->form_validation->set_rules('tipo',        'Tipo',           'required');
        $this->form_validation->set_rules('estado',      'Estado',         'required');

        if ($this->form_validation->run() == FALSE) {
            // Redirigir de vuelta a Panel::registrar para que cargue
            // los datos (marcas, tipos, estados) correctamente
            redirect('panel/registrar');
            return;
        }

        // Panel::view() encripta los id_tipos antes de pasarlos a la vista,
        // así que los values de tipo llegan encriptados — desencriptar
        $marca_id  = (int) $this->input->post('marca');
        $tipo_id   = (int) $this->idencrypt->decrypt($this->input->post('tipo'));
        $estado_id = (int) $this->input->post('estado');

        // Validación: IDs deben ser > 0
        if ($marca_id <= 0 || $tipo_id <= 0 || $estado_id <= 0) {
            $this->session->set_flashdata('error', 'Selecciona una marca, tipo y estado válidos.');
            redirect('panel/registrar');
            return;
        }

        $data_equipo = array(
            'id_marcas'      => $marca_id,
            'cod_interno'    => $this->input->post('cod_interno'),
            'id_tipos'       => $tipo_id,
            'descripcion'    => $this->input->post('descripcion'),
            'id_estados'     => $estado_id,
            'laboratorio_id' => $this->session->userdata('laboratorio_id'),
            'modelo'         => $this->input->post('modelo') ?: null,
        );

        // Si es CPU (tipo_id == 1), guardar especificaciones
        if ($tipo_id == 1) {
            $data_ccompu = array(
                'procesador' => $this->input->post('procesador'),
                'tarjeta'    => $this->input->post('tarjeta_madre'),
                'ram'        => $this->input->post('ram'),
                'disco'      => $this->input->post('disco'),
            );
            $id_ccompu = $this->Inventario_model->registrar_ccompu($data_ccompu);
            if ($id_ccompu) {
                $data_equipo['id_ccompus'] = $id_ccompu;
            }
        }

        $id_equipo = $this->Inventario_model->registrar_inventario($data_equipo);

        if ($id_equipo) {
            if (!empty($_FILES['imagen']['name'])) {
                $config['upload_path']   = './recursos-panel/images/equipos/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 4096;
                $config['file_name']     = $id_equipo;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('imagen')) {
                    $upload_data = $this->upload->data();
                    $this->Inventario_model->actualizar_imagen_equipo(
                        $id_equipo,
                        array('imagen' => $upload_data['file_name'])
                    );
                }
            }
            $this->session->set_flashdata('success', 'Equipo registrado correctamente.');
            redirect('panel/ver_inventario');
        } else {
            $this->session->set_flashdata('error', 'Error al registrar el equipo. Intenta de nuevo.');
            redirect('panel/registrar');
        }
    }

    public function editar()
    {
        $this->form_validation->set_rules('marca',       'Marca',          'required');
        $this->form_validation->set_rules('cod_interno', 'Código Interno', 'required');
        $this->form_validation->set_rules('tipo',        'Tipo',           'required');
        $this->form_validation->set_rules('estado',      'Estado',         'required');

        if ($this->form_validation->run() == FALSE) {
            // id_equipos viene encriptado desde Panel::editar — pasarlo de vuelta
            $id_enc = $this->input->post('id_equipos');
            redirect('panel/editar/' . $id_enc);
            return;
        }

        $id_equipo  = $this->idencrypt->decrypt($this->input->post('id_equipos'));
        $id_ccompus = $this->input->post('id_ccompus');

        $data_equipo_up = array(
            'id_marcas'   => (int) $this->input->post('marca'),
            'cod_interno' => $this->input->post('cod_interno'),
            'id_tipos'    => (int) $this->input->post('tipo'),
            'descripcion' => $this->input->post('descripcion'),
            'id_estados'  => (int) $this->input->post('estado'),
        );

        // Si es CPU y tiene ccompu asociado
        if ((int) $this->input->post('tipo') == 1 && !empty($id_ccompus)) {
            $data_ccompu_up = array(
                'procesador' => $this->input->post('procesador'),
                'tarjeta'    => $this->input->post('tarjeta_madre'),
                'ram'        => $this->input->post('ram'),
            );
            $this->Inventario_model->actualizar_ccompu($data_ccompu_up, $id_ccompus);
        }

        if ($this->Inventario_model->actualizar_inventario($data_equipo_up, $id_equipo)) {
            if (!empty($_FILES['imagen']['name'])) {
                $dir = './recursos-panel/images/equipos/';
                foreach (['png','jpg','jpeg'] as $ext) {
                    $f = $dir . $id_equipo . '.' . $ext;
                    if (file_exists($f)) unlink($f);
                }
                $config['upload_path']   = $dir;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 4096;
                $config['file_name']     = $id_equipo;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('imagen')) {
                    $data_upload = $this->upload->data();
                    $this->Inventario_model->actualizar_imagen_equipo(
                        $id_equipo,
                        array('imagen' => $data_upload['file_name'])
                    );
                }
            }
            $this->session->set_flashdata('success', 'Equipo actualizado correctamente.');
            redirect('panel/ver_inventario');
        } else {
            $this->session->set_flashdata('error', 'Error al actualizar el equipo.');
            redirect('panel/editar/' . $this->input->post('id_equipos'));
        }
    }

    public function eliminar($id)
    {
        $id = $this->idencrypt->decrypt($id);

        $id_ccompu_obj = $this->Inventario_model->obtener_id_ccompu($id);
        if ($id_ccompu_obj !== null && isset($id_ccompu_obj->id_ccompus) && $id_ccompu_obj->id_ccompus != NULL) {
            $this->Inventario_model->eliminar_ccompu($id_ccompu_obj->id_ccompus);
        }

        $this->Inventario_model->eliminar_equipo($id);

        $dir = './recursos-panel/images/equipos/';
        foreach (['png','jpg','jpeg'] as $ext) {
            $f = $dir . $id . '.' . $ext;
            if (file_exists($f)) unlink($f);
        }

        $referer = $this->input->server('HTTP_REFERER');
        redirect(!empty($referer) ? $referer : 'panel/ver_inventario');
    }

    public function actualizar_estado($estado, $id)
    {
        $id_decrypted = $this->idencrypt->decrypt($id);
        if ($id_decrypted) {
            $this->Inventario_model->actualizar_estado($estado, $id_decrypted);
        }
        redirect('panel/ver_inventario');
    }

    public function nuevaMarca()
    {
        $this->form_validation->set_rules('marca', 'Marca', 'required');
        $id_equipo = $this->input->post('id_equipos');

        if ($this->form_validation->run() == FALSE) {
            redirect('panel/registrar');
            return;
        }

        $data = array('nombre' => $this->input->post('marca'));
        if ($this->Inventario_model->registrar_marca($data)) {
            redirect(!empty($id_equipo) ? 'panel/editar/' . $id_equipo : 'panel/registrar');
        } else {
            $this->session->set_flashdata('error', 'Error al agregar la marca.');
            redirect('panel/registrar');
        }
    }

    public function nuevoTipo()
    {
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        $id_equipo = $this->input->post('id_equipos');

        if ($this->form_validation->run() == FALSE) {
            redirect('panel/registrar');
            return;
        }

        $data = array('nombre' => $this->input->post('tipo'));
        if ($this->Inventario_model->registrar_tipo($data)) {
            redirect(!empty($id_equipo) ? 'panel/editar/' . $id_equipo : 'panel/registrar');
        } else {
            $this->session->set_flashdata('error', 'Error al agregar el tipo.');
            redirect('panel/registrar');
        }
    }
}