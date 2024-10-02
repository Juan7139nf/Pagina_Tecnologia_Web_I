<?php

namespace Models;

require_once __DIR__ . "/db.php";

use PDO;
use PDOException;

class Rol
{
    public $id;
    public $nombre;
    public $estado;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? null;
        $this->estado = $args["estado"] ?? null;
    }

    public function obtener()
    {
        $conn = getConnection();
        $result = $conn->query("SELECT * FROM roles");
        $roles = $result->fetchAll(PDO::FETCH_ASSOC);
        return $roles;
    }

    public function insertar($nombre)
    {
        try {
            $conn = getConnection();
            $stmt = $conn->prepare("INSERT INTO roles (nombre) VALUES (:nombre)");
            $stmt->bindParam(':nombre', $nombre);

            if ($stmt->execute()) {
                return ["mensaje" => "Rol insertado correctamente"];
            } else {
                return ["error" => "Error al insertar el rol"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }

    public function detalle($id)
    {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT *
            FROM roles
            WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editar($id, $nombre, $estado)
    {
        try {
            $conn = getConnection();

            $stmt = $conn->prepare("UPDATE roles SET nombre = :nombre, estado = :estado WHERE id = :id");

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':estado', $estado, PDO::PARAM_BOOL);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                return ["mensaje" => "Rol actualizado correctamente"];
            } else {
                return ["error" => "Error al actualizar el rol"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }

    public function estado($id)
    {
        try {
            // Obtener la conexión
            $conn = getConnection();

            // Primero, obtener el valor actual de "estado" para el rol especificado
            $stmt = $conn->prepare("SELECT estado FROM roles WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Obtener el estado actual del rol
            $rol = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rol) {
                // Determinar el nuevo valor de "estado"
                $nuevoEstado = $rol['estado'] == 1 ? 0 : 1;

                // Preparar la consulta para actualizar el valor de "estado"
                $updateStmt = $conn->prepare("UPDATE roles SET estado = :nuevoEstado WHERE id = :id");
                $updateStmt->bindParam(':nuevoEstado', $nuevoEstado, PDO::PARAM_BOOL);
                $updateStmt->bindParam(':id', $id);

                // Ejecutar la actualización
                if ($updateStmt->execute()) {
                    return ["mensaje" => "Estado del rol actualizado correctamente"];
                } else {
                    return ["error" => "Error al actualizar el estado del rol"];
                }
            } else {
                return ["error" => "Rol no encontrado"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }
}
