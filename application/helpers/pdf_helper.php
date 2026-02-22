<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Convierte imagen a Base64 para DOMPDF
 */
function imagen_a_base64($ruta_absoluta) {
    if (!file_exists($ruta_absoluta)) {
        log_message('error', 'Logo no encontrado: ' . $ruta_absoluta);
        return '';
    }

    $extension = strtolower(pathinfo($ruta_absoluta, PATHINFO_EXTENSION));
    $mime_types = [
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
    ];
    $mime = $mime_types[$extension] ?? 'image/png';

    $datos_imagen = file_get_contents($ruta_absoluta);
    $base64 = base64_encode($datos_imagen);

    return 'data:' . $mime . ';base64,' . $base64;
}

/**
 * Configura y genera PDF a partir de HTML
 */
function generar_pdf($html, $nombre_archivo, $orientacion = 'landscape') {
    $opciones = new Options();
    $opciones->set('isHtml5ParserEnabled', true);
    $opciones->set('isPhpEnabled', false);
    $opciones->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($opciones);
    $dompdf->loadHtml($html, 'UTF-8');
    $dompdf->setPaper('letter', $orientacion);
    $dompdf->render();

    if (ob_get_length()) ob_clean();

    $dompdf->stream($nombre_archivo, ['Attachment' => true]);
    exit;
}