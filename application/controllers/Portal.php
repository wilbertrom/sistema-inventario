<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function view($page = 'Informacion') {
        $page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page);
        
        if (empty($page)) {
            $page = 'Informacion';
        }
        
        $view_path = APPPATH . 'views/portal/' . $page . '.php';
        
        if (!file_exists($view_path)) {
            show_404();
            return;
        }
        
        $data['title'] = ucfirst($page);
        $data['page'] = $page;
        
        $this->load->view('templates/headerPortal', $data);
        $this->load->view('portal/' . $page, $data);
        $this->load->view('templates/footerPortal', $data);
    }
    
    public function index() {
        $this->view('Informacion');
    }
}