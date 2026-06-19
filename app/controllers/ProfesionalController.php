<?php
require_once __DIR__ . '/../models/Profesional.php';
require_once __DIR__ . '/../models/SolicitudServicio.php';
require_once '../app/models/Profesional.php';
require_once '../app/models/SolicitudServicio.php';
class ProfesionalController extends Controller
{
    public function dashboard()
    {
        if (!isset($_SESSION['usuario'])) {
            $this->redirect('auth/login');
        }

        if ($_SESSION['usuario']['rol'] !== 'PROFESIONAL') {
            die('Acceso denegado.');
        }

        $this->view('profesional/dashboard');
    }
    public function solicitudes()
{
    $profesionalModel = new Profesional();

    $profesional = $profesionalModel->obtenerPorUsuario(
        $_SESSION['usuario']['id_usuario']
    );

    if (!$profesional) {
        die('Profesional no encontrado');
    }

    $solicitudModel = new SolicitudServicio();

    $solicitudes = $solicitudModel->obtenerPorProfesional(
        $profesional['id_profesional']
    );

    $this->view(
        'profesional/solicitudes',
        [
            'solicitudes' => $solicitudes
        ]
    );
}
public function aceptar($idSolicitud)
{
    $solicitudModel = new SolicitudServicio();

    $solicitudModel->actualizarEstado(
        $idSolicitud,
        'ACEPTADA'
    );

    $this->redirect('profesional/solicitudes');
}
public function finalizar($idSolicitud)
{
    $solicitudModel = new SolicitudServicio();

    $solicitudModel->actualizarEstado(
        $idSolicitud,
        'FINALIZADA'
    );

    $this->redirect('profesional/solicitudes');
}
public function iniciar($idSolicitud)
{
    $solicitudModel =
        new SolicitudServicio();

    $solicitudModel->cambiarEstado(
        $idSolicitud,
        'EN_PROCESO'
    );

    $this->redirect(
        'profesional/solicitudes'
    );
}
public function cancelar($idSolicitud)
{
    $solicitudModel =
        new SolicitudServicio();

    $solicitudModel->cambiarEstado(
        $idSolicitud,
        'CANCELADA'
    );

    $this->redirect(
        'profesional/solicitudes'
    );
}
public function verSolicitud($idSolicitud)
{
    $solicitudModel = new SolicitudServicio();

    $solicitud =
        $solicitudModel->obtenerPorId($idSolicitud);

    if(!$solicitud)
    {
        die('Solicitud no encontrada');
    }

    $this->view(
        'profesional/ver_solicitud',
        [
            'solicitud' => $solicitud
        ]
    );
}
}