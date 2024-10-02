<?php
foreach ($user as $key => $value) {
    $$key = $value;
}
?>
<?php if (isset($usuario['mensaje'])): ?>
    <div class="alert alert-success">
        <?php echo $usuario['mensaje']; ?>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "/proyecto";
        }, 500);
    </script>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<?php if (isset($usuario['error'])): ?>
    <div class="alert alert-danger">
        <?php echo $usuario['error']; ?>
    </div>
<?php endif; ?>

<form action="" method="post" class="container-login mx-auto mt-5">
    <h1>Registrar</h1>
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="user[nombre]" value="<?php echo (isset($nombre) ? $nombre : '') ?>">
    </div>
    <div class="mb-3">
        <label for="apellido_paterno" class="form-label">Apellido paterno</label>
        <input type="text" class="form-control" id="apellido_paterno" name="user[apellido_paterno]" value="<?php echo (isset($apellido_paterno) ? $apellido_paterno : '') ?>">
    </div>
    <div class="mb-3">
        <label for="apellido_materno" class="form-label">Apellido materno</label>
        <input type="text" class="form-control" id="apellido_materno" name="user[apellido_materno]" value="<?php echo (isset($apellido_materno) ? $apellido_materno : '') ?>">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="user[email]" value="<?php echo (isset($email) ? $email : '') ?>">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" name="user[password]" value="<?php echo (isset($password) ? $password : '') ?>">
    </div>
    <div class="mb-5 row container-login mx-auto">
        <input type="submit" value="Registrar" class="btn btn-lg btn-primary col-6">
        <a href="/proyecto" class="btn btn-lg btn-danger col-6">Cancelar</a>
    </div>
    <p>Ya tienes una cuenta <a href="/proyecto/login">Inicia sesion</a></p>
</form>
<!--<pre><code><?php print_r($datos) ?></code></pre>-->