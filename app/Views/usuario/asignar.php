<h1>Asignar</h1>
<form action="" method="post">
    <?php if (isset($bd['mensaje'])): ?>
        <div class="alert alert-success">
            <?php echo $bd['mensaje']; ?>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = "/proyecto/admin/usuario";
            }, 500);
        </script>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($bd['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $bd['error']; ?>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">Rol</label>
        <select class="form-select" aria-label="Default select example" name="rol">
            <?php foreach ($roles as $value): ?>
                <option
                    <?php if ($value['id'] == $rol) echo 'selected' ?>
                    value="<?php echo $value['id'] ?>"><?php echo $value['nombre'] ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="mb-3">
        <input type="submit" value="Asignar" class="btn btn-lg btn-primary">
        <a href="/proyecto/admin/usuario" class="btn btn-lg btn-danger">Cancelar</a>
    </div>
</form>
<!--<pre><code><?php print_r($datos) ?></code></pre>-->