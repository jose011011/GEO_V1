<?php

class Categoria extends Model
{
    public function obtenerActivas()
    {
        $sql = "SELECT id_categoria, nombre_categoria, descripcion
                FROM categorias
                WHERE estado = 1
                ORDER BY nombre_categoria ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function listarTodas()
    {
        $sql = "SELECT *
                FROM categorias
                ORDER BY fecha_creacion DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerPorId($idCategoria)
    {
        $sql = "SELECT *
                FROM categorias
                WHERE id_categoria = :id_categoria
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_categoria' => $idCategoria
        ]);

        return $stmt->fetch();
    }

    public function existeCategoria($idCategoria)
    {
        $sql = "SELECT id_categoria
                FROM categorias
                WHERE id_categoria = :id_categoria AND estado = 1
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_categoria' => $idCategoria
        ]);

        return $stmt->rowCount() > 0;
    }

    public function nombreExiste($nombreCategoria, $idCategoria = null)
    {
        if ($idCategoria) {
            $sql = "SELECT id_categoria
                    FROM categorias
                    WHERE nombre_categoria = :nombre_categoria
                    AND id_categoria != :id_categoria
                    LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nombre_categoria' => $nombreCategoria,
                ':id_categoria' => $idCategoria
            ]);
        } else {
            $sql = "SELECT id_categoria
                    FROM categorias
                    WHERE nombre_categoria = :nombre_categoria
                    LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nombre_categoria' => $nombreCategoria
            ]);
        }

        return $stmt->rowCount() > 0;
    }

    public function crear($datos)
    {
        $sql = "INSERT INTO categorias
                (nombre_categoria, descripcion, estado)
                VALUES
                (:nombre_categoria, :descripcion, 1)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nombre_categoria' => $datos['nombre_categoria'],
            ':descripcion' => $datos['descripcion']
        ]);
    }

    public function actualizar($idCategoria, $datos)
    {
        $sql = "UPDATE categorias
                SET nombre_categoria = :nombre_categoria,
                    descripcion = :descripcion
                WHERE id_categoria = :id_categoria";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nombre_categoria' => $datos['nombre_categoria'],
            ':descripcion' => $datos['descripcion'],
            ':id_categoria' => $idCategoria
        ]);
    }

    public function cambiarEstado($idCategoria, $estado)
    {
        $sql = "UPDATE categorias
                SET estado = :estado
                WHERE id_categoria = :id_categoria";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':estado' => $estado,
            ':id_categoria' => $idCategoria
        ]);
    }
    public function contarActivas()
{
    $sql = "SELECT COUNT(*) AS total
            FROM categorias
            WHERE estado = 1";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    $resultado = $stmt->fetch();

    return $resultado['total'] ?? 0;
}
}