<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Orden
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    ac.id>
 * @author    
 * @link      
 * @param     ...
 * @return    ...
 *
 */

class Orden extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Orden_model');
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->library('idEncrypt');
  }

  public function index()
  {
    

    $data['title'] = ucfirst("Ordenes"); //Capitalizar la primera letra

    $data['ordenes'] = $this->Orden_model->obtenerTodosMantenimientos();
    
    $this->load->view('templates/header', $data);
    $this->load->view('panel/orden/todas_ordenes', $data);
    $this->load->view('templates/footer', $data);
  }

  public function registrar(){
    $this->form_validation->set_rules('fecha', 'Fecha', 'required');
    $this->form_validation->set_rules('estado', 'Estado', 'required');
    $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');

    if ($this->form_validation->run() == FALSE) {
      // Si la validación falla, recargar la vista con errores
      $this->load->view('panel/orden/mantenimiento');
    }else {
      //recoger los datos del formulario
      $id_equipo = $this->input->post('id_equipos');

      $estado = $this->input->post('estado');
      
      $data_orden = array(
        'fecha' => $this->input->post('fecha'),
        'descripcion' => $this->input->post('descripcion'),
        'especificacion' => $this->input->post('especificacion'),
        'id_equipos' => $this->idencrypt->decrypt($id_equipo)
        );
  
        $this->Orden_model->registrar_orden($data_orden);

        redirect('inventario/actualizar_estado/'. $estado."/". $id_equipo);

    }
    
  }

  public function ver_ordenesEquipo($id_equipo){
    $id = $this->idencrypt->decrypt($id_equipo);
    $data['title'] = ucfirst("Ordenes"); //Capitalizar la primera letra

    $data['ordenes'] = $this->Orden_model->obtenerOrdenesEquipo($id);
    
    $this->load->view('templates/header', $data);
    $this->load->view('panel/orden/vista_mant', $data);
    $this->load->view('templates/footer', $data);
  }

}


/* End of file Orden.php */
/* Location: ./application/controllers/Orden.php */