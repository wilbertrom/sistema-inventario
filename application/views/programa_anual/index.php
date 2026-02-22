<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <!-- Flash messages -->
                    <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                    <?php endif; ?>
                    <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Programa Anual de Mantenimiento</strong>
                            <small class="float-right">Laboratorio: <?php echo htmlspecialchars($laboratorio_nombre); ?></small>
                        </div>
                        <div class="card-body">

                            <!-- Filtro por año -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Año</label>
                                        <select class="form-control" id="filtro_anio">
                                            <?php foreach($anios_disponibles as $a): ?>
                                            <option value="<?php echo $a; ?>" <?php echo ($a == $anio_seleccionado) ? 'selected' : ''; ?>>
                                                <?php echo $a; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8 text-right align-self-end pb-3">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalNuevo">
                                        <i class="fas fa-plus"></i> Nuevo Programa
                                    </button>
                                </div>
                            </div>

                            <!-- Tabla de programas -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th width="5%"  class="text-center">ID</th>
                                            <th width="10%" class="text-center">Año</th>
                                            <th width="50%">Observaciones</th>
                                            <th width="35%" class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($programas)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                                No hay programas para el año <?php echo $anio_seleccionado; ?>
                                            </td>
                                        </tr>
                                        <?php else: ?>
                                        <?php foreach($programas as $p): ?>
                                        <tr>
                                            <td class="text-center"><?php echo $p->id; ?></td>
                                            <td class="text-center"><strong><?php echo $p->anio; ?></strong></td>
                                            <td><?php echo htmlspecialchars($p->observaciones ?? '—'); ?></td>
                                            <td class="text-center">
                                                <!-- Ver/editar actividades -->
                                                <a href="<?php echo base_url('programa-anual/actividades/'.$p->id); ?>"
                                                   class="btn btn-sm btn-primary" title="Ver Actividades">
                                                    <i class="fas fa-tasks"></i> Actividades
                                                </a>
                                                <!-- Exportar PDF -->
                                                <a href="<?php echo base_url('programa-anual/pdf/'.$p->id); ?>"
                                                   class="btn btn-sm btn-danger" title="Exportar PDF" target="_blank">
                                                    <i class="fas fa-file-pdf"></i> PDF
                                                </a>
                                                <!-- Eliminar -->
                                                <a href="<?php echo base_url('programa-anual/eliminar/'.$p->id); ?>"
                                                   class="btn btn-sm btn-outline-danger" title="Eliminar"
                                                   onclick="return confirm('¿Eliminar este programa y todas sus actividades?')">
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

<!-- ══════════════════════════════════════
     MODAL: Nuevo Programa
══════════════════════════════════════ -->
<div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo base_url('programa-anual/crear'); ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus-circle text-primary"></i> Nuevo Programa Anual</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Año <span class="text-danger">*</span></label>
                        <input type="number" name="anio" class="form-control"
                               value="<?php echo date('Y'); ?>" min="2020" max="2035" required>
                    </div>
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="3"
                                  placeholder="Observaciones generales del programa..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#filtro_anio').change(function() {
        window.location.href = '<?php echo base_url("programa-anual?anio="); ?>' + $(this).val();
    });
});
</script>
