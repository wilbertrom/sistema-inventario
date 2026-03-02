<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            
            <!-- Encabezado -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="page-header" style="background:white; border-radius:14px; padding:20px 26px; box-shadow:0 2px 8px rgba(0,0,0,0.06); display:flex; align-items:center; justify-content:space-between; border-left:4px solid #a52119;">
                        <h2 style="font-size:20px; font-weight:700; color:#1e293b; margin:0;">
                            <i class="fas fa-user-circle" style="color:#a52119; margin-right:10px;"></i> Mi Perfil
                        </h2>
                        <span style="background:#f1f5f9; padding:6px 15px; border-radius:20px; font-size:13px;">
                            <i class="fas fa-flask" style="color:#a52119;"></i> <?php echo $laboratorio_nombre ?? 'Laboratorio'; ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Mensajes de alerta -->
            <?php if($this->session->flashdata('success_img')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success_img'); ?>
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error_img')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error_img'); ?>
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
            <?php endif; ?>

            <div class="row">
                <!-- Columna izquierda - Avatar -->
                <div class="col-md-4 mb-4">
                    <div class="card" style="border-radius:14px; box-shadow:0 2px 8px rgba(0,0,0,0.06); border:1px solid #e2e8f0; overflow:hidden;">
                        <div class="card-body text-center p-4">
                            <div class="mb-4">
                                <?php 
                                $img_url = base_url('recursos-panel/images/usuario/'. $imagen);
                                ?>
                                <img src="<?php echo $img_url; ?>" 
                                     class="rounded-circle img-fluid" 
                                     style="width: 150px; height:150px; object-fit:cover; border:4px solid #a52119; padding:3px;"
                                     alt="avatar"
                                     onerror="this.onerror=null; this.src='<?php echo base_url('recursos-panel/images/usuario/default.png'); ?>';">
                            </div>
                            <h4 class="mb-1" style="color:#1e293b; font-weight:700;"><?php echo htmlspecialchars($username); ?></h4>
                            
                            <hr style="border-top:1px solid #e2e8f0;">
                            
                            <form action="<?php echo base_url('perfil/actualizar_imagen'); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group text-left">
                                    <label style="font-weight:600; font-size:13px; color:#475569;">
                                        <i class="fas fa-camera"></i> Reemplazar foto
                                    </label>
                                    <input type="file" class="form-control" id="imagen-perfil" name="imagen-perfil" accept="image/jpeg,image/png" style="border:1.5px solid #e2e8f0; border-radius:8px; padding:8px;">
                                    <small class="text-muted" id="file-name">Ningún archivo seleccionado</small>
                                </div>
                                <button type="submit" class="btn btn-block" style="background:linear-gradient(135deg,#a52119,#c0392b); color:white; border:none; border-radius:8px; padding:10px; font-weight:600;">
                                    <i class="fas fa-upload"></i> Subir foto
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Columna derecha - Información -->
                <div class="col-md-8">
                    <!-- Tarjeta de Información personal -->
                    <div class="card" style="border-radius:14px; box-shadow:0 2px 8px rgba(0,0,0,0.06); border:1px solid #e2e8f0; overflow:hidden;">
                        <div class="card-header" style="background:white; border-bottom:1px solid #e2e8f0; padding:16px 20px;">
                            <h5 style="margin:0; font-weight:700; color:#1e293b;">
                                <i class="fas fa-id-card" style="color:#a52119; margin-right:8px;"></i> Información personal
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label style="font-weight:600; font-size:13px; color:#475569;">Usuario:</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($username); ?>" disabled style="background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 12px;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label style="font-weight:600; font-size:13px; color:#475569;">Compañia:</label>
                                    <input type="text" class="form-control" value="UPTx" disabled style="background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 12px;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label style="font-weight:600; font-size:13px; color:#475569;">Correo:</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($email); ?>" disabled style="background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:8px; padding:10px 12px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Mostrar nombre del archivo seleccionado
    document.getElementById('imagen-perfil')?.addEventListener('change', function(e) {
        var fileName = e.target.files[0]?.name || 'Ningún archivo seleccionado';
        document.getElementById('file-name').textContent = fileName;
    });
</script>