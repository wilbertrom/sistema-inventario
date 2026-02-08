<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Detalles del equipo</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                <img src="<?php echo base_url('recursos-panel/images/equipos/') . $equipo->imagen ?>" alt="Detalles" onerror="this.onerror=null; this.src='<?php echo base_url('recursos-panel/images/equipos/default/image.png'); ?>'">
                                    
                                </div>
                                <div class="col-md-4">
                                    <p class="card-text mb-3"><Strong>Marca: </Strong><?php echo $equipo->marca;?></p>
                                    <p class="card-text mb-3"><Strong>Codigo Interno: </Strong><?php echo $equipo->cod_interno;?></p>
                                    <p class="card-text mb-3"><Strong>Descripción: </Strong><?php echo $equipo->descripcion;?></p>
                                    <p class="card-text mb-3"><Strong>Tipo: </Strong><?php echo $equipo->tipo;?></Strong></p>
                                    <p class="card-text mb-3"><Strong>Estado: </Strong><?php echo $equipo->estado;?></p>
                                    
                                </div>
                                <?php if($equipo->tipo === 'Computadora'){
                                    echo '
                                    <div class="col-md-4">
                                    <p class="card-text mb-3"><Strong>Procesador: </Strong>'.$equipo->procesador.'</p>
                                    <p class="card-text mb-3"><Strong>Tarjeta Madre: </Strong>'.$equipo->tarjeta.'</p>
                                    <p class="card-text mb-3"><Strong>Ram: </Strong>'.$equipo->ram.'GB</p>
                                    </div>
                                    ';
                                    
                                }?>
                                
                            </div>
                            <div class="row d-flex justify-content-end">
                                    <div class="mt-4 ">
                                        <a class="btn btn-primary mr-2" href="<?php echo base_url('panel/editar/'); echo $id_enc;?>"  role="button">Editar</a>
                                        <a class="btn btn-danger mr-2" href="<?php echo base_url('inventario/eliminar/'); echo $id_enc;?>" role="button">Borrar</a>
                                        <button class="btn btn-secondary mr-2" onclick="history.back()">Regresar</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>