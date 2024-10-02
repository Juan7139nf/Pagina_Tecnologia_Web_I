<?php
//print_r($cookie_valores);

$meses_espanol = [
    'January' => 'Enero',
    'February' => 'Febrero',
    'March' => 'Marzo',
    'April' => 'Abril',
    'May' => 'Mayo',
    'June' => 'Junio',
    'July' => 'Julio',
    'August' => 'Agosto',
    'September' => 'Septiembre',
    'October' => 'Octubre',
    'November' => 'Noviembre',
    'December' => 'Diciembre'
];

foreach ($cookie_valores as $key => $value) {
    $$key = $value;
}

setlocale(LC_TIME, 'es_ES.UTF-8');
$fecha = new DateTime($fecha_registro);
?>

<div class="px-4 py-4 my-4 text-center">
    <h1 class="display-5 fw-bold text-body-emphasis mb-4 pt-5">
        <?php
        echo "$nombre $apellido_paterno $apellido_materno";
        ?>
    </h1>
    <div class="col-lg-6 mx-auto">
        <h2 class="fw-bold text-body-emphasis mb-4">Correo:
            <?php
            echo $email;
            ?>
        </h2>
        <h3 class="fw-bold text-body-emphasis mb-4">Fecha Registro:
            <?php
            $fecha_formateada = $fecha->format('d') . ' de ' . $fecha->format('F') . ' del ' . $fecha->format('Y');

            $fecha_formateada = str_replace(array_keys($meses_espanol), array_values($meses_espanol), $fecha_formateada);

            echo $fecha_formateada;
            //echo strftime('%d de %B del %Y', $fecha->getTimestamp());
            ?>
        </h3>
        <h3 class="fw-bold text-body-emphasis mb-4">Hora Registro:
            <?php
            echo $fecha->format('h:i:s A');
            ?>
        </h3>
        <h3 class="fw-bold text-body-emphasis mb-5">Estado:
            <?php
            echo ($estado?'Activo':'Bloqueado');
            ?>
        </h3>
        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center pb-5 mb-5">
            <a href="/proyecto/editar" class="btn btn-primary btn-lg px-4 fw-bold">Editar</a>
            <a href="/proyecto/password" class="btn btn-secondary btn-lg px-4 fw-bold">Cambiar contraseña</a>
        </div>
    </div>
</div>