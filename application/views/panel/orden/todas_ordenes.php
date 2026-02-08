<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">

    <div class="col-md-12">
        <h3 class="title-5 m-b-35">Ordenes Mantenimiento</h3>
        
        
        <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Descripción</th>
                            <th>Especificación</th>
                            <th>Equipo </th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($ordenes as $orden): ?>
                            <tr>
                                <td><?php echo $orden->fecha; ?></td>
                                <td><?php echo $orden->descripcion; ?></td>
                                <td><?php echo $orden->especificacion; ?></td>
                                <td><?php echo $orden->cod_interno; ?></td>
                                <?php if($orden->estado == 0): ?>
                                        <td class="process">En proceso</td>
                                <?php else: ?>
                                        <td class="denied">Finalizada</td>
                                <?php endif ?>    
                            </tr>
                            <?php endforeach; ?>
                    
                    </tbody>
                </table>
            </div>
            <!-- END DATA TABLE-->
        </div>
    </div>
</div>