<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramaAnual extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProgramaAnual_model');
        $this->load->model('ProgramaAnualDetalle_model');
        $this->load->library('session');
        
        // Verificar sesión
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    public function index()
    {
        $laboratorio_id = $this->session->userdata('laboratorio_id');
        $anio = $this->input->get('anio') ?: date('Y');
        
        $data['programas'] = $this->ProgramaAnual_model->getByLaboratorioAnio($laboratorio_id, $anio);
        $data['anio_seleccionado'] = $anio;
        $data['anios_disponibles'] = $this->ProgramaAnual_model->getAniosDisponibles($laboratorio_id);
        $data['title'] = 'Programa Anual de Mantenimiento ' . $anio;
        $data['laboratorio_nombre'] = $this->session->userdata('laboratorio_nombre');
        
        $this->load->view('templates/header', $data);
        $this->load->view('programa_anual/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function crear()
    {
        $data = [
            'laboratorio_id' => $this->session->userdata('laboratorio_id'),
            'actividad' => $this->input->post('actividad'),
            'anio' => $this->input->post('anio'),
            'observaciones' => $this->input->post('observaciones')
        ];
        
        $programa_id = $this->ProgramaAnual_model->insertPrograma($data);
        
        if ($programa_id) {
            $this->session->set_flashdata('success', 'Programa creado correctamente');
            redirect('programa-anual/editar/' . $programa_id);
        } else {
            $this->session->set_flashdata('error', 'Error al crear el programa');
            redirect('programa-anual');
        }
    }
    
    public function editar($id)
    {
        $programa = $this->ProgramaAnual_model->getById($id);
        
        if (!$programa || $programa->laboratorio_id != $this->session->userdata('laboratorio_id')) {
            show_404();
            return;
        }
        
        $data['programa'] = $programa;
        $data['detalles'] = $this->ProgramaAnualDetalle_model->getMesesByPrograma($id);
        $data['resumen'] = $this->ProgramaAnualDetalle_model->getResumenEstatus($id);
        $data['title'] = 'Editar Programa: ' . $programa->actividad;
        $data['meses'] = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('programa_anual/editar', $data);
        $this->load->view('templates/footer');
    }
    
    public function pdf($id)
    {
        $programa = $this->ProgramaAnual_model->getById($id);
        
        if (!$programa || $programa->laboratorio_id != $this->session->userdata('laboratorio_id')) {
            show_404();
            return;
        }
        
        $detalles = $this->ProgramaAnualDetalle_model->getMesesByPrograma($id);
        
        $data = [
            'programa' => $programa,
            'detalles' => $detalles,
            'laboratorio_nombre' => $this->session->userdata('laboratorio_nombre'),
            'anio' => $programa->anio
        ];
        
        $html = $this->load->view('programa_anual/pdf_nuevo', $data, true);
        
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        $this->load->library('Uptx_pdf');
        $filename = 'Programa_Anual_' . $programa->anio . '_' . $this->session->userdata('laboratorio_nombre');
        $this->uptx_pdf->generate($html, $filename);
    }
    
    public function eliminar($id)
    {
        $programa = $this->ProgramaAnual_model->getById($id);
        
        if (!$programa || $programa->laboratorio_id != $this->session->userdata('laboratorio_id')) {
            show_404();
            return;
        }
        
        // Eliminar detalles
        $this->ProgramaAnualDetalle_model->deleteByPrograma($id);
        // Eliminar programa
        $this->ProgramaAnual_model->deletePrograma($id);
        
        $this->session->set_flashdata('success', 'Programa eliminado correctamente');
        redirect('programa-anual');
    }
}