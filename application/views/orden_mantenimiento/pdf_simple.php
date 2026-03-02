<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
/*
 * ============================================================
 * SECCION 1: FUNCIONES AUXILIARES
 * ============================================================
 * vp()        - Escapa texto de BD para mostrar seguro en HTML
 * fechaPdf()  - "2026-02-26" => "26 de Febrero de 2026"
 * logoB64pdf()- Carga imagen del disco como base64
 *               OBLIGATORIO: dompdf no carga imagenes por URL,
 *               solo acepta ruta absoluta del filesystem o base64
 * ============================================================
 */
function vp($s, $d = '') {
    return htmlspecialchars($s ?? $d, ENT_QUOTES, 'UTF-8');
}

function fechaPdf($f) {
    if (empty($f)) return '';
    $meses = array(
        '', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    );
    $p = explode('-', $f);
    return (int)$p[2] . ' de ' . $meses[(int)$p[1]] . ' de ' . $p[0];
}

function logoB64pdf($path) {
    if (!file_exists($path)) return '';
    $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $mime = ($ext === 'png') ? 'image/png' : 'image/jpeg';
    return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
}

/*
 * ============================================================
 * SECCION 2: VARIABLES DE DATOS
 * ============================================================
 * $orden  - Objeto con datos de la Seccion A (solicitante)
 * $trabs  - Array de trabajos registrados
 * $t0     - Primer trabajo (el que aparece en el PDF)
 * $lab    - Nombre del laboratorio (encabezado)
 * $chkI   - Checkbox Interno:  marcado (tick) o vacio (cuadro)
 * $chkE   - Checkbox Externo:  marcado (tick) o vacio (cuadro)
 * $resp   - Nombre responsable => aparece en firma izquierda
 * $verif  - Nombre verificador => aparece en firma derecha
 * ============================================================
 */
$orden  = isset($orden)              ? $orden              : (object)array();
$trabs  = isset($trabajos)           ? $trabajos           : array();
$lab    = isset($laboratorio_nombre) ? $laboratorio_nombre : '';
$t0     = !empty($trabs) ? $trabs[0] : null;
$chkI   = ($t0 && $t0->tipo_mantenimiento == 'INTERNO') ? '&#9745;' : '&#9744;';
$chkE   = ($t0 && $t0->tipo_mantenimiento == 'EXTERNO') ? '&#9745;' : '&#9744;';
$resp   = isset($orden->responsable_mantenimiento) ? $orden->responsable_mantenimiento : '';
$verif  = isset($orden->verificado_por)             ? $orden->verificado_por            : '';

/*
 * ============================================================
 * SECCION 3: CARGA DE IMAGENES EN BASE64
 * ============================================================
 * $logoL  - Logo UPTLAX izquierda
 *           Ruta: assets/img/logos/logo_uptlax.png
 * $logoR  - Logo SGC derecha
 *           Ruta: assets/img/logos/logo_sgc.png
 * $imgEsp - Imagen de especificacion tecnica (opcional)
 *           Ruta: recursos-panel/images/ordenes/{archivo}
 * ============================================================
 */
$logoL  = logoB64pdf(FCPATH . 'assets/img/logos/logo_uptlax.png');
$logoR  = logoB64pdf(FCPATH . 'assets/img/logos/logo_sgc.png');

$imgEsp = '';
if (!empty($orden->especificacion_imagen)) {
    $imgPath = FCPATH . 'recursos-panel/images/ordenes/' . $orden->especificacion_imagen;
    if (file_exists($imgPath)) {
        $ext    = strtolower(pathinfo($imgPath, PATHINFO_EXTENSION));
        $mime   = ($ext === 'png') ? 'image/png' : 'image/jpeg';
        $imgEsp = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($imgPath));
    }
}
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
/*
 * SECCION 4: ESTILOS CSS PARA DOMPDF
 * ============================================================
 * REGLAS CRITICAS PARA DOMPDF:
 *
 * 1. @page define el tamano y margenes de la pagina.
 *    margin-bottom DEBE ser >= altura del footer para que
 *    el contenido no quede debajo del footer fijo.
 *    Altura del footer aprox = 20mm (linea azul + franja roja)
 *
 * 2. El footer fijo usa position:fixed con bottom:0.
 *    En dompdf esto se repite en CADA pagina automaticamente.
 *    DEBE declararse ANTES del contenido en el HTML.
 *
 * 3. page-break-inside:avoid en el bloque de firmas evita
 *    que se parta entre dos paginas.
 *
 * 4. NO usar: box-sizing, flexbox, grid, transform, opacity
 * 5. NO usar caracteres UTF-8 dentro del bloque style
 * 6. Los comentarios en style DEBEN ser de barra-asterisco
 * ============================================================
 */

@page {
    size: letter portrait;
    margin-top:    10mm;
    margin-right:  12mm;
    margin-bottom: 24mm;
    margin-left:   12mm;
}

#footer-fijo {
    position: fixed;
    bottom:   0mm;
    left:     0mm;
    right:    0mm;
    height:   20mm;
}

.bloque-firmas {
    page-break-inside: avoid;
    margin-top: 6pt;
    margin-bottom: 6pt;
}
</style>
</head>
<body style="font-family:Arial,sans-serif; font-size:10pt; color:#000000; margin:0; padding:0;">


<?php /*
 * ============================================================
 * SECCION 5: FOOTER FIJO
 * ============================================================
 * IMPORTANTE: Va declarado PRIMERO en el HTML aunque
 * visualmente aparece al fondo. Dompdf requiere este orden.
 *
 * Estructura interna del footer:
 * [linea azul 1.5pt solid #1F497D]
 * [espacio 2mm]
 * [franja roja #8B1A10 con texto blanco centrado]
 *
 * Para cambiar color de linea: border-top:1.5pt solid #1F497D
 * Para cambiar color de franja: background-color:#8B1A10
 * Para cambiar texto: editar el parrafo dentro de la celda
 * Para cambiar altura total: ajustar height en @page margin-bottom
 * ============================================================
 */ ?>
<div id="footer-fijo">

    <table width="70%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
        <tr>
            <td style="border-top:0.2px dashed #000000;
                       font-size:1pt;
                       line-height:1pt;
                       height:8pt;">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td style="height:80pt; font-size:60pt; line-height:50pt;">&nbsp;</td>
        </tr>
        <tr>
            <td style="background-color:#8B1A10;
                       padding:-0.5pt -0.5pt;
                       height:4.5mm;
                       vertical-align:middle;">
                <p style="margin:0;
                          padding:0;
                          color:#ffffff;
                          font-size:8pt;
                          font-weight:semi-bold;
                          font-family:Arial,sans-serif;
                          text-align:middle;
                          line-height:0.5;">
                    Para uso de la Universidad Polit&#233;cnica de Tlaxcala mediante su Sistema de Gesti&#243;n de la Calidad
                </p>
            </td>
        </tr>
    </table>

</div>


<?php /*
 * ============================================================
 * SECCION 6: ENCABEZADO CON LOGOS Y DATOS DEL FORMATO
 * ============================================================
 * Tabla de 3 columnas:
 * [Logo UPTLAX (80pt)] [Texto central] [Logo SGC (100pt)]
 *
 * Para cambiar tamano logos: height:35pt / height:45pt
 * Para cambiar texto central: editar el td del medio
 * Para agregar el nombre del laboratorio: descomentar la linea
 * ============================================================
 */ ?>
<table width="100%" cellspacing="0" cellpadding="0"
       style="border-collapse:collapse; margin-bottom:10pt;">
    <tr>
        <td width="80" style="vertical-align:middle; text-align:center;">
            <?php if ($logoL): ?>
            <img src="<?php echo $logoL; ?>" style="height:35pt; width:auto;">
            <?php endif; ?>
        </td>
        <td style="text-align:center; vertical-align:middle;
                   font-size:10pt; line-height:1.5;
                   font-family:Arial,sans-serif;">
            Subproceso de Apoyo: <b>Mantenimiento</b><br>
            Formato: <b>Orden de Mantenimiento</b><br>
            Fecha de aprobaci&#243;n: <b>octubre 2023</b>
        </td>
        <td width="100" style="vertical-align:middle; text-align:right;">
            <?php if ($logoR): ?>
            <img src="<?php echo $logoR; ?>" style="height:45pt; width:auto;">
            <?php endif; ?>
        </td>
    </tr>
</table>


<?php /*
 * ============================================================
 * SECCION 7: TABLA A - SOLICITUD DE MANTENIMIENTO
 * ============================================================
 * Borde superior: 1.5pt solid #333399 (azul oscuro UPTLAX)
 * Borde inferior: 1.5pt solid #333399
 * Bordes internos: 0.2px dashed #000000 (punteado fino)
 * Fondo encabezado: #E0E0E0 (gris claro)
 *
 * Filas:
 *   F1 - Titulo "A) Orden de mantenimiento ... Solicitante"
 *   F2 - Labels: Area solicitante | Nombre | Fecha
 *   F3 - Datos de BD (altura minima 26pt)
 *   F4 - Labels: Descripcion | Especificacion
 *   F5 - Contenido grande con altura fija
 *        REGLA DOMPDF: height va en <tr> Y en cada <td>
 *        Para cambiar altura: modificar 165pt en ambos lugares
 * ============================================================
 */ ?>
<table border="1" cellspacing="0" cellpadding="0" width="100%"
       style="border-collapse:collapse; border:none; margin-bottom:10pt;">

    <tr>
        <td colspan="4"
            style="border-top:1.5pt solid #333399;
                   border-left:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000;
                   background-color:#E0E0E0;
                   padding:4pt 5pt;
                   text-align:center;
                   font-size:10pt;
                   font-weight:bold;
                   font-family:Arial,sans-serif;">
            A) Orden de mantenimiento
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Solicitante
        </td>
    </tr>

    <tr>
        <td width="33%"
            style="border-left:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   border-top:none;
                   padding:4pt 5pt;
                   text-align:center;
                   font-weight:bold;
                   font-size:9.5pt;">
            &#193;rea solicitante
        </td>
        <td width="34%" colspan="2"
            style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   text-align:center;
                   font-weight:bold;
                   font-size:9.5pt;">
            Nombre del solicitante
        </td>
        <td width="33%"
            style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   text-align:center;
                   font-weight:bold;
                   font-size:9.5pt;">
            Fecha de elaboraci&#243;n
        </td>
    </tr>

    <tr style="height:26pt;">
        <td style="border-top:none;
                   border-left:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   font-size:10pt;
                   vertical-align:middle;">
            <?php echo vp($orden->area_solicitante ?? ''); ?>
        </td>
        <td colspan="2"
            style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   font-size:10pt;
                   vertical-align:middle;">
            <?php echo vp($orden->solicitante ?? ''); ?>
        </td>
        <td style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   font-size:10pt;
                   text-align:center;
                   vertical-align:middle;">
            <?php echo fechaPdf($orden->fecha_elaboracion ?? ''); ?>
        </td>
    </tr>

    <tr>
        <td colspan="2"
            style="border-top:none;
                   border-left:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   text-align:center;
                   font-weight:bold;
                   font-size:9.5pt;">
            Descripci&#243;n del servicio solicitado
        </td>
        <td colspan="2"
            style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   text-align:center;
                   font-weight:bold;
                   font-size:9.5pt;">
            Especificaci&#243;n / Proyecci&#243;n t&#233;cnica
        </td>
    </tr>

    <tr style="height:165pt;">
        <td colspan="2" valign="top"
            style="border-top:none;
                   border-left:0.2px dashed #000000;
                   border-bottom:1.5pt solid #333399;
                   border-right:0.2px dashed #000000;
                   padding:5pt;
                   height:165pt;
                   font-size:10pt;">
            <?php echo nl2br(vp($orden->descripcion_servicio ?? '')); ?>
        </td>
        <td colspan="2" valign="top"
            style="border-top:none;
                   border-left:none;
                   border-bottom:1.5pt solid #333399;
                   border-right:0.2px dashed #000000;
                   padding:5pt;
                   height:165pt;
                   font-size:10pt;">
            <?php if (!empty($orden->especificacion_tecnica)): ?>
            <p style="margin:0 0 6pt 0; font-size:10pt;">
                <?php echo nl2br(vp($orden->especificacion_tecnica)); ?>
            </p>
            <?php endif; ?>
            <?php if ($imgEsp): ?>
            <p style="text-align:center; margin:4pt 0 0 0;">
                <img src="<?php echo $imgEsp; ?>"
                     style="max-width:100%; max-height:100pt;">
            </p>
            <?php endif; ?>
        </td>
    </tr>

</table>


<?php /*
 * ============================================================
 * SECCION 8: TABLA B - TRABAJO PROPORCIONADO
 * ============================================================
 * Borde superior: 1.5pt solid #1F497D (azul medio)
 * Borde inferior: 1.5pt solid #1F497D
 * Bordes internos: 0.2px dashed #000000
 *
 * Estructura de 7 columnas logicas:
 * [Interno 10%][Externo 10%][Tipo 22%][Asignado 20%+20%][Empresa 20%][Costo 18%]
 *   col1          col2         col3     col4    col5        col6         col7
 *
 * Filas:
 *   F1 - Titulo "B. Orden del trabajo..."
 *   F2 - Labels columnas
 *   F3 - Datos: checkboxes + valores de BD (altura 18pt)
 *   F4 - Fecha de realizacion (fila completa, altura 18pt)
 *   F5 - Labels: Trabajo realizado | Materiales utilizados
 *   F6 - Contenido grande con altura fija
 *        REGLA DOMPDF: height va en <tr> Y en cada <td>
 *        Para cambiar altura: modificar 165pt en ambos lugares
 * ============================================================
 */ ?>
<table border="1" cellspacing="0" cellpadding="0" width="100%"
       style="border-collapse:collapse; border:none; margin-bottom:0pt;">

    <tr>
        <td colspan="7"
            style="border-top:1.5pt solid #1F497D;
                   border-left:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000;
                   background-color:#E0E0E0;
                   padding:4pt 5pt;
                   text-align:center;
                   font-size:10pt;
                   font-weight:bold;
                   font-family:Arial,sans-serif;">
            B. Orden del trabajo proporcionado (&#193;rea de Mantenimiento)
        </td>
    </tr>

    <tr>
        <td width="20%" colspan="2"
            style="border-top:none;
                   border-left:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   text-align:center;
                   font-weight:bold;
                   font-size:9.5pt;">
            Mantenimiento:
        </td>
        <td width="22%"
            style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   text-align:center;
                   font-weight:bold;
                   font-size:9.5pt;">
            Tipo de servicio:
        </td>
        <td width="20%" colspan="2"
            style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   text-align:center;
                   font-weight:bold;
                   font-size:9.5pt;">
            Asignado a:
        </td>
        <td width="20%"
            style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   text-align:center;
                   font-weight:bold;
                   font-size:9.5pt;">
            Empresa o contratista:
        </td>
        <td width="18%"
            style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   text-align:center;
                   font-weight:bold;
                   font-size:9pt;">
            Costo del trabajo realizado:
        </td>
    </tr>

    <tr style="height:18pt;">
        <td style="border-top:none;
                   border-left:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   font-size:10pt;
                   vertical-align:middle;">
            <?php echo $chkI; ?> Interno
        </td>
        <td style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   font-size:10pt;
                   vertical-align:middle;">
            <?php echo $chkE; ?> Externo
        </td>
        <td style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   font-size:10pt;
                   vertical-align:middle;">
            <?php echo vp($t0->tipo_servicio ?? ''); ?>
        </td>
        <td colspan="2"
            style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   font-size:10pt;
                   vertical-align:middle;">
            <?php echo vp($t0->asignado_a ?? ''); ?>
        </td>
        <td style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   font-size:10pt;
                   vertical-align:middle;">
            <?php echo vp($t0->empresa_contratista ?? ''); ?>
        </td>
        <td style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   font-size:10pt;
                   text-align:right;
                   vertical-align:middle;">
            $<?php echo number_format((float)($t0->costo ?? 0), 2); ?>
        </td>
    </tr>

    <tr style="height:18pt;">
        <td colspan="7"
            style="border-top:none;
                   border-left:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   font-size:10pt;
                   vertical-align:middle;">
            Fecha de realizaci&#243;n:&nbsp;
            <?php if ($t0 && !empty($t0->fecha_realizacion)): ?>
            <b><?php echo fechaPdf($t0->fecha_realizacion); ?></b>
            <?php endif; ?>
        </td>
    </tr>

    <tr>
        <td colspan="4"
            style="border-top:none;
                   border-left:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   text-align:center;
                   font-weight:bold;
                   font-size:9.5pt;">
            Trabajo realizado
        </td>
        <td colspan="3"
            style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:4pt 5pt;
                   text-align:center;
                   font-weight:bold;
                   font-size:9.5pt;">
            Materiales utilizados
        </td>
    </tr>

    <tr style="height:165pt;">
        <td colspan="4" valign="top"
            style="border-top:none;
                   border-left:0.2px dashed #000000;
                   border-bottom:1.5pt solid #1F497D;
                   border-right:0.2px dashed #000000;
                   padding:5pt;
                   font-size:10pt;
                   height:165pt;">
            <?php echo nl2br(vp($t0->trabajo_realizado ?? '')); ?>
        </td>
        <td colspan="3" valign="top"
            style="border-top:none;
                   border-left:0.2px dashed #000000;
                   border-bottom:1.5pt solid #1F497D;
                   border-right:0.2px dashed #000000;
                   padding:5pt;
                   font-size:10pt;
                   height:165pt;">
            <?php echo nl2br(vp($t0->materiales_utilizados ?? '')); ?>
        </td>
    </tr>

</table>


<?php /*
 * ============================================================
 * SECCION 9: BLOQUE DE FIRMAS
 * ============================================================
 * page-break-inside:avoid => no se parte entre paginas
 *
 * Estructura:
 *   Fila espacio (48pt): area vacia para firma manual
 *     - El nombre ($resp / $verif) va pegado al borde
 *       inferior con valign="bottom"
 *     - $resp  => alineado a la derecha (izquierda del doc)
 *     - $verif => alineado a la izquierda (derecha del doc)
 *     - Borde: solid negro (diferente al punteado general)
 *
 *   Fila label: texto descriptivo con borde solid negro
 *     - "Nombre y firma de conformidad"
 *     - "Verificado por nombre y firma"
 *
 * Para cambiar altura del espacio de firma: modificar 48pt
 * ============================================================
 */ ?>
<div class="bloque-firmas">
<table border="1" cellspacing="0" cellpadding="0" width="100%"
       style="border-collapse:collapse; border:none;">

    <tr style="height:48pt;">
        <td colspan="4" valign="bottom"
            style="border-top:none;
                   border-left:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:0pt 6pt 3pt 6pt;
                   text-align:right;
                   font-size:8pt;
                   height:48pt;">
            <?php echo htmlspecialchars($resp); ?>
        </td>
        <td colspan="3" valign="bottom"
            style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:0pt 6pt 3pt 6pt;
                   text-align:left;
                   font-size:8pt;
                   height:48pt;">
            <?php echo htmlspecialchars($verif); ?>
        </td>
    </tr>

    <tr>
        <td colspan="4"
            style="border-top:none;
                   border-left:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:3pt 5pt;
                   text-align:center;
                   font-size:8pt;">
            Nombre y firma de conformidad
        </td>
        <td colspan="3"
            style="border-top:none;
                   border-left:none;
                   border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   padding:3pt 5pt;
                   text-align:center;
                   font-size:8pt;">
            Verificado por nombre y firma
        </td>
    </tr>

</table>
</div>


</body>
</html>