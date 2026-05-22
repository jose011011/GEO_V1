<?php

class Usuario extends Model
{
    public function buscarPorCorreo($correo)
    {
        $sql = "SELECT 
                    u.id_usuario,
                    u.id_rol,
                    u.nombre,
                    u.apellido,
                    u.correo,
                    u.celular,
                    u.password,
                    u.estado,
                    r.nombre_rol
                FROM usuarios u
                INNER JOIN roles r ON u.id_rol = r.id_rol
                WHERE u.correo = :correo
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':correo' => $correo]);
        return $stmt->fetch();
    }

    public function correoExiste($correo)
    {
        $stmt = $this->db->prepare("SELECT id_usuario FROM usuarios WHERE correo = :correo LIMIT 1");
        $stmt->execute([':correo' => $correo]);
        return $stmt->rowCount() > 0;
    }

    public function celularExiste($celular)
    {
        $stmt = $this->db->prepare("SELECT id_usuario FROM usuarios WHERE celular = :celular LIMIT 1");
        $stmt->execute([':celular' => $celular]);
        return $stmt->rowCount() > 0;
    }

    public function obtenerIdRol($nombreRol)
    {
        $stmt = $this->db->prepare("SELECT id_rol FROM roles WHERE nombre_rol = :nombre_rol LIMIT 1");
        $stmt->execute([':nombre_rol' => $nombreRol]);
        $rol = $stmt->fetch();

        return $rol ? $rol['id_rol'] : null;
    }

    public function crearUsuario($datos)
    {
        $sql = "INSERT INTO usuarios
                (id_rol, nombre, apellido, correo, celular, password, estado)
                VALUES
                (:id_rol, :nombre, :apellido, :correo, :celular, :password, 'ACTIVO')";

        $stmt = $this->db->prepare($sql);

        $ok = $stmt->execute([
            ':id_rol' => $datos['id_rol'],
            ':nombre' => $datos['nombre'],
            ':apellido' => $datos['apellido'],
            ':correo' => $datos['correo'],
            ':celular' => $datos['celular'],
            ':password' => $datos['password']
        ]);

        return $ok ? $this->db->lastInsertId() : false;
    }

    public function listarClientes()
    {
        $sql = "SELECT 
                    u.id_usuario,
                    u.nombre,
                    u.apellido,
                    u.correo,
                    u.celular,
                    u.estado,
                    u.fecha_registro,
                    c.id_cliente,
                    c.zona,
                    c.direccion_referencia
                FROM usuarios u
                INNER JOIN clientes c ON u.id_usuario = c.id_usuario
                INNER JOIN roles r ON u.id_rol = r.id_rol
                WHERE r.nombre_rol = 'CLIENTE'
                ORDER BY u.fecha_registro DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function cambiarEstado($idUsuario, $estado)
    {
        $sql = "UPDATE usuarios 
                SET estado = :estado 
                WHERE id_usuario = :id_usuario";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':estado' => $estado,
            ':id_usuario' => $idUsuario
        ]);
    }

    public function eliminarUsuario($idUsuario)
    {
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id_usuario' => $idUsuario
        ]);
    }
    public function correoExisteEditando($correo, $idUsuario)
{
    $sql = "SELECT id_usuario 
            FROM usuarios 
            WHERE correo = :correo 
            AND id_usuario != :id_usuario
            LIMIT 1";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':correo' => $correo,
        ':id_usuario' => $idUsuario
    ]);

    return $stmt->rowCount() > 0;
}

public function celularExisteEditando($celular, $idUsuario)
{
    $sql = "SELECT id_usuario 
            FROM usuarios 
            WHERE celular = :celular 
            AND id_usuario != :id_usuario
            LIMIT 1";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':celular' => $celular,
        ':id_usuario' => $idUsuario
    ]);

    return $stmt->rowCount() > 0;
}
public function contarClientes()
{
    $sql = "SELECT COUNT(*) AS total
            FROM usuarios u
            INNER JOIN roles r ON u.id_rol = r.id_rol
            WHERE r.nombre_rol = 'CLIENTE'";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetch();

    return $resultado['total'] ?? 0;
}

public function contarProfesionalesUsuarios()
{
    $sql = "SELECT COUNT(*) AS total
            FROM usuarios u
            INNER JOIN roles r ON u.id_rol = r.id_rol
            WHERE r.nombre_rol = 'PROFESIONAL'";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetch();

    return $resultado['total'] ?? 0;
}
}