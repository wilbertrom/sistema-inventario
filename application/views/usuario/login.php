<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <title>Login</title>

    <link href="<?php echo base_url('recursos-panel/');?>css/font-face.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>css/theme.css" rel="stylesheet" media="all">
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('recursos-portal/images/icon/computer.svg')?>">
</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="<?php echo base_url()?>">
                                <img src="<?php echo base_url('recursos-portal/');?>images/icon/UPTx_Logo.png" alt="Logo Uptx">
                            </a>
                        </div>
                        
                        <?php echo validation_errors('<div class="error alert alert-warning">', '</div>'); ?>
                        
                        <?php if (isset($error)): ?>
                            <div class="error alert alert-warning"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <?php echo form_open('login/do_login'); ?>
                            <div class="login-form">
                                <div class="form-group">
                                    <label>Usuario</label>
                                    <input class="au-input au-input--full" type="text" name="username" placeholder="Ingrese su usuario" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input class="au-input au-input--full" type="password" name="password" placeholder="Ingrese su contraseña" required>
                                </div>
                                
                                <!-- Campo oculto con laboratorio_id POR DEFECTO -->
                                <input type="hidden" name="laboratorio" value="1"> <!-- Cambia según necesites -->
                                
                                <button class="au-btn au-btn--block au-btn--uptx m-b-20" type="submit">Entrar</button>
                                <a href="<?php echo base_url('portal/acerca_de')?>" class="au-btn--block">
                                    <button class="au-btn au-btn--block au-btn--secondary m-b-20" type="button">Regresar</button>
                                </a>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url('recursos-panel/');?>vendor/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>vendor/slick/slick.min.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>vendor/wow/wow.min.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>vendor/animsition/animsition.min.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>vendor/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>vendor/counter-up/jquery.counterup.min.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>vendor/circle-progress/circle-progress.min.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>vendor/select2/select2.min.js"></script>
    <script src="<?php echo base_url('recursos-panel/');?>js/main.js"></script>
</body>

</html>