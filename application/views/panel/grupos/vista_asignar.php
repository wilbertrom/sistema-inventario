<style>
:root{--rojo:#a52119;--rojo-mid:#c0392b;--rojo-light:#fdf1f0;--gris-bg:#f5f6f8;--gris-borde:#e2e8f0;--texto-dark:#1e293b;--texto-mid:#475569;--sombra-sm:0 2px 8px rgba(0,0,0,0.06);--radio:14px;--radio-sm:8px;}
.main-content{background:var(--gris-bg);min-height:calc(100vh - 81px);}
.section__content--p30{padding:28px;}
.page-header{background:white;border-radius:var(--radio);padding:20px 26px;margin-bottom:22px;box-shadow:var(--sombra-sm);display:flex;align-items:center;justify-content:space-between;border-left:4px solid var(--rojo);}
.page-header h2{font-size:20px;font-weight:700;color:var(--texto-dark);margin:0;}
.page-header h2 i{color:var(--rojo);margin-right:10px;}
.form-card{background:white;border-radius:var(--radio);box-shadow:var(--sombra-sm);border:1px solid var(--gris-borde);overflow:hidden;max-width:560px;margin:0 auto;}
.form-card-body{padding:28px;}
.f-label{font-size:13px;font-weight:600;color:var(--texto-dark);margin-bottom:6px;display:block;}
.f-control{border:1.5px solid var(--gris-borde);border-radius:var(--radio-sm);padding:10px 14px;font-size:13.5px;color:var(--texto-dark);transition:border-color .2s;width:100%;}
.f-control:focus{border-color:var(--rojo);box-shadow:0 0 0 3px rgba(165,33,25,.1);outline:none;}
.f-group{margin-bottom:20px;}
.field-readonly{background:#f8fafc;color:var(--texto-mid);cursor:not-allowed;}
.type-badge{display:inline-flex;align-items:center;gap:8px;background:var(--rojo-light);color:var(--rojo);border:1.5px solid rgba(165,33,25,.2);border-radius:20px;padding:5px 14px;font-size:13px;font-weight:700;margin-bottom:20px;}
.type-badge i{font-size:15px;}
.btn-r{background:linear-gradient(135deg,var(--rojo),var(--rojo-mid));color:white;border:none;border-radius:var(--radio-sm);padding:10px 22px;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .25s;text-decoration:none;}
.btn-r:hover{box-shadow:0 6px 18px rgba(165,33,25,.3);transform:translateY(-1px);color:white;text-decoration:none;}
.btn-g{background:#f1f5f9;color:var(--texto-mid);border:1.5px solid var(--gris-borde);border-radius:var(--radio-sm);padding:10px 22px;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .2s;text-decoration:none;}
.btn-g:hover{background:#e2e8f0;color:var(--texto-dark);text-decoration:none;}
.form-actions{display:flex;gap:12px;padding-top:20px;border-top:1px solid var(--gris-borde);}
.hint{font-size:12px;color:var(--texto-mid);margin-top:5px;}
</style>

<div class="main-content">
<div class="section__content section__content--p30">
<div class="container-fluid">

    <div class="page-header">
        <h2><i class="fas fa-link"></i> Asignar Equipo</h2>
        <a href="<?php echo base_url('grupos/vista'); ?>" class="btn-g" style="padding:8px 16px;font-size:13px;">
            <i class="fas fa-arrow-left"></i> Volver a grupos
        </a>
    </div>

    <div class="form-card">
    <div class="form-card-body">

        <!-- Badge del tipo -->
        <?php
        $icons_tipo = ['CPU'=>'fa-server','MONITOR'=>'fa-desktop','TECLADO'=>'fa-keyboard','MOUSE'=>'fa-mouse-pointer','CABLE'=>'fa-plug'];
        $icon_tipo = isset($icons_tipo[$tipo_equipo]) ? $icons_tipo[$tipo_equipo] : 'fa-desktop';
        ?>
        <div class="type-badge">
            <i class="fas <?php echo $icon_tipo; ?>"></i>
            Tipo: <?php echo $tipo_equipo; ?>
        </div>

        <form action="<?php echo base_url('grupos/asignar'); ?>" method="post">
            <input type="hidden" name="tipo" value="<?php echo $tipo_equipo; ?>">

            <!-- Equipo -->
            <div class="f-group">
                <label class="f-label">
                    Equipo <?php echo ($tipo_equipo === 'CABLE') ? '(máximo 3)' : ''; ?>
                    <span style="color:var(--rojo);">*</span>
                </label>
                <select name="equipo[]" id="equipo" class="f-control"
                        <?php echo (strtolower($tipo_equipo) === 'cable') ? 'multiple size="4"' : ''; ?> required>
                    <?php if(empty($equipos_tipo)): ?>
                        <option value="" disabled selected>No hay equipos disponibles</option>
                    <?php else: ?>
                        <?php foreach($equipos_tipo as $eq): ?>
                        <option value="<?php echo $eq->id_equipos; ?>"
                                <?php echo in_array($eq->id_equipos, array_column($equipos_asignados, 'id_equipos')) ? 'selected' : ''; ?>>
                            <?php echo $eq->tipo.' — '.$eq->cod_interno; ?>
                        </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <?php if(strtolower($tipo_equipo) === 'cable'): ?>
                <p class="hint"><i class="fas fa-info-circle"></i> Mantén Ctrl (o Cmd en Mac) para seleccionar múltiples cables.</p>
                <?php endif; ?>
            </div>

            <!-- Mesa (solo lectura) -->
            <div class="f-group">
                <label class="f-label">Mesa</label>
                <input type="text" class="f-control field-readonly" value="Mesa <?php echo $id_mesa; ?>" readonly>
                <input type="hidden" name="mesa" value="<?php echo $id_mesa; ?>">
            </div>

            <!-- Grupo (solo lectura) -->
            <div class="f-group">
                <label class="f-label">Máquina / Grupo</label>
                <input type="text" class="f-control field-readonly" value="Grupo <?php echo $id_grupo; ?>" readonly>
                <input type="hidden" name="grupo" value="<?php echo $id_grupo; ?>">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-r"><i class="fas fa-link"></i> Asignar equipo</button>
                <a href="<?php echo base_url('grupos/vista'); ?>" class="btn-g"><i class="fas fa-times"></i> Cancelar</a>
            </div>
        </form>
    </div>
    </div>

</div>
</div>
</div>

<!-- Modal: sin equipos disponibles -->
<?php if(empty($equipos_tipo)): ?>
<div class="modal fade" id="modalSinEquipos" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog modal-sm"><div class="modal-content">
        <div class="modal-header" style="border-bottom:2px solid #fee2e2;">
            <h5 class="modal-title" style="color:#dc2626;font-weight:700;">
                <i class="fas fa-exclamation-triangle mr-2"></i> Sin equipos
            </h5>
        </div>
        <div class="modal-body" style="font-size:14px;color:var(--texto-mid);">
            No hay equipos de tipo <strong><?php echo $tipo_equipo; ?></strong> disponibles para asignar.
        </div>
        <div class="modal-footer">
            <a href="<?php echo base_url('grupos/vista'); ?>" class="btn-r" style="width:100%;justify-content:center;">
                <i class="fas fa-arrow-left"></i> Volver a grupos
            </a>
        </div>
    </div></div>
</div>
<script>$(document).ready(function(){ $('#modalSinEquipos').modal('show'); });</script>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function(){
    var select = document.getElementById('equipo');
    if(!select) return;
    select.addEventListener('change', function(){
        if('<?php echo strtolower($tipo_equipo); ?>' === 'cable'){
            if(this.selectedOptions.length > 3){
                alert('No puedes seleccionar más de 3 cables.');
                this.options[this.selectedIndex].selected = false;
            }
        }
    });
});
</script>