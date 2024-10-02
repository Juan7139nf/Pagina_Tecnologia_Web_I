<?php

namespace Models;

require_once __DIR__ . "/db.php";

use PDO;
use PDOException;

class Oferta
{
    public $id;
    public $servicio_id;
    public $descripcion;
    public $descuento;
    public $fecha_inicio;
    public $fecha_fin;
    public $estado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->servicio_id = $args['servicio_id'] ?? null;
        $this->descripcion = $args['descripcion'] ?? null;
        $this->descuento = $args['descuento'] ?? null;
        $this->fecha_inicio = $args['fecha_inicio'] ?? null;
        $this->fecha_fin = $args['fecha_fin'] ?? null;
        $this->estado = $args['estado'] ?? true;
    }

    public function obtener()
    {
        $conn = getConnection();

    $sql = "
        SELECT 
            o.*,
            s.nombre AS servicio_nombre
        FROM ofertas o
        JOIN servicios s ON o.servicio_id = s.id
    ";

    $result = $conn->query($sql);
    $ofertas = $result->fetchAll(PDO::FETCH_ASSOC);
    return $ofertas;
    }

    public function insertar($servicio_id, $descripcion, $descuento, $fecha_inicio, $fecha_fin)
    {
        try {
            $conn = getConnection();
            $stmt = $conn->prepare("INSERT INTO ofertas (servicio_id, descripcion, descuento, fecha_inicio, fecha_fin) 
                                    VALUES (:servicio_id, :descripcion, :descuento, :fecha_inicio, :fecha_fin)");
            $stmt->bindParam(':servicio_id', $servicio_id);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':descuento', $descuento);
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);
            $stmt->bindParam(':fecha_fin', $fecha_fin);

            if ($stmt->execute()) {
                return ["mensaje" => "Oferta insertada correctamente"];
            } else {
                return ["error" => "Error al insertar la oferta"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }

    public function detalle($id)
    {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM ofertas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editar($id, $servicio_id, $descripcion, $descuento, $fecha_inicio, $fecha_fin)
    {
        try {
            $conn = getConnection();

            $stmt = $conn->prepare("UPDATE ofertas SET servicio_id = :servicio_id, descripcion = :descripcion, descuento = :descuento, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin 
                                    WHERE id = :id");

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':servicio_id', $servicio_id);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':descuento', $descuento);
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);
            $stmt->bindParam(':fecha_fin', $fecha_fin);

            if ($stmt->execute()) {
                return ["mensaje" => "Oferta actualizada correctamente"];
            } else {
                return ["error" => "Error al actualizar la oferta"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }

    public function estado($id)
    {
        try {
            $conn = getConnection();
            $stmt = $conn->prepare("SELECT estado FROM ofertas WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $oferta = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($oferta) {
                $nuevoEstado = $oferta['estado'] == 1 ? 0 : 1;

                $updateStmt = $conn->prepare("UPDATE ofertas SET estado = :nuevoEstado WHERE id = :id");
                $updateStmt->bindParam(':nuevoEstado', $nuevoEstado, PDO::PARAM_BOOL);
                $updateStmt->bindParam(':id', $id);

                if ($updateStmt->execute()) {
                    return ["mensaje" => "Estado de la oferta actualizado correctamente"];
                } else {
                    return ["error" => "Error al actualizar el estado de la oferta"];
                }
            } else {
                return ["error" => "Oferta no encontrada"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }
}
