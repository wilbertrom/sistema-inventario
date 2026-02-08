<?php

class Portal extends CI_Controller{

  public function view($page = 'Informacion'){
    
    if(! file_exists(APPPATH.'views/portal/'.$page.'.php')){
      // no se tiene una pagina para esa ruta
      show_404();
    }

    $data['title'] = ucfirst($page); //Capitalizar la primera letra

    $this->load->view('templates/headerPortal', $data);
    $this->load->view('portal/'.$page, $data);
    $this->load->view('templates/footerPortal', $data);
  }
}