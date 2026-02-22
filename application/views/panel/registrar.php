<style>
:root{--rojo:#a52119;--rojo-mid:#c0392b;--rojo-light:#fdf1f0;--gris-bg:#f5f6f8;--gris-borde:#e2e8f0;--texto-dark:#1e293b;--texto-mid:#475569;--sombra-sm:0 2px 8px rgba(0,0,0,0.06);--radio:14px;--radio-sm:8px;}
.main-content{background:var(--gris-bg);min-height:calc(100vh - 81px);}
.section__content--p30{padding:28px;}
.page-header{background:white;border-radius:var(--radio);padding:20px 26px;margin-bottom:22px;box-shadow:var(--sombra-sm);display:flex;align-items:center;justify-content:space-between;border-left:4px solid var(--rojo);}
.page-header h2{font-size:20px;font-weight:700;color:var(--texto-dark);margin:0;}
.page-header h2 i{color:var(--rojo);margin-right:10px;}
.form-card{background:white;border-radius:var(--radio);box-shadow:var(--sombra-sm);border:1px solid var(--gris-borde);overflow:hidden;}
.form-card-body{padding:28px;}
.f-label{font-size:13px;font-weight:600;color:var(--texto-dark);margin-bottom:6px;display:block;}
.f-control{border:1.5px solid var(--gris-borde);border-radius:var(--radio-sm);padding:10px 14px;font-size:13.5px;color:var(--texto-dark);transition:border-color .2s,box-shadow .2s;width:100%;background:white;}
.f-control:focus{border-color:var(--rojo);box-shadow:0 0 0 3px rgba(165,33,25,.1);outline:none;}
.f-group{margin-bottom:20px;}
.input-with-btn{display:flex;}
.input-with-btn .f-control{border-radius:var(--radio-sm) 0 0 var(--radio-sm);flex:1;}
.input-with-btn .btn-append{background:linear-gradient(135deg,var(--rojo),var(--rojo-mid));color:white;border:none;border-radius:0 var(--radio-sm) var(--radio-sm) 0;padding:10px 16px;font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap;transition:all .2s;}
.input-with-btn .btn-append:hover{filter:brightness(1.1);}
.btn-r{background:linear-gradient(135deg,var(--rojo),var(--rojo-mid));color:white;border:none;border-radius:var(--radio-sm);padding:10px 22px;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .25s;text-decoration:none;}
.btn-r:hover{box-shadow:0 6px 18px rgba(165,33,25,.3);transform:translateY(-1px);color:white;text-decoration:none;}
.btn-g{background:#f1f5f9;color:var(--texto-mid);border:1.5px solid var(--gris-borde);border-radius:var(--radio-sm);padding:10px 22px;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .2s;text-decoration:none;}
.btn-g:hover{background:#e2e8f0;color:var(--texto-dark);text-decoration:none;}
.extra-fields{background:#f8fafc;border-radius:var(--radio-sm);padding:20px;border:1.5px dashed var(--gris-borde);margin-bottom:20px;}
.extra-fields h6{font-size:13px;font-weight:700;color:var(--texto-dark);margin-bottom:16px;display:flex;align-items:center;gap:8px;}
.extra-fields h6 i{color:var(--rojo);}
.divider{height:1px;background:var(--gris-borde);margin:24px 0;}
.form-actions{display:flex;gap:12px;flex-wrap:wrap;}
.alert-m{border-radius:var(--radio-sm);padding:12px 18px;font-size:13.5px;display:flex;align-items:center;gap:10px;margin-bottom:18px;}
.alert-e{background:#fee2e2;color:#dc2626;border:1px solid #fecaca;}
.alert-s{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0;}
.val-error{font-size:12px;color:#dc2626;margin-top:4px;}
</style>

<div class="main-content">
<div class="section__content section__content--p30">
<div class="container-fluid">

    <div class="page-header">
        <h2><i class="fas fa-plus-circle"></i> Registrar Equipo</h2>
        <a href="<?php echo base_url('panel/ver_inventario'); ?>" class="btn-g" style="padding:8px 16px;font-size:13px;">
            <i class="fas fa-arrow-left"></i> Volver al inventario
        </a>
    </div>

    <div class="row justify-content-center">
    <div class="col-lg-8">
    <div class="form-card">
    <div class="form-card-body">

        <?php if($this->session->flashdata('error')): ?>
        <div class="alert-m alert-e"><i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <?php if($this->session->flashdata('success')): ?>
        <div class="alert-m alert-s"><i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <?php if(isset($error)): ?>
        <div class="alert-m alert-e"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
        <?php endif; ?>

        <form action="<?php echo base_url('inventario/registrar'); ?>" method="post"
              enctype="multipart/form-data" onsubmit="return confirmarRegistro()">

            <!-- Marca -->
            <div class="f-group">
                <label class="f-label">Marca <span style="color:var(--rojo);">*</span></label>
                <div class="input-with-btn">
                    <select name="marca" id="marca" class="f-control" required>
                        <option value="" disabled selected>Seleccione una marca</option>
                        <?php foreach($marcas as $marca): ?>
                        <option value="<?php echo $marca->id_marcas; ?>">
                            <?php echo $marca->nombre; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="btn-append" data-toggle="modal" data-target="#modalAgregarMarca">
                        <i class="fas fa-plus"></i> Nueva
                    </button>
                </div>
            </div>

            <!-- Tipo -->
            <div class="f-group">
                <label class="f-label">Tipo <span style="color:var(--rojo);">*</span></label>
                <div class="input-with-btn">
                    <select name="tipo" id="tipo" class="f-control" required>
                        <option value="" disabled selected>Seleccione un tipo</option>
                        <?php foreach($tipos as $tipo): ?>
                        <option value="<?php echo $tipo->id_tipos; ?>">
                            <?php echo $tipo->nombre; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="btn-append" data-toggle="modal" data-target="#modalAgregarTipo">
                        <i class="fas fa-plus"></i> Nuevo
                    </button>
                </div>
            </div>

            <!-- Código interno -->
            <div class="f-group">
                <label class="f-label">Código Interno <span style="color:var(--rojo);">*</span></label>
                <input type="text" name="cod_interno" class="f-control"
                       placeholder="Ej: CPU-001" required
                       value="<?php echo set_value('cod_interno'); ?>">
            </div>

            <!-- Descripción -->
            <div class="f-group">
                <label class="f-label">Descripción / Observaciones</label>
                <textarea name="descripcion" class="f-control" rows="3"
                          placeholder="Observaciones del equipo..."><?php echo set_value('descripcion'); ?></textarea>
            </div>

            <!-- Estado -->
            <div class="f-group">
                <label class="f-label">Estado <span style="color:var(--rojo);">*</span></label>
                <select name="estado" class="f-control" required>
                    <option value="" disabled selected>Seleccione un estado</option>
                    <?php foreach($estados as $estado): ?>
                    <option value="<?php echo $estado->id_estados; ?>">
                        <?php echo $estado->nombre; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Imagen -->
            <div class="f-group">
                <label class="f-label">Imagen del equipo <span style="color:var(--texto-mid);font-weight:400;">(opcional)</span></label>
                <input type="file" name="imagen" accept="image/jpeg,image/png"
                       style="width:100%;border:1.5px solid var(--gris-borde);border-radius:var(--radio-sm);padding:8px 12px;background:white;font-size:13px;">
            </div>

            <div class="divider"></div>
            <div class="form-actions">
                <button type="submit" class="btn-r">
                    <i class="fas fa-save"></i> Registrar equipo
                </button>
                <a href="<?php echo base_url('panel/ver_inventario'); ?>" class="btn-g">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
    </div>
    </div>
    </div>

</div>
</div>
</div>

<!-- Modal Marca -->
<div class="modal fade" id="modalAgregarMarca" tabindex="-1" role="dialog">
    <div class="modal-dialog"><div class="modal-content" style="border-radius:12px;overflow:hidden;">
        <div class="modal-header" style="border-bottom:2px solid #f1f5f9;">
            <h5 class="modal-title" style="font-weight:700;">Nueva Marca</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="padding:24px;">
            <form action="<?php echo base_url('Inventario/nuevaMarca'); ?>" method="post">
                <div class="f-group">
                    <label class="f-label">Nombre de la marca</label>
                    <input type="text" name="marca" class="f-control" required
                           placeholder="Ej: Apple, HP, Dell...">
                </div>
                <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:16px;">
                    <button type="button" class="btn-g" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-r"><i class="fas fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div></div>
</div>

<!-- Modal Tipo -->
<div class="modal fade" id="modalAgregarTipo" tabindex="-1" role="dialog">
    <div class="modal-dialog"><div class="modal-content" style="border-radius:12px;overflow:hidden;">
        <div class="modal-header" style="border-bottom:2px solid #f1f5f9;">
            <h5 class="modal-title" style="font-weight:700;">Nuevo Tipo</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="padding:24px;">
            <form action="<?php echo base_url('Inventario/nuevoTipo'); ?>" method="post">
                <div class="f-group">
                    <label class="f-label">Nombre del tipo</label>
                    <input type="text" name="tipo" class="f-control" required
                           placeholder="Ej: Monitor, Teclado...">
                </div>
                <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:16px;">
                    <button type="button" class="btn-g" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-r"><i class="fas fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div></div>
</div>

<script>
function confirmarRegistro() {
    return confirm('¿Confirmar el registro de este equipo?');
}

</script>