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

    $this->load->view('templates/header', $data);
    $this->load->view('panel/requisiciones/list_requisicion', $data);
    $this->load->view('templates/footer');

  }

  public function nueva(){

    $data['title'] = ucfirst("Requisición Nueva"); //Capitalizar la primera letra

    $this->load->view('templates/header', $data);
    $this->load->view('panel/requisiciones/form_requisicion');
    $this->load->view('templates/footer');
  }

  public function crear(){
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
      
      $items = array();
      for ($i = 0; $i < count($this->input->post('nombre')); $i++) {
          $items[] = array(
              'id_req' => $requisition_id,
              'nombre' => $this->input->post('nombre')[$i],
              'cantidad' => $this->input->post('cantidad')[$i]
          );
      }
      
      $this->Requisiciones_model->add_requisition_items($items);
      redirect('requisiciones/index');
  }
  }

}


/* End of file Requisiciones.php */
/* Location: ./application/controllers/Requisiciones.php */