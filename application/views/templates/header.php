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
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('recursos-portal/images/icon/computer.svg')?>">

    <!-- Main CSS-->
    <link href="<?php echo base_url('recursos-panel/');?>css/cs.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>css/theme.css" rel="stylesheet" media="all">

    <style>
        /* Estilos mejorados para el menú horizontal */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            overflow-x: hidden;
        }
        
        .header-desktop {
            background: white;
            box-shadow: 0 4px 15px rgba(165, 33, 25, 0.15);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1000;
            border-bottom: 3px solid #a52119;
        }
        
        .header-desktop .section__content {
            width: 100%;
            max-width: 100%;
            padding: 0 30px;
        }
        
        .header-desktop .container-fluid {
            width: 100%;
            max-width: 100%;
            padding: 0;
        }
        
        .header-desktop .header-wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            min-height: 80px;
        }
        
        /* Logo y marca */
        .header-logo {
            display: flex;
            align-items: center;
            min-width: 200px;
        }
        
        .header-logo .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .header-logo .logo img {
            height: 50px;
            width: auto;
            margin-right: 15px;
        }
        
        .header-logo .logo span {
            font-size: 16px;
            font-weight: 700;
            color: #a52119;
            line-height: 1.2;
        }
        
        .header-logo .logo span small {
            display: block;
            font-size: 11px;
            font-weight: 400;
            color: #666;
        }
        
        /* Navegación */
        .header-nav {
            flex: 1;
            display: flex;
            justify-content: center;
        }
        
        .header-nav ul {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }
        
        .header-nav .list-inline-item {
            margin: 0 2px;
        }
        
        .header-nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #333;
            font-size: 14px;
            font-weight: 600;
            border-radius: 40px;
            transition: all 0.3s ease;
            position: relative;
            letter-spacing: 0.3px;
        }
        
        .header-nav-link i {
            margin-right: 8px;
            font-size: 16px;
            color: #a52119;
            transition: all 0.3s ease;
        }
        
        .header-nav-link:hover,
        .header-nav-link:focus,
        .header-nav-link.active {
            background: linear-gradient(135deg, #a52119 0%, #d32f2f 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(165, 33, 25, 0.3);
        }
        
        .header-nav-link:hover i,
        .header-nav-link:focus i,
        .header-nav-link.active i {
            color: white;
        }
        
        /* Dropdown menu */
        .header-desktop .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 12px;
            margin-top: 10px;
            min-width: 240px;
            padding: 10px 0;
            border-top: 3px solid #a52119;
        }
        
        .header-desktop .dropdown-item {
            padding: 12px 20px;
            font-size: 14px;
            color: #333;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        
        .header-desktop .dropdown-item i {
            width: 24px;
            color: #a52119;
            margin-right: 12px;
            font-size: 16px;
            transition: all 0.2s ease;
        }
        
        .header-desktop .dropdown-item:hover {
            background-color: #fdf1f0;
            color: #a52119;
            padding-left: 25px;
        }
        
        .header-desktop .dropdown-item:hover i {
            color: #a52119;
            transform: scale(1.1);
        }
        
        /* Perfil de usuario */
        .header-button {
            min-width: 200px;
            display: flex;
            justify-content: flex-end;
        }
        
        .account-wrap {
            display: flex;
            align-items: center;
        }
        
        .account-item {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 40px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .account-item:hover {
            background: linear-gradient(135deg, #a52119 0%, #d32f2f 100%);
        }
        
        .account-item:hover .content a {
            color: white;
        }
        
        .account-item .image {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 12px;
            border: 2px solid #a52119;
            padding: 2px;
            background: white;
        }
        
        .account-item .image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        
        .account-item .content a {
            color: #333;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        /* Ajuste para el contenido principal */
        .page-container {
            margin-left: 0;
            width: 100vw;
            padding-top: 95px;
            min-height: 100vh;
            background: #f5f5f5;
        }
        
        .main-content {
            padding: 30px;
            width: 100%;
            max-width: 100%;
        }
        
        /* Account dropdown */
        .account-dropdown {
            width: 280px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 12px;
            margin-top: 10px;
            border-top: 3px solid #a52119;
        }
        
        .account-dropdown .info {
            padding: 20px;
            background: linear-gradient(135deg, #a52119 0%, #d32f2f 100%);
            color: white;
            border-radius: 12px 12px 0 0;
        }
        
        .account-dropdown .info .image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid white;
        }
        
        .account-dropdown .info .name a {
            color: white;
            font-size: 16px;
            font-weight: 600;
        }
        
        .account-dropdown .info .email {
            color: rgba(255,255,255,0.8);
            font-size: 12px;
        }
        
        .account-dropdown__body {
            padding: 10px 0;
        }
        
        .account-dropdown__item a {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: #333;
            transition: all 0.2s ease;
        }
        
        .account-dropdown__item a i {
            width: 24px;
            color: #a52119;
            margin-right: 12px;
        }
        
        .account-dropdown__item a:hover {
            background: #fdf1f0;
            color: #a52119;
            text-decoration: none;
        }
        
        .account-dropdown__footer {
            border-top: 1px solid #eee;
            padding: 10px 0;
        }
        
        .account-dropdown__footer a {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: #dc3545;
            transition: all 0.2s ease;
        }
        
        .account-dropdown__footer a i {
            width: 24px;
            margin-right: 12px;
        }
        
        .account-dropdown__footer a:hover {
            background: #ffeeee;
            text-decoration: none;
        }
        
        /* Responsive */
        @media (max-width: 1199px) {
            .header-logo {
                min-width: 150px;
            }
            
            .header-logo .logo span {
                font-size: 13px;
            }
            
            .header-nav-link {
                padding: 8px 12px;
                font-size: 12px;
            }
        }
        
        @media (max-width: 991px) {
            .header-desktop {
                display: none;
            }
            
            .page-container {
                padding-top: 0;
            }
        }
        
        @media (min-width: 992px) {
            .header-mobile {
                display: none;
            }
        }
      body, .page-wrapper, .page-container {
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
    max-width: 100% !important;
}
    </style>
</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE (solo visible en móvil)-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="<?php echo base_url();?>">
                            <img src="<?php echo base_url('recursos-portal/');?>images/icon/UPTx_Logo.png" alt="Logo Uptx" style="height: 45px;" />
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
                        <li>
                            <a href="<?php echo base_url()?>">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-desktop"></i> Inventario
                            </a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li><a href="<?php echo base_url('panel/ver_inventario')?>">Ver Inventario</a></li>
                                <li><a href="<?php echo base_url('panel/registrar')?>">Registrar Equipo</a></li>
                                <li><a href="<?php echo base_url('grupos/vista')?>">Ver Grupos</a></li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-certificate"></i> Calidad
                            </a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li><a href="<?php echo base_url('reporteServicios/index')?>">Reportes de servicios</a></li>
                                <li><a href="<?php echo base_url('programa-anual'); ?>">Programa Anual</a></li>
                                <li><a href="<?php echo base_url('orden-mantenimiento'); ?>">Órdenes de Mantenimiento</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo base_url('perfil/editar')?>">
                                <i class="fas fa-user"></i> Mi Perfil
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('login/logout')?>">
                                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- HEADER DESKTOP (solo visible en desktop)-->
        <header class="header-desktop d-none d-lg-block">
            <div class="section__content">
                <div class="container-fluid">
                    <div class="header-wrap">
                        <!-- Logo y nombre de la universidad -->
                        <div class="header-logo">
                            <a class="logo" href="<?php echo base_url();?>">
                                <img src="<?php echo base_url('recursos-portal/');?>images/icon/UPTx_Logo.png" alt="Logo Uptx" />
                                <span>Universidad Politécnica<br><small>de Tlaxcala</small></span>
                            </a>
                        </div>
                        
                        <!-- Menú horizontal de navegación -->
                        <div class="header-nav">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <a href="<?php echo base_url()?>" class="header-nav-link <?php echo (current_url() == base_url()) ? 'active' : ''; ?>">
                                        <i class="fas fa-home"></i> Dashboard
                                    </a>
                                </li>
                                
                                <!-- Menú desplegable: Administrar Inventario -->
                                <li class="list-inline-item dropdown">
                                    <a href="#" class="header-nav-link dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-desktop"></i> Inventario
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?php echo base_url('panel/ver_inventario')?>">
                                            <i class="fas fa-search"></i> Ver Inventario
                                        </a>
                                        <a class="dropdown-item" href="<?php echo base_url('panel/registrar')?>">
                                            <i class="fas fa-plus"></i> Registrar Equipo
                                        </a>
                                        <a class="dropdown-item" href="<?php echo base_url('grupos/vista')?>">
                                            <i class="fas fa-th-large"></i> Ver Grupos
                                        </a>
                                    </div>
                                </li>
                                
                                <!-- Menú desplegable: Gestión de Calidad -->
                                <li class="list-inline-item dropdown">
                                    <a href="#" class="header-nav-link dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-certificate"></i> Calidad
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?php echo base_url('reporteServicios/index')?>">
                                            <i class="fas fa-clipboard-check"></i> Reportes de servicios
                                        </a>
                                        <a class="dropdown-item" href="<?php echo base_url('programa-anual'); ?>">
                                            <i class="fas fa-calendar-alt"></i> Programa Anual
                                        </a>
                                        <a class="dropdown-item" href="<?php echo base_url('orden-mantenimiento'); ?>">
                                            <i class="fas fa-tools"></i> Órdenes de Mantenimiento
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Perfil de usuario -->
                        <div class="header-button">
                            <div class="account-wrap">
                                <div class="account-item clearfix js-item-menu">
                                    <div class="image">
                                        <img src="<?php echo base_url('recursos-panel/images/usuario/'. $this->session->userdata('img'));?>" alt="<?php echo $this->session->userdata('username'); ?>" />
                                    </div>
                                    <div class="content">
                                        <a class="js-acc-btn" href="#"><?php echo $this->session->userdata('username'); ?></a>
                                    </div>
                                    <div class="account-dropdown js-dropdown">
                                        <div class="info clearfix">
                                            <div class="image">
                                                <img src="<?php echo base_url('recursos-panel/images/usuario/'. $this->session->userdata('img'));?>" alt="<?php echo $this->session->userdata('username'); ?>" />
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
                                                    <i class="zmdi zmdi-account"></i> Mi Cuenta
                                                </a>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__footer">
                                            <a href="<?php echo base_url('login/logout')?>">
                                                <i class="zmdi zmdi-power"></i> Cerrar sesión
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- END HEADER DESKTOP-->

        <!-- PAGE CONTAINER (contenido principal) -->
        <div class="page-container">
            <!-- El contenido específico de cada página se cargará aquí -->