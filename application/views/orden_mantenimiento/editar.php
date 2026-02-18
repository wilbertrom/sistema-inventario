<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title"><?php echo $title; ?></strong>
                            <small class="float-right">Laboratorio: <?php echo $this->session->userdata('laboratorio_nombre'); ?></small>
                        </div>
                        <div class="card-body">
                            
                            <?php if($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible">
                                <?php echo $this->session->flashdata('success'); ?>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <?php echo $this->session->flashdata('error'); ?>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Formulario principal -->
                            <form action="<?php echo base_url('orden-mantenimiento/actualizar/'.$orden->id); ?>" method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Área Solicitante</label>
                                            <input type="text" name="area_solicitante" class="form-control" value="<?php echo $orden->area_solicitante; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Solicitante</label>
                                            <input type="text" name="solicitante" class="form-control" value="<?php echo $orden->solicitante; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha de Elaboración</label>
                                            <input type="date" name="fecha_elaboracion" class="form-control" value="<?php echo $orden->fecha_elaboracion; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Descripción del Servicio</label>
                                    <textarea name="descripcion_servicio" class="form-control" rows="4" required><?php echo $orden->descripcion_servicio; ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>Especificación Técnica</label>
                                    <textarea name="especificacion_tecnica" class="form-control" rows="4"><?php echo $orden->especificacion_tecnica; ?></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Actualizar Orden
                                </button>
                                <a href="<?php echo base_url('orden-mantenimiento'); ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                                <a href="<?php echo base_url('orden-mantenimiento/pdf/'.$orden->id); ?>" class="btn btn-success" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Generar PDF
                                </a>
                            </form>
                            
                            <hr>
                            
                            <!-- Sección de Trabajos de Mantenimiento -->
                            <h4 class="mt-4">Trabajos de Mantenimiento</h4>
                            
                            <button class="btn btn-sm btn-primary mb-3" data-toggle="modal" data-target="#modalTrabajo">
                                <i class="fas fa-plus"></i> Agregar Trabajo
                            </button>
                            
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Servicio</th>
                                        <th>Asignado a</th>
                                        <th>Fecha</th>
                                        <th>Costo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($trabajos)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No hay trabajos registrados</td>
                                    </tr>
                                    <?php else: ?>
                                    <?php foreach($trabajos as $t): ?>
                                    <tr>
                                        <td><?php echo $t->tipo_mantenimiento; ?></td>
                                        <td><?php echo $t->tipo_servicio; ?></td>
                                        <td><?php echo $t->asignado_a ?: $t->empresa_contratista; ?></td>
                                        <td><?php echo $t->fecha_realizacion; ?></td>
                                        <td>$<?php echo number_format($t->costo, 2); ?></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-danger" onclick="if(confirm('¿Eliminar?')) window.location.href='<?php echo base_url('orden-trabajo/eliminar/'.$t->id); ?>'">
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

<!-- Modal Agregar Trabajo -->
<div class="modal fade" id="modalTrabajo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?php echo base_url('orden-trabajo/crear'); ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Trabajo de Mantenimiento</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    
                    <input type="hidden" name="orden_id" value="<?php echo $orden->id; ?>">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Mantenimiento</label>
                                <select name="tipo_mantenimiento" class="form-control" required>
                                    <option value="INTERNO">Interno</option>
                                    <option value="EXTERNO">Externo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipo de Servicio</label>
                                <input type="text" name="tipo_servicio" class="form-control" placeholder="Ej: Eléctrico, Mecánico, Preventivo" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Asignado a (Personal Interno)</label>
                                <input type="text" name="asignado_a" class="form-control" placeholder="Nombre del responsable">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Empresa Contratista (Externo)</label>
                                <input type="text" name="empresa_contratista" class="form-control" placeholder="Nombre de la empresa">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha de Realización</label>
                                <input type="date" name="fecha_realizacion" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Costo</label>
                                <input type="number" step="0.01" name="costo" class="form-control" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Trabajo Realizado</label>
                        <textarea name="trabajo_realizado" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Materiales Utilizados</label>
                        <textarea name="materiales_utilizados" class="form-control" rows="3"></textarea>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Trabajo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Si hay error, mostrar mensaje
    <?php if($this->session->flashdata('error_trabajo')): ?>
    alert('<?php echo $this->session->flashdata('error_trabajo'); ?>');
    <?php endif; ?>
});
</script>