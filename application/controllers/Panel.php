<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends MY_Controller
{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Inventario_model');
        $this->load->model('Orden_model');
        $this->load->model('Requisiciones_model');
        $this->load->library('idEncrypt');
        $this->load->library('pagination');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $laboratorio_id = $this->session->userdata('laboratorio_id');
        $username = $this->session->userdata('username');
        
        $data['title'] = 'Dashboard - Sistema de Inventario';
        $data['numero_equipos'] = $this->Inventario_model->contar_equipos_por_laboratorio($laboratorio_id);
        $data['numero_mantenimientos'] = $this->Orden_model->contar_mantenimientos_por_laboratorio($laboratorio_id);
        $data['numero_requisiciones'] = $this->Requisiciones_model->contar_requisiciones_por_laboratorio($laboratorio_id);
        
        $this->load->model('Laboratorio_model');
        $lab = $this->Laboratorio_model->get_by_id($laboratorio_id);
        $data['laboratorio_nombre'] = $lab ? $lab->nombre : ($laboratorio_id == 1 ? 'Open Source' : 'Mac');
        $data['username'] = $username;
        
        $this->load->view('templates/header', $data);
        $this->load->view('panel/dashboard', $data);
        $this->load->view('templates/footer', $data);
    }

    public function view($page = 'dashboard') {
        if (!file_exists(APPPATH . 'views/panel/' . $page . '.php')) {
            show_404();
        }

        $laboratorio_id = $this->session->userdata('laboratorio_id');
        $data['title'] = ucfirst($page);
        
        $data['numero_equipos'] = $this->Inventario_model->contar_equipos_por_laboratorio($laboratorio_id);
        $data['numero_mantenimientos'] = $this->Orden_model->contar_mantenimientos_por_laboratorio($laboratorio_id);
        $data['numero_requisiciones'] = $this->Requisiciones_model->contar_requisiciones_por_laboratorio($laboratorio_id);

        $tipos = $this->Inventario_model->obtener_tipos();
        $data['tipos'] = array();
        if (!empty($tipos)) {
            foreach ($tipos as $key => $tipo) {
                $data['tipos'][$key] = $tipo;
                $data['tipos'][$key]->id_tipos = $this->idencrypt->encrypt($tipo->id_tipos);
            }
        }

        if ($page === 'registrar' || $page === 'editar') {
            $data['marcas'] = $this->Inventario_model->obtener_marcas();
            $data['estados'] = $this->Inventario_model->obtener_estados();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('panel/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function ver_inventario($page = 0) {
        $laboratorio_id = $this->session->userdata('laboratorio_id');
        $data['title'] = "Ver Inventario";

        $tipos = $this->Inventario_model->obtener_tipos();
        $data['tipos'] = array();
        foreach ($tipos as $key => $tipo) {
            $data['tipos'][$key] = $tipo;
            $data['tipos'][$key]->id_tipos = $this->idencrypt->encrypt($tipo->id_tipos);
        }

        $total_rows = $this->Inventario_model->contar_equipos_por_laboratorio($laboratorio_id);
        
        $config['base_url']    = base_url('panel/ver_inventario');
        $config['total_rows']  = $total_rows;
        $config['per_page']    = 10;
        $config['uri_segment'] = 3;
        
        $config['full_tag_open']  = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link']     = 'Primero';
        $config['last_link']      = 'Último';
        $config['first_tag_open']  = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link']      = '&laquo;';
        $config['prev_tag_open']   = '<li class="page-item">';
        $config['prev_tag_close']  = '</li>';
        $config['next_link']      = '&raquo;';
        $config['next_tag_open']   = '<li class="page-item">';
        $config['next_tag_close']  = '</li>';
        $config['last_tag_open']   = '<li class="page-item">';
        $config['last_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li class="page-item">';
        $config['num_tag_close']   = '</li>';
        $config['attributes']      = array('class' => 'page-link');
        
        $this->pagination->initialize($config);

        if (method_exists($this->Inventario_model, 'obtener_equipos_por_laboratorio_paginados')) {
            $equipos = $this->Inventario_model->obtener_equipos_por_laboratorio_paginados($laboratorio_id, $config['per_page'], $page);
        } else {
            $equipos = $this->Inventario_model->obtener_equipos_paginados($config['per_page'], $page);
        }
        
        $data['equipos'] = array();
        foreach ($equipos as $key => $equipo) {
            $data['equipos'][$key] = $equipo;
            $data['equipos'][$key]->id_equipos = $this->idencrypt->encrypt($equipo->id_equipos);
        }

        $data['tipo_seleccionado'] = null;

        $this->load->view('templates/header', $data);
        $this->load->view('panel/ver_inventario', $data);
        $this->load->view('templates/footer', $data);
    }

    public function filtrar_inventario() {
        $laboratorio_id = $this->session->userdata('laboratorio_id');
        $tipo_id_enc = $this->input->post('tipo');
        $tipo_id = !empty($tipo_id_enc) ? (int)$this->idencrypt->decrypt($tipo_id_enc) : 0;

        $data['title'] = "Inventario Filtrado";
        $data['tipo_seleccionado'] = $tipo_id_enc;

        $tipos = $this->Inventario_model->obtener_tipos();
        $data['tipos'] = array();
        foreach ($tipos as $key => $tipo) {
            $data['tipos'][$key] = $tipo;
            $data['tipos'][$key]->id_tipos = $this->idencrypt->encrypt($tipo->id_tipos);
        }

        if (!empty($tipo_id)) {
            $equipos = $this->Inventario_model->obtener_equipos_por_tipo_paginados($tipo_id, 100, 0);
        } else {
            $equipos = $this->Inventario_model->obtener_equipos_por_laboratorio_paginados($laboratorio_id, 100, 0);
        }

        $data['equipos'] = array();
        foreach ($equipos as $key => $equipo) {
            $data['equipos'][$key] = $equipo;
            $data['equipos'][$key]->id_equipos = $this->idencrypt->encrypt($equipo->id_equipos);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('panel/ver_inventario', $data);
        $this->load->view('templates/footer', $data);
    }

    public function debug_session() {
        echo "<h3>DEPURACION DEL SISTEMA</h3><hr>";
        echo "Usuario: <strong>" . $this->session->userdata('username') . "</strong><br>";
        echo "Laboratorio ID: <strong>" . $this->session->userdata('laboratorio_id') . "</strong><br>";
        echo "Logged In: <strong>" . ($this->session->userdata('logged_in') ? 'SI' : 'NO') . "</strong><br>";
        
        $lab_id = $this->session->userdata('laboratorio_id');
        $this->db->where('laboratorio_id', $lab_id);
        $total = $this->db->count_all_results('equipos');
        echo "Total equipos lab $lab_id: <strong>$total</strong><br>";

        $equipos_db = $this->db->select('e.id_equipos, e.codigo_interno, e.descripcion_producto')
                               ->from('equipos e')
                               ->where('e.laboratorio_id', $lab_id)
                               ->limit(10)->get()->result();
        
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Código</th><th>Descripción</th></tr>";
        foreach($equipos_db as $e) {
            echo "<tr><td>{$e->id_equipos}</td><td>{$e->codigo_interno}</td><td>{$e->descripcion_producto}</td></tr>";
        }
        echo "</table>";
        echo "<pre>" . $this->db->last_query() . "</pre>";
    }

    public function detalles($id) {
        $laboratorio_id = $this->session->userdata('laboratorio_id');
        $id_decrypted = $this->idencrypt->decrypt($id);
        
        $data['title'] = "Detalles del Equipo";
        $data['id_enc'] = $id;
        $data['equipo'] = $this->Inventario_model->obtener_equipo_computo($id_decrypted);
        
        if (!$data['equipo'] || $data['equipo']->laboratorio_id != $laboratorio_id) {
            show_404();
            return;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('panel/detalles', $data);
        $this->load->view('templates/footer', $data);
    }

    public function buscar_inventario() {
        $codigo_interno = $this->input->post("cInterno");

        if (empty($codigo_interno)) {
            redirect('panel/ver_inventario');
            return;
        }

        $data['tipos']   = array();
        $data['equipos'] = array();

        $tipos = $this->Inventario_model->obtener_tipos();
        foreach ($tipos as $key => $tipo) {
            $data['tipos'][$key] = $tipo;
            $data['tipos'][$key]->id_tipos = $this->idencrypt->encrypt($tipo->id_tipos);
        }

        $data['title'] = 'Busqueda: ' . $codigo_interno;
        $equipos = $this->Inventario_model->obtener_equipos_por_codigo($codigo_interno);

        foreach ($equipos as $key => $equipo) {
            $data['equipos'][$key] = $equipo;
            $data['equipos'][$key]->id_equipos = $this->idencrypt->encrypt($equipo->id_equipos);
        }

        $data['codigo_buscado']   = $codigo_interno;
        $data['tipo_seleccionado'] = null;

        $this->load->view('templates/header', $data);
        $this->load->view('panel/ver_inventario', $data);
        $this->load->view('templates/footer', $data);
    }

    public function editar($id) {
        $laboratorio_id = $this->session->userdata('laboratorio_id');
        $id_decrypted   = $this->idencrypt->decrypt($id);
        
        $data['title']   = "Editar Equipo";
        $data['tipos']   = $this->Inventario_model->obtener_tipos();
        $data['estados'] = $this->Inventario_model->obtener_estados();
        $data['marcas']  = $this->Inventario_model->obtener_marcas();
        
        $equipo = $this->Inventario_model->obtener_equipo_computo($id_decrypted);
        if (!$equipo || $equipo->laboratorio_id != $laboratorio_id) {
            show_404();
            return;
        }
        
        $data['equipo'] = $equipo;
        // Pasar el id YA encriptado para que la vista lo use directamente
        $data['equipo']->id_equipos = $id;

        $this->load->view('templates/header', $data);
        $this->load->view('panel/editar', $data);
        $this->load->view('templates/footer', $data);
    }

    public function orden_mantenimiento($id) {
        $id_decrypted = $this->idencrypt->decrypt($id);
        $data['title'] = "Orden de Mantenimiento";
        $data['equipo'] = $this->Inventario_model->obtener_info_equipo($id_decrypted);
        
        $this->load->view('templates/header', $data);
        $this->load->view('panel/orden_mantenimiento', $data);
        $this->load->view('templates/footer', $data);
    }
}