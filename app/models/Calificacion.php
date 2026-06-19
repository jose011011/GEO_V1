<?php

class Calificacion extends Model
{
    public function registrar($datos)
    {
        $sql = "INSERT INTO calificaciones
                (
                    id_solicitud,
                    puntuacion,
                    comentario
                )
                VALUES
                (
                    :id_solicitud,
                    :puntuacion,
                    :comentario
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id_solicitud' => $datos['id_solicitud'] ?? null,
            ':puntuacion' => $datos['puntuacion'] ?? null,
            ':comentario' => $datos['comentario'] ?? null
        ]);

    }

    // Para evitar calificaciones repetidas por el mismo cliente y profesional
    public function yaCalificoClienteProfesional($idCliente, $idProfesional)
    {
        $sql = "SELECT 1
                FROM calificaciones c
                INNER JOIN solicitudes_servicio s ON c.id_solicitud = s.id_solicitud
                WHERE s.id_cliente = ? AND s.id_profesional = ?
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idCliente, $idProfesional]);
        return (bool) $stmt->fetch();
    }

    public function obtenerProfesionalPorSolicitud($idSolicitud)
    {
        $sql = "SELECT id_cliente, id_profesional
                FROM solicitudes_servicio
                WHERE id_solicitud = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([(int)$idSolicitud]);
        return $stmt->fetch();
    }


    public function existe($idSolicitud)
    {
        $sql = "SELECT *
                FROM calificaciones
                WHERE id_solicitud = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idSolicitud]);

        return $stmt->fetch();
    }
}