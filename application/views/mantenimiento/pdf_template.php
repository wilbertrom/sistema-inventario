<!DOCTYPE html>
<html lang="es">
<head>
<!--
    ARCHIVO: application/views/mantenimiento/pdf_template.php
    PROPÓSITO: Plantilla HTML que DOMPDF convierte a PDF.
               Replica el formato oficial del Programa Anual de Mantenimiento.

    VARIABLES DISPONIBLES (enviadas desde el controlador):
      $anio              - Año del programa
      $laboratorio       - Nombre del laboratorio
      $edificio          - Edificio / Campus
      $responsable       - Nombre del responsable
      $revisor           - Nombre del revisor
      $autorizo          - Nombre de quien autorizó
      $actividades       - Array de actividades (máx. 8)
      $logo_uptlax_b64   - Logo UPTLAX en Base64
      $logo_sgc_b64      - Logo SGC en Base64
-->
<meta charset="UTF-8">
<style>
    /* ═══════════════════════════════════════════════════════════════════
       CSS INSTITUCIONAL - PROGRAMA ANUAL DE MANTENIMIENTO
       ═══════════════════════════════════════════════════════════════════
       CÓMO MODIFICAR:
       • Tamaño de letra global       → body { font-size: X pt; }
       • Tamaño letra encabezado      → .enc-titulo { font-size: X pt; }
       • Color institucional          → Busca #a52119 y reemplaza
       • Bordes de tabla              → .tabla-principal td { border: Xpx solid COLOR; }
       • Posición logo izquierdo      → .enc-logo-izq { width: Xmm; }
       • Fondo encabezado columnas    → .th-mes { background-color: COLOR; }
    ═══════════════════════════════════════════════════════════════════ */

    /* ── RESET y BASE ── */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        -webkit-print-color-adjust: exact; /* Fuerza colores en impresión */
        print-color-adjust: exact;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 7pt;          /* ← MODIFICA: tamaño base de todo el texto */
        color: #1a1a1a;
        background: #ffffff;
    }

    /* ── PÁGINA ── */
    @page {
        size: letter landscape;  /* ← Orientación: landscape = horizontal */
        margin: 8mm 8mm 8mm 8mm; /* ← MODIFICA: márgenes del PDF */
    }

    /* ═══════════════════════════════════════════════════════
       ENCABEZADO INSTITUCIONAL
    ═══════════════════════════════════════════════════════ */
    .encabezado {
        width: 100%;
        border: 1.5px solid #a52119; /* ← MODIFICA: borde del encabezado */
        margin-bottom: 4mm;
    }

    .enc-tabla {
        width: 100%;
        border-collapse: collapse;
    }

    /* Celda del logo izquierdo (UPTLAX) */
    .enc-logo-izq {
        width: 35mm;         /* ← MODIFICA: ancho de la celda del logo izquierdo */
        padding: 3mm;
        text-align: center;
        vertical-align: middle;
        border-right: 1px solid #cccccc;
    }

    /* Celda central con títulos */
    .enc-centro {
        text-align: center;
        vertical-align: middle;
        padding: 3mm 5mm;
    }

    /* Celda del logo derecho (SGC) */
    .enc-logo-der {
        width: 35mm;         /* ← MODIFICA: ancho de la celda del logo derecho */
        padding: 3mm;
        text-align: center;
        vertical-align: middle;
        border-left: 1px solid #cccccc;
    }

    .enc-logo-izq img,
    .enc-logo-der img {
        max-width: 30mm;     /* ← MODIFICA: tamaño máximo de los logos */
        max-height: 16mm;
        display: block;
        margin: 0 auto;
    }

    .enc-subtitulo {
        font-size: 7.5pt;    /* ← MODIFICA: "Subproceso de Apoyo: Laboratorios" */
        color: #333333;
        margin-bottom: 1mm;
    }

    .enc-titulo {
        font-size: 10pt;     /* ← MODIFICA: título principal del documento */
        font-weight: bold;
        color: #1a1a1a;
        margin-bottom: 1mm;
    }

    .enc-fecha {
        font-size: 7.5pt;    /* ← MODIFICA: "Fecha de aprobación: octubre 2023" */
        color: #333333;
    }

    .enc-anio {
        font-size: 11pt;     /* ← MODIFICA: el año centrado debajo del encabezado */
        font-weight: bold;
        text-align: center;
        margin: 3mm 0 3mm 0;
        color: #1a1a1a;
    }

    /* ═══════════════════════════════════════════════════════
       FILA DE LABORATORIO / EDIFICIO
    ═══════════════════════════════════════════════════════ */
    .tabla-info {
        width: 100%;
        border-collapse: collapse;
        border: 1.5px solid #a52119;
        margin-bottom: 3mm;
    }

    .tabla-info td {
        padding: 2mm 3mm;
        font-size: 8pt;
        border: 1px solid #cccccc;
    }

    .label-campo {
        font-weight: bold;
        background-color: #f5f5f5;
        width: 20mm;
        color: #1a1a1a;
    }

    .valor-campo {
        color: #1a1a1a;
    }

    /* ═══════════════════════════════════════════════════════
       TABLA PRINCIPAL DE ACTIVIDADES
    ═══════════════════════════════════════════════════════ */
    .tabla-principal {
        width: 100%;
        border-collapse: collapse;
        border: 1.5px solid #a52119; /* ← MODIFICA: borde exterior de la tabla */
        margin-bottom: 3mm;
    }

    /* ── Encabezados de columna ── */
    .tabla-principal th {
        background-color: #a52119;   /* ← MODIFICA: fondo rojo de los headers */
        color: #ffffff;               /* ← MODIFICA: color texto de headers */
        font-weight: bold;
        font-size: 7pt;               /* ← MODIFICA: tamaño texto headers */
        text-align: center;
        vertical-align: middle;
        padding: 2mm 1mm;
        border: 1px solid #7a1813;   /* ← MODIFICA: borde entre headers */
    }

    /* Header de la sección "Meses" (que agrupa los 12 meses) */
    .th-meses-grupo {
        background-color: #c0392b;   /* ← MODIFICA: rojo más claro para el grupo */
        color: #ffffff;
    }

    /* ── Celdas de datos ── */
    .tabla-principal td {
        border: 1px solid #cccccc;   /* ← MODIFICA: bordes de celdas normales */
        padding: 1.5mm 1mm;
        text-align: center;
        vertical-align: middle;
        font-size: 6.5pt;            /* ← MODIFICA: tamaño texto en celdas */
    }

    /* Columnas con texto largo (Laboratorio, Actividad) → alineación izquierda */
    .td-text-left {
        text-align: left;
        padding-left: 2mm;
    }

    /* Filas de "Planeado" y "Realizado" */
    .td-estatus {
        font-size: 6pt;
        color: #555555;
        font-style: italic;
    }

    /* Estilo de la "X" cuando hay marca en un mes */
    .marca-x {
        font-weight: bold;
        font-size: 8pt;
        color: #a52119;              /* ← MODIFICA: color de la "X" en meses */
    }

    /* Filas alternas (zebra striping) */
    .fila-planeado {
        background-color: #ffffff;
    }

    .fila-realizado {
        background-color: #faf5f5;   /* ← MODIFICA: color fondo fila "Realizado" */
    }

    /* Separador entre grupos de actividad */
    .fila-separador td {
        border-top: 2px solid #a52119; /* ← MODIFICA: línea entre actividades */
        padding: 0;
        height: 0;
    }

    /* ── Columnas de ancho fijo ── */
    .col-num        { width: 6mm;  }  /* N° */
    .col-lab        { width: 22mm; }  /* Laboratorio */
    .col-act        { width: 40mm; }  /* Actividad a realizar */
    .col-estatus    { width: 13mm; }  /* Estatus */
    .col-mes        { width: 8mm;  }  /* Cada mes (x12) */
    .col-obs        { width: 30mm; }  /* Observaciones */

    /* ═══════════════════════════════════════════════════════
       TABLA DE FIRMAS (pie del documento)
    ═══════════════════════════════════════════════════════ */
    .tabla-firmas {
        width: 100%;
        border-collapse: collapse;
        border: 1.5px solid #a52119;
        margin-bottom: 3mm;
    }

    .tabla-firmas td {
        border: 1px solid #cccccc;
        padding: 2mm 3mm;
        font-size: 7pt;
        text-align: center;
        vertical-align: top;
    }

    .td-firma-header {
        background-color: #f0f0f0;
        font-weight: bold;
        font-size: 7pt;
        color: #1a1a1a;
    }

    .td-firma-contenido {
        height: 12mm;       /* ← MODIFICA: espacio para las firmas */
        vertical-align: bottom;
        font-size: 7pt;
        color: #555555;
    }

    /* ═══════════════════════════════════════════════════════
       PIE INSTITUCIONAL (banda roja inferior)
    ═══════════════════════════════════════════════════════ */
    .pie-institucional {
        background-color: #a52119;  /* ← MODIFICA: color de la banda roja */
        color: #ffffff;
        text-align: center;
        padding: 2mm 4mm;
        font-size: 7.5pt;
        font-weight: bold;
    }

</style>
</head>
<body>

<!-- ═══════════════════════════════════════════════════════════════
     ENCABEZADO INSTITUCIONAL
     MODIFICA: Los textos de subproceso, formato y fecha de aprobación
     están hardcodeados aquí. Puedes pasarlos como variables si cambian.
═══════════════════════════════════════════════════════════════ -->
<div class="encabezado">
    <table class="enc-tabla">
        <tr>
            <!-- LOGO IZQUIERDO: UPTLAX -->
            <td class="enc-logo-izq">
                <?php if (!empty($logo_uptlax_b64)): ?>
                    <!--
                        CÓMO REFERENCIAR LOGOS EN DOMPDF:
                        La forma CORRECTA es Base64 (ya convertido en el controlador).
                        NUNCA uses rutas relativas como src="../assets/img/logo.png"
                        porque DOMPDF no puede resolverlas.

                        Si el logo no carga, verifica:
                        1. Que el archivo exista en: assets/img/logos/logo_uptlax.png
                        2. Que PHP tenga permisos de lectura en esa carpeta
                        3. Revisa el log de CI: application/logs/
                    -->
                    <img src="<?= $logo_uptlax_b64 ?>" alt="Logo UPTLAX">
                <?php else: ?>
                    <!-- Placeholder si no hay logo -->
                    <div style="width:30mm;height:14mm;border:1px dashed #999;text-align:center;
                                line-height:14mm;font-size:6pt;color:#999;">
                        LOGO<br>UPTLAX
                    </div>
                <?php endif; ?>
            </td>

            <!-- TEXTO CENTRAL -->
            <td class="enc-centro">
                <div class="enc-subtitulo">
                    Subproceso de Apoyo: <strong>Laboratorios</strong>
                </div>
                <div class="enc-titulo">
                    Formato: Programa Anual de Mantenimiento a Laboratorios
                </div>
                <div class="enc-fecha">
                    Fecha de aprobación: <strong>octubre 2023</strong>
                </div>
            </td>

            <!-- LOGO DERECHO: SGC -->
            <td class="enc-logo-der">
                <?php if (!empty($logo_sgc_b64)): ?>
                    <img src="<?= $logo_sgc_b64 ?>" alt="Logo SGC UPTx">
                <?php else: ?>
                    <div style="width:30mm;height:14mm;border:1px dashed #999;text-align:center;
                                line-height:7mm;font-size:6pt;color:#999;padding-top:1mm;">
                        SGC<br>UPTx
                    </div>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</div>

<!-- ═══════════════════════════════════════════════════════════════
     AÑO DEL PROGRAMA
═══════════════════════════════════════════════════════════════ -->
<div class="enc-anio">&lt;<?= htmlspecialchars($anio) ?>&gt;</div>

<!-- ═══════════════════════════════════════════════════════════════
     DATOS GENERALES: LABORATORIO Y EDIFICIO
═══════════════════════════════════════════════════════════════ -->
<table class="tabla-info">
    <tr>
        <td class="label-campo">Laboratorio:</td>
        <td class="valor-campo" style="width:60%;"><?= htmlspecialchars($laboratorio) ?></td>
        <td class="label-campo" style="width:18mm;">Edificio / Campus:</td>
        <td class="valor-campo"><?= htmlspecialchars($edificio) ?></td>
    </tr>
</table>

<!-- ═══════════════════════════════════════════════════════════════
     TABLA PRINCIPAL DE ACTIVIDADES
     ESTRUCTURA: 17 columnas
       [N°] [Laboratorio] [Actividad] [Estatus] [Ene..Dic x12] [Observaciones]
       Cada actividad = 2 filas: Planeado / Realizado
═══════════════════════════════════════════════════════════════ -->
<table class="tabla-principal">

    <!-- ── ENCABEZADOS ── -->
    <thead>
        <!-- Fila 1: Grupos de columnas -->
        <tr>
            <th class="col-num"  rowspan="2">N°</th>
            <th class="col-lab"  rowspan="2">Laboratorio</th>
            <th class="col-act"  rowspan="2">Actividad a realizar</th>
            <th class="col-estatus" rowspan="2">Estatus</th>
            <!-- HEADER GRUPO MESES: abarca las 12 columnas de meses -->
            <th colspan="12" class="th-meses-grupo">Meses</th>
            <th class="col-obs" rowspan="2">Observaciones</th>
        </tr>
        <!-- Fila 2: Nombres de cada mes -->
        <tr>
            <!-- Los 12 meses. MODIFICA: nombres si necesitas otro idioma -->
            <?php
            $meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
            foreach ($meses as $mes):
            ?>
            <th class="col-mes"><?= $mes ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>

    <!-- ── CUERPO DE LA TABLA ── -->
    <tbody>
        <?php
        /**
         * ESTRUCTURA DEL ARRAY $actividades:
         * [
         *   [
         *     'numero'           => '1',
         *     'laboratorio'      => 'Lab de Cómputo',
         *     'actividad'        => 'Limpieza de equipos',
         *     'meses_planeado'   => [1, 3, 6, 9, 12],  // números de mes (1=Ene)
         *     'meses_realizado'  => [1, 3],
         *     'observaciones'    => 'Sin novedad',
         *   ],
         *   ... máx 8 actividades
         * ]
         */

        // Si no hay actividades, mostrar 4 filas vacías por defecto
        $actividades_render = !empty($actividades) ? $actividades : array_fill(0, 4, []);

        foreach ($actividades_render as $idx => $act):
            // Datos de la actividad (con fallback a vacío)
            $num_act    = $act['numero']          ?? ($idx + 1);
            $nom_lab    = $act['laboratorio']     ?? '';
            $desc_act   = $act['actividad']       ?? '';
            $obs        = $act['observaciones']   ?? '';
            $pl_meses   = $act['meses_planeado']  ?? [];  // array de números 1-12
            $re_meses   = $act['meses_realizado'] ?? [];  // array de números 1-12

            // Convertir a índices enteros para comparación
            $pl_meses = array_map('intval', (array)$pl_meses);
            $re_meses = array_map('intval', (array)$re_meses);
        ?>

            <!-- ── FILA: PLANEADO ── -->
            <tr class="fila-planeado">
                <!-- N° → abarca 2 filas (Planeado + Realizado) -->
                <td rowspan="2" class="col-num">
                    <?= htmlspecialchars($num_act) ?>
                </td>
                <!-- Laboratorio → abarca 2 filas -->
                <td rowspan="2" class="col-lab td-text-left">
                    <?= htmlspecialchars($nom_lab) ?>
                </td>
                <!-- Actividad → abarca 2 filas -->
                <td rowspan="2" class="col-act td-text-left">
                    <?= htmlspecialchars($desc_act) ?>
                </td>
                <!-- Estatus: Planeado -->
                <td class="td-estatus">Planeado</td>

                <!-- 12 celdas de meses para "Planeado" -->
                <?php for ($m = 1; $m <= 12; $m++): ?>
                <td class="col-mes">
                    <?php if (in_array($m, $pl_meses)): ?>
                        <!-- La "X" indica que ese mes está marcado -->
                        <span class="marca-x">X</span>
                    <?php endif; ?>
                </td>
                <?php endfor; ?>

                <!-- Observaciones → abarca 2 filas -->
                <td rowspan="2" class="col-obs td-text-left">
                    <?= htmlspecialchars($obs) ?>
                </td>
            </tr>

            <!-- ── FILA: REALIZADO ── -->
            <tr class="fila-realizado">
                <!-- Estatus: Realizado -->
                <td class="td-estatus">Realizado</td>

                <!-- 12 celdas de meses para "Realizado" -->
                <?php for ($m = 1; $m <= 12; $m++): ?>
                <td class="col-mes">
                    <?php if (in_array($m, $re_meses)): ?>
                        <span class="marca-x">X</span>
                    <?php endif; ?>
                </td>
                <?php endfor; ?>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<!-- ═══════════════════════════════════════════════════════════════
     TABLA DE FIRMAS Y CUATRIMESTRES
     Contiene: Responsable, Revisó, Autorizó, 3 cuatrimestres
═══════════════════════════════════════════════════════════════ -->
<table class="tabla-firmas">
    <!-- Fila de encabezados -->
    <tr>
        <td class="td-firma-header" style="width:15%;">Responsable</td>
        <td class="td-firma-header" style="width:15%;">Revisó</td>
        <td class="td-firma-header" style="width:15%;">Autorizó</td>
        <td class="td-firma-header" style="width:18%;">Primer cuatrimestre</td>
        <td class="td-firma-header" style="width:18%;">Segundo cuatrimestre</td>
        <td class="td-firma-header" style="width:19%;">Tercer cuatrimestre</td>
    </tr>
    <!-- Fila de contenido (espacio para firmas) -->
    <tr>
        <td class="td-firma-contenido"><?= htmlspecialchars($responsable) ?></td>
        <td class="td-firma-contenido"><?= htmlspecialchars($revisor) ?></td>
        <td class="td-firma-contenido"><?= htmlspecialchars($autorizo) ?></td>
        <td class="td-firma-contenido"></td>
        <td class="td-firma-contenido"></td>
        <td class="td-firma-contenido"></td>
    </tr>
    <!-- Fila de etiquetas -->
    <tr>
        <td style="font-size:6.5pt;color:#555;text-align:center;padding:1mm;">
            Nombre y firma del Área
        </td>
        <td style="font-size:6.5pt;color:#555;text-align:center;padding:1mm;">
            Director de Programa Educativo
        </td>
        <td style="font-size:6.5pt;color:#555;text-align:center;padding:1mm;">
            Secretaría Académica
        </td>
        <td colspan="3" style="font-size:6.5pt;color:#555;text-align:center;padding:1mm;">
            Nombre, firma y sello de la Dirección de Programa Educativo de revisar
            cuatrimestralmente el estado programático
        </td>
    </tr>
</table>

<!-- ═══════════════════════════════════════════════════════════════
     PIE INSTITUCIONAL (banda roja)
═══════════════════════════════════════════════════════════════ -->
<div class="pie-institucional">
    Para uso de la Universidad Politécnica de Tlaxcala mediante su Sistema de Gestión de la Calidad
</div>

</body>
</html>
