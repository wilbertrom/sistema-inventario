<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><?php echo $title; ?></strong>
                            <small class="float-right">Laboratorio: <?php echo $laboratorio_nombre; ?></small>
                        </div>
                        <div class="card-body">
                            
                            <div class="row mb-4">
                                <div class="col-md-12 text-right">
                                    <a href="<?php echo base_url('orden-mantenimiento/crear'); ?>" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Nueva Orden
                                    </a>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Área Solicitante</th>
                                            <th>Solicitante</th>
                                            <th>Fecha</th>
                                            <th>Descripción</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($ordenes)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No hay órdenes registradas</td>
                                        </tr>
                                        <?php else: ?>
                                        <?php foreach($ordenes as $o): ?>
                                        <tr>
                                            <td><?php echo $o->id; ?></td>
                                            <td><?php echo $o->area_solicitante; ?></td>
                                            <td><?php echo $o->solicitante; ?></td>
                                            <td><?php echo $o->fecha_elaboracion; ?></td>
                                            <td><?php echo substr($o->descripcion_servicio, 0, 50); ?>...</td>
                                            <td>
                                                <a href="<?php echo base_url('orden-mantenimiento/editar/'.$o->id); ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?php echo base_url('orden-mantenimiento/pdf/'.$o->id); ?>" class="btn btn-sm btn-success" target="_blank">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                                <a href="<?php echo base_url('orden-mantenimiento/eliminar/'.$o->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
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
        </div>
    </div>
</div>