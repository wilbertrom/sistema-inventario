<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <?php foreach ($cables as $cable): ?>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Detalles del cable</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="<?php echo base_url('recursos-panel/images/equipos/').$cable->imagen?>" alt="Detalles">
                                    
                                </div>
                            </div>
                                <div class="col-md-10">
                                    <p class="card-text mb-3"><Strong>Marca: </Strong><?php echo $cable->marca;?></p>
                                    <p class="card-text mb-3"><Strong>Modelo: </Strong><?php echo $cable->modelo;?></p>
                                    <p class="card-text mb-3"><Strong>Codigo Interno: </Strong><?php echo $cable->cod_interno;?></p>
                                    <p class="card-text mb-3"><Strong>Descripción: </Strong><?php echo $cable->descripcion;?></p>
                                    <p class="card-text mb-3"><Strong>Tipo: </Strong><?php echo $cable->tipo;?></Strong></p>
                                    <p class="card-text mb-3"><Strong>Estado: </Strong><?php echo $cable->estado;?></p>
                                    
                                </div>
                                
                            <div class="row d-flex justify-content-end">
                                    <div class="mt-4 ">
                                        <a class="btn btn-primary mr-2" href="<?php echo base_url('panel/editar/'); echo $cable->id_equipos;?>"  role="button">Editar</a>
                                        <a class="btn btn-danger mr-2" href="<?php echo base_url('inventario/eliminar/'); echo $cable->id_equipos;?>" role="button">Borrar</a>
                                        <button class="btn btn-secondary mr-2" onclick="history.back()">Regresar</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
        </div>
    </div>
</div>