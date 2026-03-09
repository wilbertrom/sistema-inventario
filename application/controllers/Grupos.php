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
        redirect('login');
    }
  }

  public function index()
  {
    return;
  }

  public function vista(){
    $data['title'] = ucfirst("Grupos");
    
    $data['mesas'] = $this->Grupo_model->obtenerMesas();

    if (is_array($data['mesas']) || is_object($data['mesas'])) {
      foreach ($data['mesas'] as &$mesa){
        $mesa->grupos = $this->Grupo_model->obtenerGrupos($mesa->id_mesas);
        
        if (is_array($mesa->grupos) || is_object($mesa->grupos)) {
          foreach ($mesa->grupos as &$grupo) {
            $grupo->equipos = $this->Grupo_model->getEquipos($grupo->id_grupos);
          }
        }
      }
    }

    $this->load->view('templates/header', $data);
    $this->load->view('panel/grupos/vista_grupos', $data);
    $this->load->view('templates/footer', $data);
  }

  public function vista_asignar($tipo_equipo, $id_mesa, $id_grupo){

    $data['title'] = ucfirst("Grupos");
    
    $id_tipo = $this->obtenerIdTipoEquipo($tipo_equipo);
    $equipos_asignados  = $this->Grupo_model->obtenerEquipoAsignado($id_grupo, $id_tipo);
    $data['equipos_tipo'] = $this->Grupo_model->obtenerEquiposPorTipo($id_tipo);
    
    $data['id_mesa'] = $id_mesa;
    $data['id_grupo'] = $id_grupo;
    $data['tipo_equipo'] = $tipo_equipo;
    $data['equipos_asignados'] = $equipos_asignados;

    $this->load->view('templates/header', $data);
    $this->load->view('panel/grupos/vista_asignar', $data);
    $this->load->view('templates/footer', $data);
  }

  public function asignar(){
    $this->form_validation->set_rules('equipo[]', 'Equipo', 'required');
    $this->form_validation->set_rules('mesa', 'Mesa', 'required');
    $this->form_validation->set_rules('grupo', 'Grupo', 'required');
    
    if ($this->form_validation->run() == FALSE) {
      $this->vista();
    } else {
      $id_tipo = $this->obtenerIdTipoEquipo($this->input->post('tipo'));
      $equipos = $this->input->post('equipo');
      $id_grupo = $this->input->post('grupo');
      
      if (!is_array($equipos)) {
        $equipos = array($equipos);
      }
      
      if ($id_tipo == 16 && count($equipos) > 3) {
        $this->session->set_flashdata('error', 'No puedes asignar más de 3 cables.');
        redirect('grupos/vista_asignar/' . $this->input->post('tipo') . '/' . $this->input->post('mesa') . '/' . $id_grupo);
      }

      if ($id_tipo != 16 && count($equipos) > 1) {
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
      } else {
        $data['error'] = 'Error al asignar el equipo';
        $this->vista();
      }
    }
  }

  public function detalles($tipo_equipo, $id_grupo){
    if($tipo_equipo == "CABLE"){
      $data['title'] = ucfirst("Detalles");
      $cables = $this->Grupo_model->obtenerEquipoAsignado($id_grupo, 16);
      
      $data['cables'] = array();
      
      if (is_array($cables) || is_object($cables)) {
        foreach($cables as $key => $cable){
          $data['cables'][$key] = $cable;
          if (isset($cable->id_equipos)) {
            $data['cables'][$key]->id_equipos = $this->idencrypt->encrypt($cable->id_equipos);
          }
        }
      }

      $this->load->view('templates/header', $data);
      $this->load->view('panel/grupos/vista_cables', $data);
      $this->load->view('templates/footer', $data);
    } else {
      $id_tipo = $this->obtenerIdTipoEquipo($tipo_equipo);
      $equipo = $this->Grupo_model->obtenerIdAsignado($id_grupo, $id_tipo);
      
      if($equipo == null){
        $data['title'] = ucfirst("Error");
        
        $this->load->view('templates/header', $data);
        $this->load->view('panel/detalles404');
        $this->load->view('templates/footer', $data);
      } else {
        if (isset($equipo->id_equipos)) {
          $id_enc = $this->idencrypt->encrypt($equipo->id_equipos);
          redirect('panel/detalles/'.$id_enc);
        } else {
          $data['title'] = ucfirst("Error");
          $this->load->view('templates/header', $data);
          $this->load->view('panel/detalles404');
          $this->load->view('templates/footer', $data);
        }
      }
    }
  }
  
  public function mantenimiento($tipo_equipo, $id_grupo){
    $id_tipo = $this->obtenerIdTipoEquipo($tipo_equipo);
    $equipo = $this->Grupo_model->obtenerIdAsignado($id_grupo, $id_tipo);
    
    if($equipo == null){
      $data['title'] = ucfirst("Error");

      $this->load->view('templates/header', $data);
      $this->load->view('panel/detalles404');
      $this->load->view('templates/footer', $data);
    } else {
      if (isset($equipo->id_equipos)) {
        $id_enc = $this->idencrypt->encrypt($equipo->id_equipos);
        redirect('panel/orden_mantenimiento/'.$id_enc);
      } else {
        $data['title'] = ucfirst("Error");
        $this->load->view('templates/header', $data);
        $this->load->view('panel/detalles404');
        $this->load->view('templates/footer', $data);
      }
    }
  }
  
  public function todos_mantenimiento($tipo_equipo, $id_grupo){
    $id_tipo = $this->obtenerIdTipoEquipo($tipo_equipo);
    $equipo = $this->Grupo_model->obtenerIdAsignado($id_grupo, $id_tipo);
    
    if($equipo == null){
      $data['title'] = ucfirst("Error");

      $this->load->view('templates/header', $data);
      $this->load->view('panel/detalles404');
      $this->load->view('templates/footer', $data);
    } else {
      if (isset($equipo->id_equipos)) {
        $id_enc = $this->idencrypt->encrypt($equipo->id_equipos);
        redirect('orden/ver_ordenesEquipo/'.$id_enc);
      } else {
        $data['title'] = ucfirst("Error");
        $this->load->view('templates/header', $data);
        $this->load->view('panel/detalles404');
        $this->load->view('templates/footer', $data);
      }
    }
  }

  protected function obtenerIdTipoEquipo($tipo_equipo){
    $id_tipo = 0;
    
    if (is_string($tipo_equipo) || is_numeric($tipo_equipo)) {
      switch(strval($tipo_equipo)){
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
    }
    return $id_tipo;
  }
}

/* End of file Grupos.php */
/* Location: ./application/controllers/Grupos.php */