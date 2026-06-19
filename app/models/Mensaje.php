<?php

class Mensaje extends Model
{
    public function enviar($datos)
    {
        $sql = "INSERT INTO mensajes
                (
                    id_solicitud,
                    id_remitente,
                    mensaje
                )
                VALUES
                (
                    :id_solicitud,
                    :id_remitente,
                    :mensaje
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id_solicitud' => $datos['id_solicitud'],
            ':id_remitente' => $datos['id_remitente'],
            ':mensaje' => $datos['mensaje']
        ]);
    }

    public function obtenerPorSolicitud($idSolicitud)
    {
        $sql = "SELECT
                    m.*,
                    u.nombre,
                    u.apellido
                FROM mensajes m
                LEFT JOIN usuarios u
                    ON m.id_remitente = u.id_usuario
                WHERE m.id_solicitud = ?
                ORDER BY m.fecha_envio ASC";


        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idSolicitud]);

        return $stmt->fetchAll();
    }
}