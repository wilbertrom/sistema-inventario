<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
        <h1>Crear Requisición</h1>
    <?php echo validation_errors(); ?>
    <?php echo form_open('requisiciones/crear', array('onsubmit' => 'return validateForm()')); ?>
        <div class="form-group">
            <label for="razon" class="form-control-label">Razón</label>
            <textarea name="razon" class="form-control" required></textarea><br>
        </div>
        
        <div class="form-group">
            <label for="proposito" class="form-control-label">Propósito</label>
            <textarea name="proposito" class="form-control" required></textarea><br>
        </div>
        
        <div class="form-group">
            <label for="partida_p" class="form-control-label">Partida Presupuestal</label>
            <input type="text" name="partida_p" class="form-control" required><br>
        </div>
        
        <h3>Materiales</h3>
        <div id="materials">
            <div class="material">
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="form-group">
                            <label for="nombre[]" class="form-control-label">Nombre del Material</label>
                            <input type="text" name="nombre[]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label for="cantidad[]" class="form-control-label">Cantidad</label>
                            <input type="number" name="cantidad[]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                    <div class="form-group">
                             <label for="eliminar" class="form-control-label">Eliminar</label>
                            <button type="button" name="eliminar" onclick="removeMaterial(this)" class="btn btn-uptx  form-control">Eliminar</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" onclick="addMaterial()" class="btn btn-primary btn-uptx">Agregar Material</button><br><br>
        
        <div class="form-group form-actions">
            <button type="submit" class="btn btn-uptx">Crear Requisicion</button>
        </div>
    <?php echo form_close(); ?>
    
    <script>
        function addMaterial() {
            const materialsDiv = document.getElementById('materials');
            const newMaterialDiv = document.createElement('div');
            newMaterialDiv.className = 'material';
            newMaterialDiv.innerHTML = `
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="form-group">
                            <label for="nombre[]" class="form-control-label">Nombre del Material</label>
                            <input type="text" name="nombre[]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label for="cantidad[]" class="form-control-label">Cantidad</label>
                            <input type="number" name="cantidad[]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                    <div class="form-group">
                             <label for="eliminar" class="form-control-label">Eliminar</label>
                            <button type="button" name="eliminar" onclick="removeMaterial(this)" class="btn btn-uptx  form-control">Eliminar</button>
                    </div>
                    </div>
                </div>
            `;
            materialsDiv.appendChild(newMaterialDiv);
        }
        
        function removeMaterial(button) {
            button.closest('.row').remove();
        }
        
        function validateForm() {
                const names = document.getElementsByName('nombre[]');
                const quantities = document.getElementsByName('cantidad[]');
                let valid = false;
                
                for (let i = 0; i < names.length; i++) {
                    if (names[i].value.trim() !== '' && quantities[i].value.trim() !== '') {
                        valid = true;
                        break;
                    }
                }
                
                if (!valid) {
                    alert('Debe agregar al menos un ítem con nombre y cantidad.');
                    return false;
                }
                
                return true;
            }
    </script>
        </div>
    </div>
</div>