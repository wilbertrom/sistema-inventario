<style>
:root{--rojo:#a52119;--rojo-mid:#c0392b;--rojo-light:#fdf1f0;--gris-bg:#f5f6f8;--gris-borde:#e2e8f0;--texto-dark:#1e293b;--texto-mid:#475569;--sombra-sm:0 2px 8px rgba(0,0,0,0.06);--radio:14px;}
.main-content{background:var(--gris-bg);min-height:calc(100vh - 81px);}
.section__content--p30{padding:28px;}
.page-header{background:white;border-radius:var(--radio);padding:20px 26px;margin-bottom:22px;box-shadow:var(--sombra-sm);display:flex;align-items:center;justify-content:space-between;border-left:4px solid var(--rojo);}
.page-header h2{font-size:20px;font-weight:700;color:var(--texto-dark);margin:0;}
.page-header h2 i{color:var(--rojo);margin-right:10px;}
.card-m{background:white;border-radius:var(--radio);box-shadow:var(--sombra-sm);border:1px solid var(--gris-borde);overflow:hidden;max-width:700px;margin:0 auto;}
.card-head{padding:18px 24px;border-bottom:1px solid var(--gris-borde);background:#fafbfc;}
.card-head h4{margin:0;font-size:16px;font-weight:700;color:var(--texto-dark);}
.card-body-p{padding:24px;}
.servicio-row{display:flex;align-items:center;justify-content:space-between;padding:14px 0;border-bottom:1px solid #f1f5f9;}
.servicio-row:last-child{border-bottom:none;}
.servicio-nombre{font-size:14px;color:var(--texto-dark);font-weight:500;flex:1;padding-right:16px;}
.radio-group{display:flex;gap:20px;}
.radio-opt{display:flex;align-items:center;gap:6px;cursor:pointer;}
.radio-opt input[type=radio]{accent-color:var(--rojo);width:16px;height:16px;cursor:pointer;}
.radio-opt label{font-size:13px;font-weight:600;cursor:pointer;margin:0;}
.radio-si  label{color:#15803d;}
.radio-no  label{color:#dc2626;}
.radio-na  label{color:#6b7280;}
.form-actions{display:flex;gap:12px;margin-top:24px;padding-top:20px;border-top:1px solid var(--gris-borde);}
.btn-r{background:linear-gradient(135deg,var(--rojo),var(--rojo-mid));color:white;border:none;border-radius:8px;padding:10px 22px;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .25s;}
.btn-r:hover{box-shadow:0 6px 18px rgba(165,33,25,.3);transform:translateY(-1px);}
.btn-g{background:#f1f5f9;color:var(--texto-mid);border:1.5px solid var(--gris-borde);border-radius:8px;padding:10px 22px;font-size:13.5px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .2s;text-decoration:none;}
.btn-g:hover{background:#e2e8f0;color:var(--texto-dark);text-decoration:none;}
</style>

<div class="main-content">
<div class="section__content section__content--p30">
<div class="container-fluid">

    <div class="page-header">
        <h2><i class="fas fa-clipboard-list"></i> Actualizar Mes</h2>
        <a href="<?php echo base_url('reporteservicios/index'); ?>" class="btn-g" style="padding:8px 16px;font-size:13px;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card-m">
        <div class="card-head">
            <h4><i class="fas fa-calendar-alt" style="color:var(--rojo);margin-right:8px;"></i>
                <?php
                $meses_nombres = [1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',
                                  7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'];
                echo isset($meses_nombres[$mes]) ? $meses_nombres[$mes] : 'Mes '.$mes;
                ?>
            </h4>
        </div>
        <div class="card-body-p">
            <form action="<?php echo site_url('ReporteServicios/actualizar_servicios'); ?>" method="post">
                <input type="hidden" name="reporte_id" value="<?php echo $reporte_id; ?>">
                <input type="hidden" name="mes" value="<?php echo $mes; ?>">

                <?php foreach($servicios as $servicio):
                    $estado = isset($estados_servicios[$servicio->id]) ? $estados_servicios[$servicio->id] : '';
                ?>
                <div class="servicio-row">
                    <span class="servicio-nombre"><?php echo $servicio->nombre_servicio; ?></span>
                    <div class="radio-group">
                        <label class="radio-opt radio-si">
                            <input type="radio" name="servicio_<?php echo $servicio->id; ?>" value="SI" required
                                   <?php echo ($estado === 'SI') ? 'checked' : ''; ?>>
                            <label>SI</label>
                        </label>
                        <label class="radio-opt radio-no">
                            <input type="radio" name="servicio_<?php echo $servicio->id; ?>" value="NO"
                                   <?php echo ($estado === 'NO') ? 'checked' : ''; ?>>
                            <label>NO</label>
                        </label>
                        <label class="radio-opt radio-na">
                            <input type="radio" name="servicio_<?php echo $servicio->id; ?>" value="NA"
                                   <?php echo ($estado === 'NA') ? 'checked' : ''; ?>>
                            <label>N/A</label>
                        </label>
                    </div>
                </div>
                <?php endforeach; ?>

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