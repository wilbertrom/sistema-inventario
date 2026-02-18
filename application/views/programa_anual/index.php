<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Programa Anual de Mantenimiento</strong>
                            <small class="float-right">Laboratorio: <?php echo $this->session->userdata('laboratorio_nombre'); ?></small>
                        </div>
                        <div class="card-body">
                            
                            <!-- Filtro por año -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Año</label>
                                        <select class="form-control" id="filtro_anio" onchange="window.location.href='<?php echo base_url('programa-anual?anio='); ?>'+this.value">
                                            <?php 
                                            $anio_actual = date('Y');
                                            for($a = $anio_actual - 2; $a <= $anio_actual + 2; $a++): 
                                            ?>
                                            <option value="<?php echo $a; ?>" <?php echo ($a == ($this->input->get('anio') ?: $anio_actual)) ? 'selected' : ''; ?>>
                                                <?php echo $a; ?>
                                            </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8 text-right">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalNuevo">
                                        <i class="fas fa-plus"></i> Nuevo Programa
                                    </button>
                                    <a href="<?php echo base_url('programa-anual/pdf_anual/'.($this->input->get('anio') ?: date('Y'))); ?>" class="btn btn-success" target="_blank">
                                        <i class="fas fa-file-pdf"></i> Exportar PDF Anual
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Tabla de programas -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="30%">Actividad</th>
                                            <th width="10%">Año</th>
                                            <th width="25%">Observaciones</th>
                                            <th width="15%">Avance</th>
                                            <th width="15%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($programas)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No hay programas para el año seleccionado</td>
                                        </tr>
                                        <?php else: ?>
                                        <?php foreach($programas as $p): 
                                            $this->load->model('ProgramaAnualDetalle_model');
                                            $resumen = $this->ProgramaAnualDetalle_model->getResumenEstatus($p->id);
                                            $total_meses = $resumen['TOTAL'] ?? 0;
                                            $completados = $resumen['COMPLETADO'] ?? 0;
                                            $porcentaje = $total_meses > 0 ? round(($completados / $total_meses) * 100) : 0;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $p->id; ?></td>
                                            <td><?php echo $p->actividad; ?></td>
                                            <td class="text-center"><?php echo $p->anio; ?></td>
                                            <td><?php echo $p->observaciones; ?></td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                         style="width: <?php echo $porcentaje; ?>%;" 
                                                         aria-valuenow="<?php echo $porcentaje; ?>" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                        <?php echo $porcentaje; ?>%
                                                    </div>
                                                </div>
                                                <small class="text-muted"><?php echo $completados; ?>/<?php echo $total_meses; ?> meses</small>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?php echo base_url('programa-anual/editar/'.$p->id); ?>" class="btn btn-sm btn-primary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?php echo base_url('programa-anual/pdf/'.$p->id); ?>" class="btn btn-sm btn-success" title="PDF" target="_blank">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                                <a href="<?php echo base_url('programa-anual/eliminar/'.$p->id); ?>" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Eliminar este programa?')">
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

<!-- Modal Nuevo Programa -->
<div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?php echo base_url('programa-anual/crear'); ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Programa Anual</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Actividad</label>
                        <input type="text" name="actividad" class="form-control" placeholder="Ej: Mantenimiento preventivo de equipos" required>
                    </div>
                    <div class="form-group">
                        <label>Año</label>
                        <input type="number" name="anio" class="form-control" value="<?php echo date('Y'); ?>" min="2020" max="2030" required>
                    </div>
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="3" placeholder="Observaciones generales..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Programa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Inicializar tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>