<?php

require_once __DIR__ . '/../models/SolicitudServicio.php';
require_once __DIR__ . '/../models/Cliente.php';

class SolicitudController extends Controller
{
    private $solicitudModel;

    public function __construct()
    {
        $this->solicitudModel = new SolicitudServicio();
    }

    public function guardar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('cliente/profesionales');
        }

        $clienteModel = new Cliente();
        $idUsuario = $_SESSION['usuario']['id_usuario'] ?? null;
        $cliente = $clienteModel->obtenerPorUsuario($idUsuario);

        if (!$cliente) {
            die('Cliente no encontrado');
        }

        $idProfesional = $_POST['id_profesional'] ?? null;
        $latitud = (isset($_POST['latitud']) && $_POST['latitud'] !== '') ? $_POST['latitud'] : null;
        $longitud = (isset($_POST['longitud']) && $_POST['longitud'] !== '') ? $_POST['longitud'] : null;

        $datos = [
            'id_cliente' => $cliente['id_cliente'],
            'id_profesional' => $idProfesional,
            'descripcion_problema' => trim($_POST['descripcion_problema'] ?? ''),
            'direccion_servicio' => trim($_POST['direccion_servicio'] ?? ''),
            'zona' => trim($_POST['zona'] ?? ''),
            'latitud' => $latitud,
            'longitud' => $longitud
        ];

        if (empty($datos['id_profesional'])) {
            $_SESSION['error'] = 'Profesional no válido.';
            $this->redirect('cliente/profesionales');
        }

        // Validación básica para evitar guardar lat/lng vacíos
        if ($datos['latitud'] === null || $datos['longitud'] === null) {
            $_SESSION['error'] = 'Debes seleccionar una ubicación exacta en el mapa.';
$this->redirect('cliente/crearSolicitud/' . $datos['id_profesional']);
        }

        $this->solicitudModel->crear($datos);

        $_SESSION['success'] = 'Solicitud enviada correctamente';
        $this->redirect('cliente/misSolicitudes');
    }
}

