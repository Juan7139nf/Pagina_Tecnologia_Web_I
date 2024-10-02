<?php

namespace Models;

require_once __DIR__ . "/db.php";

use PDO;
use PDOException;

class Contacto
{
    public $id;
    public $usuario_id;
    public $asunto;
    public $estado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->usuario_id = $args['usuario_id'] ?? null;
        $this->asunto = $args['asunto'] ?? null;
        $this->estado = $args['estado'] ?? true;
    }

    public function obtener()
    {
        $conn = getConnection();
        $query = "
        SELECT contactos.*, usuarios.nombre, usuarios.apellido_paterno, usuarios.apellido_materno
        FROM contactos
        JOIN usuarios ON contactos.usuario_id = usuarios.id
        ";
        $result = $conn->query($query);
        $contactos = $result->fetchAll(PDO::FETCH_ASSOC);
        return $contactos;
    }

    public function insertar($usuario_id, $asunto)
    {
        try {
            $conn = getConnection();
            $stmt = $conn->prepare("INSERT INTO contactos (usuario_id, asunto) 
                                    VALUES (:usuario_id, :asunto)");
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':asunto', $asunto);

            if ($stmt->execute()) {
                return ["mensaje" => "El mensaje fue enviado."];
            } else {
                return ["error" => "Error al enviar mensaje."];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }

    public function detalle($id)
    {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM contactos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editar($id, $usuario_id, $asunto)
    {
        try {
            $conn = getConnection();
            $stmt = $conn->prepare("UPDATE contactos SET usuario_id = :usuario_id, asunto = :asunto 
                                    WHERE id = :id");

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':asunto', $asunto);

            if ($stmt->execute()) {
                return ["mensaje" => "Contacto actualizado correctamente"];
            } else {
                return ["error" => "Error al actualizar el contacto"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }

    public function estado($id)
    {
        try {
            $conn = getConnection();
            $stmt = $conn->prepare("SELECT estado FROM contactos WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $contacto = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($contacto) {
                $nuevoEstado = $contacto['estado'] == 1 ? 0 : 1;

                $updateStmt = $conn->prepare("UPDATE contactos SET estado = :nuevoEstado WHERE id = :id");
                $updateStmt->bindParam(':nuevoEstado', $nuevoEstado, PDO::PARAM_BOOL);
                $updateStmt->bindParam(':id', $id);

                if ($updateStmt->execute()) {
                    return ["mensaje" => "Estado del contacto actualizado correctamente"];
                } else {
                    return ["error" => "Error al actualizar el estado del contacto"];
                }
            } else {
                return ["error" => "Contacto no encontrado"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }
}
