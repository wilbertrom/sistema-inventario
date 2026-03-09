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
.page-header h2 { font-size: 18px; font-weight: 700; color: var(--texto-dark); margin: 0; }
.page-header h2 i { color: var(--rojo); margin-right: 8px; }

.btn-r {
    background: linear-gradient(135deg, var(--rojo), var(--rojo-mid));
    color: white; border: none; border-radius: var(--radio-sm);
    padding: 9px 18px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center;
    gap: 6px; transition: all .25s; text-decoration: none;
}
.btn-r:hover { box-shadow: 0 5px 15px rgba(165,33,25,.3); transform: translateY(-1px); color: white; text-decoration: none; }

.btn-g {
    background: #f1f5f9; color: var(--texto-mid);
    border: 1.5px solid var(--gris-borde); border-radius: var(--radio-sm);
    padding: 9px 18px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center;
    gap: 6px; transition: all .2s; text-decoration: none;
}
.btn-g:hover { background: #e2e8f0; color: var(--texto-dark); text-decoration: none; }

.card-m {
    background: white; border-radius: var(--radio);
    box-shadow: var(--sombra-sm); border: 1px solid var(--gris-borde);
    overflow: hidden; margin-bottom: 24px;
}
.table-wrap { overflow-x: auto; }
table.t { width: 100%; border-collapse: collapse; min-width: 600px; }
table.t thead th {
    background: var(--rojo-dark); color: white; font-size: 11px;
    font-weight: 600; text-transform: uppercase; letter-spacing: .4px;
    padding: 12px 16px; white-space: nowrap;
}
table.t tbody tr { border-bottom: 1px solid var(--gris-borde); transition: background .15s; }
table.t tbody tr:nth-child(even) { background: #fdf5f5; }
table.t tbody tr:hover { background: #fce8e8; }
table.t td { padding: 11px 16px; font-size: 13px; color: var(--texto-mid); vertical-align: middle; }

.ac-btn {
    width: 30px; height: 30px; border-radius: 7px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 13px; transition: all .2s; border: none;
    cursor: pointer; text-decoration: none; margin: 0 2px;
}
.ac-btn:hover { transform: scale(1.1); text-decoration: none; }
.ab-info { background: #fce8e8; color: var(--rojo); }
.ab-info:hover { background: var(--rojo); color: white; }
.ab-del { background: #fef2f2; color: #b91c1c; }
.ab-del:hover { background: #b91c1c; color: white; }

.empty-state { padding: 50px 20px; text-align: center; color: var(--texto-mid); }
.empty-state i { font-size: 44px; color: #cbd5e1; display: block; margin-bottom: 12px; }

.alert-s { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; border-radius: var(--radio-sm); padding: 12px 18px; font-size: 13.5px; display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
.alert-e { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; border-radius: var(--radio-sm); padding: 12px 18px; font-size: 13.5px; display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }

.info-programa { background: white; border-radius: var(--radio-sm); padding: 15px 20px; margin-bottom: 20px; border: 1px solid var(--gris-borde); display: flex; align-items: center; gap: 15px; flex-wrap: wrap; }
.info-badge { background: #fdf1f0; color: var(--rojo); padding: 5px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; }

/* Dropdown select estilo */
.select-firmante {
    width: 100%;
    border: 1.5px solid var(--gris-borde);
    border-radius: 8px;
    padding: 7px 10px;
    font-size: 13px;
    color: var(--texto-dark);
    background: white;
    outline: none;
    transition: border-color .2s;
    cursor: pointer;
}
.select-firmante:focus { border-color: var(--rojo); }
.lbl-firma { font-size: 12px; font-weight: 600; color: var(--texto-mid); display: block; margin-bottom: 5px; }
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

            <!-- Info programa -->
            <div class="info-programa">
                <div><strong>Año:</strong> <?php echo $programa->anio; ?></div>
                <div><strong>Actividades:</strong> <?php echo count($actividades); ?> / <?php echo $max_actividades; ?></div>
                <div><strong>Edificio:</strong> <?php echo htmlspecialchars($firmas->edificio ?? 'UD-4 — Campus Principal'); ?></div>
            </div>

            <!-- Botones -->
            <div class="row mb-3">
                <div class="col-md-12 text-right">
                    <button class="btn-r mr-1" data-toggle="modal" data-target="#modalActividad"
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
                                    <?php for($m=1;$m<=12;$m++): ?>
                                    <td class="text-center" style="background:#fdf5f5;">
                                        <?php if(in_array($m,$mpl)): ?>
                                        <span style="color:var(--rojo);font-weight:bold;font-size:14px;">✓</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php endfor; ?>
                                    <td style="max-width:150px;"><?php echo htmlspecialchars($act->observaciones ?? ''); ?></td>
                                    <td style="text-align:center;white-space:nowrap;">
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

            <!-- ══ Card de Firmas con DROPDOWNS ══ -->
            <div class="card-m mt-4">
                <div class="page-header" style="margin-bottom:0; border-radius: var(--radio) var(--radio) 0 0;">
                    <h5 style="margin:0; font-size:15px;"><i class="fas fa-signature" style="color:var(--rojo);margin-right:6px;"></i> Responsables</h5>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Selecciona de la lista o agrega nuevo</small>
                        <!-- Botón para agregar nuevo firmante directo desde aquí -->
                        <button type="button" class="btn-r" style="padding:6px 12px;font-size:12px;"
                                data-toggle="modal" data-target="#modalNuevoFirmante">
                            <i class="fas fa-user-plus"></i> Agregar nombre
                        </button>
                    </div>
                </div>
                <div class="p-3">
                    <form id="formFirmas">
                        <input type="hidden" name="programa_id" value="<?php echo $programa->id; ?>">

                        <div class="row">
                            <!-- Responsable -->
                            <div class="col-md-4 mb-3">
                                <label class="lbl-firma"><i class="fas fa-user-tie mr-1" style="color:var(--rojo);"></i> Responsable (Jefe de Laboratorio)</label>
                                <select name="responsable" class="select-firmante">
                                    <option value="">— Selecciona —</option>
                                    <?php foreach($firmantes_responsable as $f): ?>
                                    <option value="<?php echo htmlspecialchars($f->nombre); ?>"
                                        <?php echo (isset($firmas->responsable) && $firmas->responsable == $f->nombre) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($f->nombre); ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php
                                    // Si el valor guardado no está en la lista, igual lo mostramos
                                    $nombres_resp = array_map(function($f){ return $f->nombre; }, (array)$firmantes_responsable);
                                    if(!empty($firmas->responsable) && !in_array($firmas->responsable, $nombres_resp)): ?>
                                    <option value="<?php echo htmlspecialchars($firmas->responsable); ?>" selected>
                                        <?php echo htmlspecialchars($firmas->responsable); ?>
                                    </option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <!-- Revisó -->
                            <div class="col-md-4 mb-3">
                                <label class="lbl-firma"><i class="fas fa-check-double mr-1" style="color:#15803d;"></i> Revisó (Vo. Bo.)</label>
                                <select name="revisor" class="select-firmante">
                                    <option value="">— Selecciona —</option>
                                    <?php foreach($firmantes_revisor as $f): ?>
                                    <option value="<?php echo htmlspecialchars($f->nombre); ?>"
                                        <?php echo (isset($firmas->revisor) && $firmas->revisor == $f->nombre) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($f->nombre); ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php
                                    $nombres_rev = array_map(function($f){ return $f->nombre; }, (array)$firmantes_revisor);
                                    if(!empty($firmas->revisor) && !in_array($firmas->revisor, $nombres_rev)): ?>
                                    <option value="<?php echo htmlspecialchars($firmas->revisor); ?>" selected>
                                        <?php echo htmlspecialchars($firmas->revisor); ?>
                                    </option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <!-- Autorizó -->
                            <div class="col-md-4 mb-3">
                                <label class="lbl-firma"><i class="fas fa-stamp mr-1" style="color:#7e22ce;"></i> Autorizó</label>
                                <select name="autorizo" class="select-firmante">
                                    <option value="">— Selecciona —</option>
                                    <?php foreach($firmantes_autorizo as $f): ?>
                                    <option value="<?php echo htmlspecialchars($f->nombre); ?>"
                                        <?php echo (isset($firmas->autorizo) && $firmas->autorizo == $f->nombre) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($f->nombre); ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php
                                    $nombres_aut = array_map(function($f){ return $f->nombre; }, (array)$firmantes_autorizo);
                                    if(!empty($firmas->autorizo) && !in_array($firmas->autorizo, $nombres_aut)): ?>
                                    <option value="<?php echo htmlspecialchars($firmas->autorizo); ?>" selected>
                                        <?php echo htmlspecialchars($firmas->autorizo); ?>
                                    </option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Primer Cuatrimestre -->
                            <div class="col-md-4 mb-3">
                                <label class="lbl-firma">Primer Cuatrimestre</label>
                                <select name="primer_cuatrimestre" class="select-firmante">
                                    <option value="">— Selecciona —</option>
                                    <?php foreach($firmantes_cuatrimestre as $f): ?>
                                    <option value="<?php echo htmlspecialchars($f->nombre); ?>"
                                        <?php echo (isset($firmas->primer_cuatrimestre) && $firmas->primer_cuatrimestre == $f->nombre) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($f->nombre); ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php
                                    $nombres_cuat = array_map(function($f){ return $f->nombre; }, (array)$firmantes_cuatrimestre);
                                    if(!empty($firmas->primer_cuatrimestre) && !in_array($firmas->primer_cuatrimestre, $nombres_cuat)): ?>
                                    <option value="<?php echo htmlspecialchars($firmas->primer_cuatrimestre); ?>" selected>
                                        <?php echo htmlspecialchars($firmas->primer_cuatrimestre); ?>
                                    </option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <!-- Segundo Cuatrimestre -->
                            <div class="col-md-4 mb-3">
                                <label class="lbl-firma">Segundo Cuatrimestre</label>
                                <select name="segundo_cuatrimestre" class="select-firmante">
                                    <option value="">— Selecciona —</option>
                                    <?php foreach($firmantes_cuatrimestre as $f): ?>
                                    <option value="<?php echo htmlspecialchars($f->nombre); ?>"
                                        <?php echo (isset($firmas->segundo_cuatrimestre) && $firmas->segundo_cuatrimestre == $f->nombre) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($f->nombre); ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php if(!empty($firmas->segundo_cuatrimestre) && !in_array($firmas->segundo_cuatrimestre, $nombres_cuat)): ?>
                                    <option value="<?php echo htmlspecialchars($firmas->segundo_cuatrimestre); ?>" selected>
                                        <?php echo htmlspecialchars($firmas->segundo_cuatrimestre); ?>
                                    </option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <!-- Tercer Cuatrimestre -->
                            <div class="col-md-4 mb-3">
                                <label class="lbl-firma">Tercer Cuatrimestre</label>
                                <select name="tercer_cuatrimestre" class="select-firmante">
                                    <option value="">— Selecciona —</option>
                                    <?php foreach($firmantes_cuatrimestre as $f): ?>
                                    <option value="<?php echo htmlspecialchars($f->nombre); ?>"
                                        <?php echo (isset($firmas->tercer_cuatrimestre) && $firmas->tercer_cuatrimestre == $f->nombre) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($f->nombre); ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php if(!empty($firmas->tercer_cuatrimestre) && !in_array($firmas->tercer_cuatrimestre, $nombres_cuat)): ?>
                                    <option value="<?php echo htmlspecialchars($firmas->tercer_cuatrimestre); ?>" selected>
                                        <?php echo htmlspecialchars($firmas->tercer_cuatrimestre); ?>
                                    </option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="lbl-firma">Edificio / Campus</label>
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

<!-- ══ MODAL: Nueva / Editar Actividad ══ -->
<div class="modal fade" id="modalActividad" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#a52119,#8B1A10);color:white;">
                <h5 class="modal-title" style="color:white;" id="tituloModal">
                    <i class="fas fa-plus-circle"></i> Nueva Actividad
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color:white;">&times;</button>
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

<!-- ══ MODAL: Agregar nuevo firmante ══ -->
<div class="modal fade" id="modalNuevoFirmante" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="border-radius:14px;overflow:hidden;border:none;">
            <div class="modal-header" style="background:linear-gradient(135deg,#8B1A10,#a52119);border:none;padding:18px 22px;">
                <h5 class="modal-title" style="color:white;font-weight:700;">
                    <i class="fas fa-user-plus mr-2"></i> Agregar nuevo firmante
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color:white;">&times;</button>
            </div>
            <div class="modal-body" style="padding:22px;">
                <form id="formNuevoFirmante">
                    <div class="form-group">
                        <label class="lbl-firma">Nombre completo <span class="text-danger">*</span></label>
                        <input type="text" id="nf_nombre" class="form-control" placeholder="Ej: Dr. Juan Pérez López" required>
                    </div>
                    <div class="form-group">
                        <label class="lbl-firma">Cargo <span class="text-danger">*</span></label>
                        <input type="text" id="nf_cargo" class="form-control" placeholder="Ej: Director de Programa Educativo" required>
                    </div>
                    <div class="form-group">
                        <label class="lbl-firma">Rol en los formatos <span class="text-danger">*</span></label>
                        <select id="nf_rol" class="form-control" required>
                            <option value="">— Selecciona un rol —</option>
                            <option value="jefe_laboratorio">Jefe de Laboratorio (Responsable)</option>
                            <option value="vo_bo">Vo. Bo. / Revisó</option>
                            <option value="autorizo">Autorizó</option>
                            <option value="cuatrimestre">Responsable Cuatrimestral</option>
                        </select>
                    </div>
                    <div style="display:flex;gap:10px;margin-top:16px;">
                        <button type="button" class="btn-g" data-dismiss="modal" style="flex:1;justify-content:center;">Cancelar</button>
                        <button type="submit" class="btn-r" style="flex:1;justify-content:center;" id="btnGuardarFirmante">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    var BASE_URL   = '<?php echo base_url(); ?>';
    var LAB_ID     = '<?php echo $this->session->userdata("laboratorio_id"); ?>';

    // ── Guardar firmas ────────────────────────────────────
    $('#formFirmas').submit(function(e) {
        e.preventDefault();
        var btn = $('#btnGuardarFirmas');
        var status = $('#firmasStatus');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

        $.ajax({
            url: '<?php echo base_url("programa-anual/guardar_firmas"); ?>',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(r) {
                if (r.success) {
                    status.show().html('<i class="fas fa-check-circle" style="color:#a52119;"></i> Firmas guardadas').css('display','inline-block');
                    setTimeout(function(){ status.fadeOut(); }, 3000);
                } else {
                    status.show().html('<i class="fas fa-times-circle text-danger"></i> ' + (r.error || 'Error')).css('display','inline-block');
                }
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar firmas');
            },
            error: function() {
                status.show().html('<i class="fas fa-times-circle text-danger"></i> Error de conexión').css('display','inline-block');
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar firmas');
            }
        });
    });

    // ── Guardar NUEVO FIRMANTE desde modal ───────────────
    $('#formNuevoFirmante').submit(function(e) {
        e.preventDefault();
        var btn = $('#btnGuardarFirmante');
        var nombre = $('#nf_nombre').val().trim();
        var cargo  = $('#nf_cargo').val().trim();
        var rol    = $('#nf_rol').val();

        if (!nombre || !cargo || !rol) {
            alert('Completa todos los campos.');
            return;
        }

        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');

        $.ajax({
            url: BASE_URL + 'firmantes/crear_ajax',
            method: 'POST',
            data: {
                nombre: nombre,
                cargo:  cargo,
                rol:    rol,
                laboratorio_id: (rol === 'jefe_laboratorio') ? LAB_ID : ''
            },
            dataType: 'json',
            success: function(r) {
                if (r.success) {
                    // Agregar el nuevo nombre a todos los selects del rol correspondiente
                    var selectMap = {
                        'jefe_laboratorio': '[name="responsable"]',
                        'vo_bo':            '[name="revisor"]',
                        'autorizo':         '[name="autorizo"]',
                        'cuatrimestre':     '[name="primer_cuatrimestre"],[name="segundo_cuatrimestre"],[name="tercer_cuatrimestre"]'
                    };
                    var selectors = selectMap[rol];
                    if (selectors) {
                        $(selectors).each(function() {
                            $(this).append('<option value="' + nombre + '" selected>' + nombre + '</option>');
                        });
                    }
                    $('#modalNuevoFirmante').modal('hide');
                    $('#nf_nombre, #nf_cargo').val('');
                    $('#nf_rol').val('');
                    // Mostrar confirmación
                    var alerta = $('<div class="alert-s" style="margin-top:10px;"><i class="fas fa-check-circle"></i> Firmante "' + nombre + '" agregado correctamente.</div>');
                    $('.card-m.mt-4').before(alerta);
                    setTimeout(function(){ alerta.fadeOut(400, function(){ $(this).remove(); }); }, 3000);
                } else {
                    alert(r.error || 'Error al guardar');
                }
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar');
            },
            error: function() {
                alert('Error de conexión');
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar');
            }
        });
    });

    // ── Editar actividad ──────────────────────────────────
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
        $('#tituloModal').html('<i class="fas fa-edit" style="color:white;"></i> Editar Actividad #' + $(this).data('id'));
        $('#btnGuardar').html('<i class="fas fa-save"></i> Actualizar');
        $('#modalActividad').modal('show');
    });

    // ── Nueva actividad — limpiar modal ──────────────────
    $('[data-target="#modalActividad"]:not(.btn-editar)').click(function() {
        $('.chk-planeado, .chk-realizado').prop('checked', false);
        $('#input_actividad_nombre').val('');
        $('#input_observaciones').val('');
        $('#tituloModal').html('<i class="fas fa-plus-circle" style="color:white;"></i> Nueva Actividad');
        $('#btnGuardar').html('<i class="fas fa-save"></i> Guardar Actividad');
        $('#input_actividad_id').val(<?php echo count($actividades) + 1; ?>);
    });

    // ── Guardar actividad (AJAX) ──────────────────────────
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
                        icon:'success', title:'¡Guardado!',
                        timer:1400, showConfirmButton:false,
                        confirmButtonColor:'#a52119'
                    }).then(function(){ location.reload(); });
                } else {
                    Swal.fire({ icon:'error', title:'Error', text: r.error || 'No se pudo guardar.', confirmButtonColor:'#a52119' });
                    btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Actividad');
                }
            },
            error: function() {
                Swal.fire({ icon:'error', title:'Error de conexión', text:'Intenta nuevamente.', confirmButtonColor:'#a52119' });
                btn.prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Actividad');
            }
        });
    });

});
</script>