<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-4">
                <div class="statistic__item">
                        <a href="<?php echo base_url('panel/ver_inventario');?>">
                            <h2 class="number"><?php echo $numero_equipos?></h2>
                            <span class="desc">Equipos registrados</span>
                            <div class="icon">
                                <i class="zmdi zmdi-desktop-windows"></i>
                            </div>
                        </a>
                </div>
            </div>
            <div class="col-md-7 col-lg-4">
                <div class="statistic__item">
                    <a href="<?php echo base_url('reporteservicios/index');?>">
                        <h2 class="number"></h2>
                        <span class="desc">Lista de Cotejo</span>
                        <span class="desc">Servicios</span>
                        <div class="icon">
                            <i class="fas fa-check-square"></i>
                        </div>
                    </a>
                </div>
            </div>
            
        </div>
        <div class="row justify-content-center">
        <div class="col-md-7 col-lg-4">
                <div class="statistic__item">
                    <a href="<?php echo base_url('grupos/vista');?>">
                        <h2 class="number"></h2>
                        <span class="desc">Grupos</span>
                        <div class="icon">
                            <i class="fas fa-th-large"></i>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-7 col-lg-4">
                <div class="statistic__item">
                    <a href="<?php echo base_url('recursos-panel/manual/Manual de usuario - Sistema Inventario.pdf')?>">
                        <h2 class="number"></h2>
                        <span class="desc">Manual de usuario</span>
                        <div class="icon">
                            <i class="fas fa-file"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

            <footer class="mt-auto" style="background-color: gray; padding: 1rem 0">
                        <div class="row text-center">
                            <div class="col-sm-12 col-md-12 col-md-12 col-lg-12 mt-3">
                                <p><a href="<?php echo base_url('portal/acerca_de')?>" class="text-white">Acerca de </a></p>
                                <p><a href="<?php echo base_url('portal/equipo')?>" class="text-white">Equipo de desarrollo </a></p>
                                <p><a href="<?php echo base_url('recursos-panel/manual/Manual de usuario - Sistema Inventario.pdf')?>" class="text-white" target="_blank">Manual del panel </a></p>
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                        
                                <div class="copyright">
                                    <p style="color: white;">
                                        Copyright © 2024 Universidad Politécnica de Tlaxcala. Todos los derechos reservados.
                                    </p>
                                </div>
                            </div>
                        </div>
            </footer>
        
    </div>
</div>