<?php

namespace Models;

require_once __DIR__ . "/db.php";

use PDO;
use PDOException;

class Model
{
    public function listar()
    {
        $conn = getConnection();

        $query = "
            SELECT s.id, s.nombre, s.descripcion, s.precio, s.estado, f.id AS foto_id, f.url, f.estado AS foto_estado
            FROM servicios s
            LEFT JOIN fotos f ON s.id = f.servicio_id AND f.estado = 1
            WHERE s.estado = 1
        ";

        $result = $conn->query($query);
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);

        $servicios = [];

        foreach ($rows as $row) {
            $servicioId = $row['id'];

            // Si el servicio aún no está en el arreglo, lo agregamos
            if (!isset($servicios[$servicioId])) {
                $servicios[$servicioId] = [
                    'id' => $row['id'],
                    'nombre' => $row['nombre'],
                    'descripcion' => $row['descripcion'],
                    'precio' => $row['precio'],
                    'estado' => $row['estado'],
                    'fotos' => []
                ];
            }

            // Si hay una foto asociada, la agregamos
            if (!empty($row['foto_id'])) {
                $servicios[$servicioId]['fotos'][] = [
                    'id' => $row['foto_id'],
                    'servicio_id' => $servicioId,
                    'url' => $row['url'],
                    'estado' => $row['foto_estado']
                ];
            }
        }

        return array_values($servicios);
    }


    public function listarOferta()
    {
        $conn = getConnection();

    $query = "
        SELECT 
            s.id, s.nombre, s.descripcion, s.precio, s.estado, 
            f.id AS foto_id, f.url, f.estado AS foto_estado,
            o.id AS oferta_id, o.descripcion AS oferta_descripcion, o.descuento, o.fecha_inicio, o.fecha_fin, o.estado AS oferta_estado
        FROM servicios s
        LEFT JOIN fotos f ON s.id = f.servicio_id AND f.estado = 1
        LEFT JOIN ofertas o ON s.id = o.servicio_id 
            AND o.estado = 1 
            AND CURDATE() BETWEEN o.fecha_inicio AND o.fecha_fin
        WHERE s.estado = 1 AND o.descuento > 0.00
        ORDER BY o.descuento DESC
    ";

    $result = $conn->query($query);
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    $servicios = [];

    foreach ($rows as $row) {
        $servicioId = $row['id'];

        // Si el servicio aún no está en el arreglo, lo agregamos
        if (!isset($servicios[$servicioId])) {
            $servicios[$servicioId] = [
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'descripcion' => $row['descripcion'],
                'precio' => $row['precio'],
                'estado' => $row['estado'],
                'fotos' => [],
                'oferta' => null // Inicializamos la oferta como null
            ];
        }

        // Verificamos si la foto ya fue agregada para evitar duplicados
        $fotoId = $row['foto_id'];
        if (!empty($fotoId) && !array_filter($servicios[$servicioId]['fotos'], fn($f) => $f['id'] == $fotoId)) {
            $servicios[$servicioId]['fotos'][] = [
                'id' => $fotoId,
                'servicio_id' => $servicioId,
                'url' => $row['url'],
                'estado' => $row['foto_estado']
            ];
        }

        // Solo agregamos la oferta si aún no se ha agregado
        if (!empty($row['oferta_id']) && is_null($servicios[$servicioId]['oferta'])) {
            $servicios[$servicioId]['oferta'] = [
                'id' => $row['oferta_id'],
                'servicio_id' => $servicioId,
                'descripcion' => $row['oferta_descripcion'],
                'descuento' => $row['descuento'],
                'fecha_inicio' => $row['fecha_inicio'],
                'fecha_fin' => $row['fecha_fin'],
                'estado' => $row['oferta_estado']
            ];
        }
    }

    return array_values($servicios);
    }
}
