<?php

namespace Models;

require_once __DIR__ . "/db.php";

use PDO;
use PDOException;

class Servicio
{
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $estado;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? null;
        $this->descripcion = $args["descripcion"] ?? null;
        $this->precio = $args["precio"] ?? null;
        $this->estado = $args["estado"] ?? true;
    }

    public function obtener()
    {
        $conn = getConnection();
        $result = $conn->query("SELECT * FROM servicios");
        $servicios = $result->fetchAll(PDO::FETCH_ASSOC);
        return $servicios;
    }

    public function insertar($nombre, $descripcion, $precio)
    {
        try {
            $conn = getConnection();
            $stmt = $conn->prepare("INSERT INTO servicios (nombre, descripcion, precio) VALUES (:nombre, :descripcion, :precio)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);

            if ($stmt->execute()) {
                return ["mensaje" => "Servicio insertado correctamente"];
            } else {
                return ["error" => "Error al insertar el servicio"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }

    public function detalle($id)
    {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM servicios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editar($id, $nombre, $descripcion, $precio)
    {
        try {
            $conn = getConnection();

            $stmt = $conn->prepare("UPDATE servicios SET nombre = :nombre, descripcion = :descripcion, precio = :precio WHERE id = :id");

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);

            if ($stmt->execute()) {
                return ["mensaje" => "Servicio actualizado correctamente"];
            } else {
                return ["error" => "Error al actualizar el servicio"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }

    public function estado($id)
    {
        try {
            $conn = getConnection();
            $stmt = $conn->prepare("SELECT estado FROM servicios WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $servicio = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($servicio) {
                $nuevoEstado = $servicio['estado'] == 1 ? 0 : 1;

                $updateStmt = $conn->prepare("UPDATE servicios SET estado = :nuevoEstado WHERE id = :id");
                $updateStmt->bindParam(':nuevoEstado', $nuevoEstado, PDO::PARAM_BOOL);
                $updateStmt->bindParam(':id', $id);

                if ($updateStmt->execute()) {
                    return ["mensaje" => "Estado del servicio actualizado correctamente"];
                } else {
                    return ["error" => "Error al actualizar el estado del servicio"];
                }
            } else {
                return ["error" => "Servicio no encontrado"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }
}
