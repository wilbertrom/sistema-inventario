<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
        <div class="row justify-content-center">
        <div class="col-lg-9">
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th class="bg_uptx">Año</th>
                                                <th class="bg_uptx">Mes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $reporte->año?></td>
                                                <td><a class="anchor_uptx" href="<?php echo base_url('reporteservicios/actualizar_mes/'. $reporte->id."/1")?>">Enero</a></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $reporte->año?></td>
                                                <td><a class="anchor_uptx" href="<?php echo base_url('reporteservicios/actualizar_mes/'. $reporte->id."/2")?>">Febrero</a></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $reporte->año?></td>
                                                <td><a class="anchor_uptx" href="<?php echo base_url('reporteservicios/actualizar_mes/'. $reporte->id."/3")?>">Marzo</a></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $reporte->año?></td>
                                                <td><a class="anchor_uptx" href="<?php echo base_url('reporteservicios/actualizar_mes/'. $reporte->id."/4")?>">Abril</a></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $reporte->año?></td>
                                                <td><a class="anchor_uptx" href="<?php echo base_url('reporteservicios/actualizar_mes/'. $reporte->id."/5")?>">Mayo</a></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $reporte->año?></td>
                                                <td><a class="anchor_uptx" href="<?php echo base_url('reporteservicios/actualizar_mes/'. $reporte->id."/6")?>">Junio</a></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $reporte->año?></td>
                                                <td><a class="anchor_uptx" href="<?php echo base_url('reporteservicios/actualizar_mes/'. $reporte->id."/7")?>">Julio</a></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $reporte->año?></td>
                                                <td><a class="anchor_uptx" href="<?php echo base_url('reporteservicios/actualizar_mes/'. $reporte->id."/8")?>">Agosto</a></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $reporte->año?></td>
                                                <td><a class="anchor_uptx" href="<?php echo base_url('reporteservicios/actualizar_mes/'. $reporte->id."/9")?>">Septiembre</a></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $reporte->año?></td>
                                                <td><a class="anchor_uptx" href="<?php echo base_url('reporteservicios/actualizar_mes/'. $reporte->id."/10")?>">Octubre</a></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $reporte->año?></td>
                                                <td><a class="anchor_uptx" href="<?php echo base_url('reporteservicios/actualizar_mes/'. $reporte->id."/11")?>">Noviembre</a></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $reporte->año?></td>
                                                <td><a class="anchor_uptx" href="<?php echo base_url('reporteservicios/actualizar_mes/'. $reporte->id."/12")?>">Diciembre</a></td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-7">
              <a class="btn btn-uptx btn-block" href="<?php echo base_url('reporteServicios/generarReporte/'.$reporte->año)?>" role="button" target="_blank">Exportar</a>
            </div>
        </div>
    </div>
</div>
