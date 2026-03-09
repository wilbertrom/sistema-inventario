<style>
:root {
    --rojo: #a52119;
    --rojo-dark: #8a1a14;
    --rojo-mid: #c0392b;
    --rojo-light: #fdf1f0;
    --gris-bg: #f5f6f8;
    --gris-borde: #e2e8f0;
    --texto-dark: #1f243f;
    --texto-mid: #475569;
    --sombra-sm: 0 2px 8px rgba(0,0,0,0.06);
    --radio: 14px;
    --radio-sm: 8px;
}

.main-content { background: var(--gris-bg); min-height: calc(100vh - 81px); }
.section__content--p30 { padding: 20px 16px; }
@media(min-width:768px){ .section__content--p30 { padding: 28px; } }

.page-header {
    background: white; border-radius: var(--radio); padding: 16px 20px;
    margin-bottom: 18px; box-shadow: var(--sombra-sm);
    display: flex; align-items: center; justify-content: space-between;
    border-left: 4px solid var(--rojo); flex-wrap: wrap; gap: 10px;
}
.page-header h2 { font-size: 17px; font-weight: 700; color: var(--texto-dark); margin: 0; }
.page-header h2 i { color: var(--rojo); margin-right: 8px; }
@media(min-width:768px){
    .page-header h2 { font-size: 20px; }
    .page-header { padding: 20px 26px; }
}

/* Banner del encargado */
.encargado-banner {
    background: white; border-radius: var(--radio); padding: 14px 20px;
    margin-bottom: 18px; box-shadow: var(--sombra-sm);
    border: 1px solid var(--gris-borde);
    display: flex; align-items: center; flex-wrap: wrap; gap: 12px;
}
.encargado-banner .lbl {
    font-size: 13px; font-weight: 700; color: var(--texto-dark);
    white-space: nowrap; display: flex; align-items: center; gap: 6px;
}
.encargado-banner .lbl i { color: var(--rojo); }
.encargado-banner select {
    border: 1.5px solid var(--gris-borde); border-radius: var(--radio-sm);
    padding: 8px 12px; font-size: 13px; color: var(--texto-dark);
    background: white; min-width: 220px; flex: 1; max-width: 340px;
    outline: none; transition: border-color .2s;
}
.encargado-banner select:focus { border-color: var(--rojo); }
.encargado-banner .btn-agregar {
    background: linear-gradient(135deg, var(--rojo), var(--rojo-mid));
    color: white; border: none; border-radius: var(--radio-sm);
    padding: 8px 14px; font-size: 12.5px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
    white-space: nowrap; transition: all .2s;
}
.encargado-banner .btn-agregar:hover { box-shadow: 0 4px 12px rgba(165,33,25,.3); }
.encargado-banner .saved-msg {
    font-size: 12px; color: #15803d; background: #dcfce7;
    border-radius: 6px; padding: 4px 10px; display: none;
    align-items: center; gap: 4px;
}

.card-m {
    background: white; border-radius: var(--radio); box-shadow: var(--sombra-sm);
    border: 1px solid var(--gris-borde); overflow: hidden;
}

.toolbar {
    padding: 12px 16px; display: flex; flex-direction: column; gap: 10px;
    border-bottom: 1px solid var(--gris-borde);
}
@media(min-width:768px){
    .toolbar { flex-direction: row; align-items: center; justify-content: space-between; padding: 14px 20px; }
}
.toolbar-left { display: flex; flex-direction: column; gap: 8px; width: 100%; }
@media(min-width:576px){ .toolbar-left { flex-direction: row; align-items: center; flex-wrap: wrap; } }
.toolbar-right { display: flex; justify-content: flex-end; }

.input-buscar {
    display: flex; align-items: center; background: #f8fafc;
    border: 1.5px solid var(--gris-borde); border-radius: var(--radio-sm);
    padding: 0 12px; gap: 8px; transition: border-color .2s; width: 100%;
}
@media(min-width:576px){ .input-buscar { width: 220px; } }
.input-buscar:focus-within { border-color: var(--rojo); }
.input-buscar input {
    border: none; background: transparent; padding: 9px 0;
    font-size: 13.5px; color: var(--texto-dark); outline: none; width: 100%;
}
.input-buscar i { color: var(--texto-mid); font-size: 14px; }

.select-filtro {
    border: 1.5px solid var(--gris-borde); border-radius: var(--radio-sm);
    padding: 9px 12px; font-size: 13.5px; color: var(--texto-dark);
    background: white; cursor: pointer; outline: none;
    transition: border-color .2s; width: 100%;
}
@media(min-width:576px){ .select-filtro { width: auto; } }
.select-filtro:focus { border-color: var(--rojo); }

.btn-r {
    background: linear-gradient(135deg, var(--rojo), var(--rojo-mid));
    color: white; border: none; border-radius: var(--radio-sm);
    padding: 9px 16px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
    transition: all .25s; text-decoration: none; white-space: nowrap;
}
.btn-r:hover { box-shadow: 0 5px 15px rgba(165,33,25,.3); transform: translateY(-1px); color: white; text-decoration: none; }

.btn-g {
    background: #f1f5f9; color: var(--texto-mid);
    border: 1.5px solid var(--gris-borde); border-radius: var(--radio-sm);
    padding: 10px 22px; font-size: 13.5px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 7px;
    text-decoration: none;
}
.btn-g:hover { background: #e2e8f0; color: var(--texto-dark); }

.btn-outline {
    background: white; color: var(--texto-mid);
    border: 1.5px solid var(--gris-borde); border-radius: var(--radio-sm);
    padding: 9px 15px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
    transition: all .2s; text-decoration: none; white-space: nowrap;
}
.btn-outline:hover { background: #f1f5f9; color: var(--texto-dark); text-decoration: none; }

.f-label { font-size: 13px; font-weight: 600; color: var(--texto-dark); margin-bottom: 6px; display: block; }
.f-control {
    border: 1.5px solid var(--gris-borde); border-radius: var(--radio-sm);
    padding: 10px 14px; font-size: 13.5px; color: var(--texto-dark);
    width: 100%; background: white; transition: border-color .2s;
}
.f-control:focus { border-color: var(--rojo); box-shadow: 0 0 0 3px rgba(165,33,25,.1); outline: none; }
.f-group { margin-bottom: 16px; }

.table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
table.inv-t { width: 100%; border-collapse: collapse; min-width: 700px; }
table.inv-t thead th {
    background: var(--rojo); color: white; font-size: 11px; font-weight: 600;
    text-transform: uppercase; letter-spacing: .4px; padding: 12px 14px;
    border: none; white-space: nowrap;
}
table.inv-t tbody tr { border-bottom: 1px solid var(--gris-borde); transition: background .15s; }
table.inv-t tbody tr:hover { background: #fafbfc; }
table.inv-t td { padding: 11px 14px; font-size: 13px; color: var(--texto-mid); vertical-align: middle; }
.td-main { color: var(--texto-dark) !important; font-weight: 600; }

.badge-e { padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block; white-space: nowrap; }
.be-green  { background: #dcfce7; color: #15803d; }
.be-red    { background: #fee2e2; color: #dc2626; }
.be-yellow { background: #fef9c3; color: #a16207; }
.be-blue   { background: #dbeafe; color: #1d4ed8; }

.ac-btn {
    width: 30px; height: 30px; border-radius: 7px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 14px; transition: all .2s; border: none;
    cursor: pointer; text-decoration: none;
}
.ac-btn:hover { transform: scale(1.1); text-decoration: none; }
.ab-info { background: #eff6ff; color: #2563eb; }
.ab-edit { background: #fffbeb; color: #d97706; }
.ab-del  { background: #fef2f2; color: #dc2626; }

.mobile-cards { display: none; }
@media(max-width:699px){
    .table-wrap { display: none; }
    .mobile-cards { display: block; padding: 12px; }
}
.equipo-card {
    background: white; border: 1px solid var(--gris-borde);
    border-radius: 12px; padding: 14px 16px; margin-bottom: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}
.equipo-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; gap: 8px; }
.equipo-card-num { background: var(--rojo); color: white; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 20px; white-space: nowrap; }
.equipo-card-tipo { font-size: 13.5px; font-weight: 700; color: var(--texto-dark); flex: 1; }
.equipo-card-body { display: grid; grid-template-columns: 1fr 1fr; gap: 6px 12px; }
.equipo-card-row { font-size: 12px; }
.equipo-card-row .lbl { color: var(--texto-mid); display: block; font-size: 11px; text-transform: uppercase; letter-spacing: .3px; margin-bottom: 1px; }
.equipo-card-row .val { color: var(--texto-dark); font-weight: 500; }
.equipo-card-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 12px; padding-top: 10px; border-top: 1px solid var(--gris-borde); }
.card-actions { display: flex; gap: 6px; }

.dropdown-menu { border: none; box-shadow: 0 8px 24px rgba(0,0,0,.12); border-radius: 10px; border-top: 2px solid var(--rojo); padding: 6px 0; min-width: 170px; }
.dropdown-item { font-size: 13px; padding: 9px 16px; color: var(--texto-mid); display: flex; align-items: center; gap: 8px; transition: background .15s, color .15s; }
.dropdown-item:hover { background: var(--rojo-light); color: var(--rojo); }

.empty-state { padding: 50px 20px; text-align: center; color: var(--texto-mid); }
.empty-state i { font-size: 44px; color: #cbd5e1; display: block; margin-bottom: 12px; }
.pagination-wrap { padding: 12px 16px; border-top: 1px solid var(--gris-borde); }
</style>

<div class="main-content">
<div class="section__content section__content--p30">
<div class="container-fluid">

    <div class="page-header">
        <h2><i class="fas fa-desktop"></i> Inventario de Equipos</h2>
        <a href="<?php echo base_url('panel/registrar'); ?>" class="btn-r">
            <i class="fas fa-plus"></i> Agregar Equipo
        </a>
    </div>

    <!-- ══ BANNER ENCARGADO ══ -->
    <div class="encargado-banner">
        <span class="lbl"><i class="fas fa-user-tie"></i> Responsable del laboratorio:</span>
        <select id="selectEncargado">
            <option value="">— Selecciona el encargado —</option>
            <?php foreach($firmantes_resp as $f): ?>
            <option value="<?php echo htmlspecialchars($f->nombre); ?>"
                <?php echo ($this->session->userdata('encargado_inventario') == $f->nombre) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($f->nombre); ?>
            </option>
            <?php endforeach; ?>
        </select>
        <button type="button" class="btn-agregar" data-toggle="modal" data-target="#modalNuevoEncargado">
            <i class="fas fa-user-plus"></i> Agregar nombre
        </button>
        <span class="saved-msg" id="savedMsg"><i class="fas fa-check-circle"></i> Guardado</span>
        <span style="font-size:11.5px;color:var(--texto-mid);">
            <i class="fas fa-info-circle"></i> Este nombre aparecerá en PDF y Excel al exportar
        </span>
    </div>

    <div class="card-m">

        <div class="toolbar">
            <div class="toolbar-left">
                <form action="<?php echo base_url('panel/filtrar_inventario'); ?>" method="post" style="margin:0;">
                    <select class="select-filtro" name="tipo" onchange="this.form.submit()">
                        <option value="">Todos los tipos</option>
                        <?php foreach($tipos as $tipo): ?>
                        <option value="<?php echo $tipo->id_tipos; ?>"
                                <?php echo ($tipo->id_tipos == $tipo_seleccionado) ? 'selected' : ''; ?>>
                            <?php echo $tipo->nombre; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <form action="<?php echo base_url('panel/buscar_inventario'); ?>" method="POST" style="margin:0;width:100%;">
                    <div class="input-buscar">
                        <i class="fas fa-search"></i>
                        <input type="text" name="cInterno" placeholder="Buscar código interno..."
                               value="<?php echo isset($codigo_buscado) ? htmlspecialchars($codigo_buscado) : ''; ?>">
                    </div>
                </form>
            </div>
            <div class="toolbar-right">
                <div class="dropdown">
                    <button class="btn-outline dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-download"></i> Exportar
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="<?php echo base_url('pdf/generarPdfEquipos'); ?>" target="_blank">
                            <i class="fas fa-file-pdf" style="color:#dc2626;"></i> PDF
                        </a>
                        <a class="dropdown-item" href="<?php echo base_url('excel/index'); ?>">
                            <i class="fas fa-file-excel" style="color:#16a34a;"></i> Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php
        function badge_estado($e) {
            $e_lower = strtolower($e);
            if (strpos($e_lower,'servicio') !== false && strpos($e_lower,'fuera') === false)
                return '<span class="badge-e be-green">'.htmlspecialchars($e).'</span>';
            if (strpos($e_lower,'fuera') !== false || strpos($e_lower,'baja') !== false || strpos($e_lower,'malo') !== false)
                return '<span class="badge-e be-red">'.htmlspecialchars($e).'</span>';
            if (strpos($e_lower,'bueno') !== false)
                return '<span class="badge-e be-green">'.htmlspecialchars($e).'</span>';
            if (strpos($e_lower,'mantenimiento') !== false || strpos($e_lower,'reparaci') !== false)
                return '<span class="badge-e be-blue">'.htmlspecialchars($e).'</span>';
            return '<span class="badge-e be-yellow">'.htmlspecialchars($e).'</span>';
        }
        ?>

        <!-- TABLA desktop -->
        <div class="table-wrap">
        <table class="inv-t">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Descripción del producto</th>
                    <th>Unidad</th>
                    <th>Código interno</th>
                    <th>Marca</th>
                    <th>Proveedor</th>
                    <th>Estado del equipo</th>
                    <th>Observaciones</th>
                    <th style="text-align:center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if(isset($equipos) && !empty($equipos)): ?>
            <?php $contador = 1; ?>
            <?php foreach($equipos as $equipo): ?>
            <tr>
                <td class="td-main text-center"><?php echo $contador++; ?></td>
                <td><?php echo htmlspecialchars($equipo->descripcion_producto ?? $equipo->tipo ?? ''); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($equipo->unidad ?? 'Pieza'); ?></td>
                <td><?php echo htmlspecialchars($equipo->codigo_interno ?? ''); ?></td>
                <td><?php echo htmlspecialchars($equipo->marca ?? ''); ?></td>
                <td><?php echo htmlspecialchars($equipo->proveedor ?? ''); ?></td>
                <td><?php echo badge_estado($equipo->estado ?? ''); ?></td>
                <td style="max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
                    title="<?php echo htmlspecialchars($equipo->observaciones ?? ''); ?>">
                    <?php echo htmlspecialchars($equipo->observaciones ?? ''); ?>
                </td>
                <td style="text-align:center;white-space:nowrap;">
                    <a href="<?php echo base_url('panel/detalles/' . $equipo->id_equipos); ?>"
                       class="ac-btn ab-info" title="Ver detalles">
                       <i class="zmdi zmdi-eye"></i></a>
                    <a href="<?php echo base_url('panel/editar/' . $equipo->id_equipos); ?>"
                       class="ac-btn ab-edit" title="Editar">
                       <i class="zmdi zmdi-edit"></i></a>
                    <a href="<?php echo base_url('inventario/eliminar/' . $equipo->id_equipos); ?>"
                       class="ac-btn ab-del" title="Eliminar"
                       onclick="return confirm('¿Estás seguro de eliminar este equipo? Esta acción no se puede deshacer.')">
                       <i class="zmdi zmdi-delete"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="9">
                    <div class="empty-state">
                        <i class="fas fa-box-open"></i>
                        No hay equipos registrados
                    </div>
                </td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
        </div>

        <!-- CARDS móvil -->
        <div class="mobile-cards">
        <?php if(isset($equipos) && !empty($equipos)): ?>
        <?php $cnt = 1; ?>
        <?php foreach($equipos as $equipo): ?>
        <div class="equipo-card">
            <div class="equipo-card-header">
                <span class="equipo-card-num">#<?php echo $cnt++; ?></span>
                <span class="equipo-card-tipo">
                    <?php echo htmlspecialchars($equipo->descripcion_producto ?? $equipo->tipo ?? 'Sin descripción'); ?>
                </span>
                <?php echo badge_estado($equipo->estado ?? ''); ?>
            </div>
            <div class="equipo-card-body">
                <div class="equipo-card-row">
                    <span class="lbl">Código interno</span>
                    <span class="val"><?php echo htmlspecialchars($equipo->codigo_interno ?? '—'); ?></span>
                </div>
                <div class="equipo-card-row">
                    <span class="lbl">Marca</span>
                    <span class="val"><?php echo htmlspecialchars($equipo->marca ?? '—'); ?></span>
                </div>
                <div class="equipo-card-row">
                    <span class="lbl">Unidad</span>
                    <span class="val"><?php echo htmlspecialchars($equipo->unidad ?? 'Pieza'); ?></span>
                </div>
                <div class="equipo-card-row">
                    <span class="lbl">Proveedor</span>
                    <span class="val"><?php echo htmlspecialchars($equipo->proveedor ?? '—'); ?></span>
                </div>
                <?php if(!empty($equipo->observaciones)): ?>
                <div class="equipo-card-row" style="grid-column:1/-1;">
                    <span class="lbl">Observaciones</span>
                    <span class="val"><?php echo htmlspecialchars($equipo->observaciones); ?></span>
                </div>
                <?php endif; ?>
            </div>
            <div class="equipo-card-footer">
                <div class="card-actions">
                    <a href="<?php echo base_url('panel/detalles/' . $equipo->id_equipos); ?>"
                       class="ac-btn ab-info" title="Ver detalles">
                       <i class="zmdi zmdi-eye"></i></a>
                    <a href="<?php echo base_url('panel/editar/' . $equipo->id_equipos); ?>"
                       class="ac-btn ab-edit" title="Editar">
                       <i class="zmdi zmdi-edit"></i></a>
                    <a href="<?php echo base_url('inventario/eliminar/' . $equipo->id_equipos); ?>"
                       class="ac-btn ab-del" title="Eliminar"
                       onclick="return confirm('¿Estás seguro de eliminar este equipo?')">
                       <i class="zmdi zmdi-delete"></i></a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            No hay equipos registrados
        </div>
        <?php endif; ?>
        </div>

        <div class="pagination-wrap">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>

</div>
</div>
</div>

<!-- Modal: Agregar nuevo encargado -->
<div class="modal fade" id="modalNuevoEncargado" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius:14px;overflow:hidden;border:none;">
            <div class="modal-header" style="background:linear-gradient(135deg,#8B1A10,#a52119);border:none;padding:18px 22px;">
                <h5 class="modal-title" style="color:white;font-weight:700;">
                    <i class="fas fa-user-plus mr-2"></i> Agregar encargado
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color:white;opacity:1;">&times;</button>
            </div>
            <div class="modal-body" style="padding:22px;">
                <div class="f-group">
                    <label class="f-label">Nombre completo *</label>
                    <input type="text" id="ne_nombre" class="f-control" placeholder="Ej: Mtra. Eulalia Cortés Flores">
                </div>
                <div class="f-group">
                    <label class="f-label">Cargo *</label>
                    <input type="text" id="ne_cargo" class="f-control" placeholder="Ej: Responsable del Laboratorio">
                </div>
                <div style="display:flex;gap:10px;margin-top:18px;">
                    <button type="button" class="btn-g" data-dismiss="modal" style="flex:1;justify-content:center;">Cancelar</button>
                    <button type="button" class="btn-r" style="flex:1;justify-content:center;" id="btnGuardarEncargado">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var BASE_URL = '<?php echo base_url(); ?>';
var LAB_ID   = '<?php echo $this->session->userdata("laboratorio_id"); ?>';

// ── Guardar encargado en sesión al cambiar el select ────────
$('#selectEncargado').on('change', function() {
    var nombre = $(this).val();
    $.ajax({
        url: BASE_URL + 'firmantes/guardar_encargado',
        method: 'POST',
        data: { nombre: nombre },
        dataType: 'json',
        success: function(r) {
            if (r.success) {
                $('#savedMsg').css('display','inline-flex');
                setTimeout(function(){ $('#savedMsg').fadeOut(); }, 2000);
            }
        }
    });
});

// ── Guardar nuevo firmante vía AJAX ─────────────────────────
$('#btnGuardarEncargado').click(function() {
    var nombre = $('#ne_nombre').val().trim();
    var cargo  = $('#ne_cargo').val().trim();
    if (!nombre || !cargo) { alert('Completa todos los campos.'); return; }
    $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
    $.ajax({
        url: BASE_URL + 'firmantes/crear_ajax',
        method: 'POST',
        data: { nombre: nombre, cargo: cargo, rol: 'jefe_laboratorio', laboratorio_id: LAB_ID },
        dataType: 'json',
        success: function(r) {
            if (r.success) {
                $('#selectEncargado').append('<option value="' + nombre + '" selected>' + nombre + '</option>');
                // Guardar en sesión automáticamente
                $.post(BASE_URL + 'firmantes/guardar_encargado', { nombre: nombre });
                $('#modalNuevoEncargado').modal('hide');
                $('#ne_nombre, #ne_cargo').val('');
                $('#savedMsg').css('display','inline-flex');
                setTimeout(function(){ $('#savedMsg').fadeOut(); }, 2000);
            } else { alert(r.error || 'Error al guardar'); }
            $('#btnGuardarEncargado').prop('disabled', false).html('<i class="fas fa-save"></i> Guardar');
        },
        error: function() {
            alert('Error de conexión');
            $('#btnGuardarEncargado').prop('disabled', false).html('<i class="fas fa-save"></i> Guardar');
        }
    });
});
</script>