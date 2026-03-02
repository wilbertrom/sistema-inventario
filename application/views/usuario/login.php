<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Sistema de Laboratorios UPTx</title>

    <!-- Fontfaces CSS-->
    <link href="<?php echo base_url('recursos-panel/');?>css/font-face.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url('recursos-panel/');?>vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    
    <!-- Bootstrap CSS-->
    <link href="<?php echo base_url('recursos-panel/');?>vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* ===== ESTILOS INSTITUCIONALES UPTX ===== */
        :root {
            --uptx-red: #a52119;
            --uptx-red-dark: #8a1a14;
            --uptx-red-light: #d32f2f;
            --uptx-gray: #4a5568;
            --uptx-light: #f7fafc;
            --uptx-border: #e2e8f0;
            --shadow-card: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--uptx-light);
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4MCIgaGVpZ2h0PSI4MCIgdmlld0JveD0iMCAwIDQwIDQwIj48cGF0aCBkPSJNMjAgMjBhMjAgMjAgMCAwIDEgMjAgMjAgMjAgMjAgMCAwIDEtNDAgMCAyMCAyMCAwIDAgMSAyMC0yMHoiIGZpbGw9InJnYmEoMTY1LDMzLDI1LDAuMDMpIi8+PC9zdmc+');
            background-repeat: repeat;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1100px;
            padding: 20px;
            margin: 0 auto;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow-card);
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
            min-height: 600px;
            border: 1px solid var(--uptx-border);
        }

        /* ===== LADO IZQUIERDO - IMAGEN INSTITUCIONAL ===== */
        .login-hero {
            flex: 1;
            background: linear-gradient(135deg, var(--uptx-red) 0%, var(--uptx-red-dark) 100%);
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
            min-width: 300px;
        }

        .login-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            animation: rotate 30s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .hero-logo {
            margin-bottom: 40px;
        }

        .hero-logo img {
            height: 90px;
            width: auto;
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.3));
        }

        .hero-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.3;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .hero-subtitle {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 40px;
            line-height: 1.6;
            border-left: 4px solid white;
            padding-left: 20px;
        }

        .hero-features {
            list-style: none;
            padding: 0;
        }

        .hero-features li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            opacity: 0.9;
        }

        .hero-features li i {
            width: 24px;
            font-size: 18px;
        }

        .hero-footer {
            margin-top: 50px;
            font-size: 13px;
            opacity: 0.7;
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 20px;
        }

        /* ===== LADO DERECHO - FORMULARIO ===== */
        .login-form {
            flex: 1;
            padding: 50px 45px;
            background: white;
            min-width: 400px;
        }

        .form-header {
            margin-bottom: 35px;
        }

        .form-header h2 {
            color: var(--uptx-red);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .form-header p {
            color: var(--uptx-gray);
            font-size: 15px;
            border-bottom: 2px solid var(--uptx-border);
            padding-bottom: 15px;
        }

        /* Badge de laboratorio */
        .lab-selection {
            background: #f8fafc;
            border: 1px solid var(--uptx-border);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
        }

        .lab-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .lab-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .lab-icon--opensource {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
        }

        .lab-icon--mac {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
        }

        .lab-details h4 {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .lab-details p {
            font-size: 13px;
            color: var(--uptx-gray);
            margin: 4px 0 0;
        }

        .lab-change {
            color: var(--uptx-red);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 8px 16px;
            border-radius: 30px;
            border: 1px solid var(--uptx-border);
            transition: all 0.3s ease;
        }

        .lab-change:hover {
            background: var(--uptx-red);
            color: white;
            text-decoration: none;
            border-color: var(--uptx-red);
        }

        /* Formulario */
        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #1e293b;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.3px;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--uptx-red);
            font-size: 18px;
            z-index: 2;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid var(--uptx-border);
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--uptx-red);
            outline: none;
            background: white;
            box-shadow: 0 0 0 4px rgba(165, 33, 25, 0.1);
        }

        /* Botones */
        .btn-login {
            width: 100%;
            padding: 16px;
            background: var(--uptx-red);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .btn-login:hover {
            background: var(--uptx-red-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(165, 33, 25, 0.3);
        }

        .btn-back {
            width: 100%;
            padding: 14px;
            background: transparent;
            border: 2px solid var(--uptx-border);
            border-radius: 12px;
            color: var(--uptx-gray);
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-back:hover {
            background: #f8fafc;
            border-color: var(--uptx-red);
            color: var(--uptx-red);
            text-decoration: none;
        }

        /* Mensajes de error */
        .error-message {
            background: #fef2f2;
            border: 1px solid #fee2e2;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            border-left: 4px solid #dc2626;
        }

        .error-message i {
            color: #dc2626;
            font-size: 24px;
        }

        .error-content h4 {
            color: #991b1b;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .error-content p {
            color: #b91c1c;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
        }

        /* Footer */
        .form-footer {
            margin-top: 35px;
            text-align: center;
            border-top: 1px solid var(--uptx-border);
            padding-top: 25px;
        }

        .form-footer p {
            color: var(--uptx-gray);
            font-size: 13px;
            margin: 3px 0;
        }

        .form-footer .version {
            color: var(--uptx-red);
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .login-container {
                flex-direction: column;
            }
            
            .login-hero {
                padding: 40px 30px;
                min-height: 350px;
            }
            
            .login-form {
                padding: 40px 30px;
                min-width: auto;
            }
            
            .hero-title {
                font-size: 28px;
            }
        }

        @media (max-width: 576px) {
            .lab-selection {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .lab-change {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-container">
            
            <!-- LADO IZQUIERDO - HERO INSTITUCIONAL -->
            <div class="login-hero">
                <div class="hero-content">
                    <div class="hero-logo">
                        <img src="<?php echo base_url('assets/');?>img/logos/logo_uptlax.png" alt="UPTx Logo">
                    </div>
                    
                    <h1 class="hero-title">Sistema de Gestión de Laboratorios</h1>
                    
                    <div class="hero-subtitle">
                        Plataforma integral para la administración de recursos tecnológicos en laboratorios de cómputo
                    </div>
                    
                    <ul class="hero-features">
                        <li><i class="fas fa-check-circle"></i> Control de inventario por laboratorio</li>
                        <li><i class="fas fa-check-circle"></i> Programa anual de mantenimiento</li>
                        <li><i class="fas fa-check-circle"></i> Órdenes de servicio</li>
                        <li><i class="fas fa-check-circle"></i> Reportes y listas de cotejo</li>
                    </ul>
                    
                    <div class="hero-footer">
                        <i class="fas fa-university"></i> Universidad Politécnica de Tlaxcala
                    </div>
                </div>
            </div>
            
            <!-- LADO DERECHO - FORMULARIO -->
            <div class="login-form">
                
                <div class="form-header">
                    <h2>Iniciar sesión</h2>
                    <p>Ingresa tus credenciales para acceder al sistema</p>
                </div>
                
                <?php 
                $lab = $this->input->get('lab');
                $lab_nombre = '';
                $lab_icon = '';
                $lab_class = '';
                
                if ($lab === 'opensource') {
                    $lab_nombre = 'Open Source';
                    $lab_icon = 'fab fa-linux';
                    $lab_class = 'lab-icon--opensource';
                } elseif ($lab === 'mac') {
                    $lab_nombre = 'Mac';
                    $lab_icon = 'fab fa-apple';
                    $lab_class = 'lab-icon--mac';
                }
                
                if (!empty($lab_nombre)): 
                ?>
                <!-- Selector de laboratorio -->
                <div class="lab-selection">
                    <div class="lab-info">
                        <div class="lab-icon <?php echo $lab_class; ?>">
                            <i class="<?php echo $lab_icon; ?>"></i>
                        </div>
                        <div class="lab-details">
                            <h4>Laboratorio <?php echo $lab_nombre; ?></h4>
                            <p>Acceso restringido a usuarios autorizados</p>
                        </div>
                    </div>
                    <a href="<?php echo base_url('portal/acerca_de'); ?>" class="lab-change">
                        <i class="fas fa-exchange-alt"></i> Cambiar
                    </a>
                </div>
                <?php endif; ?>
                
                <?php if (isset($error)): ?>
                <!-- Mensaje de error -->
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <div class="error-content">
                        <h4>Error de acceso</h4>
                        <p><?php echo $error; ?></p>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php echo form_open('login/do_login' . (!empty($_GET['lab']) ? '?lab='.$_GET['lab'] : '')); ?>
                    
                    <div class="form-group">
                        <label>Usuario</label>
                        <div class="input-group">
                            <i class="fas fa-user"></i>
                            <input class="form-control" type="text" name="username" placeholder="Ingresa tu usuario" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Contraseña</label>
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input class="form-control" type="password" name="password" placeholder="Ingresa tu contraseña" required>
                        </div>
                    </div>
                    
                    <?php 
                    $lab_id = '';
                    if ($lab === 'opensource') $lab_id = 1;
                    if ($lab === 'mac') $lab_id = 2;
                    ?>
                    <input type="hidden" name="laboratorio" value="<?php echo $lab_id; ?>">
                    
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        Iniciar sesión
                    </button>
                    
                    <?php if (empty($lab_nombre)): ?>
                    <a href="<?php echo base_url('portal/acerca_de'); ?>" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Seleccionar laboratorio
                    </a>
                    <?php endif; ?>
                    
                <?php echo form_close(); ?>
                
                <div class="form-footer">
                    <p>© 2026 Universidad Politécnica de Tlaxcala</p>
                    <p class="version">Sistema de Gestión de Laboratorios v2.0</p>
                </div>
                
            </div>
        </div>
    </div>

    <?php 
    // SweetAlert2 para errores específicos de laboratorio
    if (isset($error) && strpos($error, 'pertenece al laboratorio') !== false): 
    ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Acceso denegado',
            html: '<?php echo $error; ?>',
            confirmButtonColor: '#a52119',
            confirmButtonText: 'Entendido',
            background: '#fff',
            backdrop: `rgba(0,0,0,0.4)`
        });
    </script>
    <?php endif; ?>
</body>

</html>