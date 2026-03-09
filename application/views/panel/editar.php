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
.divider{height:1px;background:var(--gris-borde);margin:24px 0;}
.form-actions{display:flex;gap:12px;flex-wrap:wrap;}
.alert-m{border-radius:var(--radio-sm);padding:12px 18px;font-size:13.5px;display:flex;align-items:center;gap:10px;margin-bottom:18px;}
.alert-e{background:#fee2e2;color:#dc2626;border:1px solid #fecaca;}
.alert-s{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0;}
</style>

<div class="main-content">
<div class="section__content section__content--p30">
<div class="container-fluid">

    <div class="page-header">
        <h2><i class="fas fa-pen"></i> Editar Equipo</h2>
        <a href="<?php echo base_url('panel/ver_inventario'); ?>" class="btn-g" style="padding:8px 16px;font-size:13px;">
            <i class="fas fa-arrow-left"></i> Volver al inventario
        </a>
    </div>

    <div class="row justify-content-center">
    <div class="col-lg-8">
    <div class="form-card">
    <div class="form-card-body">

        <?php if(isset($error)): ?>
        <div class="alert-m alert-e"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
        <?php endif; ?>
        <?php if($this->session->flashdata('success')): ?>
        <div class="alert-m alert-s"><i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <?php echo validation_errors('<div class="alert-m alert-e"><i class="fas fa-exclamation-circle"></i>','</div>'); ?>

        <form action="<?php echo base_url('inventario/editar'); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_equipos" value="<?php echo $equipo->id_equipos; ?>">
            <input type="hidden" name="id_ccompus" value="<?php echo $equipo->id_ccompus; ?>">

            <!-- Marca -->
            <div class="f-group">
                <label class="f-label">Marca <span style="color:var(--rojo);">*</span></label>
                <div class="input-with-btn">
                    <select name="marca" class="f-control" required>
                        <option value="" disabled>Seleccione una marca</option>
                        <?php foreach($marcas as $marca): ?>
                        <option value="<?php echo $marca->id_marcas; ?>"
                                <?php echo ($marca->id_marcas == $equipo->id_marcas) ? 'selected' : ''; ?>>
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
                        <option value="" disabled>Seleccione un tipo</option>
                        <?php foreach($tipos as $tipo): ?>
                        <option value="<?php echo $tipo->id_tipos; ?>"
                                <?php echo ($tipo->id_tipos == $equipo->id_tipos) ? 'selected' : ''; ?>>
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
                <input type="text" name="codigo_interno" class="f-control" required
                       value="<?php echo htmlspecialchars($equipo->codigo_interno ?? ''); ?>">
            </div>

            <!-- Descripción del producto -->
            <div class="f-group">
                <label class="f-label">Descripción del producto</label>
                <input type="text" name="descripcion" class="f-control"
                       placeholder="Ej: Monitor 24 pulgadas LED"
                       value="<?php echo htmlspecialchars($equipo->descripcion_producto ?? $equipo->descripcion ?? ''); ?>">
            </div>

            <!-- Unidad -->
            <div class="f-group">
                <label class="f-label">Unidad</label>
                <input type="text" name="unidad" class="f-control"
                       placeholder="Ej: Pieza, Juego, Par, Set..."
                       value="<?php echo htmlspecialchars($equipo->unidad ?? ''); ?>">
            </div>

            <!-- Proveedor -->
            <div class="f-group">
                <label class="f-label">Proveedor <span style="color:var(--texto-mid);font-weight:400;">(opcional)</span></label>
                <input type="text" name="proveedor" class="f-control"
                       placeholder="Nombre del proveedor"
                       value="<?php echo htmlspecialchars($equipo->proveedor ?? ''); ?>">
            </div>

            <!-- Estado -->
            <div class="f-group">
                <label class="f-label">Estado del equipo <span style="color:var(--rojo);">*</span></label>
                <div class="input-with-btn">
                    <select name="estado" class="f-control" required>
                        <option value="" disabled>Seleccione un estado</option>
                        <?php foreach($estados as $estado): ?>
                        <option value="<?php echo $estado->id_estados; ?>"
                                <?php echo ($estado->id_estados == $equipo->id_estados) ? 'selected' : ''; ?>>
                            <?php echo $estado->nombre; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="btn-append" data-toggle="modal" data-target="#modalAgregarEstado">
                        <i class="fas fa-plus"></i> Nuevo
                    </button>
                </div>
                <small style="color:var(--texto-mid);font-size:11.5px;margin-top:4px;display:block;">
                    <i class="fas fa-info-circle"></i>
                    Solo verás los estados de <strong><?php echo $this->session->userdata('laboratorio_nombre'); ?></strong>
                </small>
            </div>

            <!-- ================================================
                 OBSERVACIONES — campo nuevo agregado
                 El name="observaciones" debe coincidir con el
                 campo en el controlador inventario/editar
                 y con la columna en la BD
                 ================================================ -->
            <div class="f-group">
                <label class="f-label">Observaciones <span style="color:var(--texto-mid);font-weight:400;">(opcional)</span></label>
                <textarea name="observaciones" class="f-control"
                          rows="3"
                          placeholder="Ej: Pantalla rayada, falta cable de poder..."
                          style="resize:vertical;"><?php echo htmlspecialchars($equipo->observaciones ?? ''); ?></textarea>
            </div>

            <!-- Imagen -->
            <div class="f-group">
                <label class="f-label">Imagen del equipo <span style="color:var(--texto-mid);font-weight:400;">(opcional — reemplaza la actual)</span></label>
                <?php if(!empty($equipo->imagen)): ?>
                <div style="margin-bottom:10px;">
                    <img src="<?php echo base_url('recursos-panel/images/equipos/'.$equipo->imagen); ?>"
                         style="height:60px;border-radius:8px;border:1px solid var(--gris-borde);"
                         onerror="this.style.display='none'">
                </div>
                <?php endif; ?>
                <input type="file" name="imagen" accept="image/jpeg,image/png"
                       style="width:100%;border:1.5px solid var(--gris-borde);border-radius:var(--radio-sm);padding:8px 12px;background:white;font-size:13px;">
            </div>

            <div class="divider"></div>
            <div class="form-actions">
                <button type="submit" class="btn-r"><i class="fas fa-save"></i> Guardar cambios</button>
                <button type="button" class="btn-g" onclick="history.back()"><i class="fas fa-times"></i> Cancelar</button>
            </div>
        </form>
    </div>
    </div>
    </div>
    </div>

</div>
</div>
</div>

<!-- Modal Nueva Marca -->
<div class="modal fade" id="modalAgregarMarca" tabindex="-1" role="dialog">
    <div class="modal-dialog"><div class="modal-content" style="border-radius:12px;overflow:hidden;">
        <div class="modal-header" style="border-bottom:2px solid #f1f5f9;">
            <h5 class="modal-title" style="font-weight:700;">Nueva Marca</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="padding:24px;">
            <form action="<?php echo base_url('Inventario/nuevaMarca'); ?>" method="post">
                <input type="hidden" name="id_equipos" value="<?php echo $equipo->id_equipos; ?>">
                <p style="font-size:12.5px;color:#64748b;margin-bottom:14px;">
                    <i class="fas fa-info-circle" style="color:var(--rojo);"></i>
                    Se agregará solo para <strong><?php echo $this->session->userdata('laboratorio_nombre'); ?></strong>
                </p>
                <div class="f-group">
                    <label class="f-label">Nombre de la marca</label>
                    <input type="text" name="marca" class="f-control" required placeholder="Ej: Apple, HP...">
                </div>
                <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:16px;">
                    <button type="button" class="btn-g" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-r"><i class="fas fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div></div>
</div>

<!-- Modal Nuevo Tipo -->
<div class="modal fade" id="modalAgregarTipo" tabindex="-1" role="dialog">
    <div class="modal-dialog"><div class="modal-content" style="border-radius:12px;overflow:hidden;">
        <div class="modal-header" style="border-bottom:2px solid #f1f5f9;">
            <h5 class="modal-title" style="font-weight:700;">Nuevo Tipo</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="padding:24px;">
            <form action="<?php echo base_url('Inventario/nuevoTipo'); ?>" method="post">
                <input type="hidden" name="id_equipos" value="<?php echo $equipo->id_equipos; ?>">
                <div class="f-group">
                    <label class="f-label">Nombre del tipo</label>
                    <input type="text" name="tipo" class="f-control" required placeholder="Ej: Monitor...">
                </div>
                <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:16px;">
                    <button type="button" class="btn-g" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-r"><i class="fas fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div></div>
</div>

<!-- Modal Nuevo Estado -->
<div class="modal fade" id="modalAgregarEstado" tabindex="-1" role="dialog">
    <div class="modal-dialog"><div class="modal-content" style="border-radius:12px;overflow:hidden;">
        <div class="modal-header" style="border-bottom:2px solid #f1f5f9;">
            <h5 class="modal-title" style="font-weight:700;">Nuevo Estado del Equipo</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="padding:24px;">
            <form action="<?php echo base_url('Inventario/nuevoEstado'); ?>" method="post">
                <input type="hidden" name="id_equipos" value="<?php echo $equipo->id_equipos; ?>">
                <p style="font-size:12.5px;color:#64748b;margin-bottom:14px;">
                    <i class="fas fa-info-circle" style="color:var(--rojo);"></i>
                    Se agregará solo para <strong><?php echo $this->session->userdata('laboratorio_nombre'); ?></strong>
                </p>
                <div class="f-group">
                    <label class="f-label">Nombre del estado</label>
                    <input type="text" name="estado_nuevo" class="f-control" required
                           placeholder="Ej: Obsoleto, Prestado...">
                </div>
                <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:16px;">
                    <button type="button" class="btn-g" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-r"><i class="fas fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div></div>
</div>