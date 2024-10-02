<?php
foreach ($reserva as $key => $value) {
    $$key = $value;
}
?>
<fieldset>
    <?php if (isset($db['mensaje'])): ?>
        <div class="alert alert-success">
            <?php echo $db['mensaje']; ?>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = "/proyecto/reserva";
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
        <label for="fecha_cita" class="form-label">Fecha cita</label>
        <input type="date" class="form-control" id="fecha_cita" name="dato[fecha_cita]" value="<?php echo (isset($fecha_cita) ? $fecha_cita : '') ?>" min="<?php echo date('Y-m-d'); ?>">
    </div>
    
    <div class="mb-3">
        <label for="comentario" class="form-label">Comentario</label>
        <textarea class="form-control" id="comentario" name="dato[comentario]" rows="4"><?php echo (isset($comentario) ? $comentario : '') ?></textarea>
    </div>
    
<!--<pre><code><?php print_r($datos) ?></code></pre>-->
</fieldset>