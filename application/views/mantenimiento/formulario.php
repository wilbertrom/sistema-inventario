<!DOCTYPE html>
<!--
    ARCHIVO: application/views/mantenimiento/formulario.php
    PROPÓSITO: Formulario web para capturar los datos del Programa Anual
               de Mantenimiento. Al enviar, llama al controlador que genera el PDF.

    CÓMO USAR:
    1. El usuario llena los campos de este formulario.
    2. Al hacer clic en "Generar PDF", el POST va a: mantenimiento/exportar_pdf
    3. El controlador procesa los datos y descarga el PDF.
-->
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Programa Anual de Mantenimiento - UPTLAX</title>
<style>
    /* ── Estilo básico del formulario (puedes reemplazar con Bootstrap) ── */
    body { font-family: Arial, sans-serif; font-size: 13px;
           background:#f4f4f4; color:#222; padding:20px; }
    .card { background:#fff; border-radius:6px; padding:24px;
            max-width:900px; margin:0 auto;
            box-shadow: 0 2px 8px rgba(0,0,0,.15); }
    h2 { color:#a52119; margin-bottom:18px; font-size:17px; }
    h3 { color:#a52119; font-size:14px; border-bottom:2px solid #a52119;
         padding-bottom:4px; margin:18px 0 10px; }
    .fila { display:flex; gap:14px; margin-bottom:10px; flex-wrap:wrap; }
    .campo { flex:1; min-width:160px; }
    label { display:block; font-weight:bold; margin-bottom:3px; font-size:12px; }
    input[type=text], input[type=number], select, textarea {
        width:100%; padding:6px 9px; border:1px solid #ccc;
        border-radius:4px; font-size:12px; }
    .actividad-bloque {
        background:#fafafa; border:1px solid #ddd; border-radius:5px;
        padding:12px; margin-bottom:10px;
    }
    .actividad-bloque legend {
        font-weight:bold; color:#a52119; font-size:12px; padding:0 5px;
    }
    .meses-grid { display:flex; gap:6px; flex-wrap:wrap; margin-top:5px; }
    .mes-item { display:flex; align-items:center; gap:3px; font-size:11px; }
    .mes-item input { width:auto; }
    .btn-agregar {
        background:#555; color:#fff; border:none; padding:6px 14px;
        border-radius:4px; cursor:pointer; font-size:12px; margin-bottom:10px;
    }
    .btn-agregar:hover { background:#333; }
    .btn-generar {
        background:#a52119; color:#fff; border:none; padding:10px 28px;
        border-radius:5px; cursor:pointer; font-size:14px;
        font-weight:bold; display:block; margin:20px auto 0;
    }
    .btn-generar:hover { background:#7a1813; }
    .aviso { font-size:11px; color:#888; margin-top:4px; }
</style>
</head>
<body>
<div class="card">
    <h2>📋 Programa Anual de Mantenimiento a Laboratorios</h2>

    <!-- ── FORMULARIO: POST a mantenimiento/exportar_pdf ── -->
    <form method="POST" action="<?= site_url('mantenimiento/exportar_pdf') ?>">

        <!-- ── DATOS GENERALES ── -->
        <h3>Datos Generales</h3>
        <div class="fila">
            <div class="campo">
                <label>Año del Programa *</label>
                <input type="number" name="anio" value="<?= date('Y') ?>"
                       min="2000" max="2100" required>
            </div>
            <div class="campo">
                <label>Laboratorio *</label>
                <input type="text" name="laboratorio"
                       placeholder="Ej: Laboratorio de Sistemas Computacionales" required>
            </div>
            <div class="campo">
                <label>Edificio / Campus *</label>
                <input type="text" name="edificio"
                       placeholder="Ej: Edificio A / Campus Central" required>
            </div>
        </div>

        <!-- ── FIRMAS ── -->
        <h3>Responsables</h3>
        <div class="fila">
            <div class="campo">
                <label>Responsable (Nombre y Área)</label>
                <input type="text" name="responsable"
                       placeholder="Nombre y firma del Área">
            </div>
            <div class="campo">
                <label>Revisó (Director PE)</label>
                <input type="text" name="revisor"
                       placeholder="Director de Programa Educativo">
            </div>
            <div class="campo">
                <label>Autorizó</label>
                <input type="text" name="autorizo"
                       placeholder="Secretaría Académica">
            </div>
        </div>

        <!-- ── ACTIVIDADES ── -->
        <h3>Actividades de Mantenimiento
            <span class="aviso">(máximo 8 actividades)</span>
        </h3>

        <div id="contenedor-actividades">
            <!-- La primera actividad se genera desde PHP/HTML -->
            <?php
            // Genera 2 bloques vacíos al inicio. Puedes cambiar este número.
            for ($i = 0; $i < 2; $i++):
            ?>
            <fieldset class="actividad-bloque">
                <legend>Actividad <?= $i + 1 ?></legend>

                <div class="fila">
                    <div class="campo" style="max-width:60px;">
                        <label>N°</label>
                        <input type="text" name="actividades[<?= $i ?>][numero]"
                               value="<?= $i + 1 ?>">
                    </div>
                    <div class="campo">
                        <label>Laboratorio / Área</label>
                        <input type="text" name="actividades[<?= $i ?>][laboratorio]"
                               placeholder="Nombre del área o sub-laboratorio">
                    </div>
                    <div class="campo" style="flex:2;">
                        <label>Actividad a Realizar *</label>
                        <input type="text" name="actividades[<?= $i ?>][actividad]"
                               placeholder="Descripción de la actividad de mantenimiento">
                    </div>
                </div>

                <!-- Meses PLANEADO -->
                <label style="margin-top:6px;display:block;font-weight:bold;font-size:11px;">
                    Meses Planeado:
                </label>
                <div class="meses-grid">
                    <?php
                    $nombres_meses = ['Ene','Feb','Mar','Abr','May','Jun',
                                      'Jul','Ago','Sep','Oct','Nov','Dic'];
                    foreach ($nombres_meses as $nm => $label_mes):
                    ?>
                    <label class="mes-item">
                        <input type="checkbox"
                               name="actividades[<?= $i ?>][meses_planeado][]"
                               value="<?= $nm + 1 ?>">
                        <?= $label_mes ?>
                    </label>
                    <?php endforeach; ?>
                </div>

                <!-- Meses REALIZADO -->
                <label style="margin-top:6px;display:block;font-weight:bold;font-size:11px;">
                    Meses Realizado:
                </label>
                <div class="meses-grid">
                    <?php foreach ($nombres_meses as $nm => $label_mes): ?>
                    <label class="mes-item">
                        <input type="checkbox"
                               name="actividades[<?= $i ?>][meses_realizado][]"
                               value="<?= $nm + 1 ?>">
                        <?= $label_mes ?>
                    </label>
                    <?php endforeach; ?>
                </div>

                <div class="campo" style="margin-top:8px;">
                    <label>Observaciones</label>
                    <input type="text" name="actividades[<?= $i ?>][observaciones]"
                           placeholder="Observaciones de esta actividad">
                </div>
            </fieldset>
            <?php endfor; ?>
        </div><!-- /contenedor-actividades -->

        <!-- Botón para agregar más actividades (JS) -->
        <button type="button" class="btn-agregar" onclick="agregarActividad()">
            + Agregar Actividad
        </button>

        <!-- Botón de generación -->
        <button type="submit" class="btn-generar">
            📄 Generar y Descargar PDF
        </button>
    </form>
</div>

<script>
/**
 * FUNCIÓN: agregarActividad
 * Agrega dinámicamente un nuevo bloque de actividad al formulario.
 * Lleva un contador para asignar el índice correcto al array de PHP.
 */
let contadorActividades = <?= 2 /* mismo número de bloques iniciales */ ?>;
const MAX_ACTIVIDADES   = 8;

// Array con los 12 nombres de meses para generar checkboxes
const MESES = ['Ene','Feb','Mar','Abr','May','Jun',
               'Jul','Ago','Sep','Oct','Nov','Dic'];

function agregarActividad() {
    if (contadorActividades >= MAX_ACTIVIDADES) {
        alert('Máximo ' + MAX_ACTIVIDADES + ' actividades permitidas.');
        return;
    }

    const i = contadorActividades;
    let checkboxesPlaneado  = '';
    let checkboxesRealizado = '';

    MESES.forEach((mes, idx) => {
        const val = idx + 1;
        checkboxesPlaneado  += `<label class="mes-item">
            <input type="checkbox" name="actividades[${i}][meses_planeado][]" value="${val}"> ${mes}
        </label>`;
        checkboxesRealizado += `<label class="mes-item">
            <input type="checkbox" name="actividades[${i}][meses_realizado][]" value="${val}"> ${mes}
        </label>`;
    });

    const bloque = `
    <fieldset class="actividad-bloque">
        <legend>Actividad ${i + 1}</legend>
        <div class="fila">
            <div class="campo" style="max-width:60px;">
                <label>N°</label>
                <input type="text" name="actividades[${i}][numero]" value="${i + 1}">
            </div>
            <div class="campo">
                <label>Laboratorio / Área</label>
                <input type="text" name="actividades[${i}][laboratorio]" placeholder="Nombre del área">
            </div>
            <div class="campo" style="flex:2;">
                <label>Actividad a Realizar *</label>
                <input type="text" name="actividades[${i}][actividad]" placeholder="Descripción">
            </div>
        </div>
        <label style="margin-top:6px;display:block;font-weight:bold;font-size:11px;">Meses Planeado:</label>
        <div class="meses-grid">${checkboxesPlaneado}</div>
        <label style="margin-top:6px;display:block;font-weight:bold;font-size:11px;">Meses Realizado:</label>
        <div class="meses-grid">${checkboxesRealizado}</div>
        <div class="campo" style="margin-top:8px;">
            <label>Observaciones</label>
            <input type="text" name="actividades[${i}][observaciones]" placeholder="Observaciones">
        </div>
    </fieldset>`;

    document.getElementById('contenedor-actividades').insertAdjacentHTML('beforeend', bloque);
    contadorActividades++;
}
</script>
</body>
</html>
