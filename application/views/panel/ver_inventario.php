<style>
:root{--rojo:#a52119;--rojo-mid:#c0392b;--rojo-light:#fdf1f0;--gris-bg:#f5f6f8;--gris-borde:#e2e8f0;--texto-dark:#1e293b;--texto-mid:#475569;--sombra-sm:0 2px 8px rgba(0,0,0,0.06);--radio:14px;--radio-sm:8px;}
.main-content{background:var(--gris-bg);min-height:calc(100vh - 81px);}
.section__content--p30{padding:28px;}
.page-header{background:white;border-radius:var(--radio);padding:20px 26px;margin-bottom:22px;box-shadow:var(--sombra-sm);display:flex;align-items:center;justify-content:space-between;border-left:4px solid var(--rojo);}
.page-header h2{font-size:20px;font-weight:700;color:var(--texto-dark);margin:0;}
.page-header h2 i{color:var(--rojo);margin-right:10px;}
.card-m{background:white;border-radius:var(--radio);box-shadow:var(--sombra-sm);border:1px solid var(--gris-borde);overflow:hidden;}
.toolbar{padding:14px 20px;display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;border-bottom:1px solid var(--gris-borde);}
.toolbar-left{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.input-buscar{display:flex;align-items:center;background:#f8fafc;border:1.5px solid var(--gris-borde);border-radius:var(--radio-sm);padding:0 12px;gap:8px;transition:border-color .2s;}
.input-buscar:focus-within{border-color:var(--rojo);}
.input-buscar input{border:none;background:transparent;padding:9px 0;font-size:13.5px;color:var(--texto-dark);outline:none;width:190px;}
.input-buscar i{color:var(--texto-mid);font-size:14px;}
.select-filtro{border:1.5px solid var(--gris-borde);border-radius:var(--radio-sm);padding:9px 12px;font-size:13.5px;color:var(--texto-dark);background:white;cursor:pointer;outline:none;transition:border-color .2s;}
.select-filtro:focus{border-color:var(--rojo);}
.btn-r{background:linear-gradient(135deg,var(--rojo),var(--rojo-mid));color:white;border:none;border-radius:var(--radio-sm);padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;transition:all .25s;text-decoration:none;}
.btn-r:hover{box-shadow:0 5px 15px rgba(165,33,25,.3);transform:translateY(-1px);color:white;text-decoration:none;}
.btn-outline{background:white;color:var(--texto-mid);border:1.5px solid var(--gris-borde);border-radius:var(--radio-sm);padding:9px 15px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;transition:all .2s;text-decoration:none;}
.btn-outline:hover{background:#f1f5f9;color:var(--texto-dark);text-decoration:none;}
table.inv-t{width:100%;border-collapse:collapse;}
table.inv-t thead th{background:#1e293b;color:white;font-size:11.5px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;padding:13px 16px;border:none;}
table.inv-t thead th:first-child{border-radius:0;}
table.inv-t tbody tr{border-bottom:1px solid var(--gris-borde);transition:background .15s;}
table.inv-t tbody tr:hover{background:#fafbfc;}
table.inv-t td{padding:12px 16px;font-size:13.5px;color:var(--texto-mid);vertical-align:middle;}
.td-main{color:var(--texto-dark)!important;font-weight:600;}
.badge-e{padding:4px 10px;border-radius:20px;font-size:11.5px;font-weight:600;display:inline-block;}
.be-green{background:#dcfce7;color:#15803d;}
.be-red{background:#fee2e2;color:#dc2626;}
.be-yellow{background:#fef9c3;color:#a16207;}
.ac-btn{width:32px;height:32px;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;font-size:14px;transition:all .2s;border:none;cursor:pointer;text-decoration:none;}
.ac-btn:hover{transform:scale(1.1);text-decoration:none;}
.ab-info{background:#eff6ff;color:#2563eb;}
.ab-edit{background:#fffbeb;color:#d97706;}
.ab-del{background:#fef2f2;color:#dc2626;}
.ab-more{background:#f1f5f9;color:#475569;}
.dropdown-menu{border:none;box-shadow:0 8px 24px rgba(0,0,0,.12);border-radius:10px;border-top:2px solid var(--rojo);padding:6px 0;min-width:180px;}
.dropdown-item{font-size:13px;padding:9px 16px;color:var(--texto-mid);display:flex;align-items:center;gap:8px;transition:background .15s,color .15s;}
.dropdown-item:hover{background:var(--rojo-light);color:var(--rojo);}
.empty-state{padding:60px 20px;text-align:center;color:var(--texto-mid);}
.empty-state i{font-size:48px;color:#cbd5e1;display:block;margin-bottom:12px;}
.pagination-wrap{padding:14px 20px;border-top:1px solid var(--gris-borde);}
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

    <div class="card-m">
        <div class="toolbar">
            <div class="toolbar-left">
                <form action="<?php echo base_url('panel/filtrar_inventario'); ?>" method="post" style="margin:0;">
                    <select class="select-filtro" name="tipo" onchange="this.form.submit()">
                        <option value="">Todos los tipos</option>
                        <?php foreach($tipos as $tipo): ?>
                        <option value="<?php echo $tipo->id_tipos; ?>" <?php echo ($tipo->id_tipos == $tipo_seleccionado) ? 'selected' : ''; ?>>
                            <?php echo $tipo->nombre; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <form action="<?php echo base_url('panel/buscar_inventario'); ?>" method="POST" style="margin:0;">
                    <div class="input-buscar">
                        <i class="fas fa-search"></i>
                        <input type="text" name="cInterno" placeholder="Buscar código interno..."
                               value="<?php echo isset($codigo_buscado) ? $codigo_buscado : ''; ?>">
                    </div>
                </form>
            </div>
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

        <div class="table-responsive">
        <table class="inv-t">
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>Código Interno</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th style="text-align:center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if(isset($equipos) && !empty($equipos)): ?>
            <?php foreach($equipos as $equipo): ?>
            <tr>
                <td class="td-main"><?php echo $equipo->marca; ?></td>
                <td><?php echo $equipo->cod_interno; ?></td>
                <td><?php echo $equipo->tipo; ?></td>
                <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    <?php echo $equipo->descripcion; ?>
                </td>
                <td>
                    <?php
                    $e = $equipo->estado;
                    if($e == 'En servicio')       echo '<span class="badge-e be-green">'.$e.'</span>';
                    elseif($e == 'Fuera de servicio') echo '<span class="badge-e be-red">'.$e.'</span>';
                    else echo '<span class="badge-e be-yellow">'.$e.'</span>';
                    ?>
                </td>
                <td style="text-align:center;white-space:nowrap;">
                    <a href="<?php echo base_url('panel/detalles/'.$equipo->id_equipos); ?>"
                       class="ac-btn ab-info" title="Ver detalles"><i class="fas fa-eye"></i></a>
                    <a href="<?php echo base_url('panel/editar/'.$equipo->id_equipos); ?>"
                       class="ac-btn ab-edit" title="Editar"><i class="fas fa-pen"></i></a>
                    <a href="<?php echo base_url('inventario/eliminar/'.$equipo->id_equipos); ?>"
                       class="ac-btn ab-del" title="Eliminar"
                       onclick="return confirm('¿Eliminar este equipo?')"><i class="fas fa-trash"></i></a>
                    <div class="dropdown d-inline-block">
                        <button class="ac-btn ab-more" title="Más opciones" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="<?php echo base_url('panel/orden_mantenimiento/'.$equipo->id_equipos); ?>">
                                <i class="fas fa-tools" style="color:var(--rojo);"></i> Orden mantenimiento
                            </a>
                            <a class="dropdown-item" href="<?php echo base_url('orden/ver_ordenesEquipo/'.$equipo->id_equipos); ?>">
                                <i class="fas fa-list" style="color:#2563eb;"></i> Ver órdenes
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="6">
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

        <div class="pagination-wrap">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>

</div>
</div>
</div>