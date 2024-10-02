<h1>Crear Foto</h1>
<form action="" class="container-sm was-validated" method="post" enctype="multipart/form-data">
    <?php
    include __DIR__ ."/formulario.php";
    ?>
    <div class="mb-3">
        <input type="submit" value="Crear" class="btn btn-lg btn-primary">
        <a href="/proyecto/admin/servicio/foto" class="btn btn-lg btn-danger">Cancelar</a>
    </div>
</form>