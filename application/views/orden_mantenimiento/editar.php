<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
:root{--rojo:#a52119;--rojo-mid:#c0392b;--azul:#1F497D;--gris-bg:#f5f6f8;--gris-borde:#e2e8f0;--texto-dark:#1e293b;--texto-mid:#475569;--sombra-sm:0 2px 8px rgba(0,0,0,0.06);--radio:14px;--radio-sm:8px;}
.main-content{background:var(--gris-bg);min-height:calc(100vh - 81px);}
.section__content--p30{padding:20px 16px;}
@media(min-width:768px){.section__content--p30{padding:28px;}}
.page-header{background:white;border-radius:var(--radio);padding:16px 20px;margin-bottom:18px;box-shadow:var(--sombra-sm);display:flex;align-items:center;justify-content:space-between;border-left:4px solid var(--rojo);flex-wrap:wrap;gap:10px;}
.page-header h2{font-size:18px;font-weight:700;color:var(--texto-dark);margin:0;}
.page-header .acciones{display:flex;gap:8px;flex-wrap:wrap;}
.section-card{background:white;border-radius:var(--radio);box-shadow:var(--sombra-sm);border:1px solid var(--gris-borde);overflow:hidden;margin-bottom:20px;}
.section-card-header{padding:14px 20px;font-weight:700;font-size:14px;display:flex;align-items:center;gap:8px;}
.sec-a{border-top:3px solid #333399;}.sec-a .section-card-header{background:#f0f0ff;color:#333399;}
.sec-b{border-top:3px solid var(--azul);}.sec-b .section-card-header{background:#f0f4fa;color:var(--azul);}
.section-card-body{padding:20px;}
.f-label{font-size:13px;font-weight:600;color:var(--texto-dark);margin-bottom:6px;display:block;}
.f-control{border:1.5px solid var(--gris-borde);border-radius:var(--radio-sm);padding:10px 14px;font-size:13.5px;color:var(--texto-dark);width:100%;background:white;transition:border-color .2s;}
.f-control:focus{border-color:var(--rojo);box-shadow:0 0 0 3px rgba(165,33,25,.1);outline:none;}
.f-group{margin-bottom:16px;}
.divider{height:1px;background:var(--gris-borde);margin:20px 0;}
.form-actions{display:flex;gap:10px;flex-wrap:wrap;}
.btn-r{background:linear-gradient(135deg,var(--rojo),var(--rojo-mid));color:white;border:none;border-radius:var(--radio-sm);padding:9px 20px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;transition:all .25s;text-decoration:none;white-space:nowrap;}
.btn-r:hover{box-shadow:0 5px 15px rgba(165,33,25,.3);transform:translateY(-1px);color:white;}
.btn-azul{background:linear-gradient(135deg,#1F497D,#2563eb);color:white;border:none;border-radius:var(--radio-sm);padding:9px 20px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;text-decoration:none;white-space:nowrap;}
.btn-azul:hover{opacity:.9;color:white;}
.btn-g{background:#f1f5f9;color:var(--texto-mid);border:1.5px solid var(--gris-borde);border-radius:var(--radio-sm);padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;text-decoration:none;white-space:nowrap;}
.btn-g:hover{background:#e2e8f0;color:var(--texto-dark);}
.alert-s{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0;border-radius:var(--radio-sm);padding:12px 18px;font-size:13px;display:flex;align-items:center;gap:10px;margin-bottom:16px;}
.alert-e{background:#fee2e2;color:#dc2626;border:1px solid #fecaca;border-radius:var(--radio-sm);padding:12px 18px;font-size:13px;display:flex;align-items:center;gap:10px;margin-bottom:16px;}
/* Tabla trabajos */
table.tw{width:100%;border-collapse:collapse;font-size:12.5px;}
table.tw thead th{background:#1e293b;color:white;padding:10px 12px;font-size:11px;text-transform:uppercase;letter-spacing:.4px;white-space:nowrap;}
table.tw tbody tr{border-bottom:1px solid var(--gris-borde);}
table.tw td{padding:9px 12px;color:var(--texto-mid);vertical-align:middle;}
.chk-box{display:inline-flex;align-items:center;gap:6px;cursor:pointer;font-size:13px;font-weight:600;}
.chk-box input{width:16px;height:16px;accent-color:var(--rojo);}
</style>

<div class="main-content">
<div class="section__content section__content--p30">
<div class="container-fluid">

    <div class="page-header">
        <h2><i class="fas fa-tools"></i> Orden de Mantenimiento #<?php echo $orden->id; ?></h2>
        <div class="acciones">
            <a href="<?php echo base_url('orden-mantenimiento/pdf/'.$orden->id); ?>"
               class="btn-r" target="_blank">
               <i class="fas fa-file-pdf"></i> PDF</a>
            <a href="<?php echo base_url('orden-mantenimiento'); ?>" class="btn-g">
               <i class="fas fa-arrow-left"></i> Volver</a>
        </div>
    </div>

    <?php if($this->session->flashdata('success')): ?>
    <div class="alert-s"><i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?></div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
    <div class="alert-e"><i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <!-- ══ SECCIÓN A — DATOS DE LA ORDEN ══ -->
    <div class="section-card sec-a">
        <div class="section-card-header">
            <i class="fas fa-clipboard"></i> A) Orden de Mantenimiento — Solicitante
        </div>
        <div class="section-card-body">
            <form action="<?php echo base_url('orden-mantenimiento/actualizar/'.$orden->id); ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-5">
                        <div class="f-group">
                            <label class="f-label">Área solicitante</label>
                            <input type="text" name="area_solicitante" class="f-control"
                                   value="<?php echo htmlspecialchars($orden->area_solicitante ?? ''); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="f-group">
                            <label class="f-label">Nombre del solicitante</label>
                            <input type="text" name="solicitante" class="f-control"
                                   value="<?php echo htmlspecialchars($orden->solicitante ?? ''); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="f-group">
                            <label class="f-label">Fecha de elaboración</label>
                            <input type="date" name="fecha_elaboracion" class="f-control"
                                   value="<?php echo $orden->fecha_elaboracion ?? ''; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="f-group">
                            <label class="f-label">Descripción del servicio solicitado</label>
                            <textarea name="descripcion_servicio" class="f-control" rows="3"><?php echo htmlspecialchars($orden->descripcion_servicio ?? ''); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="f-group">
                            <label class="f-label">Especificación técnica / Proyección técnica</label>
                            <textarea name="especificacion_tecnica" class="f-control" rows="3"><?php echo htmlspecialchars($orden->especificacion_tecnica ?? ''); ?></textarea>
                        </div>
                        <div class="f-group">
                            <label class="f-label">
                                Imagen de especificación
                                <span style="font-weight:400;color:#64748b;font-size:11px;">(aparece bajo el texto en el PDF)</span>
                            </label>
                            <?php if(!empty($orden->especificacion_imagen)): ?>
                            <div id="imgActualWrap" style="margin-bottom:8px;">
                                <img src="<?php echo base_url('recursos-panel/images/ordenes/'.$orden->especificacion_imagen); ?>"
                                     style="max-height:130px;max-width:100%;border-radius:8px;border:1px solid #e2e8f0;">
                                <br>
                                <label style="font-size:12px;color:#dc2626;margin-top:6px;cursor:pointer;">
                                    <input type="checkbox" name="quitar_imagen" value="1"
                                           onchange="document.getElementById('imgActualWrap').style.opacity=this.checked?'0.3':'1'">
                                    Eliminar imagen actual
                                </label>
                            </div>
                            <?php endif; ?>
                            <div class="upload-area">
                                <input type="file" name="especificacion_imagen" id="esp_img_edit"
                                       accept="image/jpeg,image/png,image/gif"
                                       style="display:none;" onchange="previewImgEdit(this)">
                                <div id="upPlaceholderEdit"
                                     onclick="document.getElementById('esp_img_edit').click()"
                                     style="cursor:pointer;padding:14px;text-align:center;border:2px dashed #cbd5e1;border-radius:10px;color:#94a3b8;"
                                     onmouseover="this.style.borderColor='#a52119'" onmouseout="this.style.borderColor='#cbd5e1'">
                                    <i class="fa fa-image" style="font-size:22px;color:#cbd5e1;display:block;margin-bottom:6px;"></i>
                                    <span style="font-size:12px;"><?php echo !empty($orden->especificacion_imagen) ? 'Reemplazar imagen' : 'Subir imagen'; ?></span>
                                </div>
                                <div id="imgPreviewEditWrap" style="display:none;text-align:center;padding:8px;">
                                    <img id="imgPreviewEdit" src="" style="max-height:120px;max-width:100%;border-radius:8px;border:1px solid #e2e8f0;">
                                    <br>
                                    <button type="button" onclick="quitarPreviewEdit()"
                                            style="margin-top:6px;background:#fee2e2;color:#dc2626;border:none;border-radius:6px;padding:4px 12px;font-size:12px;cursor:pointer;">
                                        <i class="fa fa-times"></i> Quitar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
                <p style="font-size:13px;font-weight:700;color:#1e293b;margin-bottom:14px;">
                    <i class="fa fa-signature" style="color:#333399;"></i> Firmantes del documento
                </p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="f-group">
                            <label class="f-label">Responsable de Mantenimiento</label>
                            <input type="text" name="responsable_mantenimiento" class="f-control"
                                   value="<?php echo htmlspecialchars($orden->responsable_mantenimiento ?? ''); ?>"
                                   placeholder="Nombre del responsable de mantenimiento">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="f-group">
                            <label class="f-label">Verificado por</label>
                            <input type="text" name="verificado_por" class="f-control"
                                   value="<?php echo htmlspecialchars($orden->verificado_por ?? ''); ?>"
                                   placeholder="Nombre de quien verifica">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-r"><i class="fas fa-save"></i> Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ══ SECCIÓN B — TRABAJOS ══ -->
    <div class="section-card sec-b">
        <div class="section-card-header">
            <i class="fas fa-wrench"></i> B) Orden del Trabajo — Área de Mantenimiento
        </div>
        <div class="section-card-body">

            <?php if(!empty($trabajos)): ?>
            <div class="table-responsive" style="margin-bottom:20px;">
            <table class="tw">
                <thead>
                    <tr>
                        <th>Mantenimiento</th>
                        <th>Tipo de servicio</th>
                        <th>Asignado a</th>
                        <th>Empresa / Contratista</th>
                        <th>Costo</th>
                        <th>Fecha realización</th>
                        <th>Trabajo realizado</th>
                        <th>Materiales</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($trabajos as $t): ?>
                <tr>
                    <td><?php echo $t->tipo_mantenimiento; ?></td>
                    <td><?php echo htmlspecialchars($t->tipo_servicio ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($t->asignado_a ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($t->empresa_contratista ?? ''); ?></td>
                    <td>$<?php echo number_format((float)$t->costo, 2); ?></td>
                    <td><?php echo !empty($t->fecha_realizacion) ? date('d/m/Y', strtotime($t->fecha_realizacion)) : ''; ?></td>
                    <td style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
                        title="<?php echo htmlspecialchars($t->trabajo_realizado ?? ''); ?>">
                        <?php echo htmlspecialchars($t->trabajo_realizado ?? ''); ?>
                    </td>
                    <td style="max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
                        title="<?php echo htmlspecialchars($t->materiales_utilizados ?? ''); ?>">
                        <?php echo htmlspecialchars($t->materiales_utilizados ?? ''); ?>
                    </td>
                    <td>
                        <a href="<?php echo base_url('orden-trabajo/eliminar/'.$t->id); ?>"
                           style="color:#dc2626;font-size:13px;"
                           onclick="return confirm('¿Eliminar este trabajo?')" title="Eliminar">
                           <i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            <?php endif; ?>

            <!-- Formulario agregar trabajo -->
            <div style="background:#f8fafc;border-radius:10px;padding:18px;border:1.5px dashed var(--gris-borde);">
                <p style="font-size:13px;font-weight:700;color:var(--texto-dark);margin-bottom:14px;">
                    <i class="fas fa-plus-circle" style="color:var(--azul);"></i>
                    Agregar trabajo realizado
                </p>
                <form action="<?php echo base_url('orden-trabajo/crear'); ?>" method="post">
                    <input type="hidden" name="orden_id" value="<?php echo $orden->id; ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="f-group">
                                <label class="f-label">Tipo de mantenimiento</label>
                                <select name="tipo_mantenimiento" class="f-control">
                                    <option value="INTERNO">Interno</option>
                                    <option value="EXTERNO">Externo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="f-group">
                                <label class="f-label">Tipo de servicio</label>
                                <input type="text" name="tipo_servicio" class="f-control"
                                       placeholder="Ej: Preventivo, Correctivo...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="f-group">
                                <label class="f-label">Asignado a</label>
                                <input type="text" name="asignado_a" class="f-control"
                                       placeholder="Nombre del técnico">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="f-group">
                                <label class="f-label">Empresa o contratista</label>
                                <input type="text" name="empresa_contratista" class="f-control"
                                       placeholder="Nombre empresa (si aplica)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="f-group">
                                <label class="f-label">Costo ($)</label>
                                <input type="number" name="costo" class="f-control"
                                       step="0.01" min="0" value="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="f-group">
                                <label class="f-label">Fecha de realización</label>
                                <input type="date" name="fecha_realizacion" class="f-control"
                                       value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="f-group">
                                <label class="f-label">Trabajo realizado</label>
                                <textarea name="trabajo_realizado" class="f-control" rows="2"
                                          placeholder="Describe el trabajo que se realizó..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="f-group">
                        <label class="f-label">Materiales utilizados</label>
                        <textarea name="materiales_utilizados" class="f-control" rows="2"
                                  placeholder="Lista los materiales utilizados..."></textarea>
                    </div>
                    <button type="submit" class="btn-azul">
                        <i class="fas fa-plus"></i> Agregar trabajo
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>
</div>
</div>

<script>
function previewImgEdit(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imgPreviewEdit').src = e.target.result;
            document.getElementById('imgPreviewEditWrap').style.display = 'block';
            document.getElementById('upPlaceholderEdit').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function quitarPreviewEdit() {
    document.getElementById('esp_img_edit').value = '';
    document.getElementById('imgPreviewEditWrap').style.display = 'none';
    document.getElementById('upPlaceholderEdit').style.display = 'block';
}
</script>