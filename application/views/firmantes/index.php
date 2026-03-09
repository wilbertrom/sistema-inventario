<style>
:root {
    --rojo: #a52119; --rojo-dark: #8a1a14; --rojo-mid: #c0392b;
    --rojo-light: #fdf1f0; --gris-bg: #f5f6f8; --gris-borde: #e2e8f0;
    --texto-dark: #1e293b; --texto-mid: #475569;
    --sombra-sm: 0 2px 8px rgba(0,0,0,0.06); --radio: 14px; --radio-sm: 8px;
}
.main-content { background: var(--gris-bg); min-height: calc(100vh - 81px); }
.section__content--p30 { padding: 28px; }
.page-header {
    background: white; border-radius: var(--radio); padding: 20px 26px;
    margin-bottom: 22px; box-shadow: var(--sombra-sm);
    display: flex; align-items: center; justify-content: space-between;
    border-left: 4px solid var(--rojo);
}
.page-header h2 { font-size: 20px; font-weight: 700; color: var(--texto-dark); margin: 0; }
.page-header h2 i { color: var(--rojo); margin-right: 10px; }
.btn-r {
    background: linear-gradient(135deg, var(--rojo), var(--rojo-mid));
    color: white; border: none; border-radius: var(--radio-sm);
    padding: 9px 18px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 7px;
    transition: all .25s; text-decoration: none;
}
.btn-r:hover { box-shadow: 0 6px 18px rgba(165,33,25,.3); transform: translateY(-1px); color: white; text-decoration: none; }
.btn-g {
    background: #f1f5f9; color: var(--texto-mid); border: 1.5px solid var(--gris-borde);
    border-radius: var(--radio-sm); padding: 9px 18px; font-size: 13px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: all .2s; text-decoration: none;
}
.btn-g:hover { background: #e2e8f0; color: var(--texto-dark); text-decoration: none; }
.card-f {
    background: white; border-radius: var(--radio); box-shadow: var(--sombra-sm);
    border: 1px solid var(--gris-borde); overflow: hidden; margin-bottom: 22px;
}
.card-f-header {
    padding: 16px 22px; border-bottom: 1px solid var(--gris-borde);
    display: flex; align-items: center; justify-content: space-between;
    background: linear-gradient(135deg, var(--rojo-dark), var(--rojo));
}
.card-f-header h5 { color: white; font-weight: 700; margin: 0; font-size: 15px; }
.card-f-header h5 i { margin-right: 8px; }
.badge-rol {
    display: inline-block; padding: 3px 10px; border-radius: 20px;
    font-size: 11px; font-weight: 600; letter-spacing: .3px;
}
.rol-jefe     { background: #dbeafe; color: #1d4ed8; }
.rol-vo_bo    { background: #dcfce7; color: #15803d; }
.rol-revisor  { background: #fef9c3; color: #a16207; }
.rol-autorizo { background: #f3e8ff; color: #7e22ce; }
.rol-cuatrimestre { background: #ffe4e6; color: #be123c; }
.tabla-f { width: 100%; border-collapse: collapse; }
.tabla-f th {
    background: #f8fafc; padding: 11px 16px; font-size: 12px;
    font-weight: 700; color: var(--texto-mid); text-transform: uppercase;
    letter-spacing: .5px; border-bottom: 2px solid var(--gris-borde); text-align: left;
}
.tabla-f td {
    padding: 12px 16px; font-size: 13.5px; color: var(--texto-dark);
    border-bottom: 1px solid #f1f5f9; vertical-align: middle;
}
.tabla-f tr:hover td { background: #fafafa; }
.btn-accion {
    width: 32px; height: 32px; border-radius: 8px; border: none;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 13px; cursor: pointer; transition: all .2s;
}
.btn-edit { background: #dbeafe; color: #1d4ed8; }
.btn-edit:hover { background: #1d4ed8; color: white; }
.btn-del2 { background: #fee2e2; color: #dc2626; }
.btn-del2:hover { background: #dc2626; color: white; }
.alert-m { border-radius: var(--radio-sm); padding: 12px 18px; font-size: 13.5px; display: flex; align-items: center; gap: 10px; margin-bottom: 18px; border: none; }
.alert-s { background: #dcfce7; color: #15803d; }
.alert-e { background: #fee2e2; color: #dc2626; }
.form-ctrl {
    width: 100%; border: 1.5px solid var(--gris-borde); border-radius: 8px;
    padding: 9px 13px; font-size: 13.5px; color: var(--texto-dark);
    outline: none; transition: border-color .2s; background: white;
}
.form-ctrl:focus { border-color: var(--rojo); }
.form-lbl { font-size: 13px; font-weight: 600; color: var(--texto-dark); display: block; margin-bottom: 6px; }
.empty-row td { text-align: center; padding: 40px; color: #94a3b8; font-style: italic; }
</style>

<div class="main-content">
<div class="section__content section__content--p30">
<div class="container-fluid">

    <!-- Header -->
    <div class="page-header">
        <h2><i class="fas fa-users"></i> Gestión de Firmantes</h2>
        <button class="btn-r" data-toggle="modal" data-target="#modalNuevo">
            <i class="fas fa-plus"></i> Agregar Firmante
        </button>
    </div>

    <!-- Alerts -->
    <?php if($this->session->flashdata('success')): ?>
    <div class="alert-m alert-s"><i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
    <div class="alert-m alert-e"><i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <!-- Tabla -->
    <div class="card-f">
        <div class="card-f-header">
            <h5><i class="fas fa-signature"></i> Firmantes registrados</h5>
            <span style="color:rgba(255,255,255,.75);font-size:13px;">
                <?= count($firmantes) ?> firmante(s)
            </span>
        </div>
        <div style="overflow-x:auto;">
        <table class="tabla-f">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>Rol en formato</th>
                    <th>Laboratorio</th>
                    <th style="text-align:center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if(empty($firmantes)): ?>
                <tr class="empty-row"><td colspan="6"><i class="fas fa-user-slash" style="font-size:28px;display:block;margin-bottom:8px;"></i>No hay firmantes registrados</td></tr>
            <?php else: ?>
            <?php foreach($firmantes as $f): ?>
                <tr>
                    <td><?= $f->id ?></td>
                    <td><strong><?= htmlspecialchars($f->nombre) ?></strong></td>
                    <td><?= htmlspecialchars($f->cargo) ?></td>
                    <td>
                        <?php
                        $rolClass = [
                            'jefe_laboratorio' => 'rol-jefe',
                            'vo_bo'            => 'rol-vo_bo',
                            'revisor'          => 'rol-revisor',
                            'autorizo'         => 'rol-autorizo',
                            'cuatrimestre'     => 'rol-cuatrimestre',
                        ];
                        $rolLabel = $roles[$f->rol] ?? $f->rol;
                        $cls = $rolClass[$f->rol] ?? '';
                        ?>
                        <span class="badge-rol <?= $cls ?>"><?= $rolLabel ?></span>
                    </td>
                    <td><?= $f->laboratorio_id ? 'Lab #'.$f->laboratorio_id : '<span style="color:#94a3b8;">Todos</span>' ?></td>
                    <td style="text-align:center;">
                        <button class="btn-accion btn-edit"
                            onclick="abrirEditar(<?= $f->id ?>, '<?= addslashes($f->nombre) ?>', '<?= addslashes($f->cargo) ?>', '<?= $f->rol ?>', '<?= $f->laboratorio_id ?>')"
                            title="Editar">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="btn-accion btn-del2"
                            onclick="confirmarEliminar(<?= $f->id ?>, '<?= addslashes($f->nombre) ?>')"
                            title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>

</div>
</div>
</div>

<!-- ── Modal: Nuevo firmante ─────────────────────────────── -->
<div class="modal fade" id="modalNuevo" tabindex="-1">
<div class="modal-dialog modal-md"><div class="modal-content" style="border-radius:14px;overflow:hidden;border:none;">
    <div class="modal-header" style="background:linear-gradient(135deg,var(--rojo-dark),var(--rojo));border:none;padding:20px 24px;">
        <h5 class="modal-title" style="color:white;font-weight:700;font-size:16px;">
            <i class="fas fa-user-plus mr-2"></i> Nuevo Firmante
        </h5>
        <button type="button" class="close" data-dismiss="modal" style="color:white;opacity:.8;">&times;</button>
    </div>
    <div class="modal-body" style="padding:24px;">
        <form action="<?= base_url('firmantes/crear') ?>" method="post">
            <div style="margin-bottom:14px;">
                <label class="form-lbl">Nombre completo <span style="color:var(--rojo);">*</span></label>
                <input type="text" name="nombre" class="form-ctrl" placeholder="Ej: Dr. Juan Pérez López" required>
            </div>
            <div style="margin-bottom:14px;">
                <label class="form-lbl">Cargo <span style="color:var(--rojo);">*</span></label>
                <input type="text" name="cargo" class="form-ctrl" placeholder="Ej: Director de Programa Educativo" required>
            </div>
            <div style="margin-bottom:14px;">
                <label class="form-lbl">Rol en los formatos <span style="color:var(--rojo);">*</span></label>
                <select name="rol" class="form-ctrl" required>
                    <option value="">— Selecciona un rol —</option>
                    <?php foreach($roles as $key => $label): ?>
                    <option value="<?= $key ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="margin-bottom:20px;">
                <label class="form-lbl">Laboratorio (opcional)</label>
                <select name="laboratorio_id" class="form-ctrl">
                    <option value="">Aplica para todos</option>
                    <option value="1">Lab #1 — Open Source</option>
                    <option value="2">Lab #2 — Mac</option>
                </select>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="button" class="btn-g" data-dismiss="modal" style="flex:1;justify-content:center;">Cancelar</button>
                <button type="submit" class="btn-r" style="flex:1;justify-content:center;"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </form>
    </div>
</div></div>
</div>

<!-- ── Modal: Editar firmante ────────────────────────────── -->
<div class="modal fade" id="modalEditar" tabindex="-1">
<div class="modal-dialog modal-md"><div class="modal-content" style="border-radius:14px;overflow:hidden;border:none;">
    <div class="modal-header" style="background:linear-gradient(135deg,#1d4ed8,#2563eb);border:none;padding:20px 24px;">
        <h5 class="modal-title" style="color:white;font-weight:700;font-size:16px;">
            <i class="fas fa-user-edit mr-2"></i> Editar Firmante
        </h5>
        <button type="button" class="close" data-dismiss="modal" style="color:white;opacity:.8;">&times;</button>
    </div>
    <div class="modal-body" style="padding:24px;">
        <form id="formEditar" action="" method="post">
            <div style="margin-bottom:14px;">
                <label class="form-lbl">Nombre completo <span style="color:var(--rojo);">*</span></label>
                <input type="text" id="edit_nombre" name="nombre" class="form-ctrl" required>
            </div>
            <div style="margin-bottom:14px;">
                <label class="form-lbl">Cargo <span style="color:var(--rojo);">*</span></label>
                <input type="text" id="edit_cargo" name="cargo" class="form-ctrl" required>
            </div>
            <div style="margin-bottom:14px;">
                <label class="form-lbl">Rol en los formatos <span style="color:var(--rojo);">*</span></label>
                <select id="edit_rol" name="rol" class="form-ctrl" required>
                    <?php foreach($roles as $key => $label): ?>
                    <option value="<?= $key ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="margin-bottom:20px;">
                <label class="form-lbl">Laboratorio (opcional)</label>
                <select id="edit_lab" name="laboratorio_id" class="form-ctrl">
                    <option value="">Aplica para todos</option>
                    <option value="1">Lab #1 — Open Source</option>
                    <option value="2">Lab #2 — Mac</option>
                </select>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="button" class="btn-g" data-dismiss="modal" style="flex:1;justify-content:center;">Cancelar</button>
                <button type="submit" class="btn-r" style="flex:1;justify-content:center;background:linear-gradient(135deg,#1d4ed8,#2563eb);"><i class="fas fa-save"></i> Actualizar</button>
            </div>
        </form>
    </div>
</div></div>
</div>

<script>
var BASE_URL = '<?= base_url() ?>';

function abrirEditar(id, nombre, cargo, rol, lab) {
    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_cargo').value  = cargo;
    document.getElementById('edit_rol').value    = rol;
    document.getElementById('edit_lab').value    = lab || '';
    document.getElementById('formEditar').action = BASE_URL + 'firmantes/actualizar/' + id;
    $('#modalEditar').modal('show');
}

function confirmarEliminar(id, nombre) {
    if (confirm('¿Eliminar a "' + nombre + '" de la lista de firmantes?')) {
        window.location.href = BASE_URL + 'firmantes/eliminar/' + id;
    }
}
</script>