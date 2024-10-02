<?php
foreach ($foto as $key => $value) {
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
                window.location.href = "/proyecto/admin/servicio/foto";
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
        <label for="imagen" class="form-label">Imagen</label>
        <input class="form-control" type="file" id="imagen" name="imagen" accept="image/*"
            onchange="actualizarUrl(this)">
    </div>
    <div class="mb-3">
        <label for="url" class="form-label">Url</label>
        <input type="text" class="form-control" id="url" name="foto[url]"
            value="<?php echo isset($url) ? htmlspecialchars($url) : ''; ?>"
            placeholder="Ingresa una URL o selecciona una imagen" readonly>
    </div>

    <script>
        function actualizarUrl(input) {
            // Obtener el campo de texto de URL
            const urlInput = document.getElementById('url');

            // Verificar si hay un archivo seleccionado
            if (input.files.length > 0) {
                // Obtener el nombre del archivo seleccionado
                const archivo = input.files[0].name;

                // Asignar el nombre del archivo al campo URL
                urlInput.value = archivo;
            }
        }
    </script>

    <!--<?php print_r($datos) ?>-->
</fieldset>