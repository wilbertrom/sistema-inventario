<style>
:root{--rojo:#a52119;--rojo-mid:#c0392b;--rojo-light:#fdf1f0;--gris-bg:#f5f6f8;--gris-borde:#e2e8f0;--texto-dark:#1e293b;--texto-mid:#475569;--sombra-sm:0 2px 8px rgba(0,0,0,0.06);--radio:14px;}
.main-content{background:var(--gris-bg);min-height:calc(100vh - 81px);}
.section__content--p30{padding:28px;}
.page-header{background:white;border-radius:var(--radio);padding:20px 26px;margin-bottom:22px;box-shadow:var(--sombra-sm);display:flex;align-items:center;border-left:4px solid var(--rojo);}
.page-header h2{font-size:20px;font-weight:700;color:var(--texto-dark);margin:0;}
.page-header h2 i{color:var(--rojo);margin-right:10px;}
.mesa-card{background:white;border-radius:var(--radio);box-shadow:var(--sombra-sm);border:1px solid var(--gris-borde);margin-bottom:24px;overflow:hidden;transition:box-shadow .25s;}
.mesa-card:hover{box-shadow:0 10px 30px rgba(0,0,0,.1);}
.mesa-header{background:linear-gradient(135deg,var(--texto-dark) 0%,#334155 100%);color:white;padding:16px 22px;display:flex;align-items:center;gap:10px;}
.mesa-header h4{margin:0;font-size:16px;font-weight:700;}
.mesa-header .mesa-num{background:var(--rojo);color:white;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;flex-shrink:0;}
.mesa-body{padding:20px;}
.maquinas-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:16px;}
.maquina-card{background:#f8fafc;border-radius:10px;border:1.5px solid var(--gris-borde);padding:14px;text-align:center;transition:all .2s;}
.maquina-card:hover{border-color:var(--rojo);background:var(--rojo-light);}
.maquina-title{font-size:12px;font-weight:700;color:var(--texto-dark);margin-bottom:12px;text-transform:uppercase;letter-spacing:.4px;}
.equipo-item{margin-bottom:6px;}
.equipo-item .dropdown-toggle{background:transparent;border:none;cursor:pointer;padding:4px;border-radius:6px;transition:background .15s;width:100%;}
.equipo-item .dropdown-toggle:hover{background:rgba(0,0,0,.05);}
.equipo-item .fa{font-size:28px;display:block;margin-bottom:2px;}
.equipo-item .fa.text-danger{color:var(--rojo)!important;}
.equipo-item .fa.text-muted{color:#cbd5e1!important;}
.equipo-item .eq-label{font-size:10px;color:var(--texto-mid);display:block;}
.dropdown-menu{border:none;box-shadow:0 8px 24px rgba(0,0,0,.12);border-radius:10px;border-top:2px solid var(--rojo);padding:6px 0;min-width:140px;}
.dropdown-item{font-size:13px;padding:9px 16px;color:var(--texto-mid);transition:background .15s,color .15s;}
.dropdown-item:hover{background:var(--rojo-light);color:var(--rojo);}
</style>

<div class="main-content">
<div class="section__content section__content--p30">
<div class="container-fluid">

    <div class="page-header">
        <h2><i class="fas fa-th-large"></i> Grupos y Mesas de Trabajo</h2>
    </div>

    <div class="row">
    <?php foreach($mesas as $mesa): ?>
    <div class="col-xl-6 col-lg-6">
        <div class="mesa-card">
            <div class="mesa-header">
                <div class="mesa-num"><?php echo $mesa->id_mesas; ?></div>
                <h4>Mesa #<?php echo $mesa->id_mesas; ?></h4>
                <span style="margin-left:auto;font-size:12px;opacity:.75;">
                    <?php echo count($mesa->grupos); ?> máquina<?php echo count($mesa->grupos) != 1 ? 's' : ''; ?>
                </span>
            </div>
            <div class="mesa-body">
                <div class="maquinas-grid">
                <?php foreach($mesa->grupos as $grupo): ?>
                <div class="maquina-card">
                    <div class="maquina-title">Máquina #<?php echo $grupo->id_grupos; ?></div>
                    <?php
                    $equipos = $grupo->equipos;
                    $icons = ['CPU'=>'fa-server','MONITOR'=>'fa-desktop','TECLADO'=>'fa-keyboard','MOUSE'=>'fa-mouse-pointer','CABLE'=>'fa-plug'];
                    $labels = ['CPU'=>'CPU','MONITOR'=>'Monitor','TECLADO'=>'Teclado','MOUSE'=>'Mouse','CABLE'=>'Cable'];
                    foreach($icons as $type => $icon):
                        $hasEquipo = array_filter($equipos, function($e) use($type){ return strpos($e->tipo, $type) !== false; });
                        $color = $hasEquipo ? 'text-danger' : 'text-muted';
                    ?>
                    <div class="equipo-item">
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="fa <?php echo $icon; ?> fa-2x <?php echo $color; ?>"></i>
                                <span class="eq-label"><?php echo $labels[$type]; ?></span>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?php echo base_url('grupos/vista_asignar/'.$type.'/'.$mesa->id_mesas.'/'.$grupo->id_grupos); ?>">
                                    <i class="fas fa-link mr-2" style="color:var(--rojo);"></i> Asignar
                                </a>
                                <a class="dropdown-item" href="<?php echo base_url('grupos/detalles/'.$type.'/'.$grupo->id_grupos); ?>">
                                    <i class="fas fa-info-circle mr-2" style="color:#2563eb;"></i> Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    </div>

</div>
</div>
</div>