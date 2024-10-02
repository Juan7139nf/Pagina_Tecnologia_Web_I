<?php

namespace Models;

require_once __DIR__ . "/db.php";

use PDO;
use PDOException;

class Usuario
{
    public function __construct() {}

    public function obtenerUsuarios()
    {
        $conn = getConnection();
        $result = $conn->query("
        SELECT usuarios.*, roles.nombre AS rol_nombre
        FROM usuarios
        JOIN roles ON usuarios.rol_id = roles.id
        ");
        $usuarios = $result->fetchAll(PDO::FETCH_ASSOC);
        return $usuarios;
    }

    public function Detalle($id)
    {
        try {
            $conn = getConnection();

            $stmt = $conn->prepare("
            SELECT usuarios.*, roles.nombre AS rol_nombre
            FROM usuarios
            JOIN roles ON usuarios.rol_id = roles.id
            WHERE usuarios.id = :id
        ");

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            return $usuario;
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }

    public function actualizarRol($usuario_id, $nuevo_rol_id)
    {
        try {
            $conn = getConnection();

            $stmt = $conn->prepare("UPDATE usuarios SET rol_id = :nuevo_rol_id WHERE id = :usuario_id");

            $stmt->bindParam(':nuevo_rol_id', $nuevo_rol_id, PDO::PARAM_INT);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                return ["mensaje" => "Rol del usuario actualizado correctamente"];
            } else {
                return ["error" >= "Error al actualizar el rol del usuario"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }
}
