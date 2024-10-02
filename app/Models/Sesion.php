<?php

namespace Models;

require_once __DIR__ . "/db.php";

use PDO;
use PDOException;

class Sesion
{
    public $id;
    public $nombre;
    public $apellido_paterno;
    public $apellido_materno;
    public $email;
    public $rol;
    public $password;
    public $estado;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? null;
        $this->apellido_paterno = $args["apellido_paterno"] ?? null;
        $this->apellido_materno = $args["apellido_materno"] ?? null;
        $this->email = $args["email"] ?? null;
        $this->rol = $args["rol"] ?? null;
        $this->password = $args["password"] ?? null;
        $this->estado = $args["estado"] ?? null;
    }

    public function Login($email, $password)
    {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT usuarios.*, roles.nombre AS rol_nombre
        FROM usuarios
        JOIN roles ON usuarios.rol_id = roles.id
        WHERE usuarios.email = :email");
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                if (password_verify($password, $usuario['password'])) {
                    $datos_usuario = json_encode($usuario);
                    $nombre_cookie = "pelukeria_cookie";
                    $tiempo_expiracion = time() + (365 * 24 * 60 * 60); // 1 año de expiración

                    setcookie($nombre_cookie, $datos_usuario, $tiempo_expiracion);

                    return ["mensaje" => "Correcto"];
                } else {
                    return ["error" => "Contraseña incorrecta"];
                }
            } else {
                return ["error" => "Usuario no encontrado"];
            }
        } else {
            return ["error" => "Error al ejecutar"];
        }
    }

    public function RegistrarUsuario($nombre, $apellido_paterno, $apellido_materno, $email, $password)
    {
        $conn = getConnection();

        // Verificar si el correo electrónico ya existe
        $stmt_check = $conn->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt_check->bindParam(':email', $email);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            // Si el correo ya existe, devolver un error
            return ["error" => "El correo electrónico ya está registrado"];
        }

        // Si el correo no existe, continuar con el registro
        $stmt = $conn->prepare("
        INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, email, password)
        VALUES (:nombre, :apellido_paterno, :apellido_materno, :email, :password)
        ");

        $password_hashed = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido_paterno', $apellido_paterno);
        $stmt->bindParam(':apellido_materno', $apellido_materno);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_hashed);

        if ($stmt->execute()) {
            $stmt = $conn->prepare("SELECT usuarios.*, roles.nombre AS rol_nombre
            FROM usuarios
            JOIN roles ON usuarios.rol_id = roles.id
            WHERE usuarios.email = :email");
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($usuario) {
                    $datos_usuario = json_encode($usuario);
                    $nombre_cookie = "pelukeria_cookie";

                    $tiempo_expiracion = time() + (365 * 24 * 60 * 60);

                    setcookie($nombre_cookie, $datos_usuario, $tiempo_expiracion);
                }
            }
            return ["mensaje" => "Usuario registrado exitosamente"];
        } else {
            return ["error" => "Error al registrar el usuario"];
        }
    }

    public function obtenerUsuario($user_id)
    {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT usuarios.*, roles.nombre AS rol_nombre
            FROM usuarios
            JOIN roles ON usuarios.rol_id = roles.id
            WHERE usuarios.id = :id");
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function EditarUsuario($id, $nombre, $apellido_paterno, $apellido_materno, $email, $estado, $v)
    {
        $conn = getConnection();

        if ($v === true) {
            $stmt_check = $conn->prepare("SELECT id FROM usuarios WHERE email = :email AND id != :id");
            $stmt_check->bindParam(':email', $email);
            $stmt_check->bindParam(':id', $id);
            $stmt_check->execute();

            if ($stmt_check->rowCount() > 0) {
                return ["error" => "El correo electrónico ya está registrado por otro usuario."];
            }
        }

        $stmt = $conn->prepare("
            UPDATE usuarios
            SET nombre = :nombre,
                apellido_paterno = :apellido_paterno,
                apellido_materno = :apellido_materno,
                email = :email,
                estado = :estado
            WHERE id = :id
        ");

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido_paterno', $apellido_paterno);
        $stmt->bindParam(':apellido_materno', $apellido_materno);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_BOOL); // Usar PDO::PARAM_BOOL para el booleano
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $stmt = $conn->prepare("SELECT usuarios.*, roles.nombre AS rol_nombre
            FROM usuarios
            JOIN roles ON usuarios.rol_id = roles.id
            WHERE usuarios.email = :email");
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($usuario) {
                    $datos_usuario = json_encode($usuario);
                    $nombre_cookie = "pelukeria_cookie";

                    $tiempo_expiracion = time() + (365 * 24 * 60 * 60);

                    setcookie($nombre_cookie, $datos_usuario, $tiempo_expiracion);
                }
            }
            return ["mensaje" => "Usuario editado correctamente."];
        } else {
            return ["error" => "Error al editar el usuario."];
        }
    }

    public function Password($email, $password_actual, $nuevaPassword)
    {
        $conn = getConnection();

        // Obtener la contraseña actual almacenada en la base de datos
        $stmt = $conn->prepare("SELECT password FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $password_almacenada = $usuario['password'];

            // Verificar si la contraseña actual proporcionada es correcta
            if (password_verify($password_actual, $password_almacenada)) {
                // Encriptar la nueva contraseña
                $nuevaPassword_hashed = password_hash($nuevaPassword, PASSWORD_BCRYPT);

                // Actualizar la contraseña en la base de datos
                $stmt_update = $conn->prepare("UPDATE usuarios SET password = :nuevaPassword WHERE email = :email");
                $stmt_update->bindParam(':nuevaPassword', $nuevaPassword_hashed);
                $stmt_update->bindParam(':email', $email);

                if ($stmt_update->execute()) {
                    return ["mensaje" => "Contraseña actualizada exitosamente"];
                } else {
                    return ["error" => "Error al actualizar la contraseña"];
                }
            } else {
                return ["error" => "La contraseña anterior no es correcta"];
            }
        } else {
            return ["error" => "Usuario no encontrado"];
        }
    }
}
