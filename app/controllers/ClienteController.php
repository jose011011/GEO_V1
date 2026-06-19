<?php

require_once __DIR__ . '/../models/Profesional.php';
require_once '../app/models/SolicitudServicio.php';
require_once '../app/models/Cliente.php';
require_once __DIR__ . '/../models/Calificacion.php';

class ClienteController extends Controller
{
    public function dashboard()
    {
        if (!isset($_SESSION['usuario'])) {
            $this->redirect('auth/login');
        }

        if ($_SESSION['usuario']['rol'] !== 'CLIENTE') {
            die('Acceso denegado.');
        }

        $this->view('cliente/dashboard');
    }

    public function profesionales()
    {
        $profesionalModel = new Profesional();

        $profesionales = $profesionalModel->obtenerDisponibles();

        $this->view(
            'cliente/profesionales',
            [
                'profesionales' => $profesionales
            ]
        );
    }

    public function crearSolicitud($idProfesional)
    {
        if (!isset($_SESSION['usuario'])) {
            $this->redirect('auth/login');
        }

        $profesionalModel = new Profesional();

        $profesional =
            $profesionalModel->obtenerDetalle($idProfesional);

        if (!$profesional) {
            die('Profesional no encontrado');
        }

        $this->view(
            'cliente/crear_solicitud',
            [
                'profesional' => $profesional
            ]
        );
    }
    public function misSolicitudes()
{
    $clienteModel = new Cliente();

    $cliente =
        $clienteModel->obtenerPorUsuario(
            $_SESSION['usuario']['id_usuario']
        );
    if (!$cliente) {
        die('No existe cliente asociado a este usuario');
    }

    $solicitudModel =
        new SolicitudServicio();

    $solicitudes =
        $solicitudModel->obtenerPorCliente(
            $cliente['id_cliente']
        );

    $this->view(
        'cliente/mis_solicitudes',
        [
            'solicitudes' => $solicitudes
        ]
    );
}
public function calificar($idSolicitud)
{
    $this->view(
        'cliente/calificar',
        [
            'id_solicitud' => $idSolicitud
        ]
    );
}
    public function guardarCalificacion()
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        return;
    }

    // Debug rápido (quita luego si no lo necesitas)
    // die('DEBUG id_solicitud=' . print_r($_POST['id_solicitud'] ?? null, true));

    $idSolicitudRaw = $_POST['id_solicitud'] ?? null;
    $puntuacion = isset($_POST['puntuacion']) ? (int)$_POST['puntuacion'] : 0;
    $comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : null;

    $idSolicitud = is_numeric($idSolicitudRaw) ? (int)$idSolicitudRaw : 0;

    if ($idSolicitud <= 0) {
        // En vez de romper, redirigir para que no muera por un POST incompleto
        $this->redirect('cliente/misSolicitudes');
        return;
    }

    if ($puntuacion < 1 || $puntuacion > 5) {
        die('Puntuación inválida');
    }

    $calificacionModel = new Calificacion();

    // Limitar: 1 calificación por cliente y profesional
    $infoSolicitud = $calificacionModel->obtenerProfesionalPorSolicitud($idSolicitud);

    if (!$infoSolicitud) {
        $this->redirect('cliente/misSolicitudes');
        return;
    }

    $idCliente = (int)$infoSolicitud['id_cliente'];
    $idProfesional = (int)$infoSolicitud['id_profesional'];

    // Verifica si el cliente ya calificó a ese profesional
    if ($calificacionModel->yaCalificoClienteProfesional($idCliente, $idProfesional)) {
        // Evita que pueda calificar de nuevo
        $this->redirect('cliente/misSolicitudes');
        return;
    }

    $calificacionModel->registrar([
        'id_solicitud' => $idSolicitud,
        'puntuacion' => $puntuacion,
        'comentario' => $comentario
    ]);

    $this->redirect('cliente/misSolicitudes?success=1');
}

}

