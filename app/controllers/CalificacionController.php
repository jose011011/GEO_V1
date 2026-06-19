<?php

require_once __DIR__ . '/../models/Calificacion.php';

class CalificacionController extends Controller
{
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            $this->redirect('cliente/misSolicitudes');
        }

        $puntuacion =
            (int)$_POST['puntuacion'];

        if ($puntuacion < 1 || $puntuacion > 5)
        {
            die('Puntuación inválida');
        }

        $calificacionModel = new Calificacion();

        $calificacionModel->registrar([
            'id_solicitud' => $_POST['id_solicitud'],
            'puntuacion' => $puntuacion,
            'comentario' => trim($_POST['comentario'])
        ]);

        $this->redirect('cliente/misSolicitudes');
    }
}