<?php

require_once '../app/models/Mensaje.php';

class ChatController extends Controller
{
    public function ver($idSolicitud)
    {
        $mensajeModel = new Mensaje();

        $mensajes =
            $mensajeModel->obtenerPorSolicitud(
                $idSolicitud
            );

        $this->view(
            'chat/ver',
            [
                'mensajes' => $mensajes,
                'idSolicitud' => $idSolicitud
            ]
        );
    }

    public function enviar()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            return;
        }

        $mensajeModel = new Mensaje();

        $mensajeModel->enviar([
            'id_solicitud' => $_POST['id_solicitud'],
            'id_remitente' => $_SESSION['usuario']['id_usuario'],
            'mensaje' => trim($_POST['mensaje'])
        ]);

        header(
            'Location: ' .
            BASE_URL .
            'chat/ver/' .
            $_POST['id_solicitud']
        );

        exit;
    }
}