<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            
            <!-- Título y bienvenida -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="welcome-card" style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 style="font-size: 28px; font-weight: 700; color: #1e293b; margin: 0;">
                                    <i class="fas fa-tachometer-alt" style="color: #a52119; margin-right: 10px;"></i> 
                                    Panel de Control
                                </h2>
                                <p style="color: #64748b; font-size: 15px; margin: 8px 0 0;">
                                    Laboratorio: <strong style="color: #a52119; background: #fef2f2; padding: 4px 12px; border-radius: 20px;"><?php echo isset($laboratorio_nombre) ? $laboratorio_nombre : ''; ?></strong>
                                </p>
                            </div>
                            <div class="col-md-4 text-right">
                                 <img src="<?php echo base_url('recursos-panel/images/logo-dashboard.png'); ?>" 
                         alt="Logo UPTx" 
                         style="height: 60px; width: auto; margin-right: 10px;">
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- PRIMERA FILA - 2 COLUMNAS -->
            <div class="row">
                <!-- Columna 1: Equipos registrados -->
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="dashboard-card dashboard-card--equipos">
                        <div class="card-icon">
                            <i class="zmdi zmdi-desktop-windows"></i>
                        </div>
                        <div class="card-content">
                            <span class="card-label">Equipos registrados</span>
                            <span class="card-value"><?php echo $numero_equipos ?? 0; ?></span>
                            <span class="card-desc">Total de equipos en inventario</span>
                            <a href="<?php echo base_url('panel/ver_inventario');?>" class="card-link">
                                Ver inventario completo <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Columna 2: Lista de Cotejo -->
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="dashboard-card dashboard-card--cotejo">
                        <div class="card-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div class="card-content">
                            <span class="card-label">Lista de Cotejo</span>
                            <span class="card-value">Servicios</span>
                            <span class="card-desc">Verificación mensual de servicios</span>
                            <a href="<?php echo base_url('reporteservicios/index');?>" class="card-link">
                                Gestionar lista <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- SEGUNDA FILA - 2 COLUMNAS -->
            <div class="row">
                <!-- Columna 3: Grupos -->
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="dashboard-card dashboard-card--grupos">
                        <div class="card-icon">
                            <i class="fas fa-th-large"></i>
                        </div>
                        <div class="card-content">
                            <span class="card-label">Grupos de trabajo</span>
                            <span class="card-value">Administrar</span>
                            <span class="card-desc">Organización por mesas y equipos</span>
                            <a href="<?php echo base_url('grupos/vista');?>" class="card-link">
                                Ver grupos <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Columna 4: Manual de usuario -->
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="dashboard-card dashboard-card--manual">
                        <div class="card-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="card-content">
                            <span class="card-label">Manual de usuario</span>
                            <span class="card-value">Documentación</span>
                            <span class="card-desc">Guía completa del sistema</span>
                            <a href="<?php echo base_url('recursos-panel/manual/Manual de usuario - Sistema Inventario.pdf');?>" target="_blank" class="card-link">
                                Abrir PDF <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- ACCESOS RÁPIDOS -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h4 style="font-size: 18px; font-weight: 600; color: #1e293b; margin-bottom: 20px;">
                        <i class="fas fa-bolt" style="color: #a52119; margin-right: 8px;"></i>
                        Accesos rápidos
                    </h4>
                </div>
                
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-3">
                    <a href="<?php echo base_url('panel/ver_inventario');?>" class="quick-link">
                        <i class="fas fa-search"></i>
                        <span>Ver inventario</span>
                    </a>
                </div>
                
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-3">
                    <a href="<?php echo base_url('panel/registrar');?>" class="quick-link">
                        <i class="fas fa-plus"></i>
                        <span>Registrar equipo</span>
                    </a>
                </div>
                
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-3">
                    <a href="<?php echo base_url('programa-anual');?>" class="quick-link">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Programa anual</span>
                    </a>
                </div>
                
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-3">
    
</div>
            </div>
            
            <!-- FOOTER -->
            <footer class="mt-5">
                <div style="background: linear-gradient(135deg, #a52119 0%, #8a1a14 100%); padding: 25px; border-radius: 15px; margin-top: 40px;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <p style="color: white; margin: 0; font-size: 14px;">
                                <i class="far fa-copyright mr-1"></i> 2026 Universidad Politécnica de Tlaxcala. 
                                Todos los derechos reservados.
                            </p>
                            <p style="color: rgba(255,255,255,0.8); margin: 5px 0 0; font-size: 12px;">
                                Sistema de Gestión de Laboratorios v2.0
                            </p>
                        </div>
                        <div class="col-md-4 text-right">
                            <img src="<?php echo base_url('recursos-portal/');?>images/icon/sgc.png" alt="SGC UPTx" style="height: 35px; opacity: 0.9;">
                        </div>
                    </div>
                </div>
            </footer>
            
        </div>
    </div>
</div>

<style>
    /* ===== AJUSTE PARA QUE EL HEADER NO TAPE EL CONTENIDO ===== */
    body {
        padding-top: 0 !important;
        margin: 0 !important;
    }
    
    .page-container {
        margin-top: 80px !important; /* Altura del header */
        padding-top: 0 !important;
    }
    
    .main-content {
        padding-top: 0;
    }
    
    /* En móvil, no hay header fijo */
    @media (max-width: 991px) {
        .page-container {
            margin-top: 0 !important;
        }
    }
    
    /* ===== ESTILOS DE LAS TARJETAS ===== */
    .dashboard-card {
        background: white;
        border-radius: 20px;
        padding: 30px 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 25px;
        height: 100%;
        border: 1px solid rgba(0,0,0,0.03);
        position: relative;
        overflow: hidden;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(165, 33, 25, 0.15);
    }
    
    /* Colores de borde */
    .dashboard-card--equipos { border-left: 5px solid #2196F3; }
    .dashboard-card--cotejo { border-left: 5px solid #FF9800; }
    .dashboard-card--grupos { border-left: 5px solid #4CAF50; }
    .dashboard-card--manual { border-left: 5px solid #9C27B0; }
    
    /* Icono */
    .card-icon {
        width: 80px;
        height: 80px;
        background: #f8fafc;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .dashboard-card:hover .card-icon {
        transform: scale(1.05) rotate(3deg);
        background: linear-gradient(135deg, #a52119 0%, #d32f2f 100%);
    }
    
    .card-icon i {
        font-size: 40px;
        color: #a52119;
        transition: all 0.3s ease;
    }
    
    .dashboard-card:hover .card-icon i {
        color: white;
    }
    
    /* Contenido */
    .card-content {
        flex: 1;
    }
    
    .card-label {
        display: block;
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .card-value {
        display: block;
        font-size: 36px;
        font-weight: 700;
        color: #a52119;
        margin-bottom: 8px;
        line-height: 1.2;
    }
    
    .card-desc {
        display: block;
        font-size: 13px;
        color: #64748b;
        margin-bottom: 15px;
    }
    
    .card-link {
        color: #a52119;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }
    
    .card-link:hover {
        color: #8a1a14;
        text-decoration: none;
        gap: 12px;
    }
    
    /* Accesos rápidos */
    .quick-link {
        background: white;
        border-radius: 12px;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #1e293b;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    
    .quick-link:hover {
        background: linear-gradient(135deg, #a52119 0%, #d32f2f 100%);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(165, 33, 25, 0.2);
        border-color: transparent;
    }
    
    .quick-link i {
        font-size: 20px;
        color: #a52119;
        transition: all 0.3s ease;
    }
    
    .quick-link:hover i {
        color: white;
    }
    
    /* Animaciones */
    .dashboard-card {
        animation: slideInLeft 0.6s ease-out forwards;
        opacity: 0;
    }
    
    .dashboard-card:nth-child(1) { animation-delay: 0.1s; }
    .dashboard-card:nth-child(2) { animation-delay: 0.2s; }
    .dashboard-card:nth-child(3) { animation-delay: 0.3s; }
    .dashboard-card:nth-child(4) { animation-delay: 0.4s; }
    
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .quick-link {
        animation: fadeInUp 0.6s ease-out forwards;
        opacity: 0;
        animation-fill-mode: forwards;
    }
    
    .quick-link:nth-child(1) { animation-delay: 0.5s; }
    .quick-link:nth-child(2) { animation-delay: 0.6s; }
    .quick-link:nth-child(3) { animation-delay: 0.7s; }
    .quick-link:nth-child(4) { animation-delay: 0.8s; }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-card {
            padding: 20px;
            gap: 15px;
        }
        
        .card-icon {
            width: 60px;
            height: 60px;
        }
        
        .card-icon i {
            font-size: 30px;
        }
        
        .card-label {
            font-size: 14px;
        }
        
        .card-value {
            font-size: 28px;
        }
    }
</style>