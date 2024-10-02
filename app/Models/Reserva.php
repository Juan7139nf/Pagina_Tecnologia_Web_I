<?php

namespace Models;

require_once __DIR__ . "/db.php";

use PDO;
use PDOException;

class Reserva
{
    public $id;
    public $usuario_id;
    public $servicio_id;
    public $fecha_reserva;
    public $fecha_cita;
    public $comentario;
    public $estado;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->usuario_id = $args["usuario_id"] ?? null;
        $this->servicio_id = $args["servicio_id"] ?? null;
        $this->fecha_reserva = $args["fecha_reserva"] ?? null;
        $this->fecha_cita = $args["fecha_cita"] ?? null;
        $this->comentario = $args["comentario"] ?? null;
        $this->estado = $args["estado"] ?? 'pendiente';
    }

    public function obtener()
    {
        $conn = getConnection();

        $sql = "
            SELECT 
                r.*,
                u.nombre AS usuario_nombre,
                u.apellido_paterno,
                u.apellido_materno,
                s.nombre AS servicio_nombre,
                s.precio AS precio_original,
                COALESCE(
                    s.precio - (s.precio * o.descuento / 100), 
                    s.precio
                ) AS precio_final,
                r.fecha_reserva,
                r.fecha_cita,
                r.comentario,
                r.estado AS estado_reserva
            FROM reservas r
            JOIN usuarios u ON r.usuario_id = u.id
            JOIN servicios s ON r.servicio_id = s.id
            LEFT JOIN ofertas o 
                ON s.id = o.servicio_id 
                AND o.estado = 1 
                AND o.fecha_inicio <= CURRENT_DATE 
                AND o.fecha_fin >= CURRENT_DATE
        ";

        $result = $conn->query($sql);
        $reservas = $result->fetchAll(PDO::FETCH_ASSOC);
        return $reservas;
    }

    public function obtenerreservas($id)
    {
        $conn = getConnection();

        $sql = "
            SELECT 
                r.*,
                u.nombre AS usuario_nombre,
                u.apellido_paterno,
                u.apellido_materno,
                s.nombre AS servicio_nombre,
                s.precio AS precio_original,
                COALESCE(
                    s.precio - (s.precio * o.descuento / 100), 
                    s.precio
                ) AS precio_final,
                r.fecha_reserva,
                r.fecha_cita,
                r.comentario,
                r.estado AS estado_reserva
            FROM reservas r
            JOIN usuarios u ON r.usuario_id = u.id
            JOIN servicios s ON r.servicio_id = s.id
            LEFT JOIN ofertas o 
                ON s.id = o.servicio_id 
                AND o.estado = 1 
                AND o.fecha_inicio <= CURRENT_DATE 
                AND o.fecha_fin >= CURRENT_DATE
            WHERE r.usuario_id = :id
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertar($usuario_id, $servicio_id, $fecha_cita, $comentario)
    {
        try {
            $conn = getConnection();
            $stmt = $conn->prepare("INSERT INTO reservas (usuario_id, servicio_id, fecha_cita, comentario) 
                                    VALUES (:usuario_id, :servicio_id, :fecha_cita, :comentario)");
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':servicio_id', $servicio_id);
            $stmt->bindParam(':fecha_cita', $fecha_cita);
            $stmt->bindParam(':comentario', $comentario);

            if ($stmt->execute()) {
                return ["mensaje" => "Reserva insertada correctamente"];
            } else {
                return ["error" => "Error al insertar la reserva"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }

    public function detalle($id)
    {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM reservas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editar($id, $fecha_cita, $comentario)
    {
        try {
            $conn = getConnection();
            $stmt = $conn->prepare("UPDATE reservas 
                                    SET fecha_cita = :fecha_cita, comentario = :comentario 
                                    WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':fecha_cita', $fecha_cita);
            $stmt->bindParam(':comentario', $comentario);

            if ($stmt->execute()) {
                return ["mensaje" => "Reserva actualizada correctamente"];
            } else {
                return ["error" => "Error al actualizar la reserva"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }

    public function estado($id)
    {
        try {
            $conn = getConnection();

            // Primero, obtener el estado actual de la reserva
            $stmt = $conn->prepare("SELECT estado FROM reservas WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($reserva) {
                // Solo permitir cambiar el estado si es "pendiente" o "cancelada"
                if ($reserva['estado'] === 'pendiente' || $reserva['estado'] === 'cancelada') {
                    // Alternar entre "pendiente" y "cancelada"
                    $nuevoEstado = ($reserva['estado'] === 'pendiente') ? 'cancelada' : 'pendiente';

                    // Actualizar el estado en la base de datos
                    $updateStmt = $conn->prepare("UPDATE reservas SET estado = :nuevoEstado WHERE id = :id");
                    $updateStmt->bindParam(':nuevoEstado', $nuevoEstado);
                    $updateStmt->bindParam(':id', $id);

                    if ($updateStmt->execute()) {
                        return ["mensaje" => "Estado de la reserva actualizado correctamente"];
                    } else {
                        return ["error" => "Error al actualizar el estado de la reserva"];
                    }
                } else {
                    // Si el estado es "confirmada", no hacer cambios
                    return ["mensaje" => "No se puede cambiar el estado de una reserva confirmada"];
                }
            } else {
                return ["error" => "Reserva no encontrada"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }

    public function confirmarReserva($id)
    {
        try {
            $conn = getConnection();

            // Obtener el estado actual de la reserva
            $stmt = $conn->prepare("SELECT estado FROM reservas WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($reserva) {
                // Si el estado es "pendiente", cambiar a "confirmada"
                if ($reserva['estado'] === 'pendiente') {
                    $nuevoEstado = 'confirmada';
                }
                // Si el estado es "confirmada", cambiar a "pendiente"
                elseif ($reserva['estado'] === 'confirmada') {
                    $nuevoEstado = 'pendiente';
                }
                // Si el estado es "cancelada", no hacer nada
                else {
                    return ["mensaje" => "No se puede cambiar el estado de una reserva cancelada"];
                }

                // Actualizar el estado en la base de datos
                $updateStmt = $conn->prepare("UPDATE reservas SET estado = :nuevoEstado WHERE id = :id");
                $updateStmt->bindParam(':nuevoEstado', $nuevoEstado);
                $updateStmt->bindParam(':id', $id);

                if ($updateStmt->execute()) {
                    return ["mensaje" => "Estado de la reserva actualizado correctamente"];
                } else {
                    return ["error" => "Error al actualizar el estado de la reserva"];
                }
            } else {
                return ["error" => "Reserva no encontrada"];
            }
        } catch (PDOException $e) {
            return ["error" => "Error al conectar a la base de datos: " . $e->getMessage()];
        }
    }
}
