<?php

if (isset($_GET['idu'])) {
    // Obtener el ID de la URL
    $id = $_GET['idu'];

    // Asignar el ID a la sesión
    $_SESSION['id'] = $id;

    header("Location: /proyecto/admin/usuario/asignar");
    exit;
}
?>
<div class="d-flex justify-content-between">
    <h1>Listar Usuarios</h1>
</div>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Usuario</th>
                <th scope="col">Email</th>
                <th scope="col">Rol</th>
                <th scope="col">Fecha registro</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos["usuarios"] as $value): ?>
                <tr>
                    <th scope="row"><?php echo $value['id'] ?></th>
                    <td><?php echo $value['nombre'] . ' ' . $value['apellido_paterno'] . ' ' . $value['apellido_materno'] ?></td>
                    <td><?php echo $value['email'] ?></td>
                    <td><?php echo $value['rol_nombre'] ?></td>
                    <td><?php echo $value['fecha_registro'] ?></td>
                    <td><?php echo ($value['estado'] ? 'Activo' : 'Bloqueado') ?></td>
                    <td class="p-0">
                        <div class="btn-group">
                            <button class="btn btn-success" onclick="editarItem(<?php echo $value['id'] ?>)"><i class="bi bi-pencil-fill"></i></button>
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
        window.location.href = '/proyecto/admin/usuario?idu=' + id;
    }
</script>
<!--<pre><code><?php print_r($datos) ?></code></pre>-->