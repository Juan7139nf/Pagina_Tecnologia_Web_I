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

<form action="/proyecto/login" method="post" class="container-login mx-auto mt-5">
    <h1>Iniciar sesion</h1>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="user[email]"
            value="<?php echo (isset($email) ? $email : '') ?>">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" name="user[password]">
    </div>
    <div class="mb-5 row container-login mx-auto">
        <input type="submit" value="Iniciar sesion" class="btn btn-lg btn-primary col-6">
        <a href="/proyecto" class="btn btn-lg btn-danger col-6">Cancelar</a>
    </div>
    <p>No tienes una cuenta <a href="/proyecto/register">Registate</a></p>
</form>
<!--<pre><code><?php print_r($datos) ?></code></pre>-->