idades · PHP
Copiar

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                    <?php endif; ?>

                    <!-- ═══ CARD PRINCIPAL ═══ -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <strong class="card-title">
                                <i class="fas fa-calendar-alt" style="color:#a52119;"></i>
                                Actividades — Programa Anual <?php echo $programa->anio; ?>
                            </strong>
                            <small class="float-right">
                                <i class="fas fa-flask"></i> <?php echo htmlspecialchars($laboratorio_nombre); ?>
                            </small>
                        </div>
                        <div class="card-body">

                            <div class="alert alert-light border-left border-danger mb-3" style="border-left-width:4px !important;">
                                <i class="fas fa-info-circle text-danger"></i>
                                Año: <strong><?php echo $programa->anio; ?></strong> &nbsp;|&nbsp;
                                Actividades: <strong><?php echo count($actividades); ?> / <?php echo $max_actividades; ?></strong>
                            </div>

                            <!-- Botones -->
                            <div class="row mb-3">
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-primary mr-1"
                                            data-toggle="modal" data-target="#modalActividad"
                                            <?php echo (count($actividades) >= $max_actividades) ? 'disabled title="Máximo 9 actividades"' : ''; ?>>
                                        <i class="fas fa-plus"></i> Nueva Actividad
                                    </button>
                                    <a href="<?php echo base_url('programa-anual/pdf/'.$programa->id); ?>"
                                       class="btn btn-danger mr-1" target="_blank">
                                        <i class="fas fa-file-pdf"></i> Exportar PDF
                                    </a>
                                    <a href="<?php echo base_url('programa-anual'); ?>" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>

                            <!-- Tabla de actividades -->
                            <div class="table-responsive">
                                <table class="table table-bordered" style="font-size:12px;">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center" rowspan="2" style="vertical-align:middle;width:40px;">N°</th>
                                            <th class="text-center" rowspan="2" style="vertical-align:middle;width:110px;">Laboratorio</th>
                                            <th class="text-center" rowspan="2" style="vertical-align:middle;">Actividad</th>
                                            <th class="text-center" rowspan="2" style="vertical-align:middle;width:85px;">Estatus</th>
                                            <th class="text-center" colspan="12">Meses</th>
                                            <th class="text-center" rowspan="2" style="vertical-align:middle;width:120px;">Observaciones</th>
                                            <th class="text-center" rowspan="2" style="vertical-align:middle;width:75px;">Acción</th>
                                        </tr>
                                        <tr>
                                            <?php foreach($meses as $mes): ?>
                                            <th class="text-center" style="width:36px;"><?php echo $mes; ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($actividades)): ?>
                                        <tr>
                                            <td colspan="18" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                                Sin actividades. Presiona "Nueva Actividad".
                                            </td>
                                        </tr>
                                        <?php else: ?>
                                        <?php foreach($actividades as $act):
                                            $mpl = $act->meses_planeados;
                                            $mre = $act->meses_realizados;
                                        ?>
                                        <tr>
                                            <td class="text-center" rowspan="2" style="vertical-align:middle;font-weight:bold;"><?php echo $act->actividad_id; ?></td>
                                            <td rowspan="2" style="vertical-align:middle;font-size:11px;"><?php echo htmlspecialchars($laboratorio_nombre); ?></td>
                                            <td rowspan="2" style="vertical-align:middle;"><?php echo htmlspecialchars($act->actividad_nombre); ?></td>
                                            <td class="text-center" style="font-size:10px;font-weight:bold;color:#a52119;background:#fff5f5;">PLANEADO</td>
                                            <?php for($m=1;$m<=12;$m++): ?>
                                            <td class="text-center" style="background:#fff5f5;">
                                                <?php if(in_array($m,$mpl)): ?>
                                                <span style="color:#a52119;font-weight:bold;font-size:14px;">✕</span>
                                                <?php endif; ?>
                                            </td>
                                            <?php endfor; ?>
                                            <td rowspan="2" style="vertical-align:middle;font-size:11px;"><?php echo htmlspecialchars($act->observaciones ?? ''); ?></td>
                                            <td rowspan="2" class="text-center" style="vertical-align:middle;">
                                                <a href="#" class="btn btn-xs btn-outline-primary d-block mb-1 btn-editar"
                                                   data-id="<?php echo $act->actividad_id; ?>"
                                                   data-nombre="<?php echo htmlspecialchars($act->actividad_nombre, ENT_QUOTES); ?>"
                                                   data-obs="<?php echo htmlspecialchars($act->observaciones ?? '', ENT_QUOTES); ?>"
                                                   data-planeados="<?php echo implode(',',$mpl); ?>"
                                                   data-realizados="<?php echo implode(',',$mre); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?php echo base_url('programa-anual/eliminar_actividad/'.$programa->id.'/'.$act->actividad_id); ?>"
                                                   class="btn btn-xs btn-outline-danger d-block"
                                                   onclick="return confirm('¿Eliminar esta actividad?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center" style="font-size:10px;font-weight:bold;color:#28a745;background:#f4fff4;">REALIZADO</td>
                                            <?php for($m=1;$m<=12;$m++): ?>
                                            <td class="text-center" style="background:#f4fff4;">
                                                <?php if(in_array($m,$mre)): ?>
                                                <span style="color:#28a745;font-weight:bold;font-size:14px;">✕</span>
                                                <?php endif; ?>
                                            </td>
                                            <?php endfor; ?>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    <!-- ═══ CARD FIRMAS (se guardan en BD) ═══ -->
                    <div class="card">
                        <div class="card-header" style="background:#f8f9fa;">
                            <strong class="card-title">
                                <i class="fas fa-signature text-danger"></i>
                                Datos de Firmas y Edificio
                            </strong>
                            <small class="float-right text-muted">
                                <i class="fas fa-save"></i> Se guardan automáticamente
                            </small>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3" style="font-size:13px;">
                                <i class="fas fa-info-circle"></i>
                                Estos datos aparecerán en el PDF exportado. Se guardan en la base de datos y puedes actualizarlos cuando quieras.
                            </p>

                            <form id="formFirmas">
                                <input type="hidden" name="programa_id" value="<?php echo $programa->id; ?>">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <i class="fas fa-user text-danger"></i>
                                                <strong>Responsable</strong>
                                                <small class="text-muted d-block">Nombre y firma del Área</small>
                                            </label>
                                            <input type="text" name="responsable" class="form-control"
                                                   value="<?php echo htmlspecialchars($firmas->responsable ?? ''); ?>"
                                                   placeholder="Nombre del responsable...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <i class="fas fa-user-check" style="color:#d49800;"></i>
                                                <strong>Revisó</strong>
                                                <small class="text-muted d-block">Director de Programa Educativo</small>
                                            </label>
                                            <input type="text" name="revisor" class="form-control"
                                                   value="<?php echo htmlspecialchars($firmas->revisor ?? ''); ?>"
                                                   placeholder="Nombre del revisor...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <i class="fas fa-user-shield text-success"></i>
                                                <strong>Autorizó</strong>
                                                <small class="text-muted d-block">Secretaría Académica</small>
                                            </label>
                                            <input type="text" name="autorizo" class="form-control"
                                                   value="<?php echo htmlspecialchars($firmas->autorizo ?? ''); ?>"
                                                   placeholder="Nombre de quien autoriza...">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                <i class="fas fa-building"></i>
                                                <strong>Edificio / Campus</strong>
                                            </label>
                                            <input type="text" name="edificio" class="form-control"
                                                   value="<?php echo htmlspecialchars($firmas->edificio ?? 'UD-4 — Campus Principal'); ?>"
                                                   placeholder="Ej: UD-4 — Campus Principal">
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end pb-3">
                                        <button type="submit" class="btn btn-success" id="btnGuardarFirmas">
                                            <i class="fas fa-save"></i> Guardar Firmas
                                        </button>
                                        <span id="firmasStatus" class="ml-3" style="display:none;font-size:13px;"></span>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ═══ MODAL: Nueva / Editar Actividad ═══ -->
<div class="modal fade" id="modalActividad" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal">
                    <i class="fas fa-plus-circle text-primary"></i> Nueva Actividad
                </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="formActividad">
                <div class="modal-body">

                    <input type="hidden" name="programa_id"  value="<?php echo $programa->id; ?>">
                    <input type="hidden" name="actividad_id" id="input_actividad_id"
                           value="<?php echo count($actividades) + 1; ?>">

                    <div class="form-group">
                        <label>Actividad a realizar <span class="text-danger">*</span></label>
                        <input type="text" name="actividad_nombre" id="input_actividad_nombre"
                               class="form-control" required placeholder="Descripción de la actividad...">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="font-weight-bold" style="color:#a52119;">
                                <i class="fas fa-calendar"></i> Meses Planeados
                            </label>
                            <div class="row mt-1">
                                <?php foreach($meses as $num => $nom): ?>
                                <div class="col-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input chk-planeado" type="checkbox"
                                               name="meses_planeados[]" value="<?php echo $num; ?>"
                                               id="pl_<?php echo $num; ?>">
                                        <label class="form-check-label" for="pl_<?php echo $num; ?>"><?php echo $nom; ?></label>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold text-success">
                                <i class="fas fa-calendar-check"></i> Meses Realizados
                            </label>
                            <div class="row mt-1">
                                <?php foreach($meses as $num => $nom): ?>
                                <div class="col-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input chk-realizado" type="checkbox"
                                               name="meses_realizados[]" value="<?php echo $num; ?>"
                                               id="re_<?php echo $num; ?>">
                                        <label class="form-check-label" for="re_<?php echo $num; ?>"><?php echo $nom; ?></label>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label>Observaciones</label>
                        <textarea name="observaciones" id="input_observaciones"
                                  class="form-control" rows="2"
                                  placeholder="Ej: Revisión eléctrica, calibración, limpieza de filtros..."></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnGuardar">
                        <i class="fas fa-save"></i> Guardar Actividad
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.btn-xs { padding:3px 8px; font-size:11px; }
.border-left { border-left: 4px solid #a52119 !important; }
</style>

<script>
$(document).ready(function() {

    // ── GUARDAR FIRMAS (AJAX) ────────────────────────────────────
    $('#formFirmas').submit(function(e) {
        e.preventDefault();
        var btn    = $('#btnGuardarFirmas');
        var status = $('#firmasStatus');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

        $.ajax({
            url: '<?php echo base_url("programa-anual/guardar_firmas"); ?>',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(r) {
                if (r.success) {
                    status.show().html('<i class="fas fa-check-circle text-success"></i> <span class="text-success">Firmas guardadas correctamente</span>');
                    setTimeout(function(){ status.fadeOut(); }, 3000);
                } else {
                    status.show().html('<i class="fas fa-times-circle text-danger"></i> <span class="text-danger">' + (r.error || 'Error') + '</span>');
                }
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Firmas');
            },
            error: function() {
                status.show().html('<i class="fas fa-times-circle text-danger"></i> <span class="text-danger">Error de conexión</span>');
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Firmas');
            }
        });
    });

    // ── EDITAR ACTIVIDAD ─────────────────────────────────────────
    $(document).on('click', '.btn-editar', function(e) {
        e.preventDefault();
        var pl = $(this).data('planeados').toString();
        var re = $(this).data('realizados').toString();

        $('.chk-planeado, .chk-realizado').prop('checked', false);
        if (pl) pl.split(',').forEach(function(m){ if(m) $('#pl_'+m.trim()).prop('checked', true); });
        if (re) re.split(',').forEach(function(m){ if(m) $('#re_'+m.trim()).prop('checked', true); });

        $('#input_actividad_id').val($(this).data('id'));
        $('#input_actividad_nombre').val($(this).data('nombre'));
        $('#input_observaciones').val($(this).data('obs'));
        $('#tituloModal').html('<i class="fas fa-edit text-warning"></i> Editar Actividad #' + $(this).data('id'));
        $('#btnGuardar').html('<i class="fas fa-save"></i> Actualizar');
        $('#modalActividad').modal('show');
    });

    // ── NUEVA ACTIVIDAD — limpiar modal ──────────────────────────
    $('[data-target="#modalActividad"]:not(.btn-editar)').click(function() {
        $('.chk-planeado, .chk-realizado').prop('checked', false);
        $('#input_actividad_nombre').val('');
        $('#input_observaciones').val('');
        $('#tituloModal').html('<i class="fas fa-plus-circle text-primary"></i> Nueva Actividad');
        $('#btnGuardar').html('<i class="fas fa-save"></i> Guardar Actividad');
        $('#input_actividad_id').val(<?php echo count($actividades) + 1; ?>);
    });

    // ── GUARDAR ACTIVIDAD (AJAX) ──────────────────────────────────
    $('#formActividad').submit(function(e) {
        e.preventDefault();
        var btn = $('#btnGuardar');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

        $.ajax({
            url: '<?php echo base_url("programa-anual/guardar_actividad"); ?>',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(r) {
                if (r.success) {
                    $('#modalActividad').modal('hide');
                    Swal.fire({ icon:'success', title:'¡Guardado!', timer:1400, showConfirmButton:false })
                        .then(function(){ location.reload(); });
                } else {
                    Swal.fire('Error', r.error || 'No se pudo guardar.', 'error');
                    btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Actividad');
                }
            },
            error: function(xhr) {
                Swal.fire('Error de conexión', 'Intenta nuevamente.', 'error');
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Actividad');
            }
        });
    });

});
</script>