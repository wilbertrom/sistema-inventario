<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { 
    font-family: 'Arial Narrow', Arial, sans-serif; 
    color: #000; 
    background: #fff; 
    margin: 0px 40px 0px 90px;
    padding: 0;
}
@page { 
    size: letter landscape; 
    margin: 10mm 12mm 10mm 12mm;
}

/* ===== ENCABEZADO ===== */
.enc-wrap { 
    width:100%; 
    margin-bottom:4mm; 
}
.enc-tabla { 
    width:100%; 
    border-collapse:collapse; 
}
.enc-logo-izq, .enc-logo-der { 
    width:42mm; 
    padding:1mm 2mm; 
    text-align:center; 
    vertical-align:middle; 
}
.enc-logo-izq img, .enc-logo-der img { 
    max-width:50mm; 
    max-height:28mm; 
    display:block; 
    margin:0 auto; 
}
.enc-centro { 
    text-align:center; 
    vertical-align:middle; 
    padding:1mm 4mm; 
}
.enc-sin-logo { 
    display:block; 
    width:38mm; 
    height:18mm; 
    border:1px dashed #999; 
    font-size:5pt; 
    color:#999; 
    text-align:center; 
    line-height:18mm; 
    margin:0 auto; 
}
.enc-sub { 
    font-size:8pt; 
    color:#000; 
    margin-bottom:1.5mm; 
    font-family: 'Arial Narrow', Arial, sans-serif;
}
.enc-titulo { 
    font-size:11pt; 
    font-weight:bold; 
    color:#000; 
    margin-bottom:1.5mm; 
    font-family: 'Arial Narrow', Arial, sans-serif;
}
.enc-fecha { 
    font-size:8pt; 
    color:#000; 
    font-family: 'Arial Narrow', Arial, sans-serif;
}
.enc-anio { 
    text-align:center; 
    font-size:11pt; 
    font-weight:bold; 
    margin:3mm 0; 
    color:#000; 
    font-family: 'Arial Narrow', Arial, sans-serif;
}

/* ===== TABLA DE INFORMACIÓN ===== */
.t-info {
    width: 100%;
    margin: 0;
    border-collapse: collapse;
    margin-bottom: 3mm;
    text-align: left;
}
.t-info td {
    padding: 0;
    font-size: 9pt;
    font-family: 'Arial Narrow', Arial, sans-serif;
    border: 1px solid #000;
}
.t-info .lbl {
    font-weight: normal;
    background-color: #f2f2f2;
    white-space: nowrap;
    padding-left: 3mm;
}

/* ===== TABLA PRINCIPAL ===== */
.tp {
    width: 100%;
    margin: 0;
    border-collapse: collapse;
    margin-bottom: 3mm;
    font-family: 'Arial Narrow', Arial, sans-serif;
}

/*
   Columnas ajustadas para máximo parecido a la imagen:
   - N°: muy pequeño
   - Laboratorio: moderado
   - Actividad a realizar: el más ancho
   - Estatus: solo para "Planeado/Realizado"
   - 12 meses: al mínimo posible
   - Observaciones: amplio
*/
/* Distribución optimizada REAL */


.tp td {
    border: 1px solid #aaa;
    padding: 0.8mm 1pt;
    vertical-align: middle;
    font-size: 6.5pt;
    font-family: 'Arial Narrow', Arial, sans-serif;
    word-wrap: break-word;
}


/* Borde exterior azul oscuro de toda la tabla */
.tp {
    width: 100%;
    margin-bottom: 6mm;
    border-top: 2px solid #333399;
    border-bottom: 2px solid #333399;
}

/* Encabezados principales */
.tp .enc-prin {
    background-color: #e8e8e8;
    font-weight: normal;
    text-align: center;
    font-size: 6.5pt;
    padding: 1mm 1pt;
    border: 1px solid #aaa;
}

/* Encabezado "Meses" agrupa los 12 */
.tp .enc-meses {
    background-color: #e8e8e8;
    font-weight: normal;
    text-align: center;
    font-size: 6.5pt;
    border: 1px solid #aaa;
    padding: 1mm 0;
}

/* Subencabezados de cada mes */
.tp .enc-mes {
    background-color: #efefef;
    text-align: center;
    font-size: 5pt;
    font-weight: normal;
    padding: 0;
    letter-spacing: -0.5pt;
    border: 1px solid #aaa;
}

/* Etiquetas Planeado / Realizado */
.tp .est-lbl {
    font-size: 6pt;
    text-align: center;
    border: 1px solid #aaa;
}

/* Última fila: borde inferior azul */
.tp tr:last-child td {
    border-bottom: 1.5px;
}

/* Marca X */
.x-marca { 
    font-weight: bold; 
    font-size: 7pt; 
    display: block;
    text-align: center;
}

/* ===== TABLA DE FIRMAS ===== */
.t-firmas {
    width: 100%;
    margin-bottom: 6mm;
    border-collapse: collapse;
    font-family: 'Arial Narrow', Arial, sans-serif;
}
.t-firmas td {
    border: 1px solid #aaa;
    padding: 0px;
    font-size: 7pt;
    text-align: center;
    vertical-align: middle;
    font-family: 'Arial Narrow', Arial, sans-serif;

}
.tf-titulo {
    font-weight: normal;
    font-size: 7pt;
    border-bottom: 1px solid #ffffff !important;
}
.tf-espacio { 
    height: 12mm; 
    vertical-align: bottom; 
    padding-bottom: 1mm; 
}
.tf-lbl { 
    font-size: 7pt; 
    color: #000;
}

/* ===== PIE DE PÁGINA ===== */
.pie {
    background-color: #8B1A10;
    color: #fff;
    font-size: 7.5pt;
    font-weight: bold;
    font-family: 'Arial Narrow', Arial, sans-serif;
    display: inline-block;
    margin-top:0; 
    margin-left: 6mm;
    padding: 1px;
}

.text-left   { text-align: left; }
.text-center { text-align: center; }
</style>
</head>
<body>

<div class="page-content">

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

    <!-- AÑO -->
    <div class="enc-anio">&lt;<?php echo htmlspecialchars($anio); ?>&gt;</div>

    <!-- TABLA DE INFORMACIÓN -->
    <table class="t-info">
    <tr>
        <td class="lbl" style="width:17.5%;"><strong>Laboratorio:</strong></td>
        <td style="width:37.5%; padding-left: 3mm;"><?php echo htmlspecialchars($laboratorio); ?></td>
        <td class="lbl" style="width:15%;">Edificio / Campus:</td>
        <td style="width:30%; padding-left: 3mm;"><?php echo htmlspecialchars($edificio); ?></td>
    </tr>
</table>

    <!-- TABLA PRINCIPAL -->
    <table class="tp">
    <colgroup>
    <col style="width: 4%">
    <col style="width:12%">
    <col style="width:22%">  <!-- Actividad -->
    <col style="width:6%">
    <?php for($i=1;$i<=12;$i++): ?>
        <col style="width:3%">
    <?php endfor; ?>
    <col style="width:20%">  <!-- Observaciones -->
</colgroup>

    <!-- Fila 1: encabezados -->
    <tr>
        <td rowspan="2" class="enc-prin">N°</td>
        <td rowspan="2" class="enc-prin">Laboratorio</td>
        <td rowspan="2" class="enc-prin">Actividad a realizar</td>
        <td rowspan="2" class="enc-prin">Estatus</td>
        <td colspan="12" class="enc-meses">M e s e s</td>
        <td rowspan="2" class="enc-prin">Observaciones</td>
    </tr>
    <!-- Fila 2: nombres de meses -->
    <tr>
        <td class="enc-mes">Ene</td>
        <td class="enc-mes">Feb</td>
        <td class="enc-mes">Mar</td>
        <td class="enc-mes">Abr</td>
        <td class="enc-mes">May</td>
        <td class="enc-mes">Jun</td>
        <td class="enc-mes">Jul</td>
        <td class="enc-mes">Ago</td>
        <td class="enc-mes">Sep</td>
        <td class="enc-mes">Oct</td>
        <td class="enc-mes">Nov</td>
        <td class="enc-mes">Dic</td>
    </tr>

    <tbody>
    <?php
    $max_filas = 9;
    $total_act = (!empty($actividades)) ? min(count($actividades), $max_filas) : 0;

    if (!function_exists('mes_marcado_pdf')):
        function mes_marcado_pdf($mes, $marcados) {
            return (is_array($marcados) && in_array($mes, $marcados))
                ? '<span class="x-marca">X</span>' : '';
        }
    endif;

    if ($total_act > 0):
        $idx = 0;
        foreach ($actividades as $act):
            if ($idx >= $max_filas) break;
            $idx++;
            $pl = array_map('intval', (array)($act['meses_planeado']  ?? []));
            $re = array_map('intval', (array)($act['meses_realizado'] ?? []));
    ?>
        <tr>
            <td rowspan="2" class="text-center" style="font-weight:bold;"><?php echo (int)$act['numero']; ?></td>
            <td rowspan="2" class="text-left"><?php echo htmlspecialchars($act['laboratorio']); ?></td>
            <td rowspan="2" class="text-left"><?php echo htmlspecialchars($act['actividad']); ?></td>
            <td class="est-lbl">Planeado</td>
            <?php for($m=1;$m<=12;$m++): ?>
            <td class="text-center"><?php echo mes_marcado_pdf($m, $pl); ?></td>
            <?php endfor; ?>
            <td rowspan="2" class="text-left"><?php echo htmlspecialchars($act['observaciones'] ?? ''); ?></td>
        </tr>
        <tr>
            <td class="est-lbl">Realizado</td>
            <?php for($m=1;$m<=12;$m++): ?>
            <td class="text-center"><?php echo mes_marcado_pdf($m, $re); ?></td>
            <?php endfor; ?>
        </tr>
    <?php
        endforeach;
        for ($j = $total_act + 1; $j <= $max_filas; $j++):
    ?>
        <tr>
            <td rowspan="2" class="text-center"></td>
            <td rowspan="2" class="text-left"></td>
            <td rowspan="2" class="text-left"></td>
            <td class="est-lbl">Planeado</td>
            <?php for($m=1;$m<=12;$m++): ?><td></td><?php endfor; ?>
            <td rowspan="2" class="text-left"></td>
        </tr>
        <tr>
            <td class="est-lbl">Realizado</td>
            <?php for($m=1;$m<=12;$m++): ?><td></td><?php endfor; ?>
        </tr>
    <?php
        endfor;
    else:
        for ($j = 1; $j <= $max_filas; $j++):
    ?>
        <tr>
            <td rowspan="2" class="text-center"></td>
            <td rowspan="2" class="text-left"></td>
            <td rowspan="2" class="text-left"></td>
            <td class="est-lbl">Planeado</td>
            <?php for($m=1;$m<=12;$m++): ?><td></td><?php endfor; ?>
            <td rowspan="2" class="text-left"></td>
        </tr>
        <tr>
            <td class="est-lbl">Realizado</td>
            <?php for($m=1;$m<=12;$m++): ?><td></td><?php endfor; ?>
        </tr>
    <?php
        endfor;
    endif;
    ?>
    </tbody>
    </table>

  <!-- TABLA DE FIRMAS -->
<table class="t-firmas">
    <tr>
        <td class="tf-titulo" style="width:15%;">Responsable</td>
        <td class="tf-titulo" style="width:15%;">Revisó</td>
        <td class="tf-titulo" style="width:15%;">Autorizó</td>
        <td class="tf-titulo" style="width:18.3%;">Primer cuatrimestre</td>
        <td class="tf-titulo" style="width:18.3%;">Segundo cuatrimestre</td>
        <td class="tf-titulo" style="width:18.3%;">Tercer cuatrimestre</td>
    </tr>
    <tr>
        <!-- Responsable -->
        <td class="tf-espacio" style="text-align: left; padding-left: 2mm; vertical-align: bottom;">
            <?php echo htmlspecialchars($responsable ?? 'Mtra. Eulalia Cortés F.'); ?>
        </td>
        <!-- Revisó -->
        <td class="tf-espacio" style="text-align: left; padding-left: 2mm; vertical-align: bottom;">
            <?php echo htmlspecialchars($revisor ?? 'Director de Programa Educativo'); ?>
        </td>
        <!-- Autorizó -->
        <td class="tf-espacio" style="text-align: left; padding-left: 2mm; vertical-align: bottom;">
            <?php echo htmlspecialchars($autorizo ?? 'Secretaría Académica'); ?>
        </td>
        <!-- Primer cuatrimestre -->
        <td class="tf-espacio" style="text-align: left; padding-left: 2mm; vertical-align: bottom;">
            <?php echo htmlspecialchars($primer_cuatrimestre ?? ''); ?>
        </td>
        <!-- Segundo cuatrimestre -->
        <td class="tf-espacio" style="text-align: left; padding-left: 2mm; vertical-align: bottom;">
            <?php echo htmlspecialchars($segundo_cuatrimestre ?? ''); ?>
        </td>
        <!-- Tercer cuatrimestre -->
        <td class="tf-espacio" style="text-align: left; padding-left: 2mm; vertical-align: bottom;">
            <?php echo htmlspecialchars($tercer_cuatrimestre ?? ''); ?>
        </td>
    </tr>
    <tr>
        <td class="tf-lbl">Nombre y firma del Área</td>
        <td class="tf-lbl">Director de Programa Educativo</td>
        <td class="tf-lbl">Secretaría Académica</td>
        <td colspan="3" class="tf-lbl">
            Nombre, firma y sello de la Dirección de Programa Educativo
            de revisar cuatrimestralmente el estado programático
        </td>
    </tr>
</table>

    <!-- PIE DE PÁGINA -->
    <div class="pie">
        Para uso de la Universidad Politécnica de Tlaxcala mediante su Sistema de Gestión de la Calidad
    </div>

</div>
</body>
</html>