<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
:root{--rojo:#a52119;--rojo-mid:#c0392b;--gris-bg:#f5f6f8;--gris-borde:#e2e8f0;--texto-dark:#1e293b;--texto-mid:#475569;--sombra-sm:0 2px 8px rgba(0,0,0,0.06);--radio:14px;--radio-sm:8px;}
.main-content{background:var(--gris-bg);min-height:calc(100vh - 81px);}
.section__content--p30{padding:20px 16px;}
@media(min-width:768px){.section__content--p30{padding:28px;}}
.page-header{background:white;border-radius:var(--radio);padding:16px 20px;margin-bottom:18px;box-shadow:var(--sombra-sm);display:flex;align-items:center;justify-content:space-between;border-left:4px solid var(--rojo);flex-wrap:wrap;gap:10px;}
.page-header h2{font-size:18px;font-weight:700;color:var(--texto-dark);margin:0;}
.page-header h2 i{color:var(--rojo);margin-right:8px;}
.form-card{background:white;border-radius:var(--radio);box-shadow:var(--sombra-sm);border:1px solid var(--gris-borde);}
.form-card-body{padding:28px;}
.f-label{font-size:13px;font-weight:600;color:var(--texto-dark);margin-bottom:6px;display:block;}
.f-control{border:1.5px solid var(--gris-borde);border-radius:var(--radio-sm);padding:10px 14px;font-size:13.5px;color:var(--texto-dark);width:100%;background:white;transition:border-color .2s;}
.f-control:focus{border-color:var(--rojo);box-shadow:0 0 0 3px rgba(165,33,25,.1);outline:none;}
.f-group{margin-bottom:20px;}
.divider{height:1px;background:var(--gris-borde);margin:24px 0;}
.form-actions{display:flex;gap:12px;flex-wrap:wrap;}
.btn-r{background:linear-gradient(135deg,var(--rojo),var(--rojo-mid));color:white;border:none;border-radius:var(--radio-sm);padding:10px 22px;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .25s;text-decoration:none;}
.btn-r:hover{box-shadow:0 6px 18px rgba(165,33,25,.3);transform:translateY(-1px);color:white;}
.btn-g{background:#f1f5f9;color:var(--texto-mid);border:1.5px solid var(--gris-borde);border-radius:var(--radio-sm);padding:10px 22px;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;text-decoration:none;}
.btn-g:hover{background:#e2e8f0;color:var(--texto-dark);}
.alert-e{background:#fee2e2;color:#dc2626;border:1px solid #fecaca;border-radius:var(--radio-sm);padding:12px 18px;font-size:13px;margin-bottom:16px;}
</style>

<div class="main-content">
<div class="section__content section__content--p30">
<div class="container-fluid">

    <div class="page-header">
        <h2><i class="fas fa-plus-circle"></i> Nueva Orden de Mantenimiento</h2>
        <a href="<?php echo base_url('orden-mantenimiento'); ?>" class="btn-g" style="padding:8px 16px;font-size:13px;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="row justify-content-center">
    <div class="col-lg-8">
    <div class="form-card">
    <div class="form-card-body">

        <?php if($this->session->flashdata('error')): ?>
        <div class="alert-e"><i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <form action="<?php echo base_url('orden-mantenimiento/crear'); ?>" method="post" enctype="multipart/form-data">

            <div class="row">
                <div class="col-md-6">
                    <div class="f-group">
                        <label class="f-label">Área solicitante <span style="color:var(--rojo)">*</span></label>
                        <input type="text" name="area_solicitante" class="f-control" required
                               placeholder="Ej: Laboratorio Open Source"
                               value="<?php echo set_value('area_solicitante'); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="f-group">
                        <label class="f-label">Nombre del solicitante <span style="color:var(--rojo)">*</span></label>
                        <input type="text" name="solicitante" class="f-control" required
                               placeholder="Nombre completo"
                               value="<?php echo set_value('solicitante'); ?>">
                    </div>
                </div>
            </div>

            <div class="f-group">
                <label class="f-label">Fecha de elaboración <span style="color:var(--rojo)">*</span></label>
                <input type="date" name="fecha_elaboracion" class="f-control" required
                       value="<?php echo set_value('fecha_elaboracion', date('Y-m-d')); ?>">
            </div>

            <div class="f-group">
                <label class="f-label">Descripción del servicio solicitado</label>
                <textarea name="descripcion_servicio" class="f-control" rows="4"
                          placeholder="Describe el servicio que se requiere..."><?php echo set_value('descripcion_servicio'); ?></textarea>
            </div>

            <div class="f-group">
                <label class="f-label">Especificación técnica / Proyección técnica</label>
                <textarea name="especificacion_tecnica" class="f-control" rows="3"
                          placeholder="Texto de especificación técnica..."><?php echo set_value('especificacion_tecnica'); ?></textarea>
            </div>
            <div class="f-group">
                <label class="f-label">
                    Imagen de especificación técnica
                    <span style="font-weight:400;color:#64748b;font-size:11px;">(opcional — se mostrará debajo del texto en el PDF)</span>
                </label>
                <div class="upload-area" id="uploadArea">
                    <input type="file" name="especificacion_imagen" id="especificacion_imagen"
                           accept="image/jpeg,image/png,image/gif"
                           style="display:none;" onchange="previewImg(this)">
                    <div id="uploadPlaceholder" onclick="document.getElementById('especificacion_imagen').click()"
                         style="cursor:pointer;padding:22px;text-align:center;border:2px dashed #cbd5e1;border-radius:10px;color:#94a3b8;transition:border-color .2s;"
                         onmouseover="this.style.borderColor='#a52119'" onmouseout="this.style.borderColor='#cbd5e1'">
                        <i class="fa fa-image" style="font-size:28px;color:#cbd5e1;display:block;margin-bottom:8px;"></i>
                        <span style="font-size:13px;">Haz clic para seleccionar imagen (JPG, PNG)</span><br>
                        <span style="font-size:11px;color:#b0b8c1;">Máx. 5 MB</span>
                    </div>
                    <div id="imgPreviewWrap" style="display:none;text-align:center;padding:10px;">
                        <img id="imgPreview" src="" style="max-height:160px;max-width:100%;border-radius:8px;border:1px solid #e2e8f0;">
                        <br>
                        <button type="button" onclick="quitarImagen()"
                                style="margin-top:8px;background:#fee2e2;color:#dc2626;border:none;border-radius:6px;padding:5px 14px;font-size:12px;cursor:pointer;">
                            <i class="fa fa-times"></i> Quitar imagen
                        </button>
                    </div>
                </div>
            </div>

            <div class="divider"></div>
            <p style="font-size:13px;font-weight:700;color:#1e293b;margin-bottom:14px;">
                <i class="fa fa-pen-nib" style="color:#a52119;"></i> Firmantes
            </p>
            <div class="row">
                <div class="col-md-6">
                    <div class="f-group">
                        <label class="f-label">Responsable de Mantenimiento</label>
                        <input type="text" name="responsable_mantenimiento" class="f-control"
                               placeholder="Nombre del responsable de mantenimiento"
                               value="<?php echo set_value('responsable_mantenimiento'); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="f-group">
                        <label class="f-label">Verificado por</label>
                        <input type="text" name="verificado_por" class="f-control"
                               placeholder="Nombre de quien verifica"
                               value="<?php echo set_value('verificado_por'); ?>">
                    </div>
                </div>
            </div>
            <div class="divider"></div>
            <div class="form-actions">
                <button type="submit" class="btn-r"><i class="fas fa-save"></i> Crear Orden</button>
                <a href="<?php echo base_url('orden-mantenimiento'); ?>" class="btn-g">
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

<script>
function previewImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imgPreview').src = e.target.result;
            document.getElementById('imgPreviewWrap').style.display = 'block';
            document.getElementById('uploadPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function quitarImagen() {
    document.getElementById('especificacion_imagen').value = '';
    document.getElementById('imgPreviewWrap').style.display = 'none';
    document.getElementById('uploadPlaceholder').style.display = 'block';
}
</script>