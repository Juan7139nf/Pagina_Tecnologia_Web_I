<?php
/*
$servidor = 'sql10.freemysqlhosting.net';
$base_datos = 'sql10733256';
$usuario = 'sql10733256';
$contraseña = '1FZVuT1mNt';
$puerto = 3306;*/

$servidor = 'localhost';
$base_datos = 'peluqueria';
$usuario = 'root';
$contraseña = 'j123';
$puerto = 3306;

function getConnection()
{
    global $servidor, $usuario, $contraseña, $base_datos, $puerto;
    return new PDO("mysql:host=$servidor;port=$puerto;dbname=$base_datos;charset=utf8mb4", $usuario, $contraseña);
}
?>