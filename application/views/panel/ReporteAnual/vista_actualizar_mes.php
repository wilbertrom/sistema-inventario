<style>
:root{--rojo:#a52119;--rojo-mid:#c0392b;--rojo-light:#fdf1f0;--gris-bg:#f5f6f8;--gris-borde:#e2e8f0;--texto-dark:#1e293b;--texto-mid:#475569;--sombra-sm:0 2px 8px rgba(0,0,0,0.06);--radio:14px;}
.main-content{background:var(--gris-bg);min-height:calc(100vh - 81px);}
.section__content--p30{padding:28px;}
.page-header{background:white;border-radius:var(--radio);padding:20px 26px;margin-bottom:22px;box-shadow:var(--sombra-sm);display:flex;align-items:center;justify-content:space-between;border-left:4px solid var(--rojo);}
.page-header h2{font-size:20px;font-weight:700;color:var(--texto-dark);margin:0;}
.page-header h2 i{color:var(--rojo);margin-right:10px;}
.card-m{background:white;border-radius:var(--radio);box-shadow:var(--sombra-sm);border:1px solid var(--gris-borde);overflow:hidden;max-width:780px;margin:0 auto 24px;}
.card-head{padding:18px 24px;border-bottom:1px solid var(--gris-borde);background:#fafbfc;display:flex;align-items:center;justify-content:space-between;}
.card-head h4{margin:0;font-size:16px;font-weight:700;color:var(--texto-dark);}
.card-body-p{padding:24px;}
.servicio-row{display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid #f1f5f9;}
.servicio-row:last-child{border-bottom:none;}
.servicio-nombre{font-size:14px;color:var(--texto-dark);font-weight:500;flex:1;padding-right:16px;}
.radio-group{display:flex;gap:20px;}
.radio-opt{display:flex;align-items:center;gap:6px;cursor:pointer;}
.radio-opt input[type=radio]{accent-color:var(--rojo);width:16px;height:16px;cursor:pointer;}
.radio-opt label{font-size:13px;font-weight:600;cursor:pointer;margin:0;}
.radio-si label{color:#15803d;}
.radio-no label{color:#dc2626;}
.radio-na label{color:#6b7280;}
.btn-r{background:linear-gradient(135deg,var(--rojo),var(--rojo-mid));color:white;border:none;border-radius:8px;padding:10px 22px;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .25s;text-decoration:none;}
.btn-r:hover{box-shadow:0 6px 18px rgba(165,33,25,.3);transform:translateY(-1px);color:white;}
.btn-g{background:#f1f5f9;color:var(--texto-mid);border:1.5px solid var(--gris-borde);border-radius:8px;padding:10px 22px;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .2s;text-decoration:none;}
.btn-g:hover{background:#e2e8f0;color:var(--texto-dark);text-decoration:none;}
.form-actions{display:flex;gap:12px;margin-top:24px;padding-top:20px;border-top:1px solid var(--gris-borde);}
.lbl{font-size:13px;font-weight:600;color:var(--texto-dark);display:block;margin-bottom:6px;}
.inp{width:100%;border:1.5px solid var(--gris-borde);border-radius:8px;padding:9px 13px;font-size:13.5px;color:var(--texto-dark);outline:none;transition:border-color .2s;background:white;}
.inp:focus{border-color:var(--rojo);}
.sel-firmante{width:100%;border:1.5px solid var(--gris-borde);border-radius:8px;padding:9px 13px;font-size:13.5px;color:var(--texto-dark);outline:none;background:white;cursor:pointer;transition:border-color .2s;}
.sel-firmante:focus{border-color:var(--rojo);}
.fecha-highlight{background:#fef9c3;border:1.5px solid #fbbf24;border-radius:8px;padding:9px 13px;font-size:13.5px;font-weight:600;color:#92400e;outline:none;transition:all .2s;width:100%;}
.fecha-highlight:focus{border-color:#f59e0b;box-shadow:0 0 0 3px rgba(251,191,36,.2);}
.seccion-titulo{font-size:12px;font-weight:700;color:var(--texto-mid);text-transform:uppercase;letter-spacing:.5px;margin:20px 0 8px;padding-bottom:6px;border-bottom:2px solid var(--gris-borde);}
</style>

<div class="main-content">
<div class="section__content section__content--p30">
<div class="container-fluid">

    <div class="page-header">
        <h2><i class="fas fa-clipboard-list"></i> Actualizar Mes</h2>
        <a href="<?php echo base_url('reporteservicios'); ?>" class="btn-g" style="padding:8px 16px;font-size:13px;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <form action="<?php echo site_url('ReporteServicios/actualizar_servicios'); ?>" method="post">
        <input type="hidden" name="reporte_id" value="<?php echo $reporte_id; ?>">
        <input type="hidden" name="mes" value="<?php echo $mes; ?>">

        <!-- Card: Fecha del mes -->
        <div class="card-m">
            <div class="card-head">
                <h4><i class="fas fa-calendar-alt" style="color:var(--rojo);margin-right:8px;"></i>
                    <?php
                    $meses_nombres=[1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',
                                    7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'];
                    echo isset($meses_nombres[$mes]) ? $meses_nombres[$mes] : 'Mes '.$mes;
                    ?>
                </h4>
            </div>
            <div class="card-body-p">
                <div class="row">
                    <div class="col-md-4">
                        <label class="lbl"><i class="fas fa-calendar-day" style="color:#f59e0b;margin-right:5px;"></i> Fecha de verificación</label>
                        <input type="date" name="fecha_mes" class="fecha-highlight"
                               value="<?php echo $fecha_mes ?? ''; ?>"
                               placeholder="dd/mm/aaaa">
                        <small style="color:#92400e;font-size:11px;margin-top:4px;display:block;">
                            <i class="fas fa-info-circle"></i> Esta fecha aparecerá en la fila "Día" del PDF
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Servicios -->
        <div class="card-m">
            <div class="card-head">
                <h4><i class="fas fa-list-check" style="color:var(--rojo);margin-right:8px;"></i> Servicios del mes</h4>
            </div>
            <div class="card-body-p">
                <?php
                $cat_actual = '';
                foreach($servicios as $servicio):
                    // Agrupar por categoría si el servicio tiene categoria_nombre
                    if(isset($servicio->nombre_categoria) && $servicio->nombre_categoria !== $cat_actual):
                        $cat_actual = $servicio->nombre_categoria;
                ?>
                <div class="seccion-titulo"><?php echo htmlspecialchars($cat_actual); ?></div>
                <?php endif; ?>

                <?php $estado = isset($estados_servicios[$servicio->id]) ? $estados_servicios[$servicio->id] : ''; ?>
                <div class="servicio-row">
                    <span class="servicio-nombre"><?php echo htmlspecialchars($servicio->nombre_servicio); ?></span>
                    <div class="radio-group">
                        <label class="radio-opt radio-si">
                            <input type="radio" name="servicio_<?php echo $servicio->id; ?>" value="SI" required
                                   <?php echo ($estado==='SI')?'checked':''; ?>>
                            <label>SI</label>
                        </label>
                        <label class="radio-opt radio-no">
                            <input type="radio" name="servicio_<?php echo $servicio->id; ?>" value="NO"
                                   <?php echo ($estado==='NO')?'checked':''; ?>>
                            <label>NO</label>
                        </label>
                        <label class="radio-opt radio-na">
                            <input type="radio" name="servicio_<?php echo $servicio->id; ?>" value="NA"
                                   <?php echo ($estado==='NA')?'checked':''; ?>>
                            <label>N/A</label>
                        </label>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Card: Observaciones -->
        <div class="card-m">
            <div class="card-head">
                <h4><i class="fas fa-comment-alt" style="color:var(--rojo);margin-right:8px;"></i> Observaciones</h4>
            </div>
            <div class="card-body-p">
                <textarea name="observaciones" class="inp" rows="4"
                          placeholder="Escribe las observaciones del mes..."
                          style="resize:vertical;"><?php echo htmlspecialchars($observaciones ?? ''); ?></textarea>
            </div>
        </div>

        <!-- Card: Firmantes -->
        <div class="card-m">
            <div class="card-head">
                <h4><i class="fas fa-signature" style="color:var(--rojo);margin-right:8px;"></i> Responsables</h4>
                <button type="button" class="btn-r" style="padding:6px 12px;font-size:12px;"
                        data-toggle="modal" data-target="#modalNuevoFirmante">
                    <i class="fas fa-user-plus"></i> Agregar nombre
                </button>
            </div>
            <div class="card-body-p">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="lbl"><i class="fas fa-user-tie mr-1" style="color:var(--rojo);"></i> Elaboró (Jefe de Laboratorio)</label>
                        <select name="elaboro" class="sel-firmante">
                            <option value="">— Selecciona —</option>
                            <?php foreach($firmantes_elaboro as $f): ?>
                            <option value="<?php echo htmlspecialchars($f->nombre); ?>"
                                <?php echo (isset($elaboro) && $elaboro == $f->nombre) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($f->nombre); ?>
                            </option>
                            <?php endforeach; ?>
                            <?php
                            $nombres_elab = array_map(function($f){ return $f->nombre; }, (array)$firmantes_elaboro);
                            if(!empty($elaboro) && !in_array($elaboro, $nombres_elab)): ?>
                            <option value="<?php echo htmlspecialchars($elaboro); ?>" selected><?php echo htmlspecialchars($elaboro); ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="lbl"><i class="fas fa-check-double mr-1" style="color:#15803d;"></i> Vo. Bo. (Director de Programa Educativo)</label>
                        <select name="vobo" class="sel-firmante">
                            <option value="">— Selecciona —</option>
                            <?php foreach($firmantes_vobo as $f): ?>
                            <option value="<?php echo htmlspecialchars($f->nombre); ?>"
                                <?php echo (isset($vobo) && $vobo == $f->nombre) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($f->nombre); ?>
                            </option>
                            <?php endforeach; ?>
                            <?php
                            $nombres_vobo = array_map(function($f){ return $f->nombre; }, (array)$firmantes_vobo);
                            if(!empty($vobo) && !in_array($vobo, $nombres_vobo)): ?>
                            <option value="<?php echo htmlspecialchars($vobo); ?>" selected><?php echo htmlspecialchars($vobo); ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div style="max-width:780px;margin:0 auto;">
            <div class="form-actions">
                <button type="submit" class="btn-r"><i class="fas fa-save"></i> Guardar cambios</button>
                <a href="<?php echo base_url('reporteservicios'); ?>" class="btn-g"><i class="fas fa-times"></i> Cancelar</a>
            </div>
        </div>

    </form>

</div>
</div>
</div>

<!-- Modal: Agregar nuevo firmante -->
<div class="modal fade" id="modalNuevoFirmante" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content" style="border-radius:14px;overflow:hidden;border:none;">
        <div class="modal-header" style="background:linear-gradient(135deg,#8B1A10,#a52119);border:none;padding:18px 22px;">
            <h5 class="modal-title" style="color:white;font-weight:700;"><i class="fas fa-user-plus mr-2"></i> Agregar firmante</h5>
            <button type="button" class="close" data-dismiss="modal" style="color:white;">&times;</button>
        </div>
        <div class="modal-body" style="padding:22px;">
            <div class="form-group">
                <label class="lbl">Nombre completo *</label>
                <input type="text" id="nf_nombre" class="inp" placeholder="Ej: Dr. Juan Pérez López" required>
            </div>
            <div class="form-group">
                <label class="lbl">Cargo *</label>
                <input type="text" id="nf_cargo" class="inp" placeholder="Ej: Director de Programa Educativo" required>
            </div>
            <div class="form-group">
                <label class="lbl">Rol *</label>
                <select id="nf_rol" class="inp">
                    <option value="">— Selecciona —</option>
                    <option value="jefe_laboratorio">Jefe de Laboratorio (Elaboró)</option>
                    <option value="vo_bo">Vo. Bo. / Director de Programa Educativo</option>
                </select>
            </div>
            <div style="display:flex;gap:10px;margin-top:16px;">
                <button type="button" class="btn-g" data-dismiss="modal" style="flex:1;justify-content:center;">Cancelar</button>
                <button type="button" class="btn-r" style="flex:1;justify-content:center;" id="btnGuardarFirmante">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div></div>
</div>

<script>
var BASE_URL = '<?php echo base_url(); ?>';
var LAB_ID   = '<?php echo $this->session->userdata("laboratorio_id"); ?>';

$('#btnGuardarFirmante').click(function() {
    var nombre = $('#nf_nombre').val().trim();
    var cargo  = $('#nf_cargo').val().trim();
    var rol    = $('#nf_rol').val();
    if (!nombre || !cargo || !rol) { alert('Completa todos los campos.'); return; }

    $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

    $.ajax({
        url: BASE_URL + 'firmantes/crear_ajax',
        method: 'POST',
        data: { nombre: nombre, cargo: cargo, rol: rol, laboratorio_id: (rol==='jefe_laboratorio') ? LAB_ID : '' },
        dataType: 'json',
        success: function(r) {
            if (r.success) {
                var sel = (rol === 'jefe_laboratorio') ? '[name="elaboro"]' : '[name="vobo"]';
                $(sel).append('<option value="' + nombre + '" selected>' + nombre + '</option>');
                $('#modalNuevoFirmante').modal('hide');
                $('#nf_nombre, #nf_cargo').val(''); $('#nf_rol').val('');
            } else { alert(r.error || 'Error'); }
            $('#btnGuardarFirmante').prop('disabled', false).html('<i class="fas fa-save"></i> Guardar');
        },
        error: function() {
            alert('Error de conexión');
            $('#btnGuardarFirmante').prop('disabled', false).html('<i class="fas fa-save"></i> Guardar');
        }
    });
});
</script>