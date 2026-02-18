<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><?php echo $title; ?></strong>
                        </div>
                        <div class="card-body">
                            
                            <form action="<?php echo base_url('orden-mantenimiento/crear'); ?>" method="POST">
                                <div class="form-group">
                                    <label>Área Solicitante</label>
                                    <input type="text" name="area_solicitante" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Solicitante</label>
                                    <input type="text" name="solicitante" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Fecha de Elaboración</label>
                                    <input type="date" name="fecha_elaboracion" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Descripción del Servicio</label>
                                    <textarea name="descripcion_servicio" class="form-control" rows="4" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Especificación Técnica</label>
                                    <textarea name="especificacion_tecnica" class="form-control" rows="4"></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="<?php echo base_url('orden-mantenimiento'); ?>" class="btn btn-secondary">Cancelar</a>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>