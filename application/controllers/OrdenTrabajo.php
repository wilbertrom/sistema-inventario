<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdenTrabajo extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('OrdenTrabajo_model');
        $this->load->library('session');
    }
    
    public function crear()
    {
        $data = [
            'orden_id' => $this->input->post('orden_id'),
            'tipo_mantenimiento' => $this->input->post('tipo_mantenimiento'),
            'tipo_servicio' => $this->input->post('tipo_servicio'),
            'asignado_a' => $this->input->post('asignado_a'),
            'empresa_contratista' => $this->input->post('empresa_contratista'),
            'costo' => $this->input->post('costo') ?: 0,
            'fecha_realizacion' => $this->input->post('fecha_realizacion'),
            'trabajo_realizado' => $this->input->post('trabajo_realizado'),
            'materiales_utilizados' => $this->input->post('materiales_utilizados')
        ];
        
        if ($this->OrdenTrabajo_model->insert($data)) {
            $this->session->set_flashdata('success', 'Trabajo agregado');
        } else {
            $this->session->set_flashdata('error_trabajo', 'Error al agregar');
        }
        
        redirect('orden-mantenimiento/editar/' . $this->input->post('orden_id'));
    }
    
    public function eliminar($id)
    {
        // Necesitarías obtener el orden_id antes de eliminar
        // Por simplicidad, lo dejamos para después
        redirect('orden-mantenimiento');
    }
}