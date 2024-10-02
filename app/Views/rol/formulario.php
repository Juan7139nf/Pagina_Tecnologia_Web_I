<?php
foreach ($rol as $key => $value) {
    $$key = $value;
}
?>
<fieldset>
    <?php if (isset($rol_db['mensaje'])): ?>
        <div class="alert alert-success">
            <?php echo $rol_db['mensaje']; ?>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = "/proyecto/admin/rol";
            }, 500);
        </script>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($rol_db['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $rol_db['error']; ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="rol[nombre]" value="<?php echo (isset($nombre) ? $nombre : '') ?>">
    </div>
    <div class="mb-3">
        <input class="form-check-input" type="checkbox" id="estado" value="1" name="rol[estado]"
            <?php
            echo ($accion == 'crear' ? 'disabled' : '');
            echo (isset($estado) ? 'checked' : '')
            ?>>
        <label class="form-check-label" for="estado">Estado</label>
    </div>
<!--<pre><code><?php print_r($datos) ?></code></pre>-->
</fieldset>