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
        
        // Obtener nombre del laboratorio
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
        
        $config['base_url'] = base_url('panel/ver_inventario');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        
        // Configuración de paginación con bootstrap
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = 'Primero';
        $config['last_link'] = 'Último';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
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

        // Usar el método correcto según lo que tengas en el modelo
        if (method_exists($this->Inventario_model, 'obtener_equipos_por_laboratorio_paginados')) {
            $equipos = $this->Inventario_model->obtener_equipos_por_laboratorio_paginados($laboratorio_id, $config['per_page'], $page);
        } else {
            // Fallback al método existente
            $equipos = $this->Inventario_model->obtener_equipos_paginados($config['per_page'], $page);
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
    
    /**
     * Método de depuración para verificar sesión y equipos
     */
    public function debug_session()
    {
        echo "<h3>🔍 DEPURACIÓN DEL SISTEMA</h3>";
        echo "<hr>";
        
        echo "<h4>📌 DATOS DE SESIÓN:</h4>";
        echo "Usuario: <strong>" . $this->session->userdata('username') . "</strong><br>";
        echo "User ID: <strong>" . $this->session->userdata('user_id') . "</strong><br>";
        echo "Laboratorio ID en sesión: <strong>" . $this->session->userdata('laboratorio_id') . "</strong><br>";
        echo "Laboratorio Nombre: <strong>" . $this->session->userdata('laboratorio_nombre') . "</strong><br>";
        echo "Rol: <strong>" . $this->session->userdata('rol') . "</strong><br>";
        echo "Logged In: <strong>" . ($this->session->userdata('logged_in') ? '✅ SI' : '❌ NO') . "</strong><br>";
        
        echo "<hr>";
        echo "<h4>📊 ESTADÍSTICAS:</h4>";
        
        $lab_id = $this->session->userdata('laboratorio_id');
        
        // Contar equipos directamente con consulta
        $this->db->where('laboratorio_id', $lab_id);
        $total_equipos_db = $this->db->count_all_results('equipos');
        echo "Total equipos en DB para laboratorio $lab_id: <strong>$total_equipos_db</strong><br>";
        
        // Usar método del modelo
        $total_equipos_modelo = $this->Inventario_model->contar_equipos_por_laboratorio($lab_id);
        echo "Total equipos según modelo: <strong>$total_equipos_modelo</strong><br>";
        
        echo "<hr>";
        echo "<h4>🔧 EQUIPOS EN LABORATORIO $lab_id:</h4>";
        
        // Consulta directa a la base de datos
        $equipos_db = $this->db->select('e.*, m.nombre as marca, t.nombre as tipo')
                               ->from('equipos e')
                               ->join('marcas m', 'e.id_marcas = m.id_marcas', 'left')
                               ->join('tipos t', 'e.id_tipos = t.id_tipos', 'left')
                               ->where('e.laboratorio_id', $lab_id)
                               ->limit(10)
                               ->get()
                               ->result();
        
        if (count($equipos_db) > 0) {
            echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
            echo "<tr><th>ID</th><th>Código</th><th>Tipo</th><th>Marca</th><th>Modelo</th></tr>";
            foreach($equipos_db as $e) {
                echo "<tr>";
                echo "<td>{$e->id_equipos}</td>";
                echo "<td>{$e->cod_interno}</td>";
                echo "<td>{$e->tipo}</td>";
                echo "<td>{$e->marca}</td>";
                echo "<td>{$e->modelo}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color:red; font-weight:bold;'>❌ NO HAY EQUIPOS para este laboratorio</p>";
        }
        
        echo "<hr>";
        echo "<h4>📋 ÚLTIMA CONSULA SQL:</h4>";
        echo "<pre>" . $this->db->last_query() . "</pre>";
        
        echo "<hr>";
        echo "<p><a href='" . base_url('panel/ver_inventario') . "'>➡️ Ir a Ver Inventario</a></p>";
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
    $Codigo_interno = $this->input->post("cInterno");

    if (empty($Codigo_interno)) {
        redirect('panel/ver_inventario');
        return;
    }

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
    public function editar($id) {
        $laboratorio_id = $this->session->userdata('laboratorio_id');
        $id_decrypted = $this->idencrypt->decrypt($id);
        
        $data['title'] = "Editar Equipo";
        $data['tipos'] = $this->Inventario_model->obtener_tipos();
        $data['estados'] = $this->Inventario_model->obtener_estados();
        $data['marcas'] = $this->Inventario_model->obtener_marcas();
        
        $equipo = $this->Inventario_model->obtener_equipo_computo($id_decrypted);
        if (!$equipo || $equipo->laboratorio_id != $laboratorio_id) {
            show_404();
            return;
        }
        
        $data['equipo'] = $equipo;
        $data['equipo']->id_equipos = $id;

        $this->load->view('templates/header', $data);
        $this->load->view('panel/editar', $data);
        $this->load->view('templates/footer', $data);
    }
}