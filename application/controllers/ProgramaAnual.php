<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramaAnual extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ProgramaAnual_model');
        $this->load->model('ProgramaAnualDetalle_model');
        $this->load->library('session');
        $this->load->helper('form');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $laboratorio_id = $this->session->userdata('laboratorio_id');
        $anio           = $this->input->get('anio') ?: date('Y');

        $data['programas']          = $this->ProgramaAnual_model->getByLaboratorioAnio($laboratorio_id, $anio);
        $data['anio_seleccionado']  = $anio;
        $data['anios_disponibles']  = $this->ProgramaAnual_model->getAniosDisponibles($laboratorio_id);
        $data['title']              = 'Programa Anual de Mantenimiento ' . $anio;
        $data['laboratorio_nombre'] = $this->session->userdata('laboratorio_nombre');

        $this->load->view('templates/header', $data);
        $this->load->view('programa_anual/index', $data);
        $this->load->view('templates/footer');
    }

    public function crear()
    {
        $laboratorio_id = $this->session->userdata('laboratorio_id');
        $anio           = $this->input->post('anio');

        $existe = $this->ProgramaAnual_model->getByLaboratorioAnio($laboratorio_id, $anio);
        if (!empty($existe)) {
            $this->session->set_flashdata('error', 'Ya existe un programa para el año ' . $anio);
            redirect('programa-anual');
        }

        $programa_id = $this->ProgramaAnual_model->insertPrograma([
            'laboratorio_id' => $laboratorio_id,
            'anio'           => $anio,
            'observaciones'  => $this->input->post('observaciones')
        ]);

        if ($programa_id) {
            $this->session->set_flashdata('success', 'Programa anual creado correctamente');
            redirect('programa-anual/actividades/' . $programa_id);
        } else {
            $this->session->set_flashdata('error', 'Error al crear el programa');
            redirect('programa-anual');
        }
    }

    public function actividades($programa_id)
    {
        $programa = $this->ProgramaAnual_model->getById($programa_id);

        if (!$programa || $programa->laboratorio_id != $this->session->userdata('laboratorio_id')) {
            show_404(); return;
        }

        $actividades_bd = $this->ProgramaAnualDetalle_model->getActividades($programa_id);

        foreach ($actividades_bd as &$act) {
            $act->meses_planeados  = $this->ProgramaAnualDetalle_model->getMesesByActividad($programa_id, $act->actividad_id, 'PLANEADO');
            $act->meses_realizados = $this->ProgramaAnualDetalle_model->getMesesByActividad($programa_id, $act->actividad_id, 'REALIZADO');
        }
        unset($act);

        $data['programa']           = $programa;
        $data['actividades']        = $actividades_bd;
        $data['meses']              = [1=>'Ene',2=>'Feb',3=>'Mar',4=>'Abr',5=>'May',6=>'Jun',7=>'Jul',8=>'Ago',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dic'];
        $data['title']              = 'Actividades — Programa Anual ' . $programa->anio;
        $data['laboratorio_nombre'] = $this->session->userdata('laboratorio_nombre');
        $data['max_actividades']    = 9;

        $this->load->view('templates/header', $data);
        $this->load->view('programa_anual/actividades', $data);
        $this->load->view('templates/footer');
    }

    public function guardar_actividad()
    {
        $programa_id  = $this->input->post('programa_id');
        $actividad_id = (int)$this->input->post('actividad_id');

        $programa = $this->ProgramaAnual_model->getById($programa_id);
        if (!$programa || $programa->laboratorio_id != $this->session->userdata('laboratorio_id')) {
            echo json_encode(['error' => 'Acceso no autorizado']); return;
        }

        $existentes  = $this->ProgramaAnualDetalle_model->getActividades($programa_id);
        $ids         = array_map('intval', array_column((array)$existentes, 'actividad_id'));
        $es_nueva    = !in_array($actividad_id, $ids);

        if ($es_nueva && count($existentes) >= 9) {
            echo json_encode(['error' => 'Máximo 9 actividades por programa']); return;
        }

        $ok = $this->ProgramaAnualDetalle_model->guardarActividad(
            $programa_id,
            $actividad_id,
            $this->input->post('actividad_nombre'),
            $this->input->post('meses_planeados')  ?: [],
            $this->input->post('meses_realizados') ?: [],
            $this->input->post('observaciones')
        );

        echo json_encode($ok ? ['success' => true] : ['error' => 'Error al guardar']);
    }

    public function eliminar($id)
    {
        $programa = $this->ProgramaAnual_model->getById($id);
        if (!$programa || $programa->laboratorio_id != $this->session->userdata('laboratorio_id')) {
            show_404(); return;
        }
        $this->ProgramaAnual_model->deletePrograma($id);
        $this->session->set_flashdata('success', 'Programa eliminado correctamente');
        redirect('programa-anual');
    }

    public function eliminar_actividad($programa_id, $actividad_id)
    {
        $programa = $this->ProgramaAnual_model->getById($programa_id);
        if (!$programa || $programa->laboratorio_id != $this->session->userdata('laboratorio_id')) {
            show_404(); return;
        }
        $this->ProgramaAnualDetalle_model->eliminarActividad($programa_id, $actividad_id);
        $this->session->set_flashdata('success', 'Actividad eliminada');
        redirect('programa-anual/actividades/' . $programa_id);
    }

    public function pdf($programa_id)
    {
        $programa = $this->ProgramaAnual_model->getById($programa_id);
        if (!$programa || $programa->laboratorio_id != $this->session->userdata('laboratorio_id')) {
            show_404(); return;
        }

        require_once FCPATH . 'vendor/autoload.php';

        $lab = $this->session->userdata('laboratorio_nombre');

        // Firmas van en blanco — se llenan a mano después de imprimir
        $datos = [
            'anio'        => $programa->anio,
            'laboratorio' => $lab,
            'edificio'    => 'UD-4 — Campus Principal',
            'responsable' => '',
            'revisor'     => '',
            'autorizo'    => '',
            'actividades' => [],
            'logo_uptlax_b64' => $this->_imagen_a_base64(FCPATH . 'assets/img/logos/logo_uptlax.png'),
            'logo_sgc_b64'    => $this->_imagen_a_base64(FCPATH . 'assets/img/logos/logo_sgc.png'),
        ];

        foreach ($this->ProgramaAnualDetalle_model->getActividades($programa_id) as $act) {
            $datos['actividades'][] = [
                'numero'          => $act->actividad_id,
                'laboratorio'     => $lab,
                'actividad'       => $act->actividad_nombre,
                'meses_planeado'  => array_map('intval', (array)$this->ProgramaAnualDetalle_model->getMesesByActividad($programa_id, $act->actividad_id, 'PLANEADO')),
                'meses_realizado' => array_map('intval', (array)$this->ProgramaAnualDetalle_model->getMesesByActividad($programa_id, $act->actividad_id, 'REALIZADO')),
                'observaciones'   => $act->observaciones ?? '',
            ];
        }

        $html = $this->load->view('programa_anual/pdf_template', $datos, TRUE);

        $opt = new \Dompdf\Options();
        $opt->set('isHtml5ParserEnabled', true);
        $opt->set('isPhpEnabled', false);
        $opt->set('defaultFont', 'Arial');

        $pdf = new \Dompdf\Dompdf($opt);
        $pdf->loadHtml($html, 'UTF-8');
        $pdf->setPaper('letter', 'landscape');
        $pdf->render();

        $nombre = 'Programa_Anual_' . $programa->anio . '_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $lab) . '.pdf';

        if (ob_get_length()) ob_clean();
        $pdf->stream($nombre, ['Attachment' => true]);
        exit;
    }

    private function _imagen_a_base64($ruta)
    {
        if (!file_exists($ruta)) return '';
        $ext  = strtolower(pathinfo($ruta, PATHINFO_EXTENSION));
        $mime = ($ext === 'png') ? 'image/png' : 'image/jpeg';
        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($ruta));
    }
}