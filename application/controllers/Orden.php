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
    
    // Verificar que $data['ordenes'] no sea null antes de pasarlo a la vista
    if ($data['ordenes'] === null) {
        $data['ordenes'] = array(); // Inicializar como array vacío si es null
    }
    
    $this->load->view('templates/header', $data);
    $this->load->view('panel/orden/todas_ordenes', $data);
    $this->load->view('templates/footer', $data);
  }

  public function registrar()
  {
    $this->form_validation->set_rules('fecha', 'Fecha', 'required');
    $this->form_validation->set_rules('estado', 'Estado', 'required');
    $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');

    if ($this->form_validation->run() == FALSE) {
      // Si la validación falla, recargar la vista con errores
      $this->load->view('panel/orden/mantenimiento');
    } else {
      // Recoger los datos del formulario
      $id_equipo_encrypted = $this->input->post('id_equipos');
      
      // Verificar que id_equipo no esté vacío
      if (empty($id_equipo_encrypted)) {
          // Mostrar mensaje de error si no hay ID de equipo
          $data['error'] = 'No se ha especificado el equipo.';
          $this->load->view('panel/orden/mantenimiento', $data);
          return;
      }

      $estado = $this->input->post('estado');
      
      // Desencriptar el ID del equipo
      $id_equipo_decrypted = $this->idencrypt->decrypt($id_equipo_encrypted);
      
      // Verificar que la desencriptación fue exitosa
      if (empty($id_equipo_decrypted)) {
          // Mostrar mensaje de error si la desencriptación falló
          $data['error'] = 'Error al procesar el equipo.';
          $this->load->view('panel/orden/mantenimiento', $data);
          return;
      }
      
      $data_orden = array(
        'fecha' => $this->input->post('fecha'),
        'descripcion' => $this->input->post('descripcion'),
        'especificacion' => $this->input->post('especificacion'),
        'id_equipos' => $id_equipo_decrypted
      );
  
      // Registrar la orden
      $resultado = $this->Orden_model->registrar_orden($data_orden);
      
      // Verificar si el registro fue exitoso
      if ($resultado) {
        redirect('inventario/actualizar_estado/'. $estado ."/". $id_equipo_encrypted);
      } else {
        // Mostrar mensaje de error si no se pudo registrar
        $data['error'] = 'Error al registrar la orden de mantenimiento.';
        $this->load->view('panel/orden/mantenimiento', $data);
      }
    }
  }

  public function ver_ordenesEquipo($id_equipo)
  {
    // Verificar que el parámetro no esté vacío
    if (empty($id_equipo)) {
        redirect('panel');
        return;
    }
    
    $id = $this->idencrypt->decrypt($id_equipo);
    
    // Verificar que la desencriptación fue exitosa
    if (empty($id)) {
        redirect('panel');
        return;
    }
    
    $data['title'] = ucfirst("Ordenes"); //Capitalizar la primera letra

    $data['ordenes'] = $this->Orden_model->obtenerOrdenesEquipo($id);
    
    // Verificar que $data['ordenes'] no sea null antes de pasarlo a la vista
    if ($data['ordenes'] === null) {
        $data['ordenes'] = array(); // Inicializar como array vacío si es null
    }
    
    $this->load->view('templates/header', $data);
    $this->load->view('panel/orden/vista_mant', $data);
    $this->load->view('templates/footer', $data);
  }
}

/* End of file Orden.php */
/* Location: ./application/controllers/Orden.php */