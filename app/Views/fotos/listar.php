<?php
if (isset($_GET['idu'])) {
    // Obtener el ID de la URL
    $id = $_GET['idu'];

    // Asignar el ID a la sesión
    $_SESSION['idf'] = $id;

    header("Location: /proyecto/admin/servicio/foto/actualizar");
    exit;
}

if (isset($_GET['idd'])) {
    // Obtener el ID de la URL
    $id = $_GET['idd'];

    // Asignar el ID a la sesión
    $_SESSION['idf'] = $id;
    $_SESSION['op'] = 'si';

    header("Location: /proyecto/admin/servicio/foto");
    exit;
}
?>
<div class="d-flex justify-content-between">
    <h1>Listar Fotos</h1>
    <div class="align-content-center">
        <a href="/proyecto/admin/servicio" class="btn btn-warning p-0 px-2 fs-2"><i class="bi bi-list-nested"></i></a>
        <a href="/proyecto/admin/servicio/foto/crear" class="btn btn-primary p-0 px-2 fs-2">
            <i class="bi bi-plus-circle"></i>
        </a>
    </div>
</div>

<?php if (isset($db['mensaje'])): ?>
    <div class="alert alert-success">
        <?php echo $db['mensaje']; ?>
    </div>
<?php endif; ?>

<?php if (isset($db['error'])): ?>
    <div class="alert alert-danger">
        <?php echo $db['error']; ?>
    </div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Servicio</th>
                <th scope="col">Url</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos["fotos"] as $value): ?>
                <tr class="<?php if (!$value['estado']) echo 'border-danger border-2' ?>">
                    <th scope="row"><?php echo $value['id'] ?></th>
                    <td><?php echo $servicio['nombre'] ?></td>
                    <td><?php echo $value['url'] ?></td>
                    <td><?php echo ($value['estado'] ? 'Activo' : 'Bloqueado') ?></td>
                    <td class="p-0">
                        <div class="btn-group">
                            <button class="btn btn-success" onclick="editarItem(<?php echo $value['id'] ?>)"><i class="bi bi-pencil-fill"></i></button>
                            <button class="btn btn-<?php echo ($value['estado'] ? 'primary' : 'danger') ?>" onclick="eliminarItem(<?php echo $value['id'] ?>)">
                                <?php 
                                if ($value['estado']) 
                                echo '<i class="bi bi-check-circle"></i>' ;
                            else
                            echo '<i class="bi bi-ban"></i>' ;
                                ?>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
    <?php foreach ($datos["fotos"] as $value): ?>
        <div class="col">
            <div class="card shadow-sm">
                <img src="../../public/uploads/<?php echo $value['url'] ?>" alt="<?php echo $value['url'] ?>" srcset="" class="img-listar">
                <span class="m-2"><?php echo $value['url'] ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function editarItem(id) {
        // Redirigir con el parámetro id en la URL
        window.location.href = '/proyecto/admin/servicio/foto?idu=' + id;
    }

    function eliminarItem(id) {
        // Redirigir con el parámetro id en la URL
        window.location.href = '/proyecto/admin/servicio/foto?idd=' + id;
    }
</script>
<!--<pre><code><?php print_r($datos) ?></code></pre>-->