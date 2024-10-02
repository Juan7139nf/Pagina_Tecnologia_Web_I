<?php
if (isset($_GET['idd'])) {
    // Obtener el ID de la URL
    $id = $_GET['idd'];

    // Asignar el ID a la sesión
    $_SESSION['idf'] = $id;
    $_SESSION['op'] = 'si';

    header("Location: /proyecto/admin/reserva");
    exit;
}
?>
<div class="d-flex justify-content-between">
    <h1>Listar todas las Reservas</h1>
    <div class="align-content-center">
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
                <th scope="col">Usuario</th>
                <th scope="col">Servicio</th>
                <th scope="col">Fecha reserva</th>
                <th scope="col">Fecha cita</th>
                <th scope="col">Precio</th>
                <th scope="col">Total</th>
                <th scope="col">Comentario</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos["reservas"] as $value): ?>
                <tr class="<?php 
                    if ($value['estado']=='cancelada') 
                    echo 'border-danger border-3';
                    elseif ($value['estado']=='pendiente') 
                    echo 'border-warning border-3';
                    else
                    echo 'border-success border-3';
                    ?>">
                    <th scope="row"><?php echo $value['id'] ?></th>
                    <td><?php echo $value['usuario_nombre'] ?>     <?php echo $value['apellido_paterno'] ?>
                        <?php echo $value['apellido_materno'] ?>
                    </td>
                    <td><?php echo $value['servicio_nombre'] ?></td>
                    <td><?php echo $value['fecha_reserva'] ?></td>
                    <td><?php echo $value['fecha_cita'] ?></td>
                    <td><?php echo $value['precio_original'] ?> bs</td>
                    <td><b><?php echo number_format($value['precio_final'], 2) ?> bs</b></td>
                    <td><?php echo $value['comentario'] ?></td>
                    <td><?php echo $value['estado'] ?></td>
                    <td class="p-0">
                        <?php if ($value['estado'] != 'cancelada'): ?>
                            <div class="btn-group">
                            <button class="btn btn-<?php echo ($value['estado'] == 'pendiente'? 'warning' : 'success') ?>" onclick="eliminarItem(<?php echo $value['id'] ?>)">
                                <?php 
                                if ($value['estado']=='pendiente') 
                                echo '<i class="bi bi-exclamation-diamond-fill"></i>' ;
                            else
                            echo '<i class="bi bi-check-lg"></i>' ;
                                ?>
                            </button>
                            </div>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>

    function eliminarItem(id) {
        // Redirigir con el parámetro id en la URL
        window.location.href = '/proyecto/admin/reserva?idd=' + id;
    }
</script>
<!--<pre><code><?php print_r($datos) ?></code></pre>-->