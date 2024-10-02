<?php
foreach ($servicio as $key => $value) {
    $$key = $value;
}
?>
<fieldset>
    <?php if (isset($db['mensaje'])): ?>
        <div class="alert alert-success">
            <?php echo $db['mensaje']; ?>
        </div>
        <script>
            setTimeout(function () {
                window.location.href = "/proyecto/admin/servicio";
            }, 500);
        </script>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($db['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $db['error']; ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="dato[nombre]"
            value="<?php echo (isset($nombre) ? $nombre : '') ?>">
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripcion</label>
        <textarea class="form-control" id="descripcion" name="dato[descripcion]" rows="3"><?php echo (isset($descripcion) ? $descripcion : '') ?></textarea>
    </div>
    <div class="mb-3">
        <label for="precio" class="form-label">Precio</label>
        <input type="number" class="form-control" id="precio" min="0.01" step="0.01" name="dato[precio]"
            value="<?php echo (isset($precio) ? $precio : '') ?>" require pattern="^\d+(\.\d{1,2})?$">
    </div>
    <!--<?php print_r($datos) ?>-->
</fieldset>