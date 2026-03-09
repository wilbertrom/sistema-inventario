<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdenTrabajo extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('OrdenTrabajo_model');
        $this->load->model('OrdenMantenimiento_model');
        $this->load->library('session');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    // ── AGREGAR TRABAJO A UNA ORDEN ──────────────────────────
    public function crear()
    {
        $orden_id = (int) $this->input->post('orden_id');

        if (empty($orden_id)) {
            redirect('orden-mantenimiento');
            return;
        }

        // Verificar que la orden pertenece al laboratorio del usuario
        $orden = $this->OrdenMantenimiento_model->getById($orden_id);
        if (!$orden || $orden->laboratorio_id != $this->session->userdata('laboratorio_id')) {
            show_404();
            return;
        }

        $data = [
            'orden_id'             => $orden_id,
            'tipo_mantenimiento'   => $this->input->post('tipo_mantenimiento'),
            'tipo_servicio'        => $this->input->post('tipo_servicio'),
            'asignado_a'           => $this->input->post('asignado_a'),
            'empresa_contratista'  => $this->input->post('empresa_contratista'),
            'costo'                => $this->input->post('costo') ?: 0,
            'fecha_realizacion'    => $this->input->post('fecha_realizacion'),
            'trabajo_realizado'    => $this->input->post('trabajo_realizado'),
            'materiales_utilizados'=> $this->input->post('materiales_utilizados'),
        ];

        if ($this->OrdenTrabajo_model->insert($data)) {
            $this->session->set_flashdata('success', 'Trabajo agregado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al agregar el trabajo.');
        }

        redirect('orden-mantenimiento/editar/' . $orden_id);
    }

    // ── ELIMINAR TRABAJO ─────────────────────────────────────
    public function eliminar($id)
    {
        $trabajo = $this->OrdenTrabajo_model->getById($id);

        if (!$trabajo) {
            redirect('orden-mantenimiento');
            return;
        }

        $orden_id = $trabajo->orden_id;

        // Verificar que la orden pertenece al laboratorio del usuario
        $orden = $this->OrdenMantenimiento_model->getById($orden_id);
        if (!$orden || $orden->laboratorio_id != $this->session->userdata('laboratorio_id')) {
            show_404();
            return;
        }

        $this->OrdenTrabajo_model->delete($id);
        $this->session->set_flashdata('success', 'Trabajo eliminado.');
        redirect('orden-mantenimiento/editar/' . $orden_id);
    }
}