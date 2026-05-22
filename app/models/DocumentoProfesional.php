<?php

class DocumentoProfesional extends Model
{
    public function crearDocumento($datos)
    {
        $sql = "INSERT INTO documentos_profesional
                (
                    id_profesional,
                    tipo_documento_archivo,
                    archivo,
                    estado_revision,
                    observacion
                )
                VALUES
                (
                    :id_profesional,
                    :tipo_documento_archivo,
                    :archivo,
                    'PENDIENTE',
                    NULL
                )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id_profesional' => $datos['id_profesional'],
            ':tipo_documento_archivo' => $datos['tipo_documento_archivo'],
            ':archivo' => $datos['archivo']
        ]);
    }

    public function obtenerPorProfesional($idProfesional)
    {
        $sql = "SELECT *
                FROM documentos_profesional
                WHERE id_profesional = :id_profesional
                ORDER BY fecha_subida DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_profesional' => $idProfesional]);

        return $stmt->fetchAll();
    }

    public function cambiarEstadoDocumento($idDocumento, $estado, $observacion = null)
    {
        $sql = "UPDATE documentos_profesional
                SET estado_revision = :estado_revision,
                    observacion = :observacion
                WHERE id_documento = :id_documento";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':estado_revision' => $estado,
            ':observacion' => $observacion,
            ':id_documento' => $idDocumento
        ]);
    }
}