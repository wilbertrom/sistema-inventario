<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
                                    <div class="au-card-title" style="background-image:url('images/bg-title-01.jpg');">
                                        <div class="bg-overlay bg-c2"></div>
                                        <h3>
                                            <i class="zmdi zmdi-check-square"></i>Reportes Anuales</h3>
                                        <button class="au-btn-plus">
                                            <i class="zmdi zmdi-plus"></i>
                                        </button>
                                    </div>
                                    <?php foreach ($reportes as $reporte)?>
                                    <div class="au-task js-list-load">
                                        <div class="au-task-list js-scrollbar3">
                                            <div class="au-task__item au-task__item--danger">
                                                <div class="au-task__item-inner">
                                                    <h5 class="task">
                                                        <a href="reporte/<?php echo $reporte->id; ?>">Reporte año: <?php echo $reporte->año; ?></a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <php endforeach;>
                            </div>
                           
                        </div>
        </div>
    </div>
</div>
