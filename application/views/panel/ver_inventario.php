<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <!-- DATA TABLE -->
                <h3 class="title-5 m-b-35">Inventario</h3>
                <div class="table-data__tool">
                    <div class="table-data__tool">
                    <form  class="form-header" action="<?php echo base_url('panel/filtrar_inventario'); ?>" method="post">
                        <div class="rs-select2--light rs-select2--md">
                            <select class="js-select2" name="tipo" onchange="this.form.submit()">
                                <option selected="selected">Tipo</option>
                                <?php foreach($tipos as $tipo): ?>
                                    <?php if($tipo->id_tipos == $tipo_seleccionado):?> 
                                        <option value="<?php echo $tipo->id_tipos?>" selected><?php echo $tipo->nombre?></option>
                                    <?php else:?>
                                        <option value="<?php echo $tipo->id_tipos?>"><?php echo $tipo->nombre?></option>
                                    <?php endif; ?>
                                <?php endforeach ?>
                            </select>
                            <div class="dropDownSelect2"></div>
                        </div>
                    </form>

                    <form class="form-header ml-3" action="<?php echo base_url('panel/buscar_inventario'); ?>" method="POST">
                                <input class="au-input au-input--xl" type="text" name="cInterno" placeholder="Busca por Codigo Interno" value="<?php 
                                if(isset($codigo_buscado) != null || isset($codigo_buscado) != ''): echo $codigo_buscado;
                                    endif;
                                  ?>"/>
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                    </form>
                    </div>
                    <div class="table-data__tool-right">
                        <a href="<?php echo base_url('panel/registrar')?>">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small btn-add">
                                <i class="zmdi zmdi-plus"></i>Agregar Equipo</button>
                        </a>
                        <div class="btn-group">
                                <button type="button" class="au-btn au-btn-icon au-btn--green au-btn--small btn-uptx-search dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Exportar</button>

                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?php echo base_url('pdf/generarPdfEquipos')?>" target="_blank">PDF</a>
                                    <a class="dropdown-item" href="<?php echo base_url('excel/index')?>">EXCEL</a>
                                </div>
                        </div>
                    </div>
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
                                <th>Marca</th>
                                <th>Codigo Interno</th>
                                <th>Tipo</th>
                                <th>Observacion</th>
                                <th>Estado</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(isset($equipos) && !empty($equipos)) {

                            foreach ($equipos as $equipo) : ?>
                                <tr class="tr-shadow">
                                    <td>
                                        <label class="au-checkbox">
                                            <input type="checkbox">
                                            <span class="au-checkmark"></span>
                                        </label>
                                    </td>
                                    <td><?php echo $equipo->marca;?></td>
                                    <td><?php echo $equipo->cod_interno;?></td>
                                    <td><?php echo $equipo->tipo;?></td>
                                    <td><?php echo $equipo->descripcion;?></td>
                                    <td class="<?php 
                                        if ($equipo->estado == 'En servicio') {
                                            echo 'text-success';
                                        } elseif ($equipo->estado == 'Fuera de servicio') {
                                            echo 'text-danger';
                                        } else {
                                            echo 'text-warning';
                                        }
                                    ?>"><?php echo $equipo->estado; ?></td>
                                    
                                    <td>
                                        <div class="table-data-feature">
                                            <a class="item" role="button" href="<?php echo base_url('panel/detalles/'); echo $equipo->id_equipos;?>" data-toggle="tooltip" data-placement="top" title="Detalles">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            <a class="item" role="button" href="<?php echo base_url('panel/editar/'); echo $equipo->id_equipos;?>" data-toggle="tooltip" data-placement="top" title="Editar">
                                                <i class="zmdi zmdi-edit"></i>
                                            </a>
                                            <a class="item" role="button" href="<?php echo base_url('inventario/eliminar/'); echo $equipo->id_equipos; ?>" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                                <i class="zmdi zmdi-delete"></i>
                                            </a>
                                            <div class="dropdown">
                                                <button class="item"  type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-placement="top" title="Mas">
                                                    <i class="zmdi zmdi-more"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <h6 class="dropdown-header">Mas opciones</h6>
                                                    <a class="dropdown-item" href="<?php echo base_url('panel/orden_mantenimiento/'). $equipo->id_equipos; ?>">Orden Mantenimiento</a>
                                                    <a class="dropdown-item" href="<?php echo base_url('orden/ver_ordenesEquipo/'). $equipo->id_equipos; ?>">Ver ordenes</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; 
                            } else {
                                // Handle case when $equipos is empty or not set
                                echo "<tr><td colspan='7'>No hay datos equipos registrados </td></tr>";
                            }
                            ?>
                            <tr class="spacer"></tr>
                            
                        </tbody>
                    </table>
                </div>
                <!-- END DATA TABLE -->
                 <!-- Enlaces de paginación -->
                <div class="pagination-links">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
                <script>
        window.onload = function() {
            history.pushState(null, null, location.href);
            window.onpopstate = function() {
                history.go(1);
            };
        };
    </script>
                </div>
            </div>
        </div>
    </div>
</div>
