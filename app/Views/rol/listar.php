<?php

if (isset($_GET['idu'])) {
    // Obtener el ID de la URL
    $id = $_GET['idu'];

    // Asignar el ID a la sesión
    $_SESSION['id'] = $id;

    header("Location: /proyecto/admin/rol/actualizar");
    exit;
}

if (isset($_GET['idd'])) {
    // Obtener el ID de la URL
    $id = $_GET['idd'];

    // Asignar el ID a la sesión
    $_SESSION['id'] = $id;
    $_SESSION['op'] = 'si';

    header("Location: /proyecto/admin/rol");
    exit;
}
?>

<div class="d-flex justify-content-between">
    <h1>Listar Roles</h1>
    <div class="align-content-center">
        <a href="/proyecto/admin/rol/crear" class="btn btn-primary p-0 px-2 fs-2">
            <i class="bi bi-plus-circle"></i>
        </a>
    </div>
</div>

<?php if (isset($rol_db['mensaje'])): ?>
    <div class="alert alert-success">
        <?php echo $rol_db['mensaje']; ?>
    </div>
<?php endif; ?>

<?php if (isset($rol_db['error'])): ?>
    <div class="alert alert-danger">
        <?php echo $rol_db['error']; ?>
    </div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos["roles"] as $value): ?>
                <tr class="<?php if (!$value['estado']) echo 'border-danger border-2' ?>">
                    <th scope="row"><?php echo $value['id'] ?></th>
                    <td><?php echo $value['nombre'] ?></td>
                    <td><?php echo ($value['estado'] ? 'Activo' : 'Bloqueado') ?></td>
                    <td class="p-0">
                        <div class="btn-group">
                            <button class="btn btn-success" onclick="editarItem(<?php echo $value['id'] ?>)">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
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
<script>
    function editarItem(id) {
        // Redirigir con el parámetro id en la URL
        window.location.href = '/proyecto/admin/rol?idu=' + id;
    }

    function eliminarItem(id) {
        // Redirigir con el parámetro id en la URL
        window.location.href = '/proyecto/admin/rol?idd=' + id;
    }
</script>

<!--<pre><code><?php print_r($datos) ?></code></pre>-->