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
        $this->form_validation->set_rules('codigo_interno', 'Código Interno', 'required|trim');
        $this->form_validation->set_rules('tipo',        'Tipo',           'required');
        $this->form_validation->set_rules('estado',      'Estado',         'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('panel/registrar');
            return;
        }

        $marca_id  = (int) $this->input->post('marca');
        $tipo_id   = (int) $this->idencrypt->decrypt($this->input->post('tipo'));
        $estado_id = (int) $this->input->post('estado');

        if ($marca_id <= 0 || $tipo_id <= 0 || $estado_id <= 0) {
            $this->session->set_flashdata('error', 'Selecciona una marca, tipo y estado válidos.');
            redirect('panel/registrar');
            return;
        }

        $data_equipo = array(
            'id_marcas'           => $marca_id,
            'codigo_interno' => $this->input->post('codigo_interno'),
            'id_tipos'            => $tipo_id,
            'descripcion_producto'=> $this->input->post('descripcion') ?: null,
            'id_estados'          => $estado_id,
            'laboratorio_id'      => $this->session->userdata('laboratorio_id'),
            'modelo'              => $this->input->post('modelo') ?: null,
            'proveedor'           => $this->input->post('proveedor') ?: null,
            'unidad'              => $this->input->post('unidad') ?: null,
        );

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
        $this->form_validation->set_rules('codigo_interno', 'Código Interno', 'required');
        $this->form_validation->set_rules('tipo',        'Tipo',           'required');
        $this->form_validation->set_rules('estado',      'Estado',         'required');

        $id_enc_fv = $this->input->post('id_equipos');
        if ($this->form_validation->run() == FALSE) {
            redirect(!empty($id_enc_fv) ? 'panel/editar/' . $id_enc_fv : 'panel/ver_inventario');
            return;
        }

        $id_equipo  = $this->idencrypt->decrypt($this->input->post('id_equipos'));
        $id_ccompus = $this->input->post('id_ccompus');

        // Si el decrypt falla o devuelve vacío, no podemos continuar
        if (empty($id_equipo) || !is_numeric($id_equipo)) {
            $this->session->set_flashdata('error', 'Error: ID de equipo inválido.');
            redirect('panel/ver_inventario');
            return;
        }

        $data_equipo_up = array(
            'id_marcas'           => (int) $this->input->post('marca'),
            'codigo_interno' => $this->input->post('codigo_interno'),
            'id_tipos'            => (int) $this->input->post('tipo'),
            'descripcion_producto'=> $this->input->post('descripcion') ?: null,
            'id_estados'          => (int) $this->input->post('estado'),
            'proveedor'           => $this->input->post('proveedor') ?: null,
            'unidad'              => $this->input->post('unidad') ?: null,
        );

        if ((int) $this->input->post('tipo') == 1 && !empty($id_ccompus)) {
            $data_ccompu_up = array(
                'procesador' => $this->input->post('procesador'),
                'tarjeta'    => $this->input->post('tarjeta_madre'),
                'ram'        => $this->input->post('ram'),
            );
            $this->Inventario_model->actualizar_ccompu($data_ccompu_up, $id_ccompus);
        }

        $id_enc = $this->input->post('id_equipos'); // guardar antes del update
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
            redirect(!empty($id_enc) ? 'panel/editar/' . $id_enc : 'panel/ver_inventario');
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

    // ── NUEVA MARCA (solo para el laboratorio del usuario) ────
    public function nuevaMarca()
    {
        $this->form_validation->set_rules('marca', 'Marca', 'required');
        $id_equipo = trim($this->input->post('id_equipos'));
        $origen    = (!empty($id_equipo)) ? 'panel/editar/' . $id_equipo : 'panel/registrar';

        if ($this->form_validation->run() == FALSE) {
            redirect($origen);
            return;
        }

        $data = array('nombre' => strtoupper(trim($this->input->post('marca'))));
        if ($this->Inventario_model->registrar_marca($data)) {
            $this->session->set_flashdata('success', 'Marca agregada correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al agregar la marca.');
        }
        redirect($origen);
    }

    // ── NUEVO ESTADO (solo para el laboratorio del usuario) ───
    public function nuevoEstado()
    {
        $this->form_validation->set_rules('estado_nuevo', 'Estado', 'required');
        $id_equipo = trim($this->input->post('id_equipos'));
        $origen    = (!empty($id_equipo)) ? 'panel/editar/' . $id_equipo : 'panel/registrar';

        if ($this->form_validation->run() == FALSE) {
            redirect($origen);
            return;
        }

        $data = array('nombre' => ucfirst(trim($this->input->post('estado_nuevo'))));
        if ($this->Inventario_model->registrar_estado($data)) {
            $this->session->set_flashdata('success', 'Estado agregado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al agregar el estado.');
        }
        redirect($origen);
    }

    public function nuevoTipo()
    {
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        $id_equipo = trim($this->input->post('id_equipos'));
        $origen    = (!empty($id_equipo)) ? 'panel/editar/' . $id_equipo : 'panel/registrar';

        if ($this->form_validation->run() == FALSE) {
            redirect($origen);
            return;
        }

        $data = array('nombre' => strtoupper(trim($this->input->post('tipo'))));
        if ($this->Inventario_model->registrar_tipo($data)) {
            $this->session->set_flashdata('success', 'Tipo agregado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al agregar el tipo.');
        }
        redirect($origen);
    }
}