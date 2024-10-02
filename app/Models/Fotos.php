<?php

namespace Models;

require_once __DIR__ . "/db.php";

use PDO;
use PDOException;

class Foto
{
    public $id;
    public $servicio_id;
    public $url;
    public $estado;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->servicio_id = $args["servicio_id"] ?? null;
        $this->url = $args["url"] ?? null;
        $this->estado = $args["estado"] ?? true;
    }

    public function obtenerPorServicio($servicio_id)
    {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM fotos WHERE servicio_id = :servicio_id");
        $stmt->bindParam(':servicio_id', $servicio_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertar($servicio_id, $url)
    {
        try {
            $conn = getConnection();
            $stmt = $conn->prepare("INSERT INTO fotos (servicio_id, url) VALUES (:servicio_id, :url)");
            $stmt->bindParam(':servicio_id', $servicio_id);
            $stmt->bindParam(':url', $url);

            if ($stmt->execute()) {
                return ["mensaje" => "Foto insertada correctamente"];
            } else {
                return ["error" => "Error al insertar la foto"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }

    public function detalle($id)
    {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM fotos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editar($id, $url)
    {
        try {
            $conn = getConnection();

            $stmt = $conn->prepare("UPDATE fotos SET url = :url WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':url', $url);

            if ($stmt->execute()) {
                return ["mensaje" => "Foto actualizada correctamente"];
            } else {
                return ["error" => "Error al actualizar la foto"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }

    public function estado($id)
    {
        try {
            $conn = getConnection();

            $stmt = $conn->prepare("SELECT estado FROM fotos WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $foto = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($foto) {
                $nuevoEstado = $foto['estado'] == 1 ? 0 : 1;

                $updateStmt = $conn->prepare("UPDATE fotos SET estado = :nuevoEstado WHERE id = :id");
                $updateStmt->bindParam(':nuevoEstado', $nuevoEstado, PDO::PARAM_BOOL);
                $updateStmt->bindParam(':id', $id);

                if ($updateStmt->execute()) {
                    return ["mensaje" => "Estado de la foto actualizado correctamente"];
                } else {
                    return ["error" => "Error al actualizar el estado de la foto"];
                }
            } else {
                return ["error" => "Foto no encontrada"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }
}
