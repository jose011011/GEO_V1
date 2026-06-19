<?php

class Profesional extends Model
{
    public function numeroDocumentoExiste($numeroDocumento)
    {
        $sql = "SELECT id_profesional
                FROM profesionales
                WHERE numero_documento = :numero_documento
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':numero_documento' => $numeroDocumento]);

        return $stmt->rowCount() > 0;
    }

    public function crearProfesional($datos)
    {
        $sql = "INSERT INTO profesionales
                (
                    id_usuario,
                    id_categoria,
                    tipo_documento_identidad,
                    numero_documento,
                    experiencia_anios,
                    descripcion_servicio,
                    zona_trabajo,
                    estado_validacion,
                    estado_disponibilidad
                )
                VALUES
                (
                    :id_usuario,
                    :id_categoria,
                    :tipo_documento_identidad,
                    :numero_documento,
                    :experiencia_anios,
                    :descripcion_servicio,
                    :zona_trabajo,
                    'PENDIENTE',
                    'NO_DISPONIBLE'
                )";

        $stmt = $this->db->prepare($sql);

        $ok = $stmt->execute([
            ':id_usuario' => $datos['id_usuario'],
            ':id_categoria' => $datos['id_categoria'],
            ':tipo_documento_identidad' => $datos['tipo_documento_identidad'],
            ':numero_documento' => $datos['numero_documento'],
            ':experiencia_anios' => $datos['experiencia_anios'],
            ':descripcion_servicio' => $datos['descripcion_servicio'],
            ':zona_trabajo' => $datos['zona_trabajo']
        ]);

        return $ok ? $this->db->lastInsertId() : false;
    }

    public function obtenerPorUsuario($idUsuario)
    {
        $sql = "SELECT 
                    p.*,
                    c.nombre_categoria
                FROM profesionales p
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                WHERE p.id_usuario = :id_usuario
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_usuario' => $idUsuario]);

        return $stmt->fetch();
    }

    public function listarProfesionales()
    {
        $sql = "SELECT 
                    p.id_profesional,
                    p.id_usuario,
                    p.tipo_documento_identidad,
                    p.numero_documento,
                    p.experiencia_anios,
                    p.zona_trabajo,
                    p.estado_validacion,
                    p.estado_disponibilidad,
                    p.fecha_registro,
                    u.nombre,
                    u.apellido,
                    u.correo,
                    u.celular,
                    u.estado AS estado_usuario,
                    c.nombre_categoria
                FROM profesionales p
                INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                ORDER BY p.fecha_registro DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarPendientes()
    {
        $sql = "SELECT 
                    p.id_profesional,
                    p.id_usuario,
                    p.tipo_documento_identidad,
                    p.numero_documento,
                    p.experiencia_anios,
                    p.zona_trabajo,
                    p.estado_validacion,
                    p.fecha_registro,
                    u.nombre,
                    u.apellido,
                    u.correo,
                    u.celular,
                    c.nombre_categoria
                FROM profesionales p
                INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                WHERE p.estado_validacion = 'PENDIENTE'
                ORDER BY p.fecha_registro DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerDetalle($idProfesional)
    {
        $sql = "SELECT 
                    p.*,
                    u.nombre,
                    u.apellido,
                    u.correo,
                    u.celular,
                    u.estado AS estado_usuario,
                    c.nombre_categoria
                FROM profesionales p
                INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                WHERE p.id_profesional = :id_profesional
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_profesional' => $idProfesional]);

        return $stmt->fetch();
    }

    public function cambiarValidacion($idProfesional, $estadoValidacion)
    {
        $sql = "UPDATE profesionales 
                SET estado_validacion = :estado_validacion
                WHERE id_profesional = :id_profesional";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':estado_validacion' => $estadoValidacion,
            ':id_profesional' => $idProfesional
        ]);
    }

    public function cambiarDisponibilidad($idProfesional, $estadoDisponibilidad)
    {
        $sql = "UPDATE profesionales 
                SET estado_disponibilidad = :estado_disponibilidad
                WHERE id_profesional = :id_profesional";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':estado_disponibilidad' => $estadoDisponibilidad,
            ':id_profesional' => $idProfesional
        ]);
    }
    public function numeroDocumentoExisteEditando($numeroDocumento, $idProfesional)
{
    $sql = "SELECT id_profesional
            FROM profesionales
            WHERE numero_documento = :numero_documento
            AND id_profesional != :id_profesional
            LIMIT 1";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':numero_documento' => $numeroDocumento,
        ':id_profesional' => $idProfesional
    ]);

    return $stmt->rowCount() > 0;
}

public function actualizarProfesional($idProfesional, $datos)
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

    $sqlProfesional = "UPDATE profesionales
                       SET id_categoria = :id_categoria,
                           tipo_documento_identidad = :tipo_documento_identidad,
                           numero_documento = :numero_documento,
                           experiencia_anios = :experiencia_anios,
                           zona_trabajo = :zona_trabajo,
                           descripcion_servicio = :descripcion_servicio
                       WHERE id_profesional = :id_profesional";

    $stmtProfesional = $this->db->prepare($sqlProfesional);

    $okProfesional = $stmtProfesional->execute([
        ':id_categoria' => $datos['id_categoria'],
        ':tipo_documento_identidad' => $datos['tipo_documento_identidad'],
        ':numero_documento' => $datos['numero_documento'],
        ':experiencia_anios' => $datos['experiencia_anios'],
        ':zona_trabajo' => $datos['zona_trabajo'],
        ':descripcion_servicio' => $datos['descripcion_servicio'],
        ':id_profesional' => $idProfesional
    ]);

    return $okUsuario && $okProfesional;
}
public function contarPorValidacion($estado)
{
    $sql = "SELECT COUNT(*) AS total
            FROM profesionales
            WHERE estado_validacion = :estado";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':estado' => $estado
    ]);

    $resultado = $stmt->fetch();

    return $resultado['total'] ?? 0;
}

public function contarTodos()
{
    $sql = "SELECT COUNT(*) AS total FROM profesionales";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    $resultado = $stmt->fetch();

    return $resultado['total'] ?? 0;
}
public function obtenerDisponibles()
{
    $sql = "
        SELECT
            p.id_profesional,
            u.nombre,
            u.apellido,
            u.celular,
            c.nombre_categoria,
            p.experiencia_anios,
            p.descripcion_servicio,
            p.zona_trabajo,

            (
                SELECT ROUND(AVG(ca.puntuacion),1)
                FROM calificaciones ca
                INNER JOIN solicitudes_servicio ss
                    ON ca.id_solicitud = ss.id_solicitud
                WHERE ss.id_profesional = p.id_profesional
            ) promedio,

            (
                SELECT COUNT(*)
                FROM calificaciones ca
                INNER JOIN solicitudes_servicio ss
                    ON ca.id_solicitud = ss.id_solicitud
                WHERE ss.id_profesional = p.id_profesional
            ) opiniones

        FROM profesionales p

        INNER JOIN usuarios u
            ON p.id_usuario = u.id_usuario

        INNER JOIN categorias c
            ON p.id_categoria = c.id_categoria

        WHERE p.estado_validacion='APROBADO'
        AND p.estado_disponibilidad='DISPONIBLE'

        ORDER BY u.nombre
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
}

public function obtenerPromedioCalificacion($idProfesional)
{
    $sql = "
        SELECT
            ROUND(AVG(ca.puntuacion),1) AS promedio
        FROM calificaciones ca
        INNER JOIN solicitudes_servicio ss
            ON ca.id_solicitud = ss.id_solicitud
        WHERE ss.id_profesional = ?
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$idProfesional]);

    $resultado = $stmt->fetch();

    return $resultado['promedio'] ?? 0;
}
public function obtenerTotalCalificaciones($idProfesional)
{
    $sql = "
        SELECT COUNT(*) total
        FROM calificaciones ca
        INNER JOIN solicitudes_servicio ss
            ON ca.id_solicitud = ss.id_solicitud
        WHERE ss.id_profesional = ?
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$idProfesional]);

    $resultado = $stmt->fetch();

    return $resultado['total'] ?? 0;
}
public function obtenerTotalTrabajos($idProfesional)
{
    $sql = "
        SELECT COUNT(*) total
        FROM solicitudes_servicio
        WHERE id_profesional = ?
        AND estado_servicio = 'FINALIZADA'
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$idProfesional]);

    $resultado = $stmt->fetch();

    return $resultado['total'] ?? 0;
}
}