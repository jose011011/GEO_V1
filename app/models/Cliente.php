<?php

class Cliente extends Model
{
    public function crearCliente($datos)
    {
        $sql = "INSERT INTO clientes
                (id_usuario, direccion_referencia, zona)
                VALUES
                (:id_usuario, :direccion_referencia, :zona)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id_usuario' => $datos['id_usuario'],
            ':direccion_referencia' => $datos['direccion_referencia'],
            ':zona' => $datos['zona']
        ]);
    }

    public function obtenerDetalle($idCliente)
    {
        $sql = "SELECT 
                    c.id_cliente,
                    c.id_usuario,
                    c.direccion_referencia,
                    c.zona,
                    u.nombre,
                    u.apellido,
                    u.correo,
                    u.celular,
                    u.estado
                FROM clientes c
                INNER JOIN usuarios u ON c.id_usuario = u.id_usuario
                WHERE c.id_cliente = :id_cliente
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_cliente' => $idCliente
        ]);

        return $stmt->fetch();
    }

    public function actualizarCliente($idCliente, $datos)
    {
        $sqlUsuario = "UPDATE usuarios 
                       SET nombre = :nombre,
                           apellido = :apellido,
                           correo = :correo,
                           celular = :celular
                       WHERE id_usuario = :id_usuario";

        $stmtUsuario = $this->db->prepare($sqlUsuario);

        $okUsuario = $stmtUsuario->execute([
            ':nombre' => $datos['nombre'],
            ':apellido' => $datos['apellido'],
            ':correo' => $datos['correo'],
            ':celular' => $datos['celular'],
            ':id_usuario' => $datos['id_usuario']
        ]);

        $sqlCliente = "UPDATE clientes 
                       SET direccion_referencia = :direccion_referencia,
                           zona = :zona
                       WHERE id_cliente = :id_cliente";

        $stmtCliente = $this->db->prepare($sqlCliente);

        $okCliente = $stmtCliente->execute([
            ':direccion_referencia' => $datos['direccion_referencia'],
            ':zona' => $datos['zona'],
            ':id_cliente' => $idCliente
        ]);

        return $okUsuario && $okCliente;
    }
    public function obtenerPorUsuario($idUsuario)
{
    $sql = "SELECT *
            FROM clientes
            WHERE id_usuario = ?
            LIMIT 1";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$idUsuario]);

    return $stmt->fetch();
}
}