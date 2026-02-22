<style>
:root{--rojo:#a52119;--rojo-mid:#c0392b;--rojo-light:#fdf1f0;--gris-bg:#f5f6f8;--gris-borde:#e2e8f0;--texto-dark:#1e293b;--texto-mid:#475569;--sombra-sm:0 2px 8px rgba(0,0,0,0.06);--radio:14px;--radio-sm:8px;}
.main-content{background:var(--gris-bg);min-height:calc(100vh - 81px);}
.section__content--p30{padding:28px;}
.page-header{background:white;border-radius:var(--radio);padding:20px 26px;margin-bottom:22px;box-shadow:var(--sombra-sm);display:flex;align-items:center;justify-content:space-between;border-left:4px solid var(--rojo);}
.page-header h2{font-size:20px;font-weight:700;color:var(--texto-dark);margin:0;}
.page-header h2 i{color:var(--rojo);margin-right:10px;}
.btn-r{background:linear-gradient(135deg,var(--rojo),var(--rojo-mid));color:white;border:none;border-radius:var(--radio-sm);padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .25s;text-decoration:none;}
.btn-r:hover{box-shadow:0 6px 18px rgba(165,33,25,.3);transform:translateY(-1px);color:white;text-decoration:none;}
.btn-g{background:#f1f5f9;color:var(--texto-mid);border:1.5px solid var(--gris-borde);border-radius:var(--radio-sm);padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .2s;text-decoration:none;}
.btn-g:hover{background:#e2e8f0;color:var(--texto-dark);text-decoration:none;}

/* Grid de cards */
.reportes-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(270px,1fr));gap:20px;}

/* Card individual */
.reporte-card{background:white;border-radius:var(--radio);box-shadow:var(--sombra-sm);border:1px solid var(--gris-borde);overflow:hidden;transition:all .25s;}
.reporte-card:hover{box-shadow:0 12px 32px rgba(165,33,25,.12);transform:translateY(-3px);}
.rc-top{background:linear-gradient(135deg,#1e293b 0%,#334155 100%);padding:20px 22px;position:relative;overflow:hidden;}
.rc-top::after{content:'';position:absolute;right:-15px;top:-15px;width:70px;height:70px;background:rgba(255,255,255,.06);border-radius:50%;}
.rc-top::before{content:'';position:absolute;left:-10px;bottom:-20px;width:90px;height:90px;background:rgba(165,33,25,.2);border-radius:50%;}
.rc-year{font-size:36px;font-weight:700;color:white;display:block;position:relative;z-index:1;}
.rc-sub{font-size:11.5px;color:rgba(255,255,255,.55);margin-top:3px;position:relative;z-index:1;}
.rc-body{padding:18px 20px;}

/* Grid de meses */
.meses-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:5px;margin-bottom:14px;}
.mes-btn{display:block;padding:7px 4px;background:#f8fafc;border:1.5px solid var(--gris-borde);border-radius:7px;text-align:center;font-size:11px;font-weight:700;color:var(--texto-mid);text-decoration:none;transition:all .15s;letter-spacing:.3px;}
.mes-btn:hover{background:var(--rojo-light);border-color:var(--rojo);color:var(--rojo);text-decoration:none;transform:scale(1.04);}

/* Botones de acción del card */
.rc-actions{display:flex;gap:8px;}
.rc-actions a, .rc-actions button{flex:1;display:flex;align-items:center;justify-content:center;gap:6px;padding:9px;border-radius:var(--radio-sm);font-size:12.5px;font-weight:600;text-decoration:none;transition:all .2s;border:none;cursor:pointer;}
.btn-pdf{background:var(--rojo-light);color:var(--rojo);}
.btn-pdf:hover{background:var(--rojo);color:white;text-decoration:none;}
.btn-del{background:#f1f5f9;color:#94a3b8;}
.btn-del:hover{background:#fee2e2;color:#dc2626;}

/* Card para crear nuevo */
.card-nuevo{background:white;border-radius:var(--radio);box-shadow:var(--sombra-sm);border:2px dashed var(--gris-borde);overflow:hidden;transition:all .25s;display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:220px;cursor:pointer;}
.card-nuevo:hover{border-color:var(--rojo);background:var(--rojo-light);}
.card-nuevo:hover .cn-icon{background:var(--rojo);color:white;}
.card-nuevo:hover .cn-text{color:var(--rojo);}
.cn-icon{width:52px;height:52px;border-radius:50%;background:#f1f5f9;color:var(--texto-mid);display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:12px;transition:all .25s;}
.cn-text{font-size:14px;font-weight:700;color:var(--texto-mid);transition:color .25s;}
.cn-hint{font-size:12px;color:#cbd5e1;margin-top:4px;}

/* Alerts */
.alert-m{border-radius:var(--radio-sm);padding:12px 18px;font-size:13.5px;display:flex;align-items:center;gap:10px;margin-bottom:18px;border:none;}
.alert-s{background:#dcfce7;color:#15803d;}
.alert-e{background:#fee2e2;color:#dc2626;}

/* Estado vacío */
.empty-state{text-align:center;padding:60px 20px;color:var(--texto-mid);grid-column:1/-1;}
.empty-state i{font-size:52px;color:#cbd5e1;display:block;margin-bottom:14px;}
</style>

<div class="main-content">
<div class="section__content section__content--p30">
<div class="container-fluid">

    <!-- Encabezado -->
    <div class="page-header">
        <h2><i class="fas fa-clipboard-check"></i> Reportes de Servicios</h2>
        <span style="font-size:13px;color:var(--texto-mid);">
            Laboratorio: <strong style="color:var(--rojo);"><?php echo $this->session->userdata('laboratorio_nombre'); ?></strong>
        </span>
    </div>

    <!-- Flash messages -->
    <?php if($this->session->flashdata('success')): ?>
    <div class="alert-m alert-s">
        <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
    </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
    <div class="alert-m alert-e">
        <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
    </div>
    <?php endif; ?>

    <!-- Grid de reportes -->
    <div class="reportes-grid">

        <!-- Card "Nuevo reporte" — siempre visible -->
        <div class="card-nuevo" data-toggle="modal" data-target="#modalNuevoReporte">
            <div class="cn-icon"><i class="fas fa-plus"></i></div>
            <span class="cn-text">Nuevo reporte</span>
            <span class="cn-hint">Crear lista de cotejo anual</span>
        </div>

        <?php if(!empty($reportes)): ?>
        <?php foreach($reportes as $reporte): ?>
        <div class="reporte-card">
            <!-- Cabecera con año -->
            <div class="rc-top">
                <span class="rc-year"><?php echo $reporte->año; ?></span>
                <span class="rc-sub">Lista de Cotejo — Verificación mensual</span>
            </div>
            <div class="rc-body">
                <!-- Botones de meses -->
                <div class="meses-grid">
                    <?php
                    $meses = [1=>'Ene',2=>'Feb',3=>'Mar',4=>'Abr',5=>'May',6=>'Jun',
                              7=>'Jul',8=>'Ago',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dic'];
                    foreach($meses as $num => $nombre):
                    ?>
                    <a href="<?php echo base_url('reporteservicios/actualizar_mes/'.$reporte->id.'/'.$num); ?>"
                       class="mes-btn"><?php echo $nombre; ?></a>
                    <?php endforeach; ?>
                </div>
                <!-- Acciones del card -->
                <div class="rc-actions">
                    <a href="<?php echo base_url('reporteServicios/generarReporte/'.$reporte->año); ?>"
                       class="btn-pdf" target="_blank">
                        <i class="fas fa-file-pdf"></i> Exportar PDF
                    </a>
                    <button class="btn-del"
                            onclick="confirmarEliminar(<?php echo $reporte->id; ?>, <?php echo $reporte->año; ?>)"
                            title="Eliminar reporte">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-clipboard"></i>
            <p style="font-size:15px;font-weight:700;color:var(--texto-dark);margin-bottom:6px;">Sin reportes aún</p>
            <p style="font-size:13px;">Crea tu primer reporte usando el botón <strong>+</strong></p>
        </div>
        <?php endif; ?>

    </div><!-- /reportes-grid -->

</div>
</div>
</div>

<!-- ── Modal: Nuevo reporte ───────────────────────────────── -->
<div class="modal fade" id="modalNuevoReporte" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm"><div class="modal-content" style="border-radius:14px;overflow:hidden;border:none;">
        <div class="modal-header" style="background:linear-gradient(135deg,#1e293b,#334155);border:none;padding:20px 24px;">
            <h5 class="modal-title" style="color:white;font-weight:700;font-size:16px;">
                <i class="fas fa-plus-circle mr-2" style="color:#a52119;"></i> Nuevo Reporte
            </h5>
            <button type="button" class="close" data-dismiss="modal" style="color:white;opacity:.8;">&times;</button>
        </div>
        <div class="modal-body" style="padding:24px;">
            <form action="<?php echo base_url('reporteservicios/crear'); ?>" method="post">
                <div style="margin-bottom:6px;">
                    <label style="font-size:13px;font-weight:600;color:#1e293b;display:block;margin-bottom:8px;">
                        Año del reporte
                    </label>
                    <input type="number" name="año"
                           min="2000" max="2100"
                           value="<?php echo date('Y'); ?>"
                           style="width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:10px 14px;font-size:15px;font-weight:700;color:#1e293b;outline:none;text-align:center;"
                           onfocus="this.style.borderColor='#a52119'"
                           onblur="this.style.borderColor='#e2e8f0'"
                           required>
                </div>
                <div style="display:flex;gap:10px;margin-top:20px;">
                    <button type="button" class="btn-g" data-dismiss="modal" style="flex:1;justify-content:center;">
                        Cancelar
                    </button>
                    <button type="submit" class="btn-r" style="flex:1;justify-content:center;">
                        <i class="fas fa-plus"></i> Crear
                    </button>
                </div>
            </form>
        </div>
    </div></div>
</div>

<script>
function confirmarEliminar(id, año) {
    if (confirm('¿Eliminar el reporte del año ' + año + '?\nSe borrarán todos sus registros mensuales.')) {
        window.location.href = '<?php echo base_url("reporteservicios/eliminar/"); ?>' + id;
    }
}
</script>