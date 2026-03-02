<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
:root{--rojo:#a52119;--rojo-mid:#c0392b;--gris-bg:#f5f6f8;--gris-borde:#e2e8f0;--texto-dark:#1e293b;--texto-mid:#475569;--sombra-sm:0 2px 8px rgba(0,0,0,0.06);--radio:14px;--radio-sm:8px;}
.main-content{background:var(--gris-bg);min-height:calc(100vh - 81px);}
.section__content--p30{padding:20px 16px;}
@media(min-width:768px){.section__content--p30{padding:28px;}}
.page-header{background:white;border-radius:var(--radio);padding:16px 20px;margin-bottom:18px;box-shadow:var(--sombra-sm);display:flex;align-items:center;justify-content:space-between;border-left:4px solid var(--rojo);flex-wrap:wrap;gap:10px;}
.page-header h2{font-size:18px;font-weight:700;color:var(--texto-dark);margin:0;}
.page-header h2 i{color:var(--rojo);margin-right:8px;}
.card-m{background:white;border-radius:var(--radio);box-shadow:var(--sombra-sm);border:1px solid var(--gris-borde);overflow:hidden;}
.btn-r{background:linear-gradient(135deg,var(--rojo),var(--rojo-mid));color:white;border:none;border-radius:var(--radio-sm);padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;transition:all .25s;text-decoration:none;}
.btn-r:hover{box-shadow:0 5px 15px rgba(165,33,25,.3);transform:translateY(-1px);color:white;text-decoration:none;}
.table-wrap{overflow-x:auto;}
table.t{width:100%;border-collapse:collapse;min-width:600px;}
table.t thead th{background:#1e293b;color:white;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.4px;padding:12px 16px;white-space:nowrap;}
table.t tbody tr{border-bottom:1px solid var(--gris-borde);transition:background .15s;}
table.t tbody tr:hover{background:#fafbfc;}
table.t td{padding:11px 16px;font-size:13px;color:var(--texto-mid);vertical-align:middle;}
.ac-btn{width:30px;height:30px;border-radius:7px;display:inline-flex;align-items:center;justify-content:center;font-size:13px;transition:all .2s;border:none;cursor:pointer;text-decoration:none;}
.ac-btn:hover{transform:scale(1.1);text-decoration:none;}
.ab-info{background:#eff6ff;color:#2563eb;}
.ab-pdf{background:#fee2e2;color:#dc2626;}
.ab-del{background:#fef2f2;color:#dc2626;}
.empty-state{padding:50px 20px;text-align:center;color:var(--texto-mid);}
.empty-state i{font-size:44px;color:#cbd5e1;display:block;margin-bottom:12px;}
.alert-s{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0;border-radius:var(--radio-sm);padding:12px 18px;font-size:13.5px;display:flex;align-items:center;gap:10px;margin-bottom:16px;}
.alert-e{background:#fee2e2;color:#dc2626;border:1px solid #fecaca;border-radius:var(--radio-sm);padding:12px 18px;font-size:13.5px;display:flex;align-items:center;gap:10px;margin-bottom:16px;}
</style>

<div class="main-content">
<div class="section__content section__content--p30">
<div class="container-fluid">

    <div class="page-header">
        <h2><i class="fas fa-tools"></i> Órdenes de Mantenimiento</h2>
        <a href="<?php echo base_url('orden-mantenimiento/crear'); ?>" class="btn-r">
            <i class="fas fa-plus"></i> Nueva Orden
        </a>
    </div>

    <?php if($this->session->flashdata('success')): ?>
    <div class="alert-s"><i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?></div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
    <div class="alert-e"><i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <div class="card-m">
    <div class="table-wrap">
    <table class="t">
        <thead>
            <tr>
                <th>#</th>
                <th>Área solicitante</th>
                <th>Solicitante</th>
                <th>Fecha elaboración</th>
                <th>Descripción</th>
                <th style="text-align:center;">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if(!empty($ordenes)): ?>
        <?php foreach($ordenes as $i => $o): ?>
        <tr>
            <td><?php echo $o->id; ?></td>
            <td><?php echo htmlspecialchars($o->area_solicitante ?? ''); ?></td>
            <td><?php echo htmlspecialchars($o->solicitante ?? ''); ?></td>
            <td><?php echo !empty($o->fecha_elaboracion) ? date('d/m/Y', strtotime($o->fecha_elaboracion)) : ''; ?></td>
            <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                <?php echo htmlspecialchars($o->descripcion_servicio ?? ''); ?>
            </td>
            <td style="text-align:center;white-space:nowrap;">
                <a href="<?php echo base_url('orden-mantenimiento/editar/'.$o->id); ?>"
                   class="ac-btn ab-info" title="Ver / Editar">
                   <i class="fas fa-edit"></i></a>
                <a href="<?php echo base_url('orden-mantenimiento/pdf/'.$o->id); ?>"
                   class="ac-btn ab-pdf" title="Descargar PDF" target="_blank">
                   <i class="fas fa-file-pdf"></i></a>
                <a href="<?php echo base_url('orden-mantenimiento/eliminar/'.$o->id); ?>"
                   class="ac-btn ab-del" title="Eliminar"
                   onclick="return confirm('¿Eliminar esta orden y sus trabajos?')">
                   <i class="fas fa-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <tr><td colspan="6">
            <div class="empty-state">
                <i class="fas fa-clipboard-list"></i>
                No hay órdenes de mantenimiento registradas
            </div>
        </td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
    </div>

</div>
</div>
</div>