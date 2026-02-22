<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: Arial, Helvetica, sans-serif; font-size: 6.5pt; color: #000; background: #fff; }
@page { size: letter landscape; margin: 8mm 7mm 8mm 7mm; }
.enc-wrap { width:100%; margin-bottom:3mm; }
.enc-tabla { width:100%; border-collapse:collapse; }
.enc-logo-izq, .enc-logo-der { width:42mm; padding:1mm 2mm; text-align:center; vertical-align:middle; }
.enc-logo-izq img, .enc-logo-der img { max-width:38mm; max-height:18mm; display:block; margin:0 auto; }
.enc-centro { text-align:center; vertical-align:middle; padding:1mm 4mm; }
.enc-sin-logo { display:block; width:36mm; height:16mm; border:1px dashed #999; font-size:5pt; color:#999; text-align:center; line-height:16mm; margin:0 auto; }
.enc-sub    { font-size:7.5pt; color:#222; margin-bottom:2mm; }
.enc-titulo { font-size:10.5pt; font-weight:bold; color:#000; margin-bottom:2mm; }
.enc-fecha  { font-size:7.5pt; color:#222; }
.enc-anio   { text-align:center; font-size:12pt; font-weight:bold; margin:2.5mm 0; color:#000; }
.t-info { width:100%; border-collapse:collapse; border:1px solid #000; margin-bottom:2mm; }
.t-info td { padding:2mm 2.5mm; font-size:7.5pt; border:1px solid #000; }
.t-info .lbl { font-weight:bold; background:#fff; white-space:nowrap; width:22mm; }
.tp { width:100%; border-collapse:collapse; border:1px solid #000; margin-bottom:2mm; table-layout:fixed; }
.c-num { width:5.5mm; } .c-lab { width:22mm; } .c-act { width:55mm; }
.c-est { width:15mm; } .c-mes { width:8mm; } .c-obs { width:28mm; }
.tp thead th {
    background-color: #1F3864; color: #fff; font-weight:bold; font-size:6.5pt;
    text-align:center; vertical-align:middle; padding:2mm 0.5mm;
    border:1px solid #162b4b; word-wrap:break-word;
}
.tp tbody td {
    border:1px solid #aaa; padding:1mm 0.8mm; text-align:center;
    vertical-align:middle; font-size:6pt; word-wrap:break-word; background:#fff; color:#000;
}
.td-izq { text-align:left; padding-left:1.5mm; }
.td-est { font-size:6pt; font-style:italic; color:#000; background:#fff; text-align:left; padding-left:1.5mm; }
.x-marca { font-weight:bold; font-size:8.5pt; color:#000; }
.t-firmas { width:100%; border-collapse:collapse; border:1px solid #000; margin-bottom:2mm; }
.t-firmas td { border:1px solid #aaa; padding:1.5mm 2mm; font-size:6.5pt; text-align:center; vertical-align:top; background:#fff; color:#000; }
.tf-hdr { font-weight:normal; font-size:6.5pt; }
.tf-espacio { height:13mm; vertical-align:bottom; padding-bottom:1.5mm; }
.tf-lbl { font-size:5.8pt; color:#000; padding-top:1mm; }
.pie { background-color:#8B1A10; color:#fff; text-align:center; padding:2mm 3mm; font-size:7pt; font-weight:bold; }
</style>
</head>
<body>

<!-- ENCABEZADO -->
<div class="enc-wrap">
<table class="enc-tabla"><tr>
    <td class="enc-logo-izq">
        <?php if (!empty($logo_uptlax_b64)): ?>
            <img src="<?php echo $logo_uptlax_b64; ?>" alt="UPTLAX">
        <?php else: ?>
            <span class="enc-sin-logo">LOGO UPTLAX</span>
        <?php endif; ?>
    </td>
    <td class="enc-centro">
        <div class="enc-sub">Subproceso de Apoyo: <strong>Laboratorios</strong></div>
        <div class="enc-titulo">Formato: Programa Anual de Mantenimiento a Laboratorios</div>
        <div class="enc-fecha">Fecha de aprobación: <strong>octubre 2023</strong></div>
    </td>
    <td class="enc-logo-der">
        <?php if (!empty($logo_sgc_b64)): ?>
            <img src="<?php echo $logo_sgc_b64; ?>" alt="SGC UPTx">
        <?php else: ?>
            <span class="enc-sin-logo">SGC UPTx</span>
        <?php endif; ?>
    </td>
</tr></table>
</div>

<div class="enc-anio">&lt;<?php echo htmlspecialchars($anio); ?>&gt;</div>

<!-- LABORATORIO / EDIFICIO -->
<table class="t-info"><tr>
    <td class="lbl">Laboratorio:</td>
    <td style="width:48%;"><?php echo htmlspecialchars($laboratorio); ?></td>
    <td class="lbl" style="width:26mm;">Edificio / Campus:</td>
    <td><?php echo htmlspecialchars($edificio); ?></td>
</tr></table>

<!-- TABLA PRINCIPAL -->
<table class="tp">
<colgroup>
    <col class="c-num"><col class="c-lab"><col class="c-act"><col class="c-est">
    <?php for($i=0;$i<12;$i++): ?><col class="c-mes"><?php endfor; ?>
    <col class="c-obs">
</colgroup>
<thead>
    <tr>
        <th rowspan="2">N&deg;</th>
        <th rowspan="2">Laboratorio</th>
        <th rowspan="2">Actividad a realizar</th>
        <th rowspan="2">Estatus</th>
        <th colspan="12">Meses</th>
        <th rowspan="2">Observaciones</th>
    </tr>
    <tr>
        <?php foreach([1=>'Ene',2=>'Feb',3=>'Mar',4=>'Abr',5=>'May',6=>'Jun',
                       7=>'Jul',8=>'Ago',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dic'] as $nom): ?>
        <th><?php echo $nom; ?></th>
        <?php endforeach; ?>
    </tr>
</thead>
<tbody>
<?php
$max_filas = 9;
$total_act = (!empty($actividades)) ? min(count($actividades), $max_filas) : 0;

if ($total_act > 0):
    $idx = 0;
    foreach ($actividades as $act):
        if ($idx >= $max_filas) break;
        $idx++;
        $pl = array_map('intval', (array)($act['meses_planeado']  ?? []));
        $re = array_map('intval', (array)($act['meses_realizado'] ?? []));
?>
    <tr>
        <td rowspan="2" style="font-weight:bold;font-size:6.5pt;"><?php echo (int)$act['numero']; ?></td>
        <td rowspan="2" class="td-izq" style="font-size:6pt;"><?php echo htmlspecialchars($act['laboratorio']); ?></td>
        <td rowspan="2" class="td-izq" style="font-size:6pt;"><?php echo htmlspecialchars($act['actividad']); ?></td>
        <td class="td-est">Planeado</td>
        <?php for($m=1;$m<=12;$m++): ?>
        <td><?php if(in_array($m,$pl)): ?><span class="x-marca">X</span><?php endif; ?></td>
        <?php endfor; ?>
        <!-- Observaciones: columna presente pero vacía en PDF -->
        <td rowspan="2"></td>
    </tr>
    <tr>
        <td class="td-est">Realizado</td>
        <?php for($m=1;$m<=12;$m++): ?>
        <td><?php if(in_array($m,$re)): ?><span class="x-marca">X</span><?php endif; ?></td>
        <?php endfor; ?>
    </tr>
<?php
    endforeach;

    // Filas vacías hasta completar 9 — SIN número de ID
    for ($j = $total_act + 1; $j <= $max_filas; $j++):
?>
    <tr>
        <td rowspan="2" style="border:1px solid #aaa;background:#fff;"></td>
        <td rowspan="2" style="border:1px solid #aaa;background:#fff;"></td>
        <td rowspan="2" style="border:1px solid #aaa;background:#fff;"></td>
        <td class="td-est">Planeado</td>
        <?php for($m=1;$m<=12;$m++): ?><td style="border:1px solid #aaa;background:#fff;"></td><?php endfor; ?>
        <td rowspan="2" style="border:1px solid #aaa;background:#fff;"></td>
    </tr>
    <tr>
        <td class="td-est">Realizado</td>
        <?php for($m=1;$m<=12;$m++): ?><td style="border:1px solid #aaa;background:#fff;"></td><?php endfor; ?>
    </tr>
<?php
    endfor;

else:
    // Sin actividades — sin filas, solo mensaje
?>
    <tr>
        <td colspan="17" style="text-align:center;padding:5mm;color:#888;font-style:italic;font-size:7pt;">
            No hay actividades registradas en este programa anual.
        </td>
    </tr>
<?php endif; ?>
</tbody>
</table>

<!-- FIRMAS — todas en blanco para firmar a mano después de imprimir -->
<table class="t-firmas">
    <tr>
        <td class="tf-hdr" style="width:14%;">Responsable</td>
        <td class="tf-hdr" style="width:14%;">Revis&oacute;</td>
        <td class="tf-hdr" style="width:14%;">Autoriz&oacute;</td>
        <td class="tf-hdr" style="width:19%;">Primer cuatrimestre</td>
        <td class="tf-hdr" style="width:19%;">Segundo cuatrimestre</td>
        <td class="tf-hdr" style="width:20%;">Tercer cuatrimestre</td>
    </tr>
    <tr>
        <td class="tf-espacio"></td>
        <td class="tf-espacio"></td>
        <td class="tf-espacio"></td>
        <td class="tf-espacio"></td>
        <td class="tf-espacio"></td>
        <td class="tf-espacio"></td>
    </tr>
    <tr>
        <td class="tf-lbl">Nombre y firma del &Aacute;rea</td>
        <td class="tf-lbl">Director de Programa Educativo</td>
        <td class="tf-lbl">Secretar&iacute;a Acad&eacute;mica</td>
        <td colspan="3" class="tf-lbl">
            Nombre, firma y sello de la Direcci&oacute;n de Programa Educativo
            de revisar cuatrimestralmente el estado program&aacute;tico
        </td>
    </tr>
</table>

<!-- PIE -->
<div class="pie">
    Para uso de la Universidad Polit&eacute;cnica de Tlaxcala mediante su Sistema de Gesti&oacute;n de la Calidad
</div>

</body>
</html>
