<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Grupos
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

class Grupos extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();

    $this->load->library('session');
    $this->load->helper(array('form', 'url'));
    $this->load->model('Grupo_model');
    $this->load->model('Inventario_model');
    $this->load->library('IdEncrypt');
    

    // Verificar si el usuario está logueado
    if (!$this->session->userdata('logged_in')) {
        // Redirigir al usuario a la página de login
        redirect('login');
    }
  }

  public function index()
  {
    
  }

  public function vista(){
    $data['title'] = ucfirst("Grupos"); //Capitalizar la primera letra
    
    $data['mesas'] = $this->Grupo_model->obtenerMesas();

    foreach ($data['mesas'] as &$mesa){
      $mesa->grupos = $this->Grupo_model->obtenerGrupos($mesa->id_mesas);
      foreach ($mesa->grupos as &$grupo) {
          $grupo->equipos = $this->Grupo_model->getEquipos($grupo->id_grupos);
      }
  }


    $this->load->view('templates/header', $data);
    $this->load->view('panel/grupos/vista_grupos', $data);
    $this->load->view('templates/footer', $data);
}

  public function vista_asignar($tipo_equipo, $id_mesa, $id_grupo){

    $data['title'] = ucfirst("Grupos"); //Capitalizar la primera letra
    
    $id_tipo = $this->obtenerIdTipoEquipo($tipo_equipo);
    $equipos_asignados  = $this->Grupo_model->obtenerEquipoAsignado($id_grupo, $id_tipo);
    $data['equipos_tipo'] = $this->Grupo_model->obtenerEquiporPorTipo($id_tipo);
    
    $data['id_mesa'] = $id_mesa;
    $data['id_grupo'] = $id_grupo;
    $data['tipo_equipo'] = $tipo_equipo;
    $data['equipos_asignados'] = $equipos_asignados;


    $this->load->view('templates/header', $data);
    $this->load->view('panel/grupos/vista_asignar', $data);
    $this->load->view('templates/footer', $data);
  }

  public function asignar(){
    $this->form_validation->set_rules('equipo[]', 'Equipo','required');
    $this->form_validation->set_rules('mesa', 'Mesa','required');
    $this->form_validation->set_rules('grupo', 'Grupo','required');
    
    if ($this->form_validation->run() == FALSE) {
      // Si la validación falla, recargar la vista con errores
      $this->load->view('panel/grupos/vista');
  }else {
      $id_tipo = $this->obtenerIdTipoEquipo($this->input->post('tipo'));
      $equipos = $this->input->post('equipo'); //array
      $id_grupo = $this->input->post('grupo');
      
      // Verificar que se hayan seleccionado hasta 3 equipos si el tipo es "cable"
      if ($id_tipo == 16 && count($equipos) > 3) {
        // Manejar el error, por ejemplo, redirigir con un mensaje de error
        $this->session->set_flashdata('error', 'No puedes asignar más de 3 cables.');
        redirect('grupos/vista_asignar/' . $this->input->post('tipo') . '/' . $this->input->post('mesa') . '/' . $id_grupo);
    }

    // Verificar que solo se haya seleccionado un equipo si el tipo no es "cable"
    if ($id_tipo != 16 && count($equipos) > 1) {
      // Manejar el error, por ejemplo, redirigir con un mensaje de error
      $this->session->set_flashdata('error', 'Solo puedes asignar un equipo.');
      redirect('grupos/vista_asignar/' . $this->input->post('tipo') . '/' . $this->input->post('mesa') . '/' . $id_grupo);
  }

      $data_asignar = array(
        'id_grupos' => $id_grupo
      );

      if($this->Grupo_model->eliminarEquipoGrupo($id_tipo, $id_grupo)){
        foreach ($equipos as $id_equipo) {
          $this->Grupo_model->asignarGrupo($id_equipo, $data_asignar);
      }
      redirect('/grupos/vista');
      }
      else{
        $this->load->view('/grupos/vista', array('error' => 'Error al asignar el equipo'));
      }
  }
  }

  public function detalles($tipo_equipo, $id_grupo){
    if($tipo_equipo == "CABLE"){ // si es cable cargamos otra vista
      $data['title'] = ucfirst("Detalles"); //Capitalizar la primera letra
        $cables = $this->Grupo_model->obtenerEquipoAsignado($id_grupo, 16);
        foreach($cables as $key => $cable){
          $data['cables'][$key] = $cable;
          $data['cables'][$key] -> id_equipos = $this->idencrypt->encrypt($cable->id_equipos);
        }

      $this->load->view('templates/header', $data);
      $this->load->view('panel/grupos/vista_cables', $data);
      $this->load->view('templates/footer', $data);
    }else{
      
      $id_tipo = $this->obtenerIdTipoEquipo($tipo_equipo);
      $equipo = $this->Grupo_model->obtenerIdAsignado($id_grupo, $id_tipo);
      if($equipo == null){
        $data['title'] = ucfirst("Error"); //Capitalizar la primera letra
        
        $this->load->view('templates/header', $data);
        $this->load->view('panel/detalles404');
        $this->load->view('templates/footer', $data);
      }else{
        $id_enc =$this->idencrypt->encrypt($equipo->id_equipos);
        redirect('panel/detalles/'.$id_enc);
      }
      
    }
  }
  public function mantenimiento($tipo_equipo, $id_grupo){
    $id_tipo = $this->obtenerIdTipoEquipo($tipo_equipo);
    $equipo = $this->Grupo_model->obtenerIdAsignado($id_grupo, $id_tipo);
    if($equipo == null){
      $data['title'] = ucfirst("Error"); //Capitalizar la primera letra

      $this->load->view('templates/header', $data);
      $this->load->view('panel/detalles404');
      $this->load->view('templates/footer', $data);
    }else{
    $id_enc =$this->idencrypt->encrypt($equipo->id_equipos);
    redirect('panel/orden_mantenimiento/'.$id_enc);
    }
  }
  public function todos_mantenimiento($tipo_equipo, $id_grupo){
    $id_tipo = $this->obtenerIdTipoEquipo($tipo_equipo);
    $equipo = $this->Grupo_model->obtenerIdAsignado($id_grupo, $id_tipo);
    if($equipo == null){
      $data['title'] = ucfirst("Error"); //Capitalizar la primera letra

      $this->load->view('templates/header', $data);
      $this->load->view('panel/detalles404');
      $this->load->view('templates/footer', $data);
    }else{
    $id_enc =$this->idencrypt->encrypt($equipo->id_equipos);
    redirect('orden/ver_ordenesEquipo/'.$id_enc);
    }
  }

  protected function obtenerIdTipoEquipo($tipo_equipo){
    switch($tipo_equipo){
      case 'CPU':
        $id_tipo = 2;
      break;
      case 'MONITOR':
        $id_tipo = 1;
      break;
      case 'TECLADO':
        $id_tipo = 4;
      break;
      case 'MOUSE':
        $id_tipo = 3;
      break;
      case 'CABLE':
        $id_tipo = 16;
      break;
      default:
        $id_tipo = 0;
    }
    return $id_tipo;
  }
}


/* End of file Grupos.php */
/* Location: ./application/controllers/Grupos.php */