<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-desktop mr-2"></i>Detalles del equipo</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <!-- Imagen -->
                                <div class="col-md-4 mb-3">
                                    <img src="<?php echo base_url('recursos-panel/images/equipos/') . $equipo->imagen; ?>"
                                         alt="Imagen del equipo"
                                         style="max-width:100%; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1);"
                                         onerror="this.onerror=null; this.src='<?php echo base_url('recursos-panel/images/equipos/default/image.png'); ?>'">
                                </div>

                                <!-- Info general -->
                                <div class="col-md-4 mb-3">
                                    <p class="card-text mb-3"><strong>Marca: </strong><?php echo htmlspecialchars($equipo->marca ?? '！'); ?></p>
                                    <p class="card-text mb-3"><strong>C&oacute;digo Interno: </strong><?php echo htmlspecialchars($equipo->cod_interno ?? $equipo->codigo_interno ?? '！'); ?></p>
                                    <p class="card-text mb-3"><strong>Descripci&oacute;n: </strong><?php echo htmlspecialchars($equipo->descripcion ?? $equipo->descripcion_producto ?? '！'); ?></p>
                                    <p class="card-text mb-3"><strong>Tipo: </strong><?php echo htmlspecialchars($equipo->tipo ?? '！'); ?></p>
                                    <p class="card-text mb-3"><strong>Estado: </strong><?php echo htmlspecialchars($equipo->estado ?? '！'); ?></p>
                                    <?php if(!empty($equipo->proveedor)): ?>
                                    <p class="card-text mb-3"><strong>Proveedor: </strong><?php echo htmlspecialchars($equipo->proveedor); ?></p>
                                    <?php endif; ?>
                                    <?php if(!empty($equipo->unidad)): ?>
                                    <p class="card-text mb-3"><strong>Unidad: </strong><?php echo htmlspecialchars($equipo->unidad); ?></p>
                                    <?php endif; ?>
                                    <?php if(!empty($equipo->observaciones)): ?>
                                    <p class="card-text mb-3"><strong>Observaciones: </strong><?php echo htmlspecialchars($equipo->observaciones); ?></p>
                                    <?php endif; ?>
                                </div>

                                <!-- Info computadora -->
                                <?php if(isset($equipo->tipo) && $equipo->tipo === 'Computadora'): ?>
                                <div class="col-md-4 mb-3">
                                    <p class="card-text mb-3"><strong>Procesador: </strong><?php echo htmlspecialchars($equipo->procesador ?? '！'); ?></p>
                                    <p class="card-text mb-3"><strong>Tarjeta Madre: </strong><?php echo htmlspecialchars($equipo->tarjeta ?? '！'); ?></p>
                                    <p class="card-text mb-3"><strong>RAM: </strong><?php echo htmlspecialchars($equipo->ram ?? '！'); ?> GB</p>
                                </div>
                                <?php endif; ?>

                            </div>

                            <!-- Botones -->
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end mt-3">
                                    <a class="btn btn-primary mr-2"
                                       href="<?php echo base_url('panel/editar/' . $id_enc); ?>"
                                       role="button">
                                       <i class="fas fa-edit mr-1"></i> Editar
                                    </a>

                                    <a class="btn btn-danger mr-2"
                                       href="<?php echo base_url('inventario/eliminar/' . $id_enc); ?>"
                                       role="button"
                                       onclick="return confirm('&iquest;Est&aacute;s seguro de eliminar este equipo? Esta acci&oacute;n no se puede deshacer.')">
                                       <i class="fas fa-trash mr-1"></i> Borrar
                                    </a>

                                    <button class="btn btn-secondary" onclick="history.back()">
                                        <i class="fas fa-arrow-left mr-1"></i> Regresar
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