<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Requisiciones
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

class Requisiciones extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Requisiciones_model');
    $this->load->helper('form');
    $this->load->library('form_validation');
  }

  public function index()
  {
    $data['title'] = ucfirst("Requisiciones"); //Capitalizar la primera letra
    $data['requisiciones'] = $this->Requisiciones_model->get_requisitions();
    
    // Verificar que $data['requisiciones'] no sea null
    if ($data['requisiciones'] === null) {
        $data['requisiciones'] = array();
    }

    $this->load->view('templates/header', $data);
    $this->load->view('panel/requisiciones/list_requisicion', $data);
    $this->load->view('templates/footer');
  }

  public function nueva()
  {
    $data['title'] = ucfirst("Requisición Nueva"); //Capitalizar la primera letra

    $this->load->view('templates/header', $data);
    $this->load->view('panel/requisiciones/form_requisicion');
    $this->load->view('templates/footer');
  }

  public function crear()
  {
    $this->form_validation->set_rules('razon', 'Razón', 'required');
    $this->form_validation->set_rules('proposito', 'Propósito', 'required');
    $this->form_validation->set_rules('partida_p', 'Partida Presupuestal', 'required');

    if ($this->form_validation->run() === FALSE) {
        $this->load->view('panel/requisiciones/form_requisicion');
    } else {
        $requisition_data = array(
            'razon' => $this->input->post('razon'),
            'proposito' => $this->input->post('proposito'),
            'partida_p' => $this->input->post('partida_p')
        );
        
        $requisition_id = $this->Requisiciones_model->create_requisition($requisition_data);
        
        // Verificar que la requisición se creó correctamente
        if (empty($requisition_id)) {
            // Mostrar mensaje de error
            $data['error'] = 'Error al crear la requisición.';
            $this->load->view('templates/header', $data);
            $this->load->view('panel/requisiciones/form_requisicion', $data);
            $this->load->view('templates/footer');
            return;
        }
        
        $items = array();
        $nombres = $this->input->post('nombre');
        $cantidades = $this->input->post('cantidad');
        
        // Verificar que los arrays existan y tengan el mismo tamaño
        if (is_array($nombres) && is_array($cantidades) && count($nombres) === count($cantidades)) {
            for ($i = 0; $i < count($nombres); $i++) {
                // Verificar que los valores no estén vacíos
                if (!empty($nombres[$i]) && !empty($cantidades[$i])) {
                    $items[] = array(
                        'id_req' => $requisition_id,
                        'nombre' => $nombres[$i],
                        'cantidad' => $cantidades[$i]
                    );
                }
            }
        }
        
        // Solo agregar items si hay al menos uno
        if (!empty($items)) {
            $this->Requisiciones_model->add_requisition_items($items);
        } else {
            // Si no hay items, mostrar advertencia
            $this->session->set_flashdata('warning', 'La requisición se creó sin items.');
        }
        
        // Mensaje de éxito
        $this->session->set_flashdata('success', 'Requisición creada correctamente.');
        redirect('requisiciones/index');
    }
  }
}

/* End of file Requisiciones.php */
/* Location: ./application/controllers/Requisiciones.php */