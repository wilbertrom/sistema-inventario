<?php
// application/views/portal/acerca_de.php
// Este archivo reemplaza Informacion.php
?>

<style>
    /* ANIMACIONES PERSONALIZADAS */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes floatLogo {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        50% {
            box-shadow: 0 8px 25px rgba(165, 33, 25, 0.2);
        }
    }
    
    @keyframes borderGlow {
        0%, 100% {
            border-top-color: #a52119;
            box-shadow: 0 5px 15px rgba(165, 33, 25, 0.1);
        }
        50% {
            border-top-color: #ff6b6b;
            box-shadow: 0 8px 25px rgba(165, 33, 25, 0.3);
        }
    }
    
    @keyframes borderGlowDark {
        0%, 100% {
            border-top-color: #000;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        50% {
            border-top-color: #333;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }
    }
    
    @keyframes iconHover {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }
    
    /* CLASES REUTILIZABLES */
    .fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .float-logo {
        animation: floatLogo 3s ease-in-out infinite;
    }
    
    .pulse-card {
        animation: pulse 4s ease-in-out infinite;
    }
    
    .border-glow-linux {
        animation: borderGlow 4s ease-in-out infinite;
    }
    
    .border-glow-mac {
        animation: borderGlowDark 4s ease-in-out infinite;
    }
    
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15) !important;
    }
    
    .btn-glow {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .btn-glow:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .btn-glow:hover:before {
        left: 100%;
    }
    
    .btn-glow:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2) !important;
    }
    
    .logo-container {
        position: relative;
        display: inline-block;
        transition: all 0.3s ease;
    }
    
    .logo-container:hover {
        animation: iconHover 0.6s ease;
    }
    
    .logo-bg-effect {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 120%;
        height: 120%;
        background: radial-gradient(circle, rgba(165, 33, 25, 0.1) 0%, rgba(165, 33, 25, 0) 70%);
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 0;
    }
    
    .logo-container:hover .logo-bg-effect {
        opacity: 1;
    }
    
    .separator-animated {
        position: relative;
        height: 150px;
        width: 2px;
        background: linear-gradient(to bottom, transparent, #000637, transparent);
        margin: 0 auto;
    }
    
    .separator-animated:after {
        content: 'ó';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 0 15px;
        color: #000637;
        font-weight: 600;
        font-size: 1.2rem;
    }
</style>

<div class="container mt-5 fade-in-up">
    <div class="row justify-content-center">
        <div class="col-12 text-center mb-5">
            <h1 style="
                color: #a52119; 
                font-weight: 700;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
                letter-spacing: 1px;
                margin-bottom: 10px;
            ">
                Sistema de Gestión de Laboratorios
            </h1>
            <h3 class="text-muted" style="font-weight: 300; margin-bottom: 30px;">
                Universidad Politécnica de Tlaxcala
            </h3>
            
            <!-- LOGOS ANIMADOS EN LUGAR DE LA IMAGEN -->
            <div class="d-flex justify-content-center align-items-center mb-4">
                <div class="logo-container mr-4 float-logo" style="animation-delay: 0s;">
                    <div class="logo-bg-effect"></div>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/35/Tux.svg/800px-Tux.svg.png" 
                         alt="Linux Tux" 
                         width="60" 
                         height="60"
                         style="object-fit: contain; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));">
                </div>
                <div class="logo-container float-logo" style="animation-delay: 1.5s;">
                    <div class="logo-bg-effect" style="background: radial-gradient(circle, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0) 70%);"></div>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Apple_logo_black.svg/800px-Apple_logo_black.svg.png" 
                         alt="Apple Logo" 
                         width="50" 
                         height="60"
                         style="object-fit: contain; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));">
                </div>
            </div>
            
            <p class="lead text-muted" style="max-width: 700px; margin: 0 auto; font-size: 1.1rem;">
                Plataforma avanzada para la administración de recursos tecnológicos en laboratorios de cómputo
            </p>
        </div>
    </div>
</div>

<!-- NUEVA SECCIÓN: SELECCIÓN DE LABORATORIO -->
<div class="container mt-4 mb-5">
    <div class="row justify-content-center text-center">
        <div class="col-12 mb-5 fade-in-up" style="animation-delay: 0.2s;">
            <h2 style="
                color: #000637; 
                font-weight: 700;
                position: relative;
                display: inline-block;
                padding-bottom: 15px;
            ">
                Seleccione el laboratorio al que desea acceder
                <span style="
                    display: block;
                    width: 100px;
                    height: 4px;
                    background: linear-gradient(90deg, #a52119, #000637);
                    margin: 10px auto;
                    border-radius: 2px;
                "></span>
            </h2>
            <p class="text-muted mt-3" style="font-size: 1.1rem;">
                Elija  el laboratorio 
            </p>
        </div>
        
        <!-- Laboratorio Open Source -->
        <div class="col-md-5 mb-4 fade-in-up hover-lift" style="animation-delay: 0.4s;">
            <div class="card shadow-lg border-0 h-100 pulse-card" style="
                border-top: 5px solid #a52119 !important;
                border-radius: 15px;
                overflow: hidden;
            ">
                <div class="card-body d-flex flex-column p-4" style="position: relative; z-index: 1;">
                    <!-- Elemento decorativo de fondo -->
                    <div style="
                        position: absolute;
                        top: -50px;
                        right: -50px;
                        width: 150px;
                        height: 150px;
                        background: radial-gradient(circle, rgba(165, 33, 25, 0.05) 0%, rgba(165, 33, 25, 0) 70%);
                        border-radius: 50%;
                        z-index: -1;
                    "></div>
                    
                    <div class="mb-4">
                        <div class="logo-container float-logo">
                            <div class="logo-bg-effect"></div>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/35/Tux.svg/800px-Tux.svg.png" 
                                 alt="Linux Tux" 
                                 width="90" 
                                 height="90"
                                 style="object-fit: contain; filter: drop-shadow(0 6px 12px rgba(0,0,0,0.15));">
                        </div>
                    </div>
                    
                    <h3 class="card-title mb-3" style="color: #000637; font-weight: 700;">Laboratorio Open Source</h3>
                    <p class="card-text text-muted mb-4" style="font-size: 1rem; line-height: 1.6;">
                        <i class="fas fa-code mr-2" style="color: #a52119;"></i>
                        Sistemas basados en Linux para desarrollo de software libre, programación avanzada y tecnologías abiertas con herramientas de vanguardia.
                    </p>
                    
                    <!-- Indicadores de características -->
                    <div class="features-indicators mb-4 text-left">
                        <div class="d-flex align-items-center mb-2">
                            <span class="feature-dot mr-2" style="
                                display: inline-block;
                                width: 8px;
                                height: 8px;
                                background-color: #a52119;
                                border-radius: 50%;
                            "></span>
                            <span>Sistemas operativos Linux</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="feature-dot mr-2" style="
                                display: inline-block;
                                width: 8px;
                                height: 8px;
                                background-color: #a52119;
                                border-radius: 50%;
                            "></span>
                            <span>Desarrollo de software libre</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="feature-dot mr-2" style="
                                display: inline-block;
                                width: 8px;
                                height: 8px;
                                background-color: #a52119;
                                border-radius: 50%;
                            "></span>
                            <span>Herramientas de código abierto</span>
                        </div>
                    </div>
                    
                    <div class="mt-auto">
                        <a href="<?php echo base_url('login?lab=opensource') ?>" 
                           class="btn btn-lg btn-block py-3 btn-glow"
                           style="
                                background: linear-gradient(135deg, #a52119, #d32f2f);
                                border: none;
                                color: white;
                                font-weight: 600;
                                border-radius: 10px;
                                box-shadow: 0 4px 15px rgba(165, 33, 25, 0.3);
                           ">
                            <i class="fas fa-sign-in-alt mr-2"></i> Acceder a Open Source
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-1 d-flex align-items-center justify-content-center fade-in-up" style="animation-delay: 0.5s;">
            <div class="separator-animated"></div>
        </div>
        
        <!-- Laboratorio Mac -->
        <div class="col-md-5 mb-4 fade-in-up hover-lift" style="animation-delay: 0.6s;">
            <div class="card shadow-lg border-0 h-100 pulse-card" style="
                border-top: 5px solid #000 !important;
                border-radius: 15px;
                overflow: hidden;
            ">
                <div class="card-body d-flex flex-column p-4" style="position: relative; z-index: 1;">
                    <!-- Elemento decorativo de fondo -->
                    <div style="
                        position: absolute;
                        top: -50px;
                        left: -50px;
                        width: 150px;
                        height: 150px;
                        background: radial-gradient(circle, rgba(0, 0, 0, 0.05) 0%, rgba(0, 0, 0, 0) 70%);
                        border-radius: 50%;
                        z-index: -1;
                    "></div>
                    
                    <div class="mb-4">
                        <div class="logo-container float-logo" style="animation-delay: 1s;">
                            <div class="logo-bg-effect" style="background: radial-gradient(circle, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0) 70%);"></div>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Apple_logo_black.svg/800px-Apple_logo_black.svg.png" 
                                 alt="Apple Logo" 
                                 width="70" 
                                 height="85"
                                 style="object-fit: contain; filter: drop-shadow(0 6px 12px rgba(0,0,0,0.15));">
                        </div>
                    </div>
                    
                    <h3 class="card-title mb-3" style="color: #000637; font-weight: 700;">Laboratorio Mac</h3>
                    <p class="card-text text-muted mb-4" style="font-size: 1rem; line-height: 1.6;">
                        <i class="fas fa-paint-brush mr-2" style="color: #000;"></i>
                        Equipos Apple para desarrollo multimedia, diseño gráfico profesional y aplicaciones creativas de alto rendimiento.
                    </p>
                    
                    <!-- Indicadores de características -->
                    <div class="features-indicators mb-4 text-left">
                        <div class="d-flex align-items-center mb-2">
                            <span class="feature-dot mr-2" style="
                                display: inline-block;
                                width: 8px;
                                height: 8px;
                                background-color: #000;
                                border-radius: 50%;
                            "></span>
                            <span>Sistemas operativos macOS</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="feature-dot mr-2" style="
                                display: inline-block;
                                width: 8px;
                                height: 8px;
                                background-color: #000;
                                border-radius: 50%;
                            "></span>
                            <span>Software de diseño profesional</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="feature-dot mr-2" style="
                                display: inline-block;
                                width: 8px;
                                height: 8px;
                                background-color: #000;
                                border-radius: 50%;
                            "></span>
                            <span>Aplicaciones creativas de alto rendimiento</span>
                        </div>
                    </div>
                    
                    <div class="mt-auto">
                        <a href="<?php echo base_url('login?lab=mac') ?>" 
                           class="btn btn-lg btn-block py-3 btn-glow"
                           style="
                                background: linear-gradient(135deg, #000, #333);
                                border: none;
                                color: white;
                                font-weight: 600;
                                border-radius: 10px;
                                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
                           ">
                            <i class="fas fa-sign-in-alt mr-2"></i> Acceder a Mac
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper" style="
    background: linear-gradient(135deg, #f7f8fa 0%, #eef1f5 100%);
    padding: 60px 0;
    position: relative;
    overflow: hidden;
">
    <!-- Elementos decorativos de fondo -->
    <div style="
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(165, 33, 25, 0.05) 0%, rgba(165, 33, 25, 0) 70%);
        border-radius: 50%;
        animation: floatLogo 6s ease-in-out infinite;
    "></div>
    <div style="
        position: absolute;
        bottom: -100px;
        left: -100px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(0, 6, 55, 0.05) 0%, rgba(0, 6, 55, 0) 70%);
        border-radius: 50%;
        animation: floatLogo 6s ease-in-out infinite 3s;
    "></div>
    
   <div class="container position-relative">
    <section class="features-overview" id="features-section">
        <div class="content-header p-0 text-center mb-5 fade-in-up">
            <h2 style="color: #000637; font-weight: 700; margin-bottom: 15px;">
                ¿Qué ofrece nuestro sistema?
                <span style="
                    display: block;
                    width: 80px;
                    height: 4px;
                    background: linear-gradient(90deg, #a52119, #000637);
                    margin: 15px auto;
                    border-radius: 2px;
                "></span>
            </h2>
            <p class="section-subtitle text-muted" style="
                max-width: 800px; 
                margin: 0 auto; 
                font-size: 1.1rem;
                line-height: 1.6;
            ">
                Plataforma integral para la gestión eficiente de recursos tecnológicos en laboratorios de cómputo, con monitoreo en tiempo real, reportes automatizados y administración centralizada.
            </p>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-4 mb-4 fade-in-up" style="animation-delay: 0.2s;">
                <div class="feature-card text-center p-4 h-100 hover-lift" style="
                    background: white;
                    border-radius: 12px;
                    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
                    transition: all 0.3s ease;
                    height: 100%;
                ">
                    <div class="icon-wrapper mb-4" style="
                        width: 80px;
                        height: 80px;
                        margin: 0 auto;
                        background: linear-gradient(135deg, rgba(165, 33, 25, 0.1), rgba(0, 6, 55, 0.1));
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        transition: transform 0.3s ease;
                    ">
                        <!-- SVG para Gestión Centralizada -->
                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="3" width="7" height="7" rx="1" fill="#a52119" fill-opacity="0.2"/>
                            <rect x="14" y="3" width="7" height="7" rx="1" fill="#a52119" fill-opacity="0.2"/>
                            <rect x="3" y="14" width="7" height="7" rx="1" fill="#a52119" fill-opacity="0.2"/>
                            <rect x="14" y="14" width="7" height="7" rx="1" fill="#a52119" fill-opacity="0.2"/>
                            <path d="M8.5 6.5H6.5M17.5 6.5H15.5M8.5 17.5H6.5M17.5 17.5H15.5M11.5 12H12.5" stroke="#a52119" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="12" cy="12" r="2.5" fill="#a52119"/>
                        </svg>
                    </div>
                    <h5 class="mb-3" style="color: #000637; font-weight: 600;">Gestión Centralizada</h5>
                    <p class="text-muted">Administra todos los equipos desde un solo punto con control total</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4 fade-in-up" style="animation-delay: 0.4s;">
                <div class="feature-card text-center p-4 h-100 hover-lift" style="
                    background: white;
                    border-radius: 12px;
                    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
                    transition: all 0.3s ease;
                    height: 100%;
                ">
                    <div class="icon-wrapper mb-4" style="
                        width: 80px;
                        height: 80px;
                        margin: 0 auto;
                        background: linear-gradient(135deg, rgba(0, 6, 55, 0.1), rgba(165, 33, 25, 0.1));
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        transition: transform 0.3s ease;
                    ">
                        <!-- SVG para Seguimiento en Tiempo Real -->
                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="9" stroke="#000637" stroke-width="1.5" fill="none"/>
                            <path d="M12 7V12L15 15" stroke="#000637" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M12 2C6.477 2 2 6.477 2 12" stroke="#a52119" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M12 2C17.523 2 22 6.477 22 12" stroke="#000637" stroke-width="1.5" stroke-linecap="round"/>
                            <circle cx="12" cy="12" r="1.5" fill="#000637"/>
                        </svg>
                    </div>
                    <h5 class="mb-3" style="color: #000637; font-weight: 600;">Seguimiento en Tiempo Real</h5>
                    <p class="text-muted">Monitorea el estado de cada activo tecnológico instantáneamente</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4 fade-in-up" style="animation-delay: 0.6s;">
                <div class="feature-card text-center p-4 h-100 hover-lift" style="
                    background: white;
                    border-radius: 12px;
                    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
                    transition: all 0.3s ease;
                    height: 100%;
                ">
                    <div class="icon-wrapper mb-4" style="
                        width: 80px;
                        height: 80px;
                        margin: 0 auto;
                        background: linear-gradient(135deg, rgba(165, 33, 25, 0.1), rgba(0, 6, 55, 0.1));
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        transition: transform 0.3s ease;
                    ">
                        <!-- SVG para Reportes Automatizados -->
                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 2H6C4.895 2 4 2.895 4 4V20C4 21.105 4.895 22 6 22H18C19.105 22 20 21.105 20 20V8L14 2Z" 
                                  fill="#a52119" fill-opacity="0.1" stroke="#a52119" stroke-width="1.5"/>
                            <path d="M14 2V8H20" stroke="#a52119" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M16 13H8" stroke="#a52119" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M16 17H8" stroke="#a52119" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M10 9H8" stroke="#a52119" stroke-width="1.5" stroke-linecap="round"/>
                            <rect x="10" y="9" width="2" height="2" rx="0.5" fill="#a52119"/>
                            <rect x="10" y="13" width="2" height="2" rx="0.5" fill="#a52119"/>
                            <rect x="10" y="17" width="2" height="2" rx="0.5" fill="#a52119"/>
                        </svg>
                    </div>
                    <h5 class="mb-3" style="color: #000637; font-weight: 600;">Reportes Automatizados</h5>
                    <p class="text-muted">Genera reportes en PDF y Excel con un solo clic</p>
                </div>
            </div>
        </div>
    </section>   
</div>
</div>

<script>
    // JavaScript para efectos adicionales al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        // Efecto de aparición escalonada para las tarjetas
        const cards = document.querySelectorAll('.feature-card, .hover-lift');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
        
        // Efecto hover para iconos de características
        const iconWrappers = document.querySelectorAll('.icon-wrapper');
        iconWrappers.forEach(wrapper => {
            wrapper.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1)';
            });
            
            wrapper.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
        
        // Efecto de iluminación al pasar sobre logos
        const logoContainers = document.querySelectorAll('.logo-container');
        logoContainers.forEach(container => {
            container.addEventListener('mouseenter', function() {
                this.style.filter = 'drop-shadow(0 8px 16px rgba(0,0,0,0.25))';
            });
            
            container.addEventListener('mouseleave', function() {
                this.style.filter = 'drop-shadow(0 4px 8px rgba(0,0,0,0.2))';
            });
        });
    });
</script>