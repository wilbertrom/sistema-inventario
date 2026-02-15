<?php

class Panel extends MY_Controller {
    
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

    public function index() {
        // Cargar el modelo de inventario
        $this->load->model('Inventario_model');
        
        // Obtener el número de equipos
        $data['numero_equipos'] = $this->Inventario_model->contar_equipos();
        
        // Pasar otros datos necesarios
        $data['title'] = 'Dashboard - Sistema de Inventario';
        
        // Cargar la vista con todos los datos
        $this->load->view('templates/header', $data);
        $this->load->view('panel/dashboard', $data); // o tu vista principal
        $this->load->view('templates/footer');
    }

    public function view($page = 'dashboard') {
        if (!file_exists(APPPATH . 'views/panel/' . $page . '.php')) {
            // no se tiene una pagina para esa ruta
            show_404();
        }

        $data['title'] = ucfirst($page); //Capitalizar la primera letra
        $data['numero_equipos'] = $this->Inventario_model->obtenerNumeroEquipos();
        $data['numero_mantenimientos'] = $this->Orden_model->obtenerNumeroMantenimientos();
        $data['numero_req'] = $this->Orden_model->obtenerNumeroReq();

        // Inicializar arrays para evitar errores si no hay datos
        $data['tipos'] = array();
        $data['marcas'] = array();
        $data['estados'] = array();

        $tipos = $this->Inventario_model->obtener_tipos();
        if (!empty($tipos) && (is_array($tipos) || is_object($tipos))) {
            foreach ($tipos as $key => $tipo) {
                if (is_object($tipo) && isset($tipo->id_tipos)) {
                    $data['tipos'][$key] = $tipo;
                    $data['tipos'][$key]->id_tipos = $this->idencrypt->encrypt($tipo->id_tipos);
                }
            }
        }

        // Obtener tipos y estados si la página es registrar o editar
        if ($page === 'registrar' || $page === 'editar') {
            $tipos = $this->Inventario_model->obtener_tipos();
            $estados = $this->Inventario_model->obtener_estados();
            $marcas = $this->Inventario_model->obtener_marcas();

            // Cifrar los IDs de las marcas antes de pasarlos a la vista
            if (!empty($marcas) && (is_array($marcas) || is_object($marcas))) {
                foreach ($marcas as $key => $marca) {
                    if (is_object($marca) && isset($marca->id_marcas)) {
                        $data['marcas'][$key] = $marca;
                        $data['marcas'][$key]->id_marcas = $this->idencrypt->encrypt($marca->id_marcas);
                    }
                }
            }

            if (!empty($estados) && (is_array($estados) || is_object($estados))) {
                foreach ($estados as $key => $estado) {
                    if (is_object($estado) && isset($estado->id_estados)) {
                        $data['estados'][$key] = $estado;
                        $data['estados'][$key]->id_estados = $this->idencrypt->encrypt($estado->id_estados);
                    }
                }
            }

            if (!empty($tipos) && (is_array($tipos) || is_object($tipos))) {
                foreach ($tipos as $key => $tipo) {
                    if (is_object($tipo) && isset($tipo->id_tipos)) {
                        $data['tipos'][$key] = $tipo;
                        $data['tipos'][$key]->id_tipos = $this->idencrypt->encrypt($tipo->id_tipos);
                    }
                }
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('panel/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    // Obtener equipos si la página es ver_inventario
    public function ver_inventario($page = 0) {
        $data['title'] = "Ver Inventario";

        // Inicializar arrays
        $data['tipos'] = array();
        $data['equipos'] = array();

        $tipos = $this->Inventario_model->obtener_tipos();
        if (!empty($tipos) && (is_array($tipos) || is_object($tipos))) {
            foreach ($tipos as $key => $tipo) {
                if (is_object($tipo) && isset($tipo->id_tipos)) {
                    $data['tipos'][$key] = $tipo;
                    $data['tipos'][$key]->id_tipos = $this->idencrypt->encrypt($tipo->id_tipos);
                }
            }
        }

        // Configuración de la paginación
        $total_rows = $this->Inventario_model->obtenerNumeroEquipos();
        $total_rows = is_numeric($total_rows) ? (int)$total_rows : 0;

        $config = array();
        $config['base_url'] = base_url('panel/ver_inventario');
        $config['total_rows'] = $total_rows;
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

        $equipos = $this->Inventario_model->obtener_equipos_paginados($config['per_page'], (int)$page);
        
        if (!empty($equipos) && (is_array($equipos) || is_object($equipos))) {
            foreach ($equipos as $key => $equipo) {
                if (is_object($equipo) && isset($equipo->id_equipos)) {
                    $data['equipos'][$key] = $equipo;
                    $data['equipos'][$key]->id_equipos = $this->idencrypt->encrypt($equipo->id_equipos);
                }
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('panel/ver_inventario', $data);
        $this->load->view('templates/footer', $data);
    }

    public function filtrar_inventario($page = 0) {
        $tipo_s = $this->input->post('tipo');
        $data['tipo_seleccionado'] = $tipo_s;
        
        if (empty($tipo_s)) {
            redirect('panel/ver_inventario');
            return;
        }
        
        $tipo_s_decrypted = $this->idencrypt->decrypt($tipo_s);

        if (empty($tipo_s_decrypted)) {
            redirect('panel/ver_inventario');
            return;
        }

        // Inicializar arrays
        $data['tipos'] = array();
        $data['equipos'] = array();

        $tipos = $this->Inventario_model->obtener_tipos();
        if (!empty($tipos) && (is_array($tipos) || is_object($tipos))) {
            foreach ($tipos as $key => $tipo) {
                if (is_object($tipo) && isset($tipo->id_tipos)) {
                    $data['tipos'][$key] = $tipo;
                    $data['tipos'][$key]->id_tipos = $this->idencrypt->encrypt($tipo->id_tipos);
                }
            }
        }

        $data['title'] = 'Inventario Filtrado';

        if ($tipo_s_decrypted) {
            $equipos = $this->Inventario_model->obtener_equipos_por_tipo($tipo_s_decrypted);
        } else {
            $equipos = $this->Inventario_model->obtener_equipos();
        }

        if (!empty($equipos) && (is_array($equipos) || is_object($equipos))) {
            foreach ($equipos as $key => $equipo) {
                if (is_object($equipo) && isset($equipo->id_equipos)) {
                    $data['equipos'][$key] = $equipo;
                    $data['equipos'][$key]->id_equipos = $this->idencrypt->encrypt($equipo->id_equipos);
                }
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('panel/ver_inventario', $data);
        $this->load->view('templates/footer', $data);
    }

    public function buscar_inventario() {
        $Codigo_interno = $this->input->post("cInterno");

        if (empty($Codigo_interno)) {
            redirect('panel/ver_inventario');
            return;
        }

        // Inicializar arrays
        $data['tipos'] = array();
        $data['equipos'] = array();

        $tipos = $this->Inventario_model->obtener_tipos();
        if (!empty($tipos) && (is_array($tipos) || is_object($tipos))) {
            foreach ($tipos as $key => $tipo) {
                if (is_object($tipo) && isset($tipo->id_tipos)) {
                    $data['tipos'][$key] = $tipo;
                    $data['tipos'][$key]->id_tipos = $this->idencrypt->encrypt($tipo->id_tipos);
                }
            }
        }

        $data['title'] = 'Busqueda: ' . $Codigo_interno;

        $equipos = $this->Inventario_model->obtener_equipos_por_codigo($Codigo_interno);

        if (!empty($equipos) && (is_array($equipos) || is_object($equipos))) {
            foreach ($equipos as $key => $equipo) {
                if (is_object($equipo) && isset($equipo->id_equipos)) {
                    $data['equipos'][$key] = $equipo;
                    $data['equipos'][$key]->id_equipos = $this->idencrypt->encrypt($equipo->id_equipos);
                }
            }
        }

        $data['codigo_buscado'] = $Codigo_interno;

        $this->load->view('templates/header', $data);
        $this->load->view('panel/ver_inventario', $data);
        $this->load->view('templates/footer', $data);
    }

    public function detalles($id) {
        $data['title'] = ucfirst("Detalles");
        $data['id_enc'] = $id;
        
        $id_decrypted = $this->idencrypt->decrypt($id);
        
        if (empty($id_decrypted)) {
            show_404();
            return;
        }
        
        $data['equipo'] = $this->Inventario_model->obtener_equipo_computo($id_decrypted);
        
        if (empty($data['equipo'])) {
            $data['equipo'] = null; // Para manejar en la vista
        }

        $this->load->view('templates/header', $data);
        $this->load->view('panel/detalles', $data);
        $this->load->view('templates/footer', $data);
    }

    public function editar($id) {
        if (empty($id)) {
            redirect('panel/ver_inventario');
            return;
        }

        $data['title'] = ucfirst("Editar");
        
        // Inicializar arrays
        $data['tipos'] = array();
        $data['estados'] = array();
        $data['marcas'] = array();

        $tipos = $this->Inventario_model->obtener_tipos();
        $estados = $this->Inventario_model->obtener_estados();
        $marcas = $this->Inventario_model->obtener_marcas();

        if (!empty($tipos) && (is_array($tipos) || is_object($tipos))) {
            $data['tipos'] = $tipos;
        }

        if (!empty($estados) && (is_array($estados) || is_object($estados))) {
            $data['estados'] = $estados;
        }

        if (!empty($marcas) && (is_array($marcas) || is_object($marcas))) {
            $data['marcas'] = $marcas;
        }

        $id_decrypted = $this->idencrypt->decrypt($id);
        
        if (empty($id_decrypted)) {
            redirect('panel/ver_inventario');
            return;
        }

        $data['equipo'] = $this->Inventario_model->obtener_equipo_computo($id_decrypted);
        
        if (!empty($data['equipo']) && is_object($data['equipo'])) {
            $data['equipo']->id_equipos = $id;
        } else {
            $data['equipo'] = null;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('panel/editar', $data);
        $this->load->view('templates/footer', $data);
    }

    public function orden_mantenimiento($id) {
        if (empty($id)) {
            redirect('panel/ver_inventario');
            return;
        }

        $data['estados'] = $this->Inventario_model->obtener_estados();

        $id_decrypted = $this->idencrypt->decrypt($id);
        
        if (empty($id_decrypted)) {
            redirect('panel/ver_inventario');
            return;
        }

        $data['equipo'] = $this->Inventario_model->obtener_info_equipo($id_decrypted);
        
        if (!empty($data['equipo']) && is_object($data['equipo'])) {
            $data['equipo']->id_equipos = $id;
        } else {
            $data['equipo'] = null;
        }
        
        $data['title'] = ucfirst("Mantenimiento");

        $this->load->view('templates/header', $data);
        $this->load->view('panel/orden/mantenimiento', $data);
        $this->load->view('templates/footer', $data);
    }
}