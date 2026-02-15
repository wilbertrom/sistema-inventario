<?php

class Portal extends MY_Controller {

    public function __construct() 
    {
        parent::__construct();
        // No se requiere autenticación para el portal público
        // Cargar helpers o librerías necesarias si las hay
    }

    public function view($page = 'Informacion') 
    {
        // Sanitizar el nombre de la página para prevenir directory traversal
        $page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page);
        
        // Si después de sanitizar queda vacío, usar página por defecto
        if (empty($page)) {
            $page = 'Informacion';
        }
        
        // Construir la ruta completa al archivo de vista
        $view_path = APPPATH . 'views/portal/' . $page . '.php';
        
        // Verificar si el archivo existe
        if (!file_exists($view_path)) {
            // No se tiene una página para esa ruta
            show_404();
            return;
        }

        // Capitalizar la primera letra para el título
        $data['title'] = ucfirst($page);
        
        // Inicializar otros datos que puedan ser necesarios
        $data['page'] = $page;

        // Cargar las vistas
        $this->load->view('templates/headerPortal', $data);
        $this->load->view('portal/' . $page, $data);
        $this->load->view('templates/footerPortal', $data);
    }

    /**
     * Método por defecto para la página de inicio del portal
     */
    public function index() 
    {
        // Redirigir a la vista de información por defecto
        $this->view('Informacion');
    }
}