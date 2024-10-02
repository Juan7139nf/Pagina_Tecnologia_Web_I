<?php
foreach ($oferta as $key => $value) {
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
                window.location.href = "/proyecto/admin/oferta";
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
        <label for="servicio" class="form-label">Servicio</label>
        <select class="form-select" aria-label="Default select example" id="servicio" name="dato[servicio_id]">
            <?php foreach ($servicio as $value): ?>
                <option value="<?php echo $value['id'] ?>" <?php if ($servicio_id == $value['id']) echo 'selected' ?>>
                    <?php echo $value['nombre'] ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripcion</label>
        <textarea class="form-control" id="descripcion" name="dato[descripcion]"
            rows="3"><?php echo (isset($descripcion) ? $descripcion : '') ?></textarea>
    </div>
    <div class="mb-3">
        <label for="descuento" class="form-label">Descuento</label>
        <input type="number" class="form-control" id="descuento" min="0" step="0.01" max="100" name="dato[descuento]"
            value="<?php echo (isset($descuento) ? $descuento : '0') ?>">
    </div>
    <div class="mb-3">
        <label for="fecha_inicio" class="form-label">Fecha inicio</label>
        <input type="date" class="form-control" id="fecha_inicio" name="dato[fecha_inicio]"
            value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>">
    </div>
    <div class="mb-3">
        <label for="fecha_fin" class="form-label">Fecha fin</label>
        <input type="date" class="form-control" id="fecha_fin" name="dato[fecha_fin]"
            value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
            min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
    </div>

    <script>
        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaFin = document.getElementById('fecha_fin');

        // Función para actualizar la fecha de fin
        function actualizarFechaFin() {
            const inicio = new Date(fechaInicio.value);
            if (!isNaN(inicio)) {
                // Sumar un día a la fecha de inicio
                inicio.setDate(inicio.getDate() + 1);

                // Convertir la fecha al formato YYYY-MM-DD y ajustar a la zona horaria de 'America/La_Paz'
                const nuevaFechaFin = inicio.toLocaleDateString('sv-SE', {
                    timeZone: 'America/La_Paz',
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit'
                }).replace(/\//g, '-');

                // Actualizar el valor y el mínimo de fecha_fin
                fechaFin.value = nuevaFechaFin;
                fechaFin.min = nuevaFechaFin;
            }
        }

        // Establecer el cambio inicial
        actualizarFechaFin();

        // Escuchar cambios en la fecha de inicio
        fechaInicio.addEventListener('change', actualizarFechaFin);
    </script>

    <!--<pre><code><?php print_r($datos) ?></code></pre>-->
</fieldset>