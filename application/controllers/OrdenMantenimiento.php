<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdenMantenimiento extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('OrdenMantenimiento_model');
        $this->load->model('OrdenTrabajo_model');
        $this->load->library('session');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    public function index()
    {
        $laboratorio_id = $this->session->userdata('laboratorio_id');
        
        $data['ordenes'] = $this->OrdenMantenimiento_model->getByLaboratorio($laboratorio_id);
        $data['title'] = 'Órdenes de Mantenimiento';
        $data['laboratorio_nombre'] = $this->session->userdata('laboratorio_nombre');
        
        $this->load->view('templates/header', $data);
        $this->load->view('orden_mantenimiento/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function crear()
    {
        if ($this->input->post()) {
            $data = [
                'laboratorio_id' => $this->session->userdata('laboratorio_id'),
                'area_solicitante' => $this->input->post('area_solicitante'),
                'solicitante' => $this->input->post('solicitante'),
                'fecha_elaboracion' => $this->input->post('fecha_elaboracion'),
                'descripcion_servicio' => $this->input->post('descripcion_servicio'),
                'especificacion_tecnica' => $this->input->post('especificacion_tecnica')
            ];
            
            $orden_id = $this->OrdenMantenimiento_model->insert($data);
            
            if ($orden_id) {
                $this->session->set_flashdata('success', 'Orden creada correctamente');
                redirect('orden-mantenimiento/editar/' . $orden_id);
            } else {
                $this->session->set_flashdata('error', 'Error al crear la orden');
                redirect('orden-mantenimiento');
            }
        } else {
            $data['title'] = 'Nueva Orden de Mantenimiento';
            $this->load->view('templates/header', $data);
            $this->load->view('orden_mantenimiento/crear');
            $this->load->view('templates/footer');
        }
    }
    
    public function editar($id)
    {
        $orden = $this->OrdenMantenimiento_model->getById($id);
        
        if (!$orden || $orden->laboratorio_id != $this->session->userdata('laboratorio_id')) {
            show_404();
            return;
        }
        
        $data['orden'] = $orden;
        $data['trabajos'] = $this->OrdenTrabajo_model->getByOrden($id);
        $data['title'] = 'Editar Orden #' . $id;
        
        $this->load->view('templates/header', $data);
        $this->load->view('orden_mantenimiento/editar', $data);
        $this->load->view('templates/footer');
    }
    public function actualizar($id)
{
    $orden = $this->OrdenMantenimiento_model->getById($id);
    
    if (!$orden || $orden->laboratorio_id != $this->session->userdata('laboratorio_id')) {
        show_404();
        return;
    }
    
    $data = [
        'area_solicitante' => $this->input->post('area_solicitante'),
        'solicitante' => $this->input->post('solicitante'),
        'fecha_elaboracion' => $this->input->post('fecha_elaboracion'),
        'descripcion_servicio' => $this->input->post('descripcion_servicio'),
        'especificacion_tecnica' => $this->input->post('especificacion_tecnica')
    ];
    
    if ($this->OrdenMantenimiento_model->update($id, $data)) {
        $this->session->set_flashdata('success', 'Orden actualizada correctamente');
    } else {
        $this->session->set_flashdata('error', 'Error al actualizar');
    }
    
    redirect('orden-mantenimiento/editar/' . $id);
}
    public function pdf($id)
    {
        $orden = $this->OrdenMantenimiento_model->getById($id);
        
        if (!$orden || $orden->laboratorio_id != $this->session->userdata('laboratorio_id')) {
            show_404();
            return;
        }
        
        $trabajos = $this->OrdenTrabajo_model->getByOrden($id);
        
        $data = [
            'orden' => $orden,
            'trabajos' => $trabajos,
            'laboratorio_nombre' => $this->session->userdata('laboratorio_nombre')
        ];
        
        $html = $this->load->view('orden_mantenimiento/pdf_simple', $data, true);
        
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        $this->load->library('Uptx_pdf');
        $filename = 'Orden_Mantenimiento_' . $id;
        $this->uptx_pdf->generate($html, $filename, 'A4', 'portrait');
    }
    
    public function eliminar($id)
    {
        $orden = $this->OrdenMantenimiento_model->getById($id);
        
        if (!$orden || $orden->laboratorio_id != $this->session->userdata('laboratorio_id')) {
            show_404();
            return;
        }
        
        $this->OrdenMantenimiento_model->delete($id);
        $this->session->set_flashdata('success', 'Orden eliminada');
        redirect('orden-mantenimiento');
    }
}