<?php

class SolicitudServicio extends Model
{
    public function crear($datos)
    {
        $sql = "INSERT INTO solicitudes_servicio
                (
                    id_cliente,
                    id_profesional,
                    descripcion_problema,
                    direccion_servicio,
                    zona,
                       latitud,
    longitud
                )
                VALUES
                (
                    :id_cliente,
                    :id_profesional,
                    :descripcion_problema,
                    :direccion_servicio,
                    :zona,
                     :latitud,
    :longitud
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id_cliente' => $datos['id_cliente'],
            ':id_profesional' => $datos['id_profesional'],
            ':descripcion_problema' => $datos['descripcion_problema'],
            ':direccion_servicio' => $datos['direccion_servicio'],
            ':zona' => $datos['zona'],
            ':latitud' => $datos['latitud'],
':longitud' => $datos['longitud']
        ]);
    }

    public function obtenerPorCliente($idCliente)
    {
        $sql = "
            SELECT
                s.*,
                u.nombre,
                u.apellido,
                c.nombre_categoria
            FROM solicitudes_servicio s
            INNER JOIN profesionales p
                ON s.id_profesional = p.id_profesional
            INNER JOIN usuarios u
                ON p.id_usuario = u.id_usuario
            INNER JOIN categorias c
                ON p.id_categoria = c.id_categoria
            WHERE s.id_cliente = ?
            ORDER BY s.fecha_solicitud DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idCliente]);

        return $stmt->fetchAll();
    }

    public function obtenerPorProfesional($idProfesional)
    {
        $sql = "
            SELECT
                s.*,
                u.nombre,
                u.apellido,
                cl.zona
            FROM solicitudes_servicio s
            INNER JOIN clientes cl
                ON s.id_cliente = cl.id_cliente
            INNER JOIN usuarios u
                ON cl.id_usuario = u.id_usuario
            WHERE s.id_profesional = ?
            ORDER BY s.fecha_solicitud DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idProfesional]);

        return $stmt->fetchAll();
    }

    public function actualizarEstado($idSolicitud, $estado)
    {
        $sql = "
            UPDATE solicitudes_servicio
            SET estado_servicio = ?
            WHERE id_solicitud = ?
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $estado,
            $idSolicitud
        ]);
    }

public function obtenerPorId($idSolicitud)
{
    $sql = "
        SELECT
            s.*,
            u.nombre,
            u.apellido,
            u.celular,
            u.correo,
            c.zona AS zona_cliente
        FROM solicitudes_servicio s
        INNER JOIN clientes c
            ON s.id_cliente = c.id_cliente
        INNER JOIN usuarios u
            ON c.id_usuario = u.id_usuario
        WHERE s.id_solicitud = ?
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$idSolicitud]);

    return $stmt->fetch();
}

public function cambiarEstado($idSolicitud, $estado)
{
    $sql = "UPDATE solicitudes_servicio
            SET estado_servicio = ?
            WHERE id_solicitud = ?";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        $estado,
        $idSolicitud
    ]);
}
}