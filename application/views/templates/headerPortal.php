<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $title?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="<?php echo base_url('recursos-portal/')?>css/customStyles.css">
  <link rel="stylesheet" href="<?php echo base_url('recursos-portal/')?>vendors/owl-carousel/css/owl.carousel.min.css">
  <link rel="stylesheet" href="<?php echo base_url('recursos-portal/')?>vendors/owl-carousel/css/owl.theme.default.css">
  <link rel="stylesheet" href="<?php echo base_url('recursos-portal/')?>vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url('recursos-portal/')?>vendors/aos/css/aos.css">
  <link rel="stylesheet" href="<?php echo base_url('recursos-portal/')?>css/style.min.css">
  <link rel="icon" type="image/x-icon" href="<?php echo base_url('recursos-portal\images\icon\computer.svg')?>">

</head>
<body id="body" data-spy="scroll" data-target=".navbar" data-offset="100">
  <header id="header-section">
    <nav class="navbar navbar-expand-lg pl-3 pl-sm-0" id="navbar">
    <div class="container">
      <div class="navbar-brand-wrapper d-flex w-100">
        <img src="<?php echo base_url('recursos-portal/')?>images/icon/UPTx_Logo.png" alt="" style="width: 179px;">
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="mdi mdi-menu navbar-toggler-icon"></span>
        </button> 
      </div>
      <div class="collapse navbar-collapse navbar-menu-wrapper" id="navbarSupportedContent">
        <ul class="navbar-nav align-items-lg-center align-items-start ml-auto">
          <li class="d-flex align-items-center justify-content-between pl-4 pl-lg-0">
            <div class="navbar-collapse-logo">
              <img src="<?php echo base_url('recursos/')?>images/icon/UPTx_Logo.png" alt=""  alt="">
            </div>
            <button class="navbar-toggler close-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="mdi mdi-close navbar-toggler-icon pl-5"></span>
            </button>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-uptx" href="<?php echo base_url('portal/acerca_de')?>">Acerca&nbsp;de <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-uptx" href="<?php echo base_url('portal/equipo')?>">Equipo</a>
          </li>
          
          <li class="nav-item btn-contact-us pl-4 pl-lg-0">
          <a href="<?php echo base_url('panel')?>" class="btn btn-uptx" role="button">Entrar al sistema</a>
          </li>
        </ul>
      </div>
    </div> 
    </nav>   
  </header>