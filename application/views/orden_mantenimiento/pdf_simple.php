<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
function vp($s, $d = '') {
    return htmlspecialchars($s ?? $d, ENT_QUOTES, 'UTF-8');
}
function fechaPdf($f) {
    if (empty($f)) return '';
    $meses = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
    $p = explode('-', $f);
    return (int)$p[2] . ' de ' . $meses[(int)$p[1]] . ' de ' . $p[0];
}
function logoB64pdf($path) {
    if (!file_exists($path)) return '';
    $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $mime = ($ext === 'png') ? 'image/png' : 'image/jpeg';
    return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
}
$orden  = isset($orden)              ? $orden              : (object)array();
$trabs  = isset($trabajos)           ? $trabajos           : array();
$lab    = isset($laboratorio_nombre) ? $laboratorio_nombre : '';
$t0     = !empty($trabs) ? $trabs[0] : null;

// Checkbox como tabla HTML — compatible con dompdf
// Vacio: cuadro con borde negro sin contenido
// Marcado: cuadro con borde negro y X adentro
$_vacio   = '<table cellspacing="0" cellpadding="0" style="display:inline-table;border-collapse:collapse;vertical-align:middle;"><tr><td style="width:8pt;height:8pt;border:0.2px dashed #000000;font-size:6pt;text-align:center;vertical-align:middle;">&nbsp;</td></tr></table>';
$_marcado = '<table cellspacing="0" cellpadding="0" style="display:inline-table;border-collapse:collapse;vertical-align:middle;"><tr><td style="width:8pt;height:8pt;border:0.2px dashed #000000;font-size:7pt;text-align:center;vertical-align:middle;font-weight:bold;">X</td></tr></table>';
$chkI = ($t0 && $t0->tipo_mantenimiento == 'INTERNO') ? $_marcado : $_vacio;
$chkE = ($t0 && $t0->tipo_mantenimiento == 'EXTERNO') ? $_marcado : $_vacio;

$resp   = isset($orden->responsable_mantenimiento) ? $orden->responsable_mantenimiento : '';
$verif  = isset($orden->verificado_por)             ? $orden->verificado_por            : '';
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
    left:     10.5mm;
    right:    0mm;
    height:   20mm;
}
.bloque-firmas {
    page-break-inside: avoid;
    margin-top: 8pt;
    margin-bottom: 6pt;
}
</style>
</head>
<body style="font-family:Arial,sans-serif; font-size:10pt; color:#000000; margin:0; padding:0;">

<div id="footer-fijo">
    <table width="70%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
        <tr>
            <td style="border-top:0.2px dashed #00000000; font-size:3pt; line-height:1pt; height:8pt;">&nbsp;</td>
        </tr>
        <tr>
            <td style="height:80pt; font-size:60pt; line-height:50pt;">&nbsp;</td>
        </tr>
        <tr>
            <td style="background-color:#8B1A10; padding:0; height:4.5mm; vertical-align:middle;">
                <p style="margin:0; padding:0; color:#ffffff; font-size:8pt; font-family:Arial,sans-serif; text-align:center; line-height:1.2;">
                    Para uso de la Universidad Polit&#233;cnica de Tlaxcala mediante su Sistema de Gesti&#243;n de la Calidad
                </p>
            </td>
        </tr>
    </table>
</div>

<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-bottom:10pt;">
    <tr>
        <td width="80" style="vertical-align:middle; text-align:center;">
            <?php if ($logoL): ?><img src="<?php echo $logoL; ?>" style="height:35pt; width:auto;"><?php endif; ?>
        </td>
        <td style="text-align:center; vertical-align:middle; font-size:10pt; line-height:1.5; font-family:Arial,sans-serif;">
            Subproceso de Apoyo: <b>Mantenimiento</b><br>
            Formato: <b>Orden de Mantenimiento</b><br>
            Fecha de aprobaci&#243;n: <b>octubre 2023</b>
        </td>
        <td width="100" style="vertical-align:middle; text-align:right;">
            <?php if ($logoR): ?><img src="<?php echo $logoR; ?>" style="height:45pt; width:auto;"><?php endif; ?>
        </td>
    </tr>
</table>

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
                   font-weight:bold;">
            A) Orden de mantenimiento
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Solicitante
        </td>
    </tr>
    <tr>
        <td width="33%"
            style="border-left:0.2px dashed #000000; border-bottom:0.2px dashed #000000;
                   border-right:0.2px dashed #000000; border-top:none;
                   padding:4pt 5pt; text-align:center; font-weight:bold; font-size:9.5pt;">
            &#193;rea solicitante
        </td>
        <td width="34%" colspan="2"
            style="border-top:none; border-left:none;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; text-align:center; font-weight:bold; font-size:9.5pt;">
            Nombre del solicitante
        </td>
        <td width="33%"
            style="border-top:none; border-left:none;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; text-align:center; font-weight:bold; font-size:9.5pt;">
            Fecha de elaboraci&#243;n
        </td>
    </tr>
    <tr style="height:26pt;">
        <td style="border-top:none; border-left:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; font-size:10pt; vertical-align:middle;">
            <?php echo vp($orden->area_solicitante ?? ''); ?>
        </td>
        <td colspan="2"
            style="border-top:none; border-left:none;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; font-size:10pt; vertical-align:middle;">
            <?php echo vp($orden->solicitante ?? ''); ?>
        </td>
        <td style="border-top:none; border-left:none;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; font-size:10pt; text-align:center; vertical-align:middle;">
            <?php echo fechaPdf($orden->fecha_elaboracion ?? ''); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2"
            style="border-top:none; border-left:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; text-align:center; font-weight:bold; font-size:9.5pt;">
            Descripci&#243;n del servicio solicitado
        </td>
        <td colspan="2"
            style="border-top:none; border-left:none;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; text-align:center; font-weight:bold; font-size:9.5pt;">
            Especificaci&#243;n / Proyecci&#243;n t&#233;cnica
        </td>
    </tr>
    <tr style="height:165pt;">
        <td colspan="2" valign="top"
            style="border-top:none; border-left:0.2px dashed #000000;
                   border-bottom:1.5pt solid #333399; border-right:0.2px dashed #000000;
                   padding:5pt; font-size:10pt; height:165pt;">
            <?php echo nl2br(vp($orden->descripcion_servicio ?? '')); ?>
        </td>
        <td colspan="2" valign="top"
            style="border-top:none; border-left:none;
                   border-bottom:1.5pt solid #333399; border-right:0.2px dashed #000000;
                   padding:5pt; font-size:10pt; height:165pt;">
            <?php if (!empty($orden->especificacion_tecnica)): ?>
            <p style="margin:0 0 6pt 0; font-size:10pt;"><?php echo nl2br(vp($orden->especificacion_tecnica)); ?></p>
            <?php endif; ?>
            <?php if ($imgEsp): ?>
            <p style="text-align:center; margin:4pt 0 0 0;">
                <img src="<?php echo $imgEsp; ?>" style="max-width:100%; max-height:100pt;">
            </p>
            <?php endif; ?>
        </td>
    </tr>
</table>

<table border="1" cellspacing="0" cellpadding="0" width="100%"
       style="border-collapse:collapse; border:none; margin-bottom:0pt;">
    <tr>
        <td colspan="7"
            style="border-top:1.5pt solid #1F497D;
                   border-left:0.2px dashed #000000;
                   border-right:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000;
                   background-color:#E0E0E0;
                   padding:4pt 5pt; text-align:center; font-size:10pt; font-weight:bold;">
            B. Orden del trabajo proporcionado (&#193;rea de Mantenimiento)
        </td>
    </tr>
    <tr>
        <td width="20%" colspan="2"
            style="border-top:none; border-left:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; text-align:center; font-weight:bold; font-size:9.5pt;">
            Mantenimiento:
        </td>
        <td width="22%"
            style="border-top:none; border-left:none;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; text-align:center; font-weight:bold; font-size:9.5pt;">
            Tipo de servicio:
        </td>
        <td width="20%" colspan="2"
            style="border-top:none; border-left:none;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; text-align:center; font-weight:bold; font-size:9.5pt;">
            Asignado a:
        </td>
        <td width="20%"
            style="border-top:none; border-left:none;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; text-align:center; font-weight:bold; font-size:9.5pt;">
            Empresa o contratista:
        </td>
        <td width="18%"
            style="border-top:none; border-left:none;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; text-align:center; font-weight:bold; font-size:9pt;">
            Costo del trabajo realizado:
        </td>
    </tr>
    <tr style="height:18pt;">
        <td style="border-top:none; border-left:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; font-size:10pt; vertical-align:middle;">
            <?php echo $chkI; ?> Interno
        </td>
        <td style="border-top:none; border-left:none;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; font-size:10pt; vertical-align:middle;">
            <?php echo $chkE; ?> Externo
        </td>
        <td style="border-top:none; border-left:none;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; font-size:10pt; vertical-align:middle;">
            <?php echo vp($t0->tipo_servicio ?? ''); ?>
        </td>
        <td colspan="2"
            style="border-top:none; border-left:none;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; font-size:10pt; vertical-align:middle;">
            <?php echo vp($t0->asignado_a ?? ''); ?>
        </td>
        <td style="border-top:none; border-left:none;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; font-size:10pt; vertical-align:middle;">
            <?php echo vp($t0->empresa_contratista ?? ''); ?>
        </td>
        <td style="border-top:none; border-left:none;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; font-size:10pt; text-align:right; vertical-align:middle;">
            $<?php echo number_format((float)($t0->costo ?? 0), 2); ?>
        </td>
    </tr>
    <tr style="height:18pt;">
        <td colspan="7"
            style="border-top:none; border-left:0.2px dashed #000000;
                   border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
                   padding:4pt 5pt; font-size:10pt; vertical-align:middle;">
            Fecha de realizaci&#243;n:&nbsp;
            <?php if ($t0 && !empty($t0->fecha_realizacion)): ?>
            <b><?php echo fechaPdf($t0->fecha_realizacion); ?></b>
            <?php endif; ?>
        </td>
    </tr>
    <!-- FILA 5: Encabezados - CORREGIDO -->
<tr>
    <td colspan="3" style="width:50%; border-top:none; border-left:0.2px dashed #000000;
               border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
               padding:4pt 5pt; text-align:center; font-weight:bold; font-size:9.5pt;">
        Trabajo realizado
    </td>
    <td colspan="4" style="width:50%; border-top:none; border-left:none;
               border-bottom:0.2px dashed #000000; border-right:0.2px dashed #000000;
               padding:4pt 5pt; text-align:center; font-weight:bold; font-size:9.5pt;">
        Materiales utilizados
    </td>
</tr>
    <!-- FILA 6: contenido trabajo/materiales -->
    <!-- FILA 6: contenido trabajo/materiales - CORREGIDO -->
<tr style="height:165pt;">
    <td colspan="3" valign="top" style="width:50%; border-top:none; border-left:0.2px dashed #000000;
               border-bottom:1.5pt solid #1F497D; border-right:0.2px dashed #000000;
               padding:5pt; font-size:10pt; height:165pt;">
        <?php echo nl2br(vp($t0->trabajo_realizado ?? '')); ?>
    </td>
    <td colspan="4" valign="top" style="width:50%; border-top:none; border-left:0.2px dashed #000000;
               border-bottom:1.5pt solid #1F497D; border-right:0.2px dashed #000000;
               padding:5pt; font-size:10pt; height:165pt;">
        <?php echo nl2br(vp($t0->materiales_utilizados ?? '')); ?>
    </td>
</tr>
    <!-- FILA 7: espacio para firma - CORREGIDO (50% cada una) -->
<tr style="height:50pt;">
    <td colspan="3" valign="bottom" style="width:50%; border-top:none;
               border-left:0.2px dashed #000000;
               border-bottom:0.2px dashed #000000;
               border-right:0.2px dashed #000000;
               padding:0pt 5pt 2pt 5pt;
               text-align:center;
               font-size:8pt;
               height:50pt;">
        <?php echo htmlspecialchars($resp); ?>
    </td>
    <td colspan="4" valign="bottom" style="width:50%; border-top:none;
               border-left:none;
               border-bottom:0.2px dashed #000000;
               border-right:0.2px dashed #000000;
               padding:0pt 5pt 2pt 5pt;
               text-align:center;
               font-size:8pt;
               height:50pt;">
        <?php echo htmlspecialchars($verif); ?>
    </td>
</tr>

<!-- FILA 8: labels de firma - CORREGIDO (50% cada una) -->
<tr>
    <td colspan="3" style="width:50%; border-top:none;
               border-left:0.2px dashed #000000;
               border-bottom:0.2px dashed #000000;
               border-right:0.2px dashed #000000;
               padding:2pt 5pt;
               text-align:center;
               font-size:8pt;">
        Nombre y firma de conformidad
    </td>
    <td colspan="4" style="width:50%; border-top:none;
               border-left:none;
               border-bottom:0.2px dashed #000000;
               border-right:0.2px dashed #000000;
               padding:2pt 5pt;
               text-align:center;
               font-size:8pt;">
        Verificado por nombre y firma
    </td>
</tr>

</table>

</body>
</html>