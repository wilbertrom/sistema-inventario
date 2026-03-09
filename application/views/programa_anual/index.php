<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                    <?php endif; ?>
                    <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                    <?php endif; ?>

                    <!-- ── Page header ── -->
                    <div style="background:white;border-radius:14px;padding:16px 20px;margin-bottom:18px;
                                box-shadow:0 2px 8px rgba(0,0,0,0.06);display:flex;align-items:center;
                                justify-content:space-between;border-left:4px solid #a52119;flex-wrap:wrap;gap:10px;">
                        <h2 style="font-size:20px;font-weight:700;color:#1e293b;margin:0;">
                            <i class="fas fa-calendar-alt" style="color:#a52119;margin-right:8px;"></i>
                            Programa Anual de Mantenimiento
                        </h2>
                        <span style="background:#fdf1f0;color:#a52119;padding:5px 14px;border-radius:20px;font-size:13px;font-weight:600;">
                            <i class="fas fa-flask"></i> <?php echo htmlspecialchars($laboratorio_nombre); ?>
                        </span>
                    </div>

                    <div style="background:white;border-radius:14px;box-shadow:0 2px 8px rgba(0,0,0,0.06);
                                border:1px solid #e2e8f0;overflow:hidden;">

                        <!-- Toolbar -->
                        <div style="padding:14px 20px;border-bottom:1px solid #e2e8f0;display:flex;
                                    align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                                <label style="font-weight:600;font-size:13px;color:#475569;margin:0;">Año:</label>
                                <select id="filtro_anio" style="border:1.5px solid #e2e8f0;border-radius:8px;
                                        padding:8px 12px;font-size:13px;color:#1e293b;background:white;outline:none;cursor:pointer;">
                                    <?php foreach($anios_disponibles as $a): ?>
                                    <option value="<?php echo $a; ?>" <?php echo ($a == $anio_seleccionado) ? 'selected' : ''; ?>>
                                        <?php echo $a; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button class="btn" data-toggle="modal" data-target="#modalNuevo"
                                    style="background:linear-gradient(135deg,#a52119,#c0392b);color:white;border:none;
                                           border-radius:8px;padding:9px 18px;font-size:13px;font-weight:600;
                                           display:inline-flex;align-items:center;gap:6px;cursor:pointer;">
                                <i class="fas fa-plus"></i> Nuevo Programa
                            </button>
                        </div>

                        <!-- Tabla -->
                        <div class="table-responsive">
                        <table style="width:100%;border-collapse:collapse;">
                            <thead>
                                <tr>
                                    <!-- thead en rojo oscuro institucional -->
                                    <th style="background:#8B1A10;color:white;font-size:11px;font-weight:600;
                                               text-transform:uppercase;letter-spacing:.4px;padding:12px 16px;
                                               width:5%;text-align:center;">ID</th>
                                    <th style="background:#8B1A10;color:white;font-size:11px;font-weight:600;
                                               text-transform:uppercase;letter-spacing:.4px;padding:12px 16px;
                                               width:10%;text-align:center;">Año</th>
                                    <th style="background:#8B1A10;color:white;font-size:11px;font-weight:600;
                                               text-transform:uppercase;letter-spacing:.4px;padding:12px 16px;
                                               width:50%;">Observaciones</th>
                                    <th style="background:#8B1A10;color:white;font-size:11px;font-weight:600;
                                               text-transform:uppercase;letter-spacing:.4px;padding:12px 16px;
                                               width:35%;text-align:center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($programas)): ?>
                                <tr>
                                    <td colspan="4" style="padding:50px 20px;text-align:center;color:#475569;">
                                        <i class="fas fa-inbox fa-2x" style="color:#cbd5e1;display:block;margin-bottom:12px;"></i>
                                        No hay programas para el año <?php echo $anio_seleccionado; ?>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach($programas as $i => $p): ?>
                                <tr style="border-bottom:1px solid #e2e8f0;background:<?php echo $i%2==0?'white':'#fdf5f5'; ?>;">
                                    <td style="padding:11px 16px;font-size:13px;color:#475569;text-align:center;">
                                        <?php echo $p->id; ?></td>
                                    <td style="padding:11px 16px;font-size:13px;text-align:center;">
                                        <strong style="color:#a52119;"><?php echo $p->anio; ?></strong></td>
                                    <td style="padding:11px 16px;font-size:13px;color:#475569;">
                                        <?php echo htmlspecialchars($p->observaciones ?? '—'); ?></td>
                                    <td style="padding:11px 16px;text-align:center;white-space:nowrap;">
                                        <a href="<?php echo base_url('programa-anual/actividades/'.$p->id); ?>"
                                           style="width:30px;height:30px;border-radius:7px;display:inline-flex;
                                                  align-items:center;justify-content:center;font-size:13px;
                                                  background:#fce8e8;color:#a52119;text-decoration:none;
                                                  transition:all .2s;margin:0 2px;" title="Ver Actividades">
                                           <i class="fas fa-tasks"></i></a>
                                        <a href="<?php echo base_url('programa-anual/pdf/'.$p->id); ?>"
                                           style="width:30px;height:30px;border-radius:7px;display:inline-flex;
                                                  align-items:center;justify-content:center;font-size:13px;
                                                  background:#fee2e2;color:#dc2626;text-decoration:none;
                                                  transition:all .2s;margin:0 2px;" title="PDF" target="_blank">
                                           <i class="fas fa-file-pdf"></i></a>
                                        <a href="<?php echo base_url('programa-anual/eliminar/'.$p->id); ?>"
                                           style="width:30px;height:30px;border-radius:7px;display:inline-flex;
                                                  align-items:center;justify-content:center;font-size:13px;
                                                  background:#fef2f2;color:#b91c1c;text-decoration:none;
                                                  transition:all .2s;margin:0 2px;" title="Eliminar"
                                           onclick="return confirm('¿Eliminar este programa y todas sus actividades?')">
                                           <i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Programa -->
<div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:14px;overflow:hidden;border:none;">
            <form action="<?php echo base_url('programa-anual/crear'); ?>" method="POST">
                <div class="modal-header" style="background:linear-gradient(135deg,#a52119,#c0392b);border:none;">
                    <h5 class="modal-title" style="color:white;font-weight:700;">
                        <i class="fas fa-plus-circle"></i> Nuevo Programa Anual
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                            style="color:white;opacity:1;">&times;</button>
                </div>
                <div class="modal-body" style="padding:24px;">
                    <div class="form-group">
                        <label style="font-weight:600;font-size:13px;color:#1e293b;">
                            Año <span style="color:#a52119;">*</span>
                        </label>
                        <input type="number" name="anio" class="form-control"
                               value="<?php echo date('Y'); ?>" min="2020" max="2035" required
                               style="border:1.5px solid #e2e8f0;border-radius:8px;padding:10px 12px;">
                    </div>
                    <div class="form-group">
                        <label style="font-weight:600;font-size:13px;color:#1e293b;">Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="3"
                                  placeholder="Observaciones generales del programa..."
                                  style="border:1.5px solid #e2e8f0;border-radius:8px;padding:10px 12px;resize:vertical;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #e2e8f0;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            style="border-radius:8px;font-size:13px;font-weight:600;">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit"
                            style="background:linear-gradient(135deg,#a52119,#c0392b);color:white;border:none;
                                   border-radius:8px;padding:9px 20px;font-size:13px;font-weight:600;cursor:pointer;">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#filtro_anio').change(function() {
        window.location.href = '<?php echo base_url("programa-anual?anio="); ?>' + $(this).val();
    });
});
</script>