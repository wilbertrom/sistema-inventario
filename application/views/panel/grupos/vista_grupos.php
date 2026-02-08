<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <!-- DATA TABLE -->
                <h3 class="title-5 m-b-35">Grupos</h3>
                <div class="table-data__tool">
                    
                    
                </div>
                </div>
            </div>
            <div class="row">
             <?php foreach ($mesas as $mesa) : ?>
                <?php ?>
                <div class="col-xl-6 mb-4" id="mesa-<?php echo $mesa->id_mesas; ?>">
                    <div class="card">
                        <div class="card-header text-center">
                        <h4>Mesa #<?php echo $mesa->id_mesas; ?></h4>
                        </div>
                        <div class="card-body">
                        <div class="row text-center">
                        <?php foreach ($mesa->grupos as $grupo) : ?>
                            <div class="col-md-3 mb-3 ">
                                <h5>Máquina #<?php echo $grupo->id_grupos; ?></h5>
                                <ul class="list-group mt-3">
                                <?php 
                                                $equipos = $grupo->equipos;
                                                $icons = [
                                                    'CPU' => 'fa-server',
                                                    'MONITOR' => 'fa-desktop',
                                                    'TECLADO' => 'fa-keyboard',
                                                    'MOUSE' => 'fa-mouse-pointer',
                                                    'CABLE' => 'fa-plug'
                                                ];
                                                foreach ($icons as $type => $icon) : 
                                                    $hasEquipo = array_filter($equipos, function($equipo) use ($type) {
                                                        return strpos($equipo->tipo, $type) !== false;
                                                    });
                                                    $color = $hasEquipo ? 'text-danger' : 'text-muted'; // Cambia 'text-muted' por el color que quieras para cuando no hay equipo
                                                ?>
                                    <li class="list-group-item" id="<?php echo $type."-".$grupo->id_grupos;?>">
                                        
                                        <div class="dropdown">
                                            <button class="button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                                <i class="fa <?php echo $icon; ?> fa-3x <?php echo $color; ?>"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="<?php echo base_url('grupos/vista_asignar/'). $type. "/".$mesa->id_mesas."/" . $grupo->id_grupos ?>">Asignar</a>
                                                <a class="dropdown-item" href="<?php echo base_url('grupos/detalles/').$type."/". $grupo->id_grupos?>">Detalles</a>
                                                
                                            </div>
                                        </div>    
                                    </li>
                                <?php endforeach; ?>    
                                </ul>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    </div>
                    
                </div>
                <?php endforeach; ?>
            </div>

            
        </div>
    </div>

</div>