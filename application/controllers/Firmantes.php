<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Firmantes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Firmantes_model');
        $this->load->library('session');
        $this->load->library('form_validation');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    // ── LISTA DE FIRMANTES ──────────────────────────────────
    public function index() {
        $data['firmantes'] = $this->Firmantes_model->getAll();
        $data['title']     = 'Gestión de Firmantes';
        $data['roles']     = $this->_roles();

        $this->load->view('templates/header', $data);
        $this->load->view('firmantes/index', $data);
        $this->load->view('templates/footer');
    }

    // ── CREAR FIRMANTE VÍA AJAX (desde modals en otras vistas) ─
    public function crear_ajax() {
        header('Content-Type: application/json');
        if (!$this->session->userdata('logged_in')) {
            echo json_encode(['error' => 'No autorizado']); return;
        }
        $nombre = trim($this->input->post('nombre'));
        $cargo  = trim($this->input->post('cargo'));
        $rol    = $this->input->post('rol');

        if (empty($nombre) || empty($cargo) || empty($rol)) {
            echo json_encode(['error' => 'Faltan datos']); return;
        }
        $data = [
            'nombre'         => $nombre,
            'cargo'          => $cargo,
            'rol'            => $rol,
            'laboratorio_id' => $this->input->post('laboratorio_id') ?: null,
            'activo'         => 1,
        ];
        $id = $this->Firmantes_model->insert($data);
        echo json_encode($id ? ['success' => true, 'id' => $id] : ['error' => 'Error al guardar']);
    }

    // ── CREAR FIRMANTE (formulario normal) ──────────────────────
    public function crear() {
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim|max_length[150]');
        $this->form_validation->set_rules('cargo',  'Cargo',  'required|trim|max_length[150]');
        $this->form_validation->set_rules('rol',    'Rol',    'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $data = [
                'nombre'         => $this->input->post('nombre'),
                'cargo'          => $this->input->post('cargo'),
                'rol'            => $this->input->post('rol'),
                'laboratorio_id' => $this->input->post('laboratorio_id') ?: null,
                'activo'         => 1,
            ];
            if ($this->Firmantes_model->insert($data)) {
                $this->session->set_flashdata('success', 'Firmante agregado correctamente.');
            } else {
                $this->session->set_flashdata('error', 'Error al agregar el firmante.');
            }
        }
        redirect('firmantes');
    }

    // ── EDITAR FIRMANTE (devuelve JSON para modal) ──────────
    public function editar($id) {
        $firmante = $this->Firmantes_model->getById($id);
        if (!$firmante) { show_404(); return; }
        header('Content-Type: application/json');
        echo json_encode($firmante);
    }

    // ── ACTUALIZAR FIRMANTE ─────────────────────────────────
    public function actualizar($id) {
        $firmante = $this->Firmantes_model->getById($id);
        if (!$firmante) { show_404(); return; }

        $data = [
            'nombre'         => $this->input->post('nombre'),
            'cargo'          => $this->input->post('cargo'),
            'rol'            => $this->input->post('rol'),
            'laboratorio_id' => $this->input->post('laboratorio_id') ?: null,
        ];

        if ($this->Firmantes_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'Firmante actualizado correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al actualizar.');
        }
        redirect('firmantes');
    }

    // ── ELIMINAR FIRMANTE ───────────────────────────────────
    public function eliminar($id) {
        $this->Firmantes_model->delete($id);
        $this->session->set_flashdata('success', 'Firmante eliminado.');
        redirect('firmantes');
    }

    // ── ENDPOINT JSON PARA DROPDOWNS ───────────────────────
    // Uso: /firmantes/lista?rol=vo_bo&lab=1
    public function lista() {
        $rol            = $this->input->get('rol');
        $laboratorio_id = $this->input->get('lab');

        if (empty($rol)) {
            echo json_encode([]);
            return;
        }

        $firmantes = $this->Firmantes_model->getListaJSON($rol, $laboratorio_id);
        header('Content-Type: application/json');
        echo json_encode($firmantes);
    }

    // ── HELPER: etiquetas de roles ──────────────────────────
    private function _roles() {
        return [
            'jefe_laboratorio' => 'Jefe de Laboratorio',
            'vo_bo'            => 'Vo. Bo. / Director de Programa Educativo',
            'revisor'          => 'Revisor',
            'autorizo'         => 'Autorizó',
            'cuatrimestre'     => 'Responsable Cuatrimestral',
        ];
    }
    // ── Guardar nombre encargado en sesión (para PDF/Excel inventario) ──
    public function guardar_encargado()
    {
        if (!$this->session->userdata('logged_in')) {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            return;
        }
        $nombre = $this->input->post('nombre');
        $this->session->set_userdata('encargado_inventario', $nombre);
        echo json_encode(['success' => true]);
    }
}