<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">

    <div class="col-md-12">
    <h3 class="title-5 m-b-35">Todas las requisiciones</h3>
        <a href="<?php echo base_url('requisiciones/nueva')?>" class="mb-3">
            <button class="au-btn  au-btn--small btn-uptx">
                <i class="zmdi zmdi-plus"></i>Añadir Requisición    
            </button>
        </a>   
                <!-- DATA TABLE-->
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Razon</th>
                                <th>Proposito</th>
                                <th>Partida Presupuestal</th>
                                <th>Estado</th>
                                <th>Materiales</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($requisiciones as $requisicion): ?>
                                <tr>
                                    
                                    <td><?php echo $requisicion->fecha_actual; ?></td>
                                    <td><?php echo $requisicion->razon; ?></td>
                                    <td><?php echo $requisicion->proposito; ?></td>
                                    <td><?php echo $requisicion->partida_p; ?></td>
                                    <td class="process">En proceso</td>
                                    <td><?php echo $requisicion->items; ?></td>
                                </tr>
                                <?php endforeach; ?>
                        
                        </tbody>
                    </table>
                </div>
                <!-- END DATA TABLE-->
            </div>

        </div>
    </div>
</div>