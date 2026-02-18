<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo $title; ?></h3>
                            <small class="text-muted">Laboratorio: <?php echo $this->session->userdata('laboratorio_nombre'); ?></small>
                        </div>
                        <div class="card-body">
                            
                            <!-- Mensajes de éxito/error -->
                            <?php if($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Formulario para editar programa -->
                            <form action="<?php echo base_url('programa-anual/actualizar/'.$programa->id); ?>" method="POST" class="mb-4">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="actividad">Actividad</label>
                                        <input type="text" class="form-control" id="actividad" name="actividad" 
                                               value="<?php echo $programa->actividad; ?>" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="anio">Año</label>
                                        <input type="number" class="form-control" id="anio" value="<?php echo $programa->anio; ?>" readonly disabled>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="observaciones">Observaciones</label>
                                        <input type="text" class="form-control" id="observaciones" name="observaciones" 
                                               value="<?php echo $programa->observaciones; ?>">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Actualizar Programa
                                </button>
                                <a href="<?php echo base_url('programa-anual/pdf/'.$programa->id); ?>" class="btn btn-success" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Generar PDF
                                </a>
                                <a href="<?php echo base_url('programa-anual'); ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                            </form>
                            
                            <hr>
                            
                            <h4 class="mb-3">Planeación Mensual</h4>
                            
                            <!-- Resumen de estatus -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Resumen de Estatus</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row text-center">
                                                <div class="col-md-2">
                                                    <div class="card bg-warning text-white">
                                                        <div class="card-body">
                                                            <h3><?php echo isset($resumen['PLANEADO']) ? $resumen['PLANEADO'] : 0; ?></h3>
                                                            <span>Planeado</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="card bg-info text-white">
                                                        <div class="card-body">
                                                            <h3><?php echo isset($resumen['EN_PROCESO']) ? $resumen['EN_PROCESO'] : 0; ?></h3>
                                                            <span>En Proceso</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="card bg-success text-white">
                                                        <div class="card-body">
                                                            <h3><?php echo isset($resumen['COMPLETADO']) ? $resumen['COMPLETADO'] : 0; ?></h3>
                                                            <span>Completado</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="card bg-danger text-white">
                                                        <div class="card-body">
                                                            <h3><?php echo isset($resumen['CANCELADO']) ? $resumen['CANCELADO'] : 0; ?></h3>
                                                            <span>Cancelado</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="card bg-secondary text-white">
                                                        <div class="card-body">
                                                            <h3><?php echo isset($resumen['PENDIENTE']) ? $resumen['PENDIENTE'] : 0; ?></h3>
                                                            <span>Pendiente</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="card bg-dark text-white">
                                                        <div class="card-body">
                                                            <h3><?php echo isset($resumen['TOTAL']) ? $resumen['TOTAL'] : 0; ?>/12</h3>
                                                            <span>Total Meses</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Tabla de meses -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">Mes</th>
                                            <th class="text-center">Estatus</th>
                                            <th class="text-center">Observaciones</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $meses_procesados = array();
                                        if(isset($detalles) && !empty($detalles)) {
                                            foreach($detalles as $d): 
                                                $meses_procesados[] = $d->mes;
                                        ?>
                                        <tr id="mes-<?php echo $d->mes; ?>">
                                            <td class="text-center align-middle"><strong><?php echo $meses[$d->mes]; ?></strong></td>
                                            <td class="text-center align-middle">
                                                <span class="badge 
                                                    <?php 
                                                    switch($d->estatus) {
                                                        case 'PLANEADO': echo 'badge-warning'; break;
                                                        case 'EN_PROCESO': echo 'badge-info'; break;
                                                        case 'COMPLETADO': echo 'badge-success'; break;
                                                        case 'CANCELADO': echo 'badge-danger'; break;
                                                        default: echo 'badge-secondary';
                                                    }
                                                    ?> 
                                                    badge-pill p-2" style="font-size: 14px;">
                                                    <?php echo $d->estatus; ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span id="obs-text-<?php echo $d->mes; ?>"><?php echo isset($d->observaciones) ? $d->observaciones : ''; ?></span>
                                                <input type="text" id="obs-input-<?php echo $d->mes; ?>" class="form-control form-control-sm" 
                                                       value="<?php echo isset($d->observaciones) ? $d->observaciones : ''; ?>" style="display:none;">
                                            </td>
                                            <td class="text-center align-middle">
                                                <button class="btn btn-sm btn-primary edit-btn" data-mes="<?php echo $d->mes; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-success save-btn" data-mes="<?php echo $d->mes; ?>" style="display:none;">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <select class="form-control form-control-sm estatus-select" data-mes="<?php echo $d->mes; ?>" style="width:120px; display:inline-block;">
                                                    <option value="PLANEADO" <?php echo $d->estatus == 'PLANEADO' ? 'selected' : ''; ?>>Planeado</option>
                                                    <option value="EN_PROCESO" <?php echo $d->estatus == 'EN_PROCESO' ? 'selected' : ''; ?>>En Proceso</option>
                                                    <option value="COMPLETADO" <?php echo $d->estatus == 'COMPLETADO' ? 'selected' : ''; ?>>Completado</option>
                                                    <option value="CANCELADO" <?php echo $d->estatus == 'CANCELADO' ? 'selected' : ''; ?>>Cancelado</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <?php 
                                            endforeach; 
                                        }
                                        ?>
                                        
                                        <!-- Mostrar meses sin planear -->
                                        <?php for($m = 1; $m <= 12; $m++): ?>
                                            <?php if(!in_array($m, $meses_procesados)): ?>
                                            <tr id="mes-<?php echo $m; ?>">
                                                <td class="text-center align-middle"><strong><?php echo $meses[$m]; ?></strong></td>
                                                <td class="text-center align-middle">
                                                    <span class="badge badge-secondary badge-pill p-2">PENDIENTE</span>
                                                </td>
                                                <td class="align-middle">
                                                    <span id="obs-text-<?php echo $m; ?>"></span>
                                                    <input type="text" id="obs-input-<?php echo $m; ?>" class="form-control form-control-sm" style="display:none;">
                                                </td>
                                                <td class="text-center align-middle">
                                                    <button class="btn btn-sm btn-primary edit-btn" data-mes="<?php echo $m; ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-success save-btn" data-mes="<?php echo $m; ?>" style="display:none;">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <select class="form-control form-control-sm estatus-select" data-mes="<?php echo $m; ?>" style="width:120px; display:inline-block;">
                                                        <option value="PLANEADO">Planeado</option>
                                                        <option value="EN_PROCESO">En Proceso</option>
                                                        <option value="COMPLETADO">Completado</option>
                                                        <option value="CANCELADO">Cancelado</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Botón para marcar todos los meses -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="btn-group">
                                        <button class="btn btn-warning marcar-todos" data-estatus="PLANEADO">
                                            <i class="fas fa-calendar-check"></i> Marcar todos como Planeado
                                        </button>
                                        <button class="btn btn-success marcar-todos" data-estatus="COMPLETADO">
                                            <i class="fas fa-check-double"></i> Marcar todos como Completado
                                        </button>
                                        <button class="btn btn-danger marcar-todos" data-estatus="CANCELADO">
                                            <i class="fas fa-times-circle"></i> Marcar todos como Cancelado
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    
    // Editar observaciones
    $('.edit-btn').click(function() {
        var mes = $(this).data('mes');
        $('#obs-text-' + mes).hide();
        $('#obs-input-' + mes).show().focus();
        $(this).hide();
        $('.save-btn[data-mes="' + mes + '"]').show();
    });
    
    // Guardar observaciones y estatus
    $('.save-btn').click(function() {
        var mes = $(this).data('mes');
        var observaciones = $('#obs-input-' + mes).val();
        var estatus = $('.estatus-select[data-mes="' + mes + '"]').val();
        
        $.ajax({
            url: '<?php echo base_url("programa-anual/marcar_mes"); ?>',
            method: 'POST',
            data: {
                programa_id: <?php echo $programa->id; ?>,
                mes: mes,
                estatus: estatus,
                observaciones: observaciones
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#obs-text-' + mes).text(observaciones).show();
                    $('#obs-input-' + mes).hide();
                    $('.save-btn[data-mes="' + mes + '"]').hide();
                    $('.edit-btn[data-mes="' + mes + '"]').show();
                    
                    // Actualizar badge de estatus
                    var badgeClass = '';
                    switch(estatus) {
                        case 'PLANEADO': badgeClass = 'badge-warning'; break;
                        case 'EN_PROCESO': badgeClass = 'badge-info'; break;
                        case 'COMPLETADO': badgeClass = 'badge-success'; break;
                        case 'CANCELADO': badgeClass = 'badge-danger'; break;
                        default: badgeClass = 'badge-secondary';
                    }
                    
                    $('#mes-' + mes + ' td:nth-child(2)').html(
                        '<span class="badge ' + badgeClass + ' badge-pill p-2" style="font-size:14px;">' + estatus + '</span>'
                    );
                    
                    // Mostrar mensaje de éxito
                    mostrarAlerta('success', 'Mes actualizado correctamente');
                } else {
                    mostrarAlerta('danger', 'Error al actualizar');
                }
            },
            error: function() {
                mostrarAlerta('danger', 'Error de conexión');
            }
        });
    });
    
    // Marcar todos los meses con un estatus
    $('.marcar-todos').click(function() {
        var estatus = $(this).data('estatus');
        
        if (!confirm('¿Estás seguro de marcar todos los meses como ' + estatus + '?')) {
            return;
        }
        
        $.ajax({
            url: '<?php echo base_url("programa-anual/marcar_todos"); ?>',
            method: 'POST',
            data: {
                programa_id: <?php echo $programa->id; ?>,
                estatus: estatus
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    mostrarAlerta('danger', 'Error al marcar los meses');
                }
            },
            error: function() {
                mostrarAlerta('danger', 'Error de conexión');
            }
        });
    });
    
    // Función para mostrar alertas
    function mostrarAlerta(tipo, mensaje) {
        var alerta = '<div class="alert alert-' + tipo + ' alert-dismissible fade show" role="alert">' +
                     '<i class="fas fa-' + (tipo == 'success' ? 'check-circle' : 'exclamation-circle') + '"></i> ' + mensaje +
                     '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                     '<span aria-hidden="true">&times;</span></button></div>';
        
        $('.card-body').prepend(alerta);
        
        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 3000);
    }
    
});
</script>

<style>
.badge {
    font-size: 14px;
    padding: 8px 12px;
}
.estatus-select {
    margin-left: 5px;
}
.btn-group .btn {
    margin-right: 5px;
}
</style>