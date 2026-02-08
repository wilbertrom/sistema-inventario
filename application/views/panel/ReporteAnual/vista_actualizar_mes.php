<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
        <div class="row justify-content-center">
        <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <strong>Actualizar Mes</strong>
                    </div>
                    <div class="card-body card-block">
                        <form action="<?php echo site_url('ReporteServicios/actualizar_servicios'); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <input type="hidden" name="reporte_id" value="<?php echo $reporte_id; ?>">
                        <input type="hidden" name="mes" value="<?php echo $mes; ?>">

                        <?php foreach($servicios as $servicio):?>
                            <?php $estado = isset($estados_servicios[$servicio->id]) ? $estados_servicios[$servicio->id] : ''; ?>
                            <div class="row form-group">
                                <div class="col col-md-5">
                                    <label class=" form-control-label"><?php echo $servicio->nombre_servicio;?></label>
                                </div>
                                <div class="col col-md-7a">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="servicio_<?php echo $servicio->id;?>" id="inlineRadio1" value="SI" required <?php echo ($estado === 'SI') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="inlineRadio1">SI</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="servicio_<?php echo $servicio->id;?>" id="inlineRadio2" value="NO" <?php echo ($estado === 'NO') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="inlineRadio2">NO</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="servicio_<?php echo $servicio->id;?>" id="inlineRadio3" value="NA" <?php echo ($estado === 'NA') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="inlineRadio3">NA</label>
                                    </div>

                                    
                                </div>
                            </div>
                            <hr>
                        <?php endforeach;?>
                            
                            <div class="card-footer">
                        <div class="form-actions form-group">
                                    <button type="submit" class="btn btn-uptx">Editar</button>
                                    <button class="btn btn-secondary mr-2" onclick="history.back()">Regresar</button>
                                </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
