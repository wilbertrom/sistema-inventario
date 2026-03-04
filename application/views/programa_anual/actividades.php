<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
:root {
    --rojo: #a52119;
    --rojo-mid: #c0392b;
    --rojo-dark: #8B1A10;
    --gris-bg: #f5f6f8;
    --gris-borde: #e2e8f0;
    --texto-dark: #1e293b;
    --texto-mid: #475569;
    --sombra-sm: 0 2px 8px rgba(0,0,0,0.06);
    --radio: 14px;
    --radio-sm: 8px;
}
.main-content { background: var(--gris-bg); min-height: calc(100vh - 81px); }
.section__content--p30 { padding: 20px 16px; }
@media(min-width:768px){ .section__content--p30 { padding: 28px; } }

/* ── Encabezado de página ── */
.page-header {
    background: white;
    border-radius: var(--radio);
    padding: 16px 20px;
    margin-bottom: 18px;
    box-shadow: var(--sombra-sm);
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-left: 4px solid var(--rojo);
    flex-wrap: wrap;
    gap: 10px;
}
.page-header h2 {
    font-size: 18px;
    font-weight: 700;
    color: var(--texto-dark);
    margin: 0;
}
.page-header h2 i { color: var(--rojo); margin-right: 8px; }

/* ── Botón principal rojo ── */
.btn-r {
    background: linear-gradient(135deg, var(--rojo), var(--rojo-mid));
    color: white;
    border: none;
    border-radius: var(--radio-sm);
    padding: 9px 18px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all .25s;
    text-decoration: none;
}
.btn-r:hover {
    box-shadow: 0 5px 15px rgba(165,33,25,.3);
    transform: translateY(-1px);
    color: white;
    text-decoration: none;
}

/* ── Botón secundario ── */
.btn-g {
    background: #f1f5f9;
    color: var(--texto-mid);
    border: 1.5px solid var(--gris-borde);
    border-radius: var(--radio-sm);
    padding: 9px 18px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all .2s;
    text-decoration: none;
}
.btn-g:hover {
    background: #e2e8f0;
    color: var(--texto-dark);
    text-decoration: none;
}

/* ─── Card principal ─── */
.card-m {
    background: white;
    border-radius: var(--radio);
    box-shadow: var(--sombra-sm);
    border: 1px solid var(--gris-borde);
    overflow: hidden;
    margin-bottom: 24px;
}

/* ─── Tabla ─── */
.table-wrap { overflow-x: auto; }
table.t {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
}

/* THEAD en rojo institucional */
table.t thead th {
    background: var(--rojo-dark);
    color: white;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .4px;
    padding: 12px 16px;
    white-space: nowrap;
}

/* Filas alternas con tono rojo muy suave */
table.t tbody tr { border-bottom: 1px solid var(--gris-borde); transition: background .15s; }
table.t tbody tr:nth-child(even) { background: #fdf5f5; } /* rojo muy claro */
table.t tbody tr:hover { background: #fce8e8; }
table.t td {
    padding: 11px 16px;
    font-size: 13px;
    color: var(--texto-mid);
    vertical-align: middle;
}

/* ─── Botones de acción ─── */
.ac-btn {
    width: 30px;
    height: 30px;
    border-radius: 7px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    transition: all .2s;
    border: none;
    cursor: pointer;
    text-decoration: none;
    margin: 0 2px;
}
.ac-btn:hover { transform: scale(1.1); text-decoration: none; }

/* Editar — tono cálido rojizo suave */
.ab-info { background: #fce8e8; color: var(--rojo); }
.ab-info:hover { background: var(--rojo); color: white; }

/* PDF — rojo más intenso */
.ab-pdf { background: #fee2e2; color: #dc2626; }
.ab-pdf:hover { background: #dc2626; color: white; }

/* Eliminar — rojo oscuro */
.ab-del { background: #fef2f2; color: #b91c1c; }
.ab-del:hover { background: #b91c1c; color: white; }

/* ─── Badges de estado ─── */
.badge-e {
    padding: 3px 9px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
    white-space: nowrap;
}
.be-green { background: #dcfce7; color: #15803d; }
.be-red { background: #fee2e2; color: #dc2626; }
.be-yellow { background: #fef9c3; color: #a16207; }
.be-blue { background: #dbeafe; color: #1d4ed8; }

/* ─── Estado vacío ─── */
.empty-state {
    padding: 50px 20px;
    text-align: center;
    color: var(--texto-mid);
}
.empty-state i {
    font-size: 44px;
    color: #cbd5e1;
    display: block;
    margin-bottom: 12px;
}

/* ─── Alertas ─── */
.alert-s {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #bbf7d0;
    border-radius: var(--radio-sm);
    padding: 12px 18px;
    font-size: 13.5px;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
}
.alert-e {
    background: #fee2e2;
    color: #dc2626;
    border: 1px solid #fecaca;
    border-radius: var(--radio-sm);
    padding: 12px 18px;
    font-size: 13.5px;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
}

/* ─── Información del programa ─── */
.info-programa {
    background: white;
    border-radius: var(--radio-sm);
    padding: 15px 20px;
    margin-bottom: 20px;
    border: 1px solid var(--gris-borde);
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}
.info-badge {
    background: var(--rojo-light);
    color: var(--rojo);
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}
.info-badge i { margin-right: 5px; }

/* ─── Responsive ─── */
@media(max-width: 768px) {
    .table-wrap { margin: 0 -16px; }
    table.t td { font-size: 12px; padding: 8px 10px; }
    .ac-btn { width: 26px; height: 26px; font-size: 11px; }
}
</style>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            
            <!-- Encabezado -->
            <div class="page-header">
                <h2><i class="fas fa-calendar-alt"></i> Actividades — Programa Anual <?php echo $programa->anio; ?></h2>
                <div class="d-flex gap-2">
                    <span class="info-badge"><i class="fas fa-flask"></i> <?php echo htmlspecialchars($laboratorio_nombre); ?></span>
                </div>
            </div>

            <!-- Mensajes flash -->
            <?php if($this->session->flashdata('success')): ?>
            <div class="alert-s"><i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?></div>
            <?php endif; ?>
            <?php if($this->session->flashdata('error')): ?>
            <div class="alert-e"><i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <!-- Información del programa -->
            <div class="info-programa">
                <div><strong>Año:</strong> <?php echo $programa->anio; ?></div>
                <div><strong>Actividades:</strong> <?php echo count($actividades); ?> / <?php echo $max_actividades; ?></div>
                <div><strong>Edificio:</strong> <?php echo htmlspecialchars($firmas->edificio ?? 'UD-4 — Campus Principal'); ?></div>
            </div>

            <!-- Botones de acción -->
            <div class="row mb-3">
                <div class="col-md-12 text-right">
                    <button class="btn-r mr-1"
                            data-toggle="modal" data-target="#modalActividad"
                            <?php echo (count($actividades) >= $max_actividades) ? 'disabled title="Máximo 9 actividades"' : ''; ?>>
                        <i class="fas fa-plus"></i> Nueva Actividad
                    </button>
                    <a href="<?php echo base_url('programa-anual/pdf/'.$programa->id); ?>"
                       class="btn-r mr-1" target="_blank">
                        <i class="fas fa-file-pdf"></i> Exportar PDF
                    </a>
                    <a href="<?php echo base_url('programa-anual'); ?>" class="btn-g">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            <!-- Tabla de actividades -->
            <div class="card-m">
                <div class="table-wrap">
                    <table class="t">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Actividad</th>
                                <th>Ene</th><th>Feb</th><th>Mar</th><th>Abr</th><th>May</th><th>Jun</th>
                                <th>Jul</th><th>Ago</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dic</th>
                                <th>Observaciones</th>
                                <th style="text-align:center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($actividades)): ?>
                            <tr>
                                <td colspan="15" class="empty-state">
                                    <i class="fas fa-clipboard-list"></i>
                                    No hay actividades registradas. Presiona "Nueva Actividad".
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach($actividades as $act): 
                                    $mpl = $act->meses_planeados;
                                    $mre = $act->meses_realizados;
                                ?>
                                <tr>
                                    <td><strong><?php echo $act->actividad_id; ?></strong></td>
                                    <td style="max-width:200px;"><?php echo htmlspecialchars($act->actividad_nombre); ?></td>
                                    
                                    <!-- Meses planeados -->
                                    <?php for($m=1;$m<=12;$m++): ?>
                                    <td class="text-center" style="background:#fdf5f5;">
                                        <?php if(in_array($m,$mpl)): ?>
                                        <span style="color:var(--rojo); font-weight:bold; font-size:14px;">✓</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php endfor; ?>
                                    
                                    <td style="max-width:150px;"><?php echo htmlspecialchars($act->observaciones ?? ''); ?></td>
                                    <td style="text-align:center; white-space:nowrap;">
                                        <a href="#" class="ac-btn ab-info btn-editar"
                                           data-id="<?php echo $act->actividad_id; ?>"
                                           data-nombre="<?php echo htmlspecialchars($act->actividad_nombre, ENT_QUOTES); ?>"
                                           data-obs="<?php echo htmlspecialchars($act->observaciones ?? '', ENT_QUOTES); ?>"
                                           data-planeados="<?php echo implode(',',$mpl); ?>"
                                           data-realizados="<?php echo implode(',',$mre); ?>"
                                           title="Editar actividad">
                                           <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo base_url('programa-anual/eliminar_actividad/'.$programa->id.'/'.$act->actividad_id); ?>"
                                           class="ac-btn ab-del" title="Eliminar"
                                           onclick="return confirm('¿Eliminar esta actividad?')">
                                           <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Card de Firmas -->
            <div class="card-m mt-4">
                <div class="page-header" style="margin-bottom:0; border-radius: var(--radio) var(--radio) 0 0;">
                    <h5 style="margin:0; font-size:15px;"></i> Responsables </h5>
                    <small class="text-muted"><i class="fas fa-save"></i> Se guardan automáticamente</small>
                </div>
                <div class="p-3">
                    <form id="formFirmas">
                        <input type="hidden" name="programa_id" value="<?php echo $programa->id; ?>">

                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label class="small fw-bold">Responsable</label>
                                <input type="text" name="responsable" class="form-control form-control-sm"
                                       value="<?php echo htmlspecialchars($firmas->responsable ?? ''); ?>"
                                       placeholder="Nombre del responsable...">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="small fw-bold">Revisó</label>
                                <input type="text" name="revisor" class="form-control form-control-sm"
                                       value="<?php echo htmlspecialchars($firmas->revisor ?? ''); ?>"
                                       placeholder="Director de Programa Educativo">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="small fw-bold">Autorizó</label>
                                <input type="text" name="autorizo" class="form-control form-control-sm"
                                       value="<?php echo htmlspecialchars($firmas->autorizo ?? ''); ?>"
                                       placeholder="Secretaría Académica">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label class="small fw-bold">Primer Cuatrimestre</label>
                                <input type="text" name="primer_cuatrimestre" class="form-control form-control-sm"
                                       value="<?php echo htmlspecialchars($firmas->primer_cuatrimestre ?? ''); ?>"
                                       placeholder="Nombre y firma...">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="small fw-bold">Segundo Cuatrimestre</label>
                                <input type="text" name="segundo_cuatrimestre" class="form-control form-control-sm"
                                       value="<?php echo htmlspecialchars($firmas->segundo_cuatrimestre ?? ''); ?>"
                                       placeholder="Nombre y firma...">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="small fw-bold">Tercer Cuatrimestre</label>
                                <input type="text" name="tercer_cuatrimestre" class="form-control form-control-sm"
                                       value="<?php echo htmlspecialchars($firmas->tercer_cuatrimestre ?? ''); ?>"
                                       placeholder="Nombre y firma...">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="small fw-bold">Edificio / Campus</label>
                                <input type="text" name="edificio" class="form-control form-control-sm"
                                       value="<?php echo htmlspecialchars($firmas->edificio ?? 'UD-4 — Campus Principal'); ?>">
                            </div>
                            <div class="col-md-6 d-flex align-items-end pb-3">
                                <button type="submit" class="btn-r" id="btnGuardarFirmas">
                                    <i class="fas fa-save"></i> Guardar
                                </button>
                                <span id="firmasStatus" class="ml-3" style="display:none;font-size:12px;"></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ═══ MODAL: Nueva / Editar Actividad ═══ -->
<div class="modal fade" id="modalActividad" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #a52119, #8B1A10); color: white;">
                <h5 class="modal-title" style="color: white;" id="tituloModal">
                    <i class="fas fa-plus-circle"></i> Nueva Actividad
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
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
                    <button type="button" class="btn-g" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn-r" id="btnGuardar">
                        <i class="fas fa-save"></i> Guardar Actividad
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    // ── Guardar (AJAX) ────────────────────────────────────
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
                    status.show().html('<i class="fas fa-check-circle" style="color: #a52119;"></i> Firmas guardadas').css('display', 'inline-block');
                    setTimeout(function(){ status.fadeOut(); }, 3000);
                } else {
                    status.show().html('<i class="fas fa-times-circle text-danger"></i> ' + (r.error || 'Error')).css('display', 'inline-block');
                }
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar');
            },
            error: function() {
                status.show().html('<i class="fas fa-times-circle text-danger"></i> Error de conexión').css('display', 'inline-block');
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar');
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
        $('#tituloModal').html('<i class="fas fa-edit" style="color: white;"></i> Editar Actividad #' + $(this).data('id'));
        $('#btnGuardar').html('<i class="fas fa-save"></i> Actualizar');
        $('#modalActividad').modal('show');
    });

    // ── NUEVA ACTIVIDAD — limpiar modal ──────────────────────────
    $('[data-target="#modalActividad"]:not(.btn-editar)').click(function() {
        $('.chk-planeado, .chk-realizado').prop('checked', false);
        $('#input_actividad_nombre').val('');
        $('#input_observaciones').val('');
        $('#tituloModal').html('<i class="fas fa-plus-circle" style="color: white;"></i> Nueva Actividad');
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
                    Swal.fire({ 
                        icon:'success', 
                        title:'¡Guardado!', 
                        timer:1400, 
                        showConfirmButton:false,
                        confirmButtonColor: '#a52119'
                    }).then(function(){ location.reload(); });
                } else {
                    Swal.fire({ 
                        icon:'error', 
                        title:'Error', 
                        text: r.error || 'No se pudo guardar.',
                        confirmButtonColor: '#a52119'
                    });
                    btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Actividad');
                }
            },
            error: function(xhr) {
                Swal.fire({ 
                    icon:'error', 
                    title:'Error de conexión', 
                    text: 'Intenta nuevamente.',
                    confirmButtonColor: '#a52119'
                });
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Actividad');
            }
        });
    });

});
</script>