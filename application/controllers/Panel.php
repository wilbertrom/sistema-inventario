<?php

class Panel extends CI_Controller{

  public function __construct() {
    parent::__construct();
    $this->load->library('session');
    $this->load->model('Inventario_model');
    $this->load->model('Orden_model');
    $this->load->model('Requisiciones_model');
    $this->load->library('idEncrypt');
    $this->load->library('pagination');


    
    // Verificar si el usuario está logueado
    if (!$this->session->userdata('logged_in')) {
        // Redirigir al usuario a la página de login
        redirect('login');
    }
}


  public function view($page = 'dashboard'){
    
    if(! file_exists(APPPATH.'views/panel/'.$page.'.php')){
      // no se tiene una pagina para esa ruta
      show_404();
    }

    $data['title'] = ucfirst($page); //Capitalizar la primera letra
    $data['numero_equipos'] = $this->Inventario_model->obtenerNumeroEquipos();
    $data['numero_mantenimientos'] = $this->Orden_model->obtenerNumeroMantenimientos();
    $data['numero_req'] = $this->Orden_model->obtenerNumeroReq();
    
    $tipos = $this->Inventario_model->obtener_tipos();
    foreach ($tipos as $key => $tipo) {
      $data['tipos'][$key] = $tipo;
      $data['tipos'][$key]->id_tipos = $this->idencrypt->encrypt($tipo->id_tipos);
    }
    
    // Obtener tipos y estados si la página es registrar
    if ($page === 'registrar' || $page ==='editar') {
      $tipos = $this->Inventario_model->obtener_tipos();
      $estados = $this->Inventario_model->obtener_estados();
      $marcas = $this->Inventario_model->obtener_marcas();
      
      // Cifrar los IDs de las marcas antes de pasarlos a la vista
      foreach ($marcas as $key => $marca) {
        $data['marcas'][$key] = $marca;
        $data['marcas'][$key]->id_marcas = $this->idencrypt->encrypt($marca->id_marcas);
      }


      foreach ($estados as $key => $estado) {
        $data['estados'][$key] = $estado;
        $data['estados'][$key]->id_estados = $this->idencrypt->encrypt($estado->id_estados);
      }

      foreach ($tipos as $key => $tipo) {
        $data['tipos'][$key] = $tipo;
        $data['tipos'][$key]->id_tipos = $this->idencrypt->encrypt($tipo->id_tipos);
      }
    }

    

    $this->load->view('templates/header', $data);
    $this->load->view('panel/'.$page, $data);
    $this->load->view('templates/footer', $data);
  }

  // Obtener equipos si la página es ver_inventario
  public function ver_inventario($page = 0){
    $data['title']= "Ver Inventario";


    $tipos = $this->Inventario_model->obtener_tipos();
    foreach ($tipos as $key => $tipo) {
      $data['tipos'][$key] = $tipo;
      $data['tipos'][$key]->id_tipos = $this->idencrypt->encrypt($tipo->id_tipos);
    }
    // Configuración de la paginación
    $config = array();
    $config['base_url'] = base_url('panel/ver_inventario');
    $config['total_rows'] = $this->Inventario_model->obtenerNumeroEquipos();
    $config['per_page'] = 10;
    $config['uri_segment'] = 3;

    // Configuración de los enlaces de paginación con el estilo deseado
    $config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination justify-content-end">';
    $config['full_tag_close'] = '</ul></nav>';
    $config['first_link'] = 'Primero';
    $config['last_link'] = 'Último';
    $config['first_tag_open'] = '<li class="page-item">';
    $config['first_tag_close'] = '</li>';
    $config['prev_link'] = 'Previous';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = 'Next';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li class="page-item">';
    $config['last_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['attributes'] = array('class' => 'page-link');
    $this->pagination->initialize($config);

    
    $equipos = $this->Inventario_model->obtener_equipos_paginados($config['per_page'], $page);
    foreach ($equipos as $key => $equipo) {
      $data['equipos'][$key] = $equipo;
      $data['equipos'][$key]->id_equipos = $this->idencrypt->encrypt(($equipo->id_equipos));
    }

    $this->load->view('templates/header', $data);
    $this->load->view('panel/ver_inventario', $data);
    $this->load->view('templates/footer', $data);
  }
  public function filtrar_inventario($page = 0) {
    $tipo_s = $this->input->post('tipo');
    $data['tipo_seleccionado'] = $tipo_s;
    $tipo_s = $this->idencrypt->decrypt($tipo_s);
    
    
    if($tipo_s == null){
      redirect('panel/ver_inventario');
    }
    $tipos = $this->Inventario_model->obtener_tipos();
    foreach ($tipos as $key => $tipo) {
      $data['tipos'][$key] = $tipo;
      $data['tipos'][$key]->id_tipos = $this->idencrypt->encrypt($tipo->id_tipos);
    }
    
    $data['title'] = 'Inventario Filtrado';
    
    if ($tipo_s) {
        $equipos = $this->Inventario_model->obtener_equipos_por_tipo($tipo_s);
    } else {
      $equipos = $this->Inventario_model->obtener_equipos();
    }
    foreach ($equipos as $key => $equipo) {
      $data['equipos'][$key] = $equipo;
      $data['equipos'][$key]->id_equipos = $this->idencrypt->encrypt(($equipo->id_equipos));
    }

    $this->load->view('templates/header', $data);
    $this->load->view('panel/ver_inventario', $data);
    $this->load->view('templates/footer', $data);
}

public function buscar_inventario(){
  $Codigo_interno = $this->input->post("cInterno");

  if($Codigo_interno == null){
    redirect('panel/ver_inventario');
  }
  
  $tipos = $this->Inventario_model->obtener_tipos();
    foreach ($tipos as $key => $tipo) {
      $data['tipos'][$key] = $tipo;
      $data['tipos'][$key]->id_tipos = $this->idencrypt->encrypt($tipo->id_tipos);
    }

  $data['title'] = 'Busqueda: '. $Codigo_interno;

  $equipos = $this->Inventario_model->obtener_equipos_por_codigo($Codigo_interno);

  foreach ($equipos as $key => $equipo) {
    $data['equipos'][$key] = $equipo;
    $data['equipos'][$key]->id_equipos = $this->idencrypt->encrypt(($equipo->id_equipos));
  }

  $data['codigo_buscado'] = $Codigo_interno;

  $this->load->view('templates/header', $data);
  $this->load->view('panel/ver_inventario', $data);
  $this->load->view('templates/footer', $data);
}

  public function detalles($id){
    $data['title'] = ucfirst("Detalles");
    $data['id_enc'] = $id;
    $id = $this->idencrypt->decrypt($id);
    $data['equipo'] = $this->Inventario_model->obtener_equipo_computo($id);
    

    $this->load->view('templates/header', $data);
    $this->load->view('panel/detalles', $data);
    $this->load->view('templates/footer', $data);
  }

  public function editar($id){
    $data['title'] = ucfirst("Editar");
    $data['tipos'] = $this->Inventario_model->obtener_tipos();
    $data['estados'] = $this->Inventario_model->obtener_estados();
    $data['marcas'] = $this->Inventario_model->obtener_marcas();
      
    $data['equipo'] = $this->Inventario_model->obtener_equipo_computo($this->idencrypt->decrypt($id));
    $data['equipo']->id_equipos= $id;

    $this->load->view('templates/header', $data);
    $this->load->view('panel/editar', $data);
    $this->load->view('templates/footer', $data);
  }

  public function orden_mantenimiento($id){

    $data['estados'] = $this->Inventario_model->obtener_estados();
    
    $data['equipo'] = $this->Inventario_model->obtener_info_equipo($this->idencrypt->decrypt($id));
    $data['equipo']->id_equipos= $id;
    $data['title'] = ucfirst("Mantenimiento");

    $this->load->view('templates/header', $data);
    $this->load->view('panel/orden/mantenimiento', $data);
    $this->load->view('templates/footer', $data );
  }

}