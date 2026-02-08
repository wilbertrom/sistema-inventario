<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3>Asignar equipo (<?php echo $tipo_equipo?>)</h3>
                        </div>
                        <form action="<?php echo base_url('grupos/asignar');?>" method="post">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <input type="text" name="tipo" id="tipo" value="<?php echo $tipo_equipo?>" hidden>
                                <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="equipo" class="form-control-label"><strong>Equipo</strong></label>
                                            <select name="equipo[]" id="equipo" class="form-control" <?php echo strtolower($tipo_equipo) === 'cable' ? 'multiple' : ''; ?> required>
                                            <?php if(empty($equipos_tipo)): ?>
                                                    <option value="" disabled selected>No hay equipos disponibles</option>
                                                <?php else: ?>
                                                    <?php foreach($equipos_tipo as $equipo): ?>
                                                    <option value="<?php echo $equipo->id_equipos?>" 
                                                        <?php echo in_array($equipo->id_equipos, array_column($equipos_asignados, 'id_equipos')) ? 'selected' : '' ?>>
                                                        <?php echo $equipo->tipo." - ". $equipo->cod_interno;?>
                                                    </option>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group mb-3">
                                            <label for="mesa" class="form-control-label"><strong>Mesa</strong></label>
                                            <select name="mesa" id="mesa" class="form-control" >
                                            <option value="<?php echo $id_mesa?>" selected><?php echo "Mesa ". $id_mesa?></option>
                                            </select>
                                        </div> 

                                        <div class="form-group mb-3">
                                            <label for="grupo" class="form-control-label"><strong>Grupo</strong></label>
                                            <select name="grupo" id="grupo" class="form-control" >
                                            <option value="<?php echo $id_grupo?>" selected><?php echo "Grupo ".$id_grupo?></option>
                                            </select>
                                        </div>    
                                        
                                        <div class="row d-flex justify-content-end">
                                            <div class="mt-4">
                                                <button class="btn btn-danger mr-2 btn-uptx-search" role="submit">Asignar</button>
                                                <a class="btn btn-secondary" href="<?php echo base_url('grupos/vista')?>">Regresar</a>
                                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- modal static -->
<div class="modal fade" id="staticModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true"
			 data-backdrop="static">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="staticModalLabel">Advertencia</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p>
								No hay equipos <?php echo $tipo_equipo?>
							</p>
						</div>
						<div class="modal-footer">
							<a class="btn btn-primary" href="<?php echo base_url('grupos/vista')?>">Regresar</a>
						</div>
					</div>
				</div>
			</div>
			<!-- end modal static -->

            <!-- JavaScript to show the modal -->
<?php if(empty($equipos_tipo)): ?>
<script>
    $(document).ready(function() {
        $('#staticModal').modal('show');
    });
</script>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tipoEquipo = "<?php echo $tipo_equipo; ?>";
        var equipoSelect = document.getElementById('equipo');

        if (tipoEquipo.toLowerCase() === 'cable') {
            equipoSelect.setAttribute('multiple', 'multiple');
            $(function(){
    $('#equipo').multiselect({
        buttonWidth: '100%', // Asegura que el botón del multiselect ocupe el 100% del contenedor
    });
});

        } else {
            equipoSelect.removeAttribute('multiple');
        }

        equipoSelect.addEventListener('change', function() {
            if (tipoEquipo.toLowerCase() === 'cable' && this.selectedOptions.length > 3) {
                alert('No puedes seleccionar más de 3 equipos.');
                this.options[this.selectedIndex].selected = false;
            }
        });
    });
    
    
</script>

<script>



</script>
