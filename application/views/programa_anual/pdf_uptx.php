<!-- Información del programa -->
<div style="margin-bottom: 20px;">
    <table style="border: none; margin: 0;">
        <tr>
            <td style="border: none; width: 15%;"><strong>Laboratorio:</strong></td>
            <td style="border: none; width: 35%;"><?php echo $laboratorio_nombre; ?></td>
            <td style="border: none; width: 15%;"><strong>Año:</strong></td>
            <td style="border: none; width: 35%;"><?php echo $programa->anio; ?></td>
        </tr>
        <tr>
            <td style="border: none;"><strong>Actividad:</strong></td>
            <td style="border: none;" colspan="3"><?php echo $programa->actividad; ?></td>
        </tr>
        <?php if(!empty($programa->observaciones)): ?>
        <tr>
            <td style="border: none;"><strong>Observaciones:</strong></td>
            <td style="border: none;" colspan="3"><?php echo $programa->observaciones; ?></td>
        </tr>
        <?php endif; ?>
    </table>
</div>

<!-- Tabla principal -->
<table>
    <thead>
        <tr>
            <th width="5%">No.</th>
            <th width="12%">Laboratorio</th>
            <th width="18%">Actividad a realizar</th>
            <th width="8%">Estatus</th>
            <th colspan="12" width="42%">Meses</th>
            <th width="15%">Observaciones</th>
        </tr>
        <tr>
            <th colspan="4"></th>
            <?php foreach($meses as $mes): ?>
            <th width="3.5%"><?php echo $mes; ?></th>
            <?php endforeach; ?>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php 
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
        
        <!-- Fila Planeado -->
        <tr>
            <td class="text-center">1</td>
            <td><?php echo $laboratorio_nombre; ?></td>
            <td><?php echo $programa->actividad; ?></td>
            <td class="text-center"><strong>Planeado</strong></td>
            <?php for($m = 1; $m <= 12; $m++): ?>
            <td class="text-center">
                <?php if(in_array($m, $meses_planeados)): ?>
                <span style="color: #a52119; font-weight: bold; font-size: 12pt;">✓</span>
                <?php endif; ?>
            </td>
            <?php endfor; ?>
            <td><?php echo $programa->observaciones; ?></td>
        </tr>
        
        <!-- Fila Realizado -->
        <tr>
            <td class="text-center"></td>
            <td></td>
            <td></td>
            <td class="text-center"><strong>Realizado</strong></td>
            <?php for($m = 1; $m <= 12; $m++): ?>
            <td class="text-center">
                <?php if(in_array($m, $meses_realizados)): ?>
                <span style="color: #a52119; font-weight: bold; font-size: 12pt;">✓</span>
                <?php endif; ?>
            </td>
            <?php endfor; ?>
            <td></td>
        </tr>
    </tbody>
</table>

<!-- Resumen de estatus -->
<div style="margin: 20px 0;">
    <table style="width: 60%; margin: 0 auto; border: none;">
        <tr>
            <td style="border: none; text-align: center; background-color: #fcf8f8;">
                <span style="color: #a52119; font-weight: bold;">Planeado: <?php echo count($meses_planeados); ?></span>
            </td>
            <td style="border: none; text-align: center; background-color: #fcf8f8;">
                <span style="color: #a52119; font-weight: bold;">Realizado: <?php echo count($meses_realizados); ?></span>
            </td>
            <td style="border: none; text-align: center; background-color: #a52119; color: white;">
                <span style="font-weight: bold;">Total: 12</span>
            </td>
        </tr>
    </table>
</div>

<!-- Firmas institucionales -->
<div class="firmas">
    <table style="border: none;">
        <tr>
            <td style="border: none; width: 20%;">
                <div class="firma-titulo">Responsable</div>
                <div class="firma-linea">Nombre y firma</div>
                <div class="firma-cargo">Jefe de Laboratorio</div>
            </td>
            <td style="border: none; width: 20%;">
                <div class="firma-titulo">Revisó</div>
                <div class="firma-linea">Nombre y firma</div>
                <div class="firma-cargo">Director de Programa Educativo</div>
            </td>
            <td style="border: none; width: 20%;">
                <div class="firma-titulo">Autorizó</div>
                <div class="firma-linea">Nombre y firma</div>
                <div class="firma-cargo">Secretaría Académica</div>
            </td>
            <td style="border: none; width: 20%;">
                <div class="firma-titulo">Primer cuatrimestre</div>
                <div class="firma-linea">Nombre, firma y sello</div>
                <div class="firma-cargo">Dirección de Programa Educativo</div>
            </td>
            <td style="border: none; width: 20%;">
                <div class="firma-titulo">Segundo cuatrimestre</div>
                <div class="firma-linea">Nombre, firma y sello</div>
                <div class="firma-cargo">Dirección de Programa Educativo</div>
            </td>
        </tr>
    </table>
</div>

<!-- Instructivo (en nueva página si es necesario) -->
<div class="page-break"></div>

<div class="instructivo">
    <h4>INSTRUCTIVO DE LLENADO</h4>
    <table>
        <tr>
            <td>&lt;año&gt;</td>
            <td>Indicar el año del programa anual de mantenimiento que está presentando.</td>
        </tr>
        <tr>
            <td>Laboratorio o Taller</td>
            <td>Escribir el nombre del laboratorio o taller que presenta el programa anual.</td>
        </tr>
        <tr>
            <td>No.</td>
            <td>Anotar en número consecutivo entero cada una de las actividades programáticas.</td>
        </tr>
        <tr>
            <td>Actividad a realizar</td>
            <td>Describir concisamente la actividad que se va a realizar.</td>
        </tr>
        <tr>
            <td>Estatus</td>
            <td>Cuando se haya realizado la actividad planeada, marcar en este recuadro.</td>
        </tr>
        <tr>
            <td>Meses</td>
            <td>Marcar exactamente en el recuadro del mes en el que se va a realizar la actividad planeada.</td>
        </tr>
        <tr>
            <td>Observaciones</td>
            <td>Si se tuviera alguna observación o comentario podrá ser anotado en este espacio.</td>
        </tr>
        <tr>
            <td>Responsable</td>
            <td>Nombre y firma del responsable que presenta el programa anual de mantenimiento.</td>
        </tr>
        <tr>
            <td>Revisó</td>
            <td>Nombre y firma del titular en turno del Programa Educativo correspondiente.</td>
        </tr>
        <tr>
            <td>Autorizó</td>
            <td>Nombre y firma del titular en turno de la Secretaría Académica de la UPTx.</td>
        </tr>
        <tr>
            <td>Cuatrimestres</td>
            <td>Nombre, firma y sello de la Dirección de Programa Educativo responsable de efectuar las revisiones cuatrimestrales.</td>
        </tr>
    </table>
</div>