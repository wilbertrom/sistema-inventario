<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="container bootstrap snippets bootdey">
    <h1>Editar Perfil</h1>
      <hr>
	<div class="row">
      <!-- left column -->
      <div class="col-md-3">
        <div class="text-center">
          <img src="<?php echo base_url('recursos-panel/images/usuario/'). $userimg->imagen;?>" class="rounded-circle img-fluid img-thumbnail" style="width: 150px;" alt="avatar">
          
          
        </div>
      </div>
      
      <!-- edit form column -->
      <div class="col-md-9 personal-info">
        <div class="alert alert-info alert-dismissable" style="display: none;">
          <a class="panel-close close" data-dismiss="alert">×</a> 
          <i class="fa fa-coffee"></i>
          This is an <strong>.alert</strong>. Use this to show important messages to the user.
        </div>
        <h3>Información personal</h3>
        
        <form class="form-horizontal" role="form" action="<?php echo base_url('perfil/actualizar');?>" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label class="col-lg-3 control-label">Usuario:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" value="<?php echo $user;?>" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Compañia:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" value="UPTx" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Correo:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" value="<?php echo $email;?>" disabled>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-3 control-label">Reemplazar foto:</label>
            <div class="col-lg-8">
                <input type="file" id="imagen-perfil" name="imagen-perfil" class="r-control">
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-8 col-lg-offset-3">
            <button type="submit" class="btn btn-uptx">Actualizar</button>
            </div>
        </div>
        </form>
      </div>
  </div>
</div>
<hr>
        </div>
    </div>
</div>