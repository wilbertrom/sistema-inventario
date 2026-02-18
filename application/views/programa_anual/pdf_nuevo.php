<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #222;
            margin: 1cm;
        }

        .header {
            width: 100%;
            border-bottom: 3px solid #a52119;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }

        .header table {
            width: 100%;
            border-collapse: collapse;
        }

        .header td {
            border: none;
            padding: 5px;
        }

        .header img {
            height: 50px;
            max-width: 100px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin: 10px 0;
            color: #a52119;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #a52119;
            color: white;
            border: 1px solid #333;
            padding: 5px;
            text-align: center;
            font-size: 9px;
        }

        td {
            border: 1px solid #333;
            padding: 4px;
            text-align: center;
            font-size: 9px;
        }

        .estatus-planeado {
            background: #f5d7d5;
            font-weight: bold;
            color: #a52119;
        }

        .estatus-realizado {
            background: #c9e6d3;
            font-weight: bold;
            color: #2d6a4f;
        }

        .footer {
            margin-top: 30px;
            font-size: 8px;
            text-align: center;
            color: #555;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        
        .laboratorio-info {
            font-size: 10px;
            margin-bottom: 15px;
            padding: 8px;
            background-color: #f9f9f9;
            border-left: 3px solid #a52119;
        }
        
        .check-mark {
            color: #a52119;
            font-weight: bold;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="header">
    <table>
        <tr>
            <td style="width:20%; text-align:left;">
                <img src="<?php echo FCPATH; ?>recursos-portal/images/icon/UPTx_Logo.png" alt="UPTx Logo">
            </td>
            <td style="width:60%; text-align:center;">
                <strong>UNIVERSIDAD POLITÉCNICA DE TLAXCALA</strong><br>
                <span style="font-size: 11px;">Subproceso de Apoyo: Laboratorios</span><br>
                <span style="font-size: 12px; color: #a52119;"><strong>Programa Anual de Mantenimiento a Laboratorios</strong></span><br>
                <span style="font-size: 9px;">Fecha de aprobación: octubre 2023</span>
            </td>
            <td style="width:20%; text-align:right;">
                <img src="<?php echo FCPATH; ?>recursos-portal/images/icon/sgc.png" alt="SGC UPTx" style="height:40px;">
            </td>
        </tr>
    </table>
</div>

<div class="title">Programa Anual de Mantenimiento - Año <?php echo $programa->anio; ?></div>

<div class="laboratorio-info">
    <strong>Laboratorio:</strong> <?php echo $laboratorio_nombre; ?> | 
    <strong>Actividad:</strong> <?php echo $programa->actividad; ?> | 
    <strong>Edificio/Campus:</strong> UD-4 - Campus Principal
</div>

<table>
    <thead>
        <tr>
            <th width="8%">No.</th>
            <th width="12%">Laboratorio</th>
            <th width="20%">Actividad a realizar</th>
            <th width="8%">Estatus</th>
            <th width="4%">Ene</th>
            <th width="4%">Feb</th>
            <th width="4%">Mar</th>
            <th width="4%">Abr</th>
            <th width="4%">May</th>
            <th width="4%">Jun</th>
            <th width="4%">Jul</th>
            <th width="4%">Ago</th>
            <th width="4%">Sep</th>
            <th width="4%">Oct</th>
            <th width="4%">Nov</th>
            <th width="4%">Dic</th>
            <th width="8%">Observaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        // Crear arrays de meses por estatus
        $meses_planeados = array();
        $meses_realizados = array();
        
        foreach($detalles as $d) {
            if($d->estatus == 'PLANEADO' || $d->estatus == 'EN_PROCESO') {
                $meses_planeados[] = $d->mes;
            }
            if($d->estatus == 'COMPLETADO') {
                $meses_realizados[] = $d->mes;
            }
        }
        ?>
        
        <!-- Fila PLANEADO -->
        <tr>
            <td>1</td>
            <td><?php echo $laboratorio_nombre; ?></td>
            <td style="text-align:left;"><?php echo $programa->actividad; ?></td>
            <td class="estatus-planeado">PLANEADO</td>
            <?php for($m = 1; $m <= 12; $m++): ?>
                <td>
                    <?php if(in_array($m, $meses_planeados)): ?>
                        <span class="check-mark">✓</span>
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
            <td style="text-align:left; font-size:8px;"><?php echo $programa->observaciones; ?></td>
        </tr>
        
        <!-- Fila REALIZADO -->
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td class="estatus-realizado">REALIZADO</td>
            <?php for($m = 1; $m <= 12; $m++): ?>
                <td>
                    <?php if(in_array($m, $meses_realizados)): ?>
                        <span class="check-mark">✓</span>
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
            <td></td>
        </tr>
    </tbody>
</table>

<!-- Tabla de Firmas -->
<div style="margin-top: 40px;">
    <table style="border: none;">
        <tr>
            <td style="border: none; text-align: center; width:20%;">
                <div style="border-top: 2px solid #a52119; width: 90%; margin: 0 auto; padding-top: 5px; margin-bottom: 5px;"></div>
                <strong>Responsable</strong><br>
                <span style="font-size:8px;">Jefe de Laboratorio</span>
            </td>
            <td style="border: none; text-align: center; width:20%;">
                <div style="border-top: 2px solid #a52119; width: 90%; margin: 0 auto; padding-top: 5px; margin-bottom: 5px;"></div>
                <strong>Revisó</strong><br>
                <span style="font-size:8px;">Director de Programa Educativo</span>
            </td>
            <td style="border: none; text-align: center; width:20%;">
                <div style="border-top: 2px solid #a52119; width: 90%; margin: 0 auto; padding-top: 5px; margin-bottom: 5px;"></div>
                <strong>Autorizó</strong><br>
                <span style="font-size:8px;">Secretaría Académica</span>
            </td>
            <td style="border: none; text-align: center; width:20%;">
                <div style="border-top: 2px solid #a52119; width: 90%; margin: 0 auto; padding-top: 5px; margin-bottom: 5px;"></div>
                <strong>Primer cuatrimestre</strong><br>
                <span style="font-size:8px;">Nombre, firma y sello</span>
            </td>
            <td style="border: none; text-align: center; width:20%;">
                <div style="border-top: 2px solid #a52119; width: 90%; margin: 0 auto; padding-top: 5px; margin-bottom: 5px;"></div>
                <strong>Segundo cuatrimestre</strong><br>
                <span style="font-size:8px;">Nombre, firma y sello</span>
            </td>
        </tr>
    </table>
</div>

<!-- Instructivo (nueva página) -->
<div style="page-break-before: always; margin-top: 20px;"></div>

<div style="font-weight: bold; font-size: 12px; color: #a52119; border-bottom: 2px solid #a52119; margin-bottom: 15px; padding-bottom: 5px;">
    INSTRUCTIVO DE LLENADO
</div>

<table>
    <tr>
        <td style="width:25%;"><strong>&lt;año&gt;</strong></td>
        <td>Indicar el año del programa anual de mantenimiento que está presentando.</td>
    </tr>
    <tr>
        <td><strong>Laboratorio o Taller</strong></td>
        <td>Escribir el nombre del laboratorio o taller que presenta el programa anual.</td>
    </tr>
    <tr>
        <td><strong>Edificio / campus</strong></td>
        <td>Anotar la clave del edificio al que se dará mantenimiento y escriba el nombre del campus de ubicación.</td>
    </tr>
    <tr>
        <td><strong>No.</strong></td>
        <td>Anotar en número consecutivo entero cada una de las actividades programáticas.</td>
    </tr>
    <tr>
        <td><strong>Actividad a realizar</strong></td>
        <td>Describir concisamente la actividad que se va a realizar.</td>
    </tr>
    <tr>
        <td><strong>Estatus</strong></td>
        <td>Cuando se haya realizado la actividad planeada, deberá marcar en este recuadro para llevar un control.</td>
    </tr>
    <tr>
        <td><strong>Meses</strong></td>
        <td>Marcar exactamente en el recuadro del mes en el que se va a realizar la actividad planeada.</td>
    </tr>
    <tr>
        <td><strong>Observaciones</strong></td>
        <td>Si se tuviera alguna observación o comentario podrá ser anotado en este espacio.</td>
    </tr>
    <tr>
        <td><strong>Responsable</strong></td>
        <td>Nombre y firma del responsable que presenta el programa anual de mantenimiento.</td>
    </tr>
    <tr>
        <td><strong>Revisó</strong></td>
        <td>Nombre y firma del titular en turno del Programa Educativo correspondiente.</td>
    </tr>
    <tr>
        <td><strong>Autorizó</strong></td>
        <td>Nombre y firma del titular en turno de la Secretaría Académica de la UPTx.</td>
    </tr>
    <tr>
        <td><strong>Primer, Segundo, Tercer cuatrimestre</strong></td>
        <td>Nombre, firma y sello de la Dirección de Programa Educativo responsable de efectuar las revisiones cuatrimestrales.</td>
    </tr>
</table>

<div class="footer">
    Para uso de la Universidad Politécnica de Tlaxcala mediante su Sistema de Gestión de la Calidad
</div>

</body>
</html>