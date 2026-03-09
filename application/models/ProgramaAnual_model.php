<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramaAnual_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Obtener programa por ID (TABLA CORRECTA: programa_anual_mantenimiento)
     */
    public function getById($id)
    {
        return $this->db->get_where('programa_anual_mantenimiento', ['id' => $id])->row();
    }

    /**
     * Obtener programas por laboratorio y año
     */
    public function getByLaboratorioAnio($laboratorio_id, $anio)
    {
        return $this->db->get_where('programa_anual_mantenimiento', [
            'laboratorio_id' => $laboratorio_id,
            'anio'           => $anio
        ])->result();
    }

    /**
     * Obtener años disponibles para un laboratorio
     */
    public function getAniosDisponibles($laboratorio_id)
    {
        $query = $this->db
            ->select('anio')
            ->where('laboratorio_id', $laboratorio_id)
            ->group_by('anio')
            ->order_by('anio', 'DESC')
            ->get('programa_anual_mantenimiento')
            ->result();
        
        $anios = array();
        foreach ($query as $row) {
            $anios[] = $row->anio;
        }
        
        // Agregar año actual si no existe
        $anio_actual = date('Y');
        if (!in_array($anio_actual, $anios)) {
            $anios[] = $anio_actual;
        }
        sort($anios);
        
        return $anios;
    }

    /**
     * Insertar nuevo programa
     */
    public function insertPrograma($data)
    {
        $this->db->insert('programa_anual_mantenimiento', $data);
        return $this->db->insert_id();
    }

    /**
     * Eliminar programa (con firmas asociadas)
     */
    public function deletePrograma($id)
    {
        // Borrar firmas asociadas primero
        $this->db->delete('programa_anual_firmas', ['programa_id' => $id]);
        // Borrar programa
        $this->db->delete('programa_anual_mantenimiento', ['id' => $id]);
    }

    // ── FIRMAS ────────────────────────────────────────────────────

    /**
     * Obtener firmas guardadas para un programa
     */
    
public function getFirmas($programa_id)
{
    $row = $this->db->get_where('programa_anual_firmas', ['programa_id' => $programa_id])->row();

    if ($row) return $row;

    // Devolver objeto vacío con valores por defecto
    return (object)[
        'responsable' => 'Mtra. Eulalia Cortés F.',
        'revisor'     => 'Director de Programa Educativo',
        'autorizo'    => 'Secretaría Académica',
        'primer_cuatrimestre'  => '',
        'segundo_cuatrimestre' => '',
        'tercer_cuatrimestre'  => '',
        'edificio'    => 'UD-4 — Campus Principal',
    ];
}

    /**
     * Guardar o actualizar firmas (INSERT … ON DUPLICATE KEY UPDATE)
     */
    /**
 * Guardar o actualizar firmas (INSERT … ON DUPLICATE KEY UPDATE)
 */
public function saveFirmas($datos)
{
    $existe = $this->db->get_where('programa_anual_firmas', ['programa_id' => $datos['programa_id']])->row();

    $data = [
        'responsable' => $datos['responsable'],
        'revisor'     => $datos['revisor'],
        'autorizo'    => $datos['autorizo'],
        'primer_cuatrimestre'  => $datos['primer_cuatrimestre'] ?? '',
        'segundo_cuatrimestre' => $datos['segundo_cuatrimestre'] ?? '',
        'tercer_cuatrimestre'  => $datos['tercer_cuatrimestre'] ?? '',
        'edificio'    => $datos['edificio'],
    ];

    if ($existe) {
        // Actualizar existente
        $this->db->where('programa_id', $datos['programa_id']);
        return $this->db->update('programa_anual_firmas', $data);
    } else {
        // Insertar nuevo
        $data['programa_id'] = $datos['programa_id'];
        return $this->db->insert('programa_anual_firmas', $data);
    }
}
}