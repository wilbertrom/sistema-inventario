<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title Page-->
    <title><?php echo $title?></title>

    <!-- Fontfaces CSS-->
    <link href="<?php echo base_url('recursos-panel/');?>css/font-face.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

     <!-- Jquery JS-->
   <script src="<?php echo base_url('recursos-panel/');?>vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="<?php echo base_url('recursos-panel/');?>vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Bootstrap CSS-->
    <link href="<?php echo base_url('recursos-panel/');?>vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <!-- Sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript" src="<?php echo base_url('recursos-panel/multiple/');?>js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="<?php echo base_url('recursos-panel/multiple/');?>css/bootstrap-multiselect.css" type="text/css">


    <!-- Vendor CSS-->
    <link href="<?php echo base_url('recursos-panel/');?>vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('recursos-portal\images\icon\computer.svg')?>">

    <!-- Main CSS-->
    <link href="<?php echo base_url('recursos-panel/');?>css/cs.css" rel="stylesheet" media="all">

    <link href="<?php echo base_url('recursos-panel/');?>css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="<?php echo base_url();?>">
                            <img src="<?php echo base_url('recursos-portal/');?>images/icon/UPTx_Logo.png" alt="Logo Uptx" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="active">
                            <a class="js-arrow" href="<?php echo base_url()?>">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-desktop"></i>Administrar inventario</a>
                                <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                    <li><a href="<?php echo base_url('panel/ver_inventario')?>">Ver Inventario</a></li>
                                    <li><a href="<?php echo base_url('panel/registrar')?>">Registrar</a></li>
                                <li><a href="<?php echo base_url('grupos/vista')?>">Ver Grupos</a></li>
                                <li><a class="ml-3" href="<?php echo base_url('reporteservicios/index')?>"><i class="fas fa-check-square"></i>Reportes de servicios</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="<?php echo base_url();?>">
                    <img src="<?php echo base_url('recursos-portal/');?>images/icon/UPTx_Logo.png" alt="Logo Uptx" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="active">
                            <a class="js-arrow" href="<?php echo base_url()?>">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-desktop"></i>Administrar inventario</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                
                                
                        
                            </ul>
                        </li>
                        <li><a class="ml-3" href="<?php echo base_url('panel/ver_inventario')?>"><i class="fas fa-search "></i>Ver Inventario</a></li> 
                        <li><a class="ml-3" href="<?php echo base_url('panel/registrar')?>"><i class="fas fa-plus    "></i> Registrar Equipo</a></li>
                        <li><a class="ml-3" href="<?php echo base_url('grupos/vista')?>"><i class="fas fa-th-large"></i>Ver Grupos</a></li>
                        <li><a class="ml-3" href="<?php echo base_url('reporteServicios/index')?>"><i class="fas fa-check-square"></i>Reportes de servicios</a></li>
                        
                        
                        
                        
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap justify-content-end">
                            
                            <div class="header-button justify-content-end">
                                
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image rounded-circle">
                                            <img src="<?php echo base_url('recursos-panel/images/usuario/'. $this->session->userdata('img'));?>" alt="" />
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href=""><?php echo $this->session->userdata('username'); ?></a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
                                                        <img class="rounded-circle" src="<?php echo base_url('recursos-panel/images/usuario/'. $this->session->userdata('img'));?>" alt="Usuario" />
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#"><?php echo $this->session->userdata('username'); ?></a>
                                                    </h5>
                                                    <span class="email"><?php echo $this->session->userdata('email'); ?></span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="<?php echo base_url('perfil/editar')?>">
                                                        <i class="zmdi zmdi-account"></i>Cuenta</a>
                                                </div>
                                                
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="<?php echo base_url('login/logout')?>">
                                                    <i class="zmdi zmdi-power"></i>Cerrar sesión</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->
