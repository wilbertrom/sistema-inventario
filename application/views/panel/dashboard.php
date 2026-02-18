<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            
            <!-- Título de bienvenida -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="welcome-message">
                        <h3 class="text-dark" style="font-size: 24px; font-weight: 600;">
                            <i class="fas fa-tachometer-alt" style="color: #a52119; margin-right: 10px;"></i> 
                            
                        </h3>
                        <p class="text-muted" style="font-size: 14px;"> <strong><?php echo isset($laboratorio_nombre) ? $laboratorio_nombre : ''; ?></strong></p>
                    </div>
                </div>
            </div>
            
            <!-- Grid de 4 opciones en 2 filas de 2 columnas -->
            <div class="row">
                <!-- Opción 1: Equipos registrados -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-4">
                    <a href="<?php echo base_url('panel/ver_inventario');?>" class="dashboard-card-link">
                        <div class="dashboard-card dashboard-card--equipos">
                            <div class="dashboard-card__icon">
                                <i class="zmdi zmdi-desktop-windows"></i>
                            </div>
                            <div class="dashboard-card__content">
                                <div class="dashboard-card__title">Equipos registrados</div>
                                <div class="dashboard-card__value"><?php echo $numero_equipos ?? 0; ?></div>
                                <div class="dashboard-card__link">Ver inventario →</div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Opción 2: Lista de Cotejo -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-4">
                    <a href="<?php echo base_url('reporteservicios/index');?>" class="dashboard-card-link">
                        <div class="dashboard-card dashboard-card--cotejo">
                            <div class="dashboard-card__icon">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div class="dashboard-card__content">
                                <div class="dashboard-card__title">Lista de Cotejo</div>
                                <div class="dashboard-card__value">Servicios</div>
                                <div class="dashboard-card__link">Gestionar →</div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Opción 3: Grupos -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-4">
                    <a href="<?php echo base_url('grupos/vista');?>" class="dashboard-card-link">
                        <div class="dashboard-card dashboard-card--grupos">
                            <div class="dashboard-card__icon">
                                <i class="fas fa-th-large"></i>
                            </div>
                            <div class="dashboard-card__content">
                                <div class="dashboard-card__title">Grupos</div>
                                <div class="dashboard-card__value">Administrar</div>
                                <div class="dashboard-card__link">Ver grupos →</div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Opción 4: Manual de usuario -->
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-4">
                    <a href="<?php echo base_url('recursos-panel/manual/Manual de usuario - Sistema Inventario.pdf');?>" target="_blank" class="dashboard-card-link">
                        <div class="dashboard-card dashboard-card--manual">
                            <div class="dashboard-card__icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="dashboard-card__content">
                                <div class="dashboard-card__title">Manual de usuario</div>
                                <div class="dashboard-card__value">PDF</div>
                                <div class="dashboard-card__link">Abrir documento →</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            
            <!-- Footer simplificado -->
            <footer class="mt-5" style="background: linear-gradient(135deg, #a52119 0%, #8a1a14 100%); padding: 1.5rem 0; border-radius: 10px; margin-top: 3rem !important;">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="copyright">
                            <p style="color: rgba(255,255,255,0.9); font-size: 13px; margin: 0;">
                                <i class="far fa-copyright mr-1"></i> 2024 Universidad Politécnica de Tlaxcala. Todos los derechos reservados.
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
            
        </div>
    </div>
</div>

<style>
    /* Estilos para las tarjetas del dashboard */
    .dashboard-card-link {
        text-decoration: none;
        display: block;
        height: 100%;
    }
    
    .dashboard-card-link:hover {
        text-decoration: none;
    }
    
    .dashboard-card {
        background: white;
        border-radius: 16px;
        padding: 25px 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        height: 100%;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.03);
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(165, 33, 25, 0.15);
    }
    
    /* Colores de borde izquierdo para cada tarjeta */
    .dashboard-card--equipos {
        border-left: 5px solid #2196F3;
    }
    
    .dashboard-card--cotejo {
        border-left: 5px solid #FF9800;
    }
    
    .dashboard-card--grupos {
        border-left: 5px solid #4CAF50;
    }
    
    .dashboard-card--manual {
        border-left: 5px solid #9C27B0;
    }
    
    /* Efecto de fondo al hacer hover */
    .dashboard-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 0;
        background: linear-gradient(135deg, rgba(165,33,25,0.05) 0%, rgba(165,33,25,0.02) 100%);
        transition: height 0.3s ease;
        z-index: 0;
    }
    
    .dashboard-card:hover::before {
        height: 100%;
    }
    
    /* Icono */
    .dashboard-card__icon {
        width: 70px;
        height: 70px;
        background: #f8f9fa;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }
    
    .dashboard-card:hover .dashboard-card__icon {
        background: linear-gradient(135deg, #a52119 0%, #d32f2f 100%);
        transform: scale(1.05) rotate(3deg);
        box-shadow: 0 8px 15px rgba(165,33,25,0.3);
    }
    
    .dashboard-card__icon i {
        font-size: 32px;
        color: #a52119;
        transition: all 0.3s ease;
    }
    
    .dashboard-card:hover .dashboard-card__icon i {
        color: white;
        transform: scale(1.1);
    }
    
    /* Contenido */
    .dashboard-card__content {
        flex: 1;
        position: relative;
        z-index: 1;
    }
    
    .dashboard-card__title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 6px;
        letter-spacing: 0.3px;
    }
    
    .dashboard-card__value {
        font-size: 24px;
        font-weight: 700;
        color: #a52119;
        margin-bottom: 8px;
        line-height: 1.2;
    }
    
    .dashboard-card__link {
        font-size: 13px;
        color: #666;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .dashboard-card:hover .dashboard-card__link {
        color: #a52119;
        transform: translateX(5px);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-card {
            padding: 20px 15px;
        }
        
        .dashboard-card__icon {
            width: 60px;
            height: 60px;
            margin-right: 15px;
        }
        
        .dashboard-card__icon i {
            font-size: 28px;
        }
        
        .dashboard-card__title {
            font-size: 15px;
        }
        
        .dashboard-card__value {
            font-size: 20px;
        }
    }
    
    /* Animación de entrada */
    .dashboard-card {
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
    }
    
    .dashboard-card:nth-child(1) { animation-delay: 0.1s; }
    .dashboard-card:nth-child(2) { animation-delay: 0.2s; }
    .dashboard-card:nth-child(3) { animation-delay: 0.3s; }
    .dashboard-card:nth-child(4) { animation-delay: 0.4s; }
    
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
</style>