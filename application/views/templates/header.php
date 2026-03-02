<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title; ?></title>

    <link href="<?php echo base_url('recursos-panel/');?>css/font-face.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <script src="<?php echo base_url('recursos-panel/');?>vendor/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <link href="<?php echo base_url('recursos-panel/');?>vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo base_url('recursos-panel/multiple/');?>js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="<?php echo base_url('recursos-panel/multiple/');?>css/bootstrap-multiselect.css">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('recursos-portal/images/icon/computer.svg'); ?>">
    <link href="<?php echo base_url('recursos-panel/');?>css/cs.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>css/theme.css" rel="stylesheet" media="all">

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { overflow-x: hidden; margin: 0; padding: 0; }

        .header-desktop {
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(165,33,25,.12);
            position: fixed;
            top: 0; left: 0; right: 0;
            width: 100%;
            z-index: 1000;
            border-bottom: 3px solid #a52119;
        }
        .header-desktop .section__content { width:100%; padding:0 25px; }
        .header-desktop .header-wrap {
            display:flex; justify-content:space-between; align-items:center; min-height:75px;
        }

        /* Logo */
        .header-logo { display:flex; align-items:center; min-width:200px; }
        .header-logo .logo { display:flex; align-items:center; text-decoration:none; gap:12px; }
        .header-logo .logo img { height:48px; width:auto; }
        .header-logo .logo-text { font-size:15px; font-weight:700; color:#a52119; line-height:1.25; }
        .header-logo .logo-text small { display:block; font-size:10.5px; font-weight:400; color:#666; }

        /* Nav */
        .header-nav { flex:1; display:flex; justify-content:center; }
        .header-nav ul { display:flex; align-items:center; list-style:none; margin:0; padding:0; gap:2px; }
        .header-nav-link {
            display:inline-flex; align-items:center; gap:6px;
            padding:9px 14px; color:#333; font-size:13px; font-weight:600;
            border-radius:50px; text-decoration:none;
            transition:background .25s, color .25s, transform .2s, box-shadow .25s;
            white-space:nowrap;
        }
        .header-nav-link i { font-size:14px; color:#a52119; transition:color .25s; }
        .header-nav-link:hover, .header-nav-link.active {
            background:linear-gradient(135deg,#a52119,#a52119);
            color:#fff; transform:translateY(-2px);
            box-shadow:0 6px 16px rgba(165,33,25,.28); text-decoration:none;
        }
        .header-nav-link:hover i, .header-nav-link.active i { color:#fff; }

        /* Dropdown */
        .header-desktop .dropdown-menu {
            border:none; border-top:3px solid #a52119; border-radius:14px;
            box-shadow:0 12px 35px rgba(0,0,0,.13); padding:8px 0;
            min-width:220px; margin-top:8px;
            animation:dropDown .2s ease;
        }
        @keyframes dropDown { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
        .header-desktop .dropdown-item {
            display:flex; align-items:center; gap:12px; padding:10px 20px;
            font-size:13px; color:#333; font-weight:500;
            transition:background .2s, color .2s, padding-left .2s;
        }
        .header-desktop .dropdown-item i { width:20px; font-size:14px; color:#a52119; transition:transform .2s; flex-shrink:0; }
        .header-desktop .dropdown-item:hover { background:#fdf1f0; color:#a52119; padding-left:26px; }
        .header-desktop .dropdown-item:hover i { transform:scale(1.15); }
        .dropdown-divider { margin:4px 12px; border-color:#f0e0e0; }

        /* Perfil */
        .header-button { min-width:180px; display:flex; justify-content:flex-end; }
        .account-item {
            display:flex; align-items:center; gap:10px; cursor:pointer;
            padding:6px 14px 6px 6px; border-radius:50px;
            background:#f8f9fa; border:1.5px solid #ececec; transition:all .25s;
        }
        .account-item:hover { background:linear-gradient(135deg,#a52119,#a52119); border-color:transparent; }
        .account-item:hover .account-username { color:#fff; }
        .account-item .image { width:40px; height:40px; border-radius:50%; overflow:hidden; border:2px solid #a52119; flex-shrink:0; }
        .account-item .image img { width:100%; height:100%; object-fit:cover; }
        .account-username { font-size:13px; font-weight:600; color:#333; transition:color .25s; max-width:100px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

        .account-dropdown { width:270px; border:none; border-top:3px solid #a52119; border-radius:14px; box-shadow:0 12px 35px rgba(0,0,0,.13); overflow:hidden; }
        .account-dropdown .info { padding:18px 20px; background:linear-gradient(135deg,#a52119,#a52119); color:white; display:flex; align-items:center; gap:12px; }
        .account-dropdown .info .image { width:52px; height:52px; border-radius:50%; border:2px solid rgba(255,255,255,.8); overflow:hidden; flex-shrink:0; }
        .account-dropdown .info .image img { width:100%; height:100%; object-fit:cover; }
        .account-dropdown .info .name a { color:white; font-size:15px; font-weight:600; }
        .account-dropdown .info .email { color:rgba(255,255,255,.8); font-size:11.5px; margin-top:2px; }
        .account-dropdown__body { padding:6px 0; }
        .account-dropdown__item a { display:flex; align-items:center; gap:10px; padding:11px 20px; color:#333; font-size:13px; transition:background .2s,color .2s; }
        .account-dropdown__item a i { color:#a52119; font-size:16px; width:20px; }
        .account-dropdown__item a:hover { background:#fdf1f0; color:#a52119; text-decoration:none; }
        .account-dropdown__footer { border-top:1px solid #f0e0e0; padding:6px 0; }
        .account-dropdown__footer a { display:flex; align-items:center; gap:10px; padding:11px 20px; color:#dc3545; font-size:13px; transition:background .2s; }
        .account-dropdown__footer a:hover { background:#fff5f5; text-decoration:none; }

        .page-container {
            margin-left:0 !important; width:100% !important; max-width:100% !important;
            padding-top:81px !important; padding-left:0 !important; padding-right:0 !important;
            padding-bottom:0 !important; min-height:100vh; background:#f5f6f8;
        }
        .main-content { padding:28px; width:100%; max-width:100%; }
        body, .page-wrapper { margin:0 !important; padding:0 !important; width:100% !important; max-width:100% !important; }

        @media(max-width:1199px){
            .header-logo{min-width:150px;} .header-logo .logo-text{font-size:12px;}
            .header-nav-link{padding:8px 10px;font-size:12px;}
        }
        @media(max-width:991px){ .header-desktop{display:none!important;} .page-container{padding-top:0!important;} }
        @media(min-width:992px){ .header-mobile{display:none!important;} }
        @media(max-width:768px){ .main-content{padding:16px;} }
    </style>
</head>

<body class="animsition">
<div class="page-wrapper">

<!-- HEADER MÓVIL -->
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a class="logo" href="<?php echo base_url(); ?>">
                    <img src="<?php echo base_url('assets/'); ?>img/logos/logo_uptlax.png" alt="Logo UPTx" style="height:42px;">
                </a>
                <button class="hamburger hamburger--slider" type="button">
                    <span class="hamburger-box"><span class="hamburger-inner"></span></span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
                <li><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Dashboard</a></li>
                <li class="has-sub">
                    <a class="js-arrow" href="#"><i class="fas fa-desktop"></i> Inventario</a>
                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                        <li><a href="<?php echo base_url('panel/ver_inventario'); ?>">Ver Inventario</a></li>
                        <li><a href="<?php echo base_url('panel/registrar'); ?>">Registrar Equipo</a></li>
                        <li><a href="<?php echo base_url('grupos/vista'); ?>">Ver Grupos</a></li>
                    </ul>
                </li>
                <li class="has-sub">
                    <a class="js-arrow" href="#"><i class="fas fa-certificate"></i> Gestión de Calidad</a>
                    <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                        <li><a href="<?php echo base_url('reporteServicios/index'); ?>">Reportes de servicios</a></li>
                        <li><a href="<?php echo base_url('programa-anual'); ?>">Programa Anual</a></li>
                        <li><a href="<?php echo base_url('orden-mantenimiento'); ?>">Orden de Mantenimiento</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo base_url('perfil/editar'); ?>"><i class="fas fa-user"></i> Mi Perfil</a></li>
                <li><a href="<?php echo base_url('login/logout'); ?>"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
            </ul>
        </div>
    </nav>
</header>

<!-- HEADER DESKTOP -->
<header class="header-desktop d-none d-lg-block">
    <div class="section__content">
        <div class="container-fluid">
            <div class="header-wrap">

                <!-- Logo -->
                <div class="header-logo">
                    <a class="logo" href="<?php echo base_url(); ?>">
                        <img src="<?php echo base_url('assets/'); ?>img/logos/logo_uptlax.png" alt="Logo UPTx">
                        <span class="logo-text">Universidad Politécnica<small>de Tlaxcala</small></span>
                    </a>
                </div>

                <!-- Navegación -->
                <div class="header-nav">
                    <ul>
                        <li>
                            <a href="<?php echo base_url(); ?>"
                               class="header-nav-link <?php echo (current_url()==base_url())?'active':''; ?>">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>

                        <!-- Inventario -->
                        <li class="dropdown">
                            <a href="#" class="header-nav-link dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-desktop"></i> Inventario
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?php echo base_url('panel/ver_inventario'); ?>">
                                    <i class="fas fa-search"></i> Ver Inventario
                                </a>
                                <a class="dropdown-item" href="<?php echo base_url('panel/registrar'); ?>">
                                    <i class="fas fa-plus-circle"></i> Registrar Equipo
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo base_url('grupos/vista'); ?>">
                                    <i class="fas fa-th-large"></i> Ver Grupos
                                </a>
                            </div>
                        </li>

                        <!-- Calidad — AHORA CON ORDEN DE MANTENIMIENTO -->
                        <li class="dropdown">
                            <a href="#" class="header-nav-link dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-certificate"></i> Gestión de Calidad
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?php echo base_url('reporteServicios/index'); ?>">
                                    <i class="fas fa-clipboard-check"></i> Reportes de servicios
                                </a>
                                <a class="dropdown-item" href="<?php echo base_url('programa-anual'); ?>">
                                    <i class="fas fa-calendar-alt"></i> Programa Anual
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo base_url('orden-mantenimiento'); ?>">
                                    <i class="fas fa-tools"></i> Orden de Mantenimiento
                                </a>
                            </div>
                        </li>

                    </ul>
                </div>

                <!-- Perfil -->
                <div class="header-button">
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image">
                                <img src="<?php echo base_url('recursos-panel/images/usuario/' . $this->session->userdata('img')); ?>"
                                     alt="<?php echo $this->session->userdata('username'); ?>">
                            </div>
                            <span class="account-username"><?php echo $this->session->userdata('username'); ?></span>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <img src="<?php echo base_url('recursos-panel/images/usuario/' . $this->session->userdata('img')); ?>"
                                             alt="<?php echo $this->session->userdata('username'); ?>">
                                    </div>
                                    <div>
                                        <div class="name"><a href="#"><?php echo $this->session->userdata('username'); ?></a></div>
                                        <div class="email"><?php echo $this->session->userdata('email'); ?></div>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="<?php echo base_url('perfil/editar'); ?>">
                                            <i class="zmdi zmdi-account"></i> Mi Cuenta
                                        </a>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer">
                                    <a href="<?php echo base_url('login/logout'); ?>">
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

<div class="page-container">