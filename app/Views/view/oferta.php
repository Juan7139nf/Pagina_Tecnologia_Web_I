<?php

if (isset($_GET['id'])) {
    // Obtener el ID de la URL
    $id = $_GET['id'];

    // Asignar el ID a la sesión
    $_SESSION['id'] = $id;

    header("Location: /proyecto/mis/reserva/crear");
    exit;
}
?>

<h1 class="text-center text-body p-2">Ofertas</h1>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 imagenes">
    <?php foreach ($datos["servicio"] as $value): ?>
        <div class="col">
            <div class="card shadow-sm h-100 border-2">
                <div class="card-body text-center pt-0 p-2">
                    <h1 class=""><?php echo $value['nombre'] ?></h1>
                    <h3 class="card-text text-body">Descuento: <?php echo (isset($value['oferta']) ? $value['oferta']['descuento'] : '0.00') ?> %</h3>
                    <!-- Contenedor de imágenes -->
                    <div class="img-container my-2" id="img-container-<?php echo $value['id'] ?>">
                        <?php foreach ($value['fotos'] as $index => $foto): ?>
                            <img src="public/uploads/<?php echo $foto['url'] ?>" alt="<?php echo $foto['url'] ?>" class="img-listar" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="btn btn-secondary fs-4 w-100" onclick="Item(<?php echo $value['id'] ?>)">Reservar</button>
                </div>
            </div>
        </div>

        <script>
            let currentIndex<?php echo $value['id'] ?> = 0;
            const images<?php echo $value['id'] ?> = document.querySelectorAll('#img-container-<?php echo $value['id'] ?> img');
            const totalImages<?php echo $value['id'] ?> = images<?php echo $value['id'] ?>.length;

            function showNextImage<?php echo $value['id'] ?>() {
                images<?php echo $value['id'] ?>[currentIndex<?php echo $value['id'] ?>].style.display = 'none'; // Oculta la imagen actual
                currentIndex<?php echo $value['id'] ?> = (currentIndex<?php echo $value['id'] ?> + 1) % totalImages<?php echo $value['id'] ?>; // Incrementa el índice
                images<?php echo $value['id'] ?>[currentIndex<?php echo $value['id'] ?>].style.display = 'block'; // Muestra la siguiente imagen
            }

            // Cambia la imagen cada 3 segundos
            setInterval(showNextImage<?php echo $value['id'] ?>, 3000);
        </script>
    <?php endforeach; ?>

</div>

<script>
    function Item(id) {
        // Redirigir con el parámetro id en la URL
        window.location.href = '/proyecto/servicio?id=' + id;
    }
</script>


<!--<pre><code><?php print_r($datos) ?></code></pre>-->