<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Editar equipo</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="<?php echo base_url('inventario/editar');?>" method="post" class="form-horizontal" enctype="multipart/form-data">
                                <div class="form-group">
                                <input type="hidden" id="id_equipos" name="id_equipos" value="<?php echo $equipo->id_equipos; ?>">
                                <input type="hidden" id="id_ccompus" name="id_ccompus" value="<?php echo $equipo->id_ccompus; ?>">
                                    <label for="marca" class="form-control-label">Marca</label>
                                    <div class="input-group">
                                        <select id="marca" name="marca" class="form-control" required>
                                            <option value="">Seleccione una Marca</option>
                                            <?php foreach ($marcas as $marca): ?>
                                              <?php if($marca->id_marcas == $equipo->id_marcas):?>
                                                <option value="<?php echo $marca->id_marcas; ?>" selected><?php echo $marca->nombre; ?></option>
                                              <?php else: ?>
                                                <option value="<?php echo $marca->id_marcas; ?>"><?php echo $marca->nombre; ?></option>
                                                <?php endif; ?>

                                                <?php endforeach; ?>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-uptx" data-toggle="modal" data-target="#modalAgregarMarca">Agregar Marca</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tipo" class="form-control-label">Tipo</label>
                                    <div class="input-group">
                                        <select id="tipo" name="tipo" class="form-control" onchange="toggleComputerFields()" required>
                                            <option value="">Seleccione un tipo</option>
                                            <?php foreach ($tipos as $tipo): ?>
                                              <?php if($tipo->id_tipos == $equipo->id_tipos):?>
                                                <option value="<?php echo $tipo->id_tipos; ?>" selected><?php echo $tipo->nombre; ?></option>
                                              <?php else: ?>
                                                <option value="<?php echo $tipo->id_tipos; ?>"><?php echo $tipo->nombre; ?></option>
                                                <?php endif; ?>

                                                <?php endforeach; ?>
                                        </select>
                                        <div class="input-group-append">
                                        <button type="button" class="btn btn-uptx" data-toggle="modal" data-target="#modalAgregarTipo">Agregar Tipo</button>
                                        </div>
                                    </div>
                                </div>
                       
                                <div class="form-group">
                                    <label for="cod_interno" class="form-control-label">Codigo Interno</label>
                                    <input type="text" id="cod_interno" name="cod_interno" placeholder="Codigo Interno" class="form-control" required value="<?php echo $equipo->cod_interno; ?>">
                                </div>

                                <div id="computerFields" style="display: none;">
                                    <div class="form-group">
                                        <label for="procesador" class="form-control-label">Procesador</label>
                                        <input type="text" id="procesador" name="procesador" placeholder="Procesador" class="form-control" value="<?php echo $equipo->procesador; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="tarjeta_madre" class="form-control-label">Tarjeta Madre</label>
                                        <input type="text" id="tarjeta_madre" name="tarjeta_madre" placeholder="Tarjeta Madre" class="form-control" value="<?php echo $equipo->tarjeta; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="ram" class="form-control-label">RAM</label>
                                        <input type="text" id="ram" name="ram" placeholder="RAM" class="form-control" value="<?php echo $equipo->ram; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion" class="form-control-label">Descripción</label>
                                    <textarea id="descripcion" name="descripcion" placeholder="Descripción" class="form-control" ><?php echo $equipo->descripcion; ?></textarea>
                                </div>
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
                                    <label for="imagen" class="form-control-label">Imagen del Equipo</label>
                                    <input type="file" id="imagen" name="imagen" class="form-control-file">
                                </div>
                                <div class="form-actions form-group">
                                    <button type="submit" class="btn btn-uptx">Editar</button>
                                    <button type="button" class="btn btn-secondary mr-2" onclick="history.back()">Regresar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Agregar Marca-->
<div class="modal fade" id="modalAgregarMarca" tabindex="-1" role="dialog" aria-labelledby="modalAgregarMarcaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarMarcalLabel">Agregar Marca</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('Inventario/nuevaMarca'); ?>" method="post">
          <div class="form-group">
          <input type="hidden" id="id_equipos" name="id_equipos" value="<?php echo $equipo->id_equipos; ?>">
            <label for="marca">Marca:</label>
            <input type="text" class="form-control" id="marca" name="marca" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal de Tipo con nomenclatura "modalAgregarTipo" -->
<div class="modal fade" id="modalAgregarTipo" tabindex="-1" role="dialog" aria-labelledby="modalAgregarTipoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarTipoLabel">Agregar Tipo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('Inventario/nuevoTipo'); ?>" method="post">
          <div class="form-group">
          <input type="hidden" id="id_equipos" name="id_equipos" value="<?php echo $equipo->id_equipos; ?>">
            <label for="tipo">Tipo:</label>
            <input type="text" class="form-control" id="tipo" name="tipo" required>
            <div class="invalid-feedback">Por favor, completa este campo.</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Custom JS-->
<script>
    function toggleComputerFields() {
        var tipo = document.getElementById('tipo').value;
        var computerFields = document.getElementById('computerFields');
        if (tipo === '1') {
            computerFields.style.display = 'block';
            document.getElementById('procesador').required = true;
            document.getElementById('tarjeta_madre').required = true;
            document.getElementById('ram').required = true;
        } else {
            computerFields.style.display = 'none';
            document.getElementById('procesador').required = false;
            document.getElementById('tarjeta_madre').required = false;
            document.getElementById('ram').required = false;
        }
    }

    toggleComputerFields();

</script>