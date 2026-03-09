<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Orden de mantenimiento</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="<?php echo base_url('orden/registrar');?>" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <input type="hidden" id="id_equipos" name="id_equipos" value="<?php echo $equipo->id_equipos; ?>">
                                    <label for="marca" class="form-control-label">Marca</label>
                                    <div class="input-group">
                                    <input type="text" placeholder="Marca" class="form-control"  value="<?php echo $equipo->marca; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modelo" class="form-control-label">Modelo</label>
                                    <input type="text" placeholder="Modelo" name="modelo" class="form-control"  value="<?php echo $equipo->modelo; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="cod_interno" class="form-control-label">Codigo Interno</label>
                                    <input type="text" placeholder="Codigo Interno" name="cod_interno" class="form-control"  value="<?php echo $equipo->cod_interno; ?>" readonly>
                                </div>
                               
                                <div class="form-group">
                                    <label for="tipo" class="form-control-label">Tipo</label>
                                    <div class="input-group">
                                    <input type="text" placeholder="Modelo" class="form-control"  value="<?php echo $equipo->tipo; ?>" readonly>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="fecha" class="form-control-label">Fecha</label>
                                    <div class="input-group">
                                        <input type="date" id="fecha" name="fecha" class="form-control" value="" required>

                                        <div class="input-group-append">
                                        <button type="button" class="btn btn-uptx" id="today">Hoy</button>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    
                                    document.getElementById('today').addEventListener('click', function() {
                                        var today = new Date();
                                        var dd = String(today.getDate()).padStart(2, '0'); // Día actual
                                        var mm = String(today.getMonth() + 1).padStart(2, '0'); // Mes actual (Enero es 0)
                                        var yyyy = today.getFullYear();

                                        today = yyyy + '-' + mm + '-' + dd;
                                        document.getElementById('fecha').value = today;
                                    });
                                </script>

                                <div class="form-group">
                                    <label for="estado" class="form-control-label">Estado</label>
                                    <select id="estado" name="estado" class="form-control" required>
                                    <?php foreach ($estados as $estado): ?>
                                              <?php if($estado->id_estados == $equipo->id_estados):?>
                                                <option value="<?php echo $estado->id_estados; ?>" selected><?php echo $estado->nombre; ?></option>
                                              <?php else: ?>
                                                <option value="<?php echo $estado->id_estados; ?>"><?php echo $estado->nombre; ?></option>
                                                <?php endif; ?>

                                                <?php endforeach; ?>
                                    </select>
                                    
                                  </div>
                                <div class="form-group">
                                    <label for="descripcion" class="form-control-label">Descripción</label>
                                    <textarea id="descripcion" name="descripcion" placeholder="Descripción" class="form-control" rows="3" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="especificacion" class="form-control-label">Especificación</label>
                                    <textarea id="especificacion" name="especificacion" placeholder="Especificación / Proyeccion técnica " class="form-control" rows="3"></textarea>
                                </div>
                               
                                
                                <div class="form-actions form-group">
                                    <button type="submit" class="btn btn-uptx">Crear</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>