<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdenMantenimiento extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('OrdenMantenimiento_model');
        $this->load->model('OrdenTrabajo_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('idEncrypt');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    // ── LISTA DE ÓRDENES ─────────────────────────────────────
    public function index()
    {
        $laboratorio_id = $this->session->userdata('laboratorio_id');

        $data['ordenes']            = $this->OrdenMantenimiento_model->getByLaboratorio($laboratorio_id);
        $data['title']              = 'Órdenes de Mantenimiento';
        $data['laboratorio_nombre'] = $this->session->userdata('laboratorio_nombre');

        $this->load->view('templates/header', $data);
        $this->load->view('orden_mantenimiento/index', $data);
        $this->load->view('templates/footer');
    }

    // ── CREAR ORDEN ──────────────────────────────────────────
    public function crear()
    {
        if ($this->input->post()) {

            $this->form_validation->set_rules('area_solicitante',  'Área solicitante',  'required|trim');
            $this->form_validation->set_rules('solicitante',       'Solicitante',       'required|trim');
            $this->form_validation->set_rules('fecha_elaboracion', 'Fecha elaboración', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('orden-mantenimiento/crear');
                return;
            }

            $data = [
                'laboratorio_id'        => $this->session->userdata('laboratorio_id'),
                'area_solicitante'      => $this->input->post('area_solicitante'),
                'solicitante'           => $this->input->post('solicitante'),
                'fecha_elaboracion'     => $this->input->post('fecha_elaboracion'),
                'descripcion_servicio'  => $this->input->post('descripcion_servicio'),
                'especificacion_tecnica'=> $this->input->post('especificacion_tecnica'),
                'especificacion_imagen'          => null,
                'responsable_mantenimiento'      => $this->input->post('responsable_mantenimiento'),
                'verificado_por'                 => $this->input->post('verificado_por'),
            ];

            // Subir imagen si viene
            if (!empty($_FILES['especificacion_imagen']['name'])) {
                $img = $this->_subir_imagen_especificacion();
                if ($img) $data['especificacion_imagen'] = $img;
            }

            $orden_id = $this->OrdenMantenimiento_model->insert($data);

            if ($orden_id) {
                $this->session->set_flashdata('success', 'Orden creada correctamente.');
                redirect('orden-mantenimiento/editar/' . $orden_id);
            } else {
                $this->session->set_flashdata('error', 'Error al crear la orden.');
                redirect('orden-mantenimiento/crear');
            }

        } else {
            $data['title'] = 'Nueva Orden de Mantenimiento';
            $this->load->view('templates/header', $data);
            $this->load->view('orden_mantenimiento/crear', $data);
            $this->load->view('templates/footer');
        }
    }

    // ── EDITAR / VER ORDEN ───────────────────────────────────
    public function editar($id)
    {
        $laboratorio_id = $this->session->userdata('laboratorio_id');
        $orden = $this->OrdenMantenimiento_model->getById($id);

        if (!$orden || $orden->laboratorio_id != $laboratorio_id) {
            show_404();
            return;
        }

        $data['orden']    = $orden;
        $data['trabajos'] = $this->OrdenTrabajo_model->getByOrden($id);
        $data['title']    = 'Orden de Mantenimiento #' . $id;

        $this->load->view('templates/header', $data);
        $this->load->view('orden_mantenimiento/editar', $data);
        $this->load->view('templates/footer');
    }

    // ── ACTUALIZAR DATOS DE LA ORDEN ─────────────────────────
    public function actualizar($id)
    {
        $laboratorio_id = $this->session->userdata('laboratorio_id');
        $orden = $this->OrdenMantenimiento_model->getById($id);

        if (!$orden || $orden->laboratorio_id != $laboratorio_id) {
            show_404();
            return;
        }

        $data = [
            'area_solicitante'       => $this->input->post('area_solicitante'),
            'solicitante'            => $this->input->post('solicitante'),
            'fecha_elaboracion'      => $this->input->post('fecha_elaboracion'),
            'descripcion_servicio'   => $this->input->post('descripcion_servicio'),
            'especificacion_tecnica'         => $this->input->post('especificacion_tecnica'),
            'responsable_mantenimiento'      => $this->input->post('responsable_mantenimiento'),
            'verificado_por'                 => $this->input->post('verificado_por'),
        ];

        // Subir nueva imagen si viene
        if (!empty($_FILES['especificacion_imagen']['name'])) {
            $img = $this->_subir_imagen_especificacion($orden->especificacion_imagen ?? null);
            if ($img) $data['especificacion_imagen'] = $img;
        }

        // Eliminar imagen si marcó quitar
        if ($this->input->post('quitar_imagen') == '1') {
            $this->_eliminar_imagen_especificacion($orden->especificacion_imagen ?? null);
            $data['especificacion_imagen'] = null;
        }

        if ($this->OrdenMantenimiento_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'Orden actualizada correctamente.');
        } else {
            $this->session->set_flashdata('error', 'Error al actualizar la orden.');
        }

        redirect('orden-mantenimiento/editar/' . $id);
    }

    // ── ELIMINAR ORDEN ───────────────────────────────────────
    public function eliminar($id)
    {
        $laboratorio_id = $this->session->userdata('laboratorio_id');
        $orden = $this->OrdenMantenimiento_model->getById($id);

        if (!$orden || $orden->laboratorio_id != $laboratorio_id) {
            show_404();
            return;
        }

        // Eliminar trabajos asociados primero
        $this->OrdenTrabajo_model->deleteByOrden($id);
        $this->OrdenMantenimiento_model->delete($id);

        $this->session->set_flashdata('success', 'Orden eliminada correctamente.');
        redirect('orden-mantenimiento');
    }

    // ── GENERAR PDF ──────────────────────────────────────────
    public function pdf($id)
    {
        $laboratorio_id = $this->session->userdata('laboratorio_id');
        $orden = $this->OrdenMantenimiento_model->getById($id);

        if (!$orden || $orden->laboratorio_id != $laboratorio_id) {
            show_404();
            return;
        }

        require_once FCPATH . 'vendor/autoload.php';

        // Imagen especificacion tecnica en base64
        $img_b64 = '';
        if (!empty($orden->especificacion_imagen)) {
            $img_b64 = $this->_imagen_a_base64(
                FCPATH . 'recursos-panel/images/ordenes/' . $orden->especificacion_imagen
            );
        }

        $data = [
            'orden'                      => $orden,
            'trabajos'                   => $this->OrdenTrabajo_model->getByOrden($id),
            'laboratorio_nombre'         => $this->session->userdata('laboratorio_nombre'),
            'responsable_mantenimiento'  => $orden->responsable_mantenimiento ?? '',
            'verificado_por'             => $orden->verificado_por ?? '',
            'logo_uptlax_b64'            => $this->_imagen_a_base64(FCPATH . 'assets/img/logos/logo_uptlax.png'),
            'logo_sgc_b64'               => $this->_imagen_a_base64(FCPATH . 'assets/img/logos/logo_sgc.png'),
            'imagen_especificacion_b64'  => $img_b64,
        ];

        $html = $this->load->view('orden_mantenimiento/pdf_simple', $data, TRUE);

        $opt = new \Dompdf\Options();
        $opt->set('isHtml5ParserEnabled', true);
        $opt->set('isPhpEnabled', false);
        $opt->set('defaultFont', 'Arial');

        $pdf = new \Dompdf\Dompdf($opt);
        $pdf->loadHtml($html, 'UTF-8');
        $pdf->setPaper('letter', 'portrait'); // vertical carta
        $pdf->render();

        $nombre = 'Orden_Mantenimiento_' . $id . '.pdf';
        if (ob_get_length()) ob_clean();
        $pdf->stream($nombre, ['Attachment' => true]);
        exit;
    }

    // ── HELPER base64 (mismo que ProgramaAnual) ───────────
    private function _imagen_a_base64($ruta)
    {
        if (!file_exists($ruta)) return '';
        $ext  = strtolower(pathinfo($ruta, PATHINFO_EXTENSION));
        $mime = ($ext === 'png') ? 'image/png' : 'image/jpeg';
        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($ruta));
    }

    // ── HELPER: subir imagen de especificación técnica ──────
    private function _subir_imagen_especificacion($imagen_anterior = null)
    {
        $dir = './recursos-panel/images/ordenes/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        // Borrar imagen anterior si existe
        if (!empty($imagen_anterior) && file_exists($dir . $imagen_anterior)) {
            unlink($dir . $imagen_anterior);
        }

        $nombre = 'orden_esp_' . time() . '_' . uniqid();
        $config = [
            'upload_path'   => $dir,
            'allowed_types' => 'jpg|jpeg|png|gif',
            'max_size'      => 5120,
            'file_name'     => $nombre,
        ];

        $this->load->library('upload', $config);
        if ($this->upload->do_upload('especificacion_imagen')) {
            return $this->upload->data('file_name');
        }
        return false;
    }

    private function _eliminar_imagen_especificacion($imagen)
    {
        if (!empty($imagen)) {
            $path = './recursos-panel/images/ordenes/' . $imagen;
            if (file_exists($path)) unlink($path);
        }
    }
}