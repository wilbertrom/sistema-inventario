<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <!-- DATA TABLE -->
                <h3 class="title-5 m-b-35">Ordenes de Mantenimiento</h3>
                <div class="table-data__tool">
                    
                </div>
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>
                                    <label class="au-checkbox">
                                        <input type="checkbox">
                                        <span class="au-checkmark"></span>
                                    </label>
                                </th>
                                <th>FECHA</th>
                                <th>DESCRIPCIÓN</th>
                                <th>ESPECIFICACIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(isset($ordenes) && !empty($ordenes)) {

                            foreach ($ordenes as $orden) : ?>
                                <tr class="tr-shadow">
                                    <td>
                                        <label class="au-checkbox">
                                            <input type="checkbox">
                                            <span class="au-checkmark"></span>
                                        </label>
                                    </td>
                                    <td><?php echo $orden->fecha;?></td>
                                    <td><?php echo $orden->descripcion;?></td>
                                    <td><?php echo $orden->especificacion;?></td>
                                    
                                </tr>
                            <?php endforeach; 
                            } else {
                                // Handle case when $equipos is empty or not set
                                echo "<tr><td colspan='7'>No hay datos ordenes registradas </td></tr>";
                            }
                            ?>
                            <tr class="spacer"></tr>
                            
                        </tbody>
                    </table>
                </div>
                <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
</div>
