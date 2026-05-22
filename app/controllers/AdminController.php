<?php

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Profesional.php';
require_once __DIR__ . '/../models/DocumentoProfesional.php';

require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../helpers/Validator.php';

require_once __DIR__ . '/../models/Categoria.php';


class AdminController extends Controller
{
    private function validarAdmin()
    {
        if (!isset($_SESSION['usuario'])) {
            $this->redirect('auth/login');
        }

        if ($_SESSION['usuario']['rol'] !== 'SUPER_ADMIN' && $_SESSION['usuario']['rol'] !== 'ADMIN') {
            die('Acceso denegado.');
        }
    }

public function dashboard()
{
    $this->validarAdmin();

    $usuarioModel = new Usuario();
    $profesionalModel = new Profesional();
    $categoriaModel = new Categoria();

    $estadisticas = [
        'clientes' => $usuarioModel->contarClientes(),
        'profesionales' => $profesionalModel->contarTodos(),
        'pendientes' => $profesionalModel->contarPorValidacion('PENDIENTE'),
        'aprobados' => $profesionalModel->contarPorValidacion('APROBADO'),
        'rechazados' => $profesionalModel->contarPorValidacion('RECHAZADO'),
        'categorias' => $categoriaModel->contarActivas()
    ];

    $this->view('admin/dashboard', [
        'estadisticas' => $estadisticas
    ]);
}

    public function clientes()
    {
        $this->validarAdmin();

        $usuarioModel = new Usuario();
        $clientes = $usuarioModel->listarClientes();

        $this->view('admin/clientes', [
            'clientes' => $clientes
        ]);
    }

    public function bloquearUsuario($idUsuario)
    {
        $this->validarAdmin();

        $usuarioModel = new Usuario();
        $usuarioModel->cambiarEstado($idUsuario, 'BLOQUEADO');

        $_SESSION['mensaje_admin'] = 'Usuario bloqueado correctamente.';
        $this->redirect('admin/clientes');
    }

    public function activarUsuario($idUsuario)
    {
        $this->validarAdmin();

        $usuarioModel = new Usuario();
        $usuarioModel->cambiarEstado($idUsuario, 'ACTIVO');

        $_SESSION['mensaje_admin'] = 'Usuario activado correctamente.';
        $this->redirect('admin/clientes');
    }

    public function profesionales()
    {
        $this->validarAdmin();

        $profesionalModel = new Profesional();
        $profesionales = $profesionalModel->listarProfesionales();

        $this->view('admin/profesionales', [
            'profesionales' => $profesionales
        ]);
    }

    public function pendientes()
    {
        $this->validarAdmin();

        $profesionalModel = new Profesional();
        $profesionales = $profesionalModel->listarPendientes();

        $this->view('admin/profesionales_pendientes', [
            'profesionales' => $profesionales
        ]);
    }

    public function verProfesional($idProfesional)
    {
        $this->validarAdmin();

        $profesionalModel = new Profesional();
        $documentoModel = new DocumentoProfesional();

        $profesional = $profesionalModel->obtenerDetalle($idProfesional);
        $documentos = $documentoModel->obtenerPorProfesional($idProfesional);

        if (!$profesional) {
            die('Profesional no encontrado.');
        }

        $this->view('admin/ver_profesional', [
            'profesional' => $profesional,
            'documentos' => $documentos
        ]);
    }

    public function aprobarProfesional($idProfesional)
    {
        $this->validarAdmin();

        $profesionalModel = new Profesional();
        $profesionalModel->cambiarValidacion($idProfesional, 'APROBADO');
        $profesionalModel->cambiarDisponibilidad($idProfesional, 'DISPONIBLE');

        $_SESSION['mensaje_admin'] = 'Profesional aprobado correctamente.';
        $this->redirect('admin/profesionales');
    }

    public function rechazarProfesional($idProfesional)
    {
        $this->validarAdmin();

        $profesionalModel = new Profesional();
        $profesionalModel->cambiarValidacion($idProfesional, 'RECHAZADO');
        $profesionalModel->cambiarDisponibilidad($idProfesional, 'NO_DISPONIBLE');

        $_SESSION['mensaje_admin'] = 'Profesional rechazado correctamente.';
        $this->redirect('admin/profesionales');
    }

    public function bloquearProfesional($idUsuario)
    {
        $this->validarAdmin();

        $usuarioModel = new Usuario();
        $usuarioModel->cambiarEstado($idUsuario, 'BLOQUEADO');

        $_SESSION['mensaje_admin'] = 'Profesional bloqueado correctamente.';
        $this->redirect('admin/profesionales');
    }

    public function activarProfesional($idUsuario)
    {
        $this->validarAdmin();

        $usuarioModel = new Usuario();
        $usuarioModel->cambiarEstado($idUsuario, 'ACTIVO');

        $_SESSION['mensaje_admin'] = 'Profesional activado correctamente.';
        $this->redirect('admin/profesionales');
    }

    public function editarCliente($idCliente)
{
    $this->validarAdmin();

    $clienteModel = new Cliente();
    $cliente = $clienteModel->obtenerDetalle($idCliente);

    if (!$cliente) {
        die('Cliente no encontrado.');
    }

    $this->view('admin/form_cliente', [
        'cliente' => $cliente
    ]);
}

public function actualizarCliente($idCliente)
{
    $this->validarAdmin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->redirect('admin/clientes');
    }

    $idUsuario = $_POST['id_usuario'] ?? '';
    $nombre = Validator::limpiar($_POST['nombre'] ?? '');
    $apellido = Validator::limpiar($_POST['apellido'] ?? '');
    $correo = Validator::limpiar($_POST['correo'] ?? '');
    $celular = Validator::limpiar($_POST['celular'] ?? '');
    $zona = Validator::limpiar($_POST['zona'] ?? '');
    $direccion = Validator::limpiar($_POST['direccion_referencia'] ?? '');

    $errores = [];

    $usuarioModel = new Usuario();

    if ($nombre === '') {
        $errores[] = 'El nombre es obligatorio.';
    } elseif (!Validator::nombreValido($nombre)) {
        $errores[] = 'El nombre solo debe contener letras.';
    } elseif (!Validator::maximoTresNombres($nombre)) {
        $errores[] = 'Máximo se permiten tres nombres.';
    }

    if ($apellido === '') {
        $errores[] = 'El apellido es obligatorio.';
    } elseif (!Validator::apellidoValido($apellido)) {
        $errores[] = 'El apellido debe ser uno solo y solo con letras.';
    }

    if ($correo === '') {
        $errores[] = 'El correo es obligatorio.';
    } elseif (!Validator::correoValido($correo)) {
        $errores[] = 'Ingrese un correo válido.';
    } elseif ($usuarioModel->correoExisteEditando($correo, $idUsuario)) {
        $errores[] = 'El correo ya está registrado por otro usuario.';
    }

    if ($celular === '') {
        $errores[] = 'El celular es obligatorio.';
    } elseif (!Validator::celularValido($celular)) {
        $errores[] = 'El celular debe tener solo números y entre 7 a 15 dígitos.';
    } elseif ($usuarioModel->celularExisteEditando($celular, $idUsuario)) {
        $errores[] = 'El celular ya está registrado por otro usuario.';
    }

    if ($zona === '') {
        $errores[] = 'La zona es obligatoria.';
    } elseif (strlen($zona) < 3) {
        $errores[] = 'La zona debe tener al menos 3 caracteres.';
    }

    if ($direccion === '') {
        $errores[] = 'La dirección de referencia es obligatoria.';
    } elseif (strlen($direccion) < 8) {
        $errores[] = 'La dirección debe ser más clara.';
    }

    $cliente = [
        'id_cliente' => $idCliente,
        'id_usuario' => $idUsuario,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'correo' => $correo,
        'celular' => $celular,
        'zona' => $zona,
        'direccion_referencia' => $direccion
    ];

    if (!empty($errores)) {
        $this->view('admin/form_cliente', [
            'cliente' => $cliente,
            'errores' => $errores
        ]);
        return;
    }

    $clienteModel = new Cliente();

    $clienteModel->actualizarCliente($idCliente, [
        'id_usuario' => $idUsuario,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'correo' => $correo,
        'celular' => $celular,
        'zona' => $zona,
        'direccion_referencia' => $direccion
    ]);

    $_SESSION['mensaje_admin'] = 'Cliente actualizado correctamente.';
    $this->redirect('admin/clientes');
}
public function editarProfesional($idProfesional)
{
    $this->validarAdmin();

    $profesionalModel = new Profesional();
    $categoriaModel = new Categoria();

    $profesional = $profesionalModel->obtenerDetalle($idProfesional);
    $categorias = $categoriaModel->obtenerActivas();

    if (!$profesional) {
        die('Profesional no encontrado.');
    }

    $this->view('admin/form_profesional', [
        'profesional' => $profesional,
        'categorias' => $categorias
    ]);
}

public function actualizarProfesional($idProfesional)
{
    $this->validarAdmin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->redirect('admin/profesionales');
    }

    $idUsuario = $_POST['id_usuario'] ?? '';
    $nombre = Validator::limpiar($_POST['nombre'] ?? '');
    $apellido = Validator::limpiar($_POST['apellido'] ?? '');
    $correo = Validator::limpiar($_POST['correo'] ?? '');
    $celular = Validator::limpiar($_POST['celular'] ?? '');
    $idCategoria = Validator::limpiar($_POST['id_categoria'] ?? '');
    $tipoDocumentoIdentidad = Validator::limpiar($_POST['tipo_documento_identidad'] ?? '');
    $numeroDocumento = Validator::limpiar($_POST['numero_documento'] ?? '');
    $experienciaAnios = Validator::limpiar($_POST['experiencia_anios'] ?? '');
    $zonaTrabajo = Validator::limpiar($_POST['zona_trabajo'] ?? '');
    $descripcionServicio = Validator::limpiar($_POST['descripcion_servicio'] ?? '');

    $errores = [];

    $usuarioModel = new Usuario();
    $profesionalModel = new Profesional();
    $categoriaModel = new Categoria();

    if ($nombre === '') {
        $errores[] = 'El nombre es obligatorio.';
    } elseif (!Validator::nombreValido($nombre)) {
        $errores[] = 'El nombre solo debe contener letras.';
    } elseif (!Validator::maximoTresNombres($nombre)) {
        $errores[] = 'Máximo se permiten tres nombres.';
    }

    if ($apellido === '') {
        $errores[] = 'El apellido es obligatorio.';
    } elseif (!Validator::apellidoValido($apellido)) {
        $errores[] = 'El apellido debe ser uno solo y solo con letras.';
    }

    if ($correo === '') {
        $errores[] = 'El correo es obligatorio.';
    } elseif (!Validator::correoValido($correo)) {
        $errores[] = 'Ingrese un correo válido.';
    } elseif ($usuarioModel->correoExisteEditando($correo, $idUsuario)) {
        $errores[] = 'El correo ya está registrado por otro usuario.';
    }

    if ($celular === '') {
        $errores[] = 'El celular es obligatorio.';
    } elseif (!Validator::celularValido($celular)) {
        $errores[] = 'El celular debe tener solo números y entre 7 a 15 dígitos.';
    } elseif ($usuarioModel->celularExisteEditando($celular, $idUsuario)) {
        $errores[] = 'El celular ya está registrado por otro usuario.';
    }

    if ($idCategoria === '') {
        $errores[] = 'Debe seleccionar una categoría.';
    } elseif (!$categoriaModel->existeCategoria((int)$idCategoria)) {
        $errores[] = 'La categoría seleccionada no es válida.';
    }

    if ($tipoDocumentoIdentidad === '') {
        $errores[] = 'Debe seleccionar CI o NIT.';
    } elseif (!in_array($tipoDocumentoIdentidad, ['CI', 'NIT'])) {
        $errores[] = 'El tipo de documento no es válido.';
    }

    if ($numeroDocumento === '') {
        $errores[] = 'El número de documento es obligatorio.';
    } elseif (!Validator::soloNumeros($numeroDocumento)) {
        $errores[] = 'El número de documento solo debe contener números.';
    } elseif ($tipoDocumentoIdentidad === 'CI' && (strlen($numeroDocumento) < 5 || strlen($numeroDocumento) > 12)) {
        $errores[] = 'El CI debe tener entre 5 y 12 dígitos.';
    } elseif ($tipoDocumentoIdentidad === 'NIT' && (strlen($numeroDocumento) < 7 || strlen($numeroDocumento) > 15)) {
        $errores[] = 'El NIT debe tener entre 7 y 15 dígitos.';
    } elseif ($profesionalModel->numeroDocumentoExisteEditando($numeroDocumento, $idProfesional)) {
        $errores[] = 'El número de documento ya está registrado por otro profesional.';
    }

    if ($experienciaAnios === '') {
        $errores[] = 'Ingrese años de experiencia. Si no tiene, escriba 0.';
    } elseif (!Validator::soloNumeros($experienciaAnios)) {
        $errores[] = 'La experiencia debe ser un número entero.';
    } elseif ((int)$experienciaAnios < 0 || (int)$experienciaAnios > 60) {
        $errores[] = 'La experiencia debe estar entre 0 y 60 años.';
    }

    if ($zonaTrabajo === '') {
        $errores[] = 'La zona de trabajo es obligatoria.';
    } elseif (strlen($zonaTrabajo) < 3) {
        $errores[] = 'La zona de trabajo debe tener al menos 3 caracteres.';
    }

    if ($descripcionServicio === '') {
        $errores[] = 'La descripción del servicio es obligatoria.';
    } elseif (strlen($descripcionServicio) < 30) {
        $errores[] = 'La descripción debe tener al menos 30 caracteres.';
    } elseif (strlen($descripcionServicio) > 500) {
        $errores[] = 'La descripción no debe superar los 500 caracteres.';
    }

    $profesional = [
        'id_profesional' => $idProfesional,
        'id_usuario' => $idUsuario,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'correo' => $correo,
        'celular' => $celular,
        'id_categoria' => $idCategoria,
        'tipo_documento_identidad' => $tipoDocumentoIdentidad,
        'numero_documento' => $numeroDocumento,
        'experiencia_anios' => $experienciaAnios,
        'zona_trabajo' => $zonaTrabajo,
        'descripcion_servicio' => $descripcionServicio
    ];

    $categorias = $categoriaModel->obtenerActivas();

    if (!empty($errores)) {
        $this->view('admin/form_profesional', [
            'profesional' => $profesional,
            'categorias' => $categorias,
            'errores' => $errores
        ]);
        return;
    }

    $profesionalModel->actualizarProfesional($idProfesional, [
        'id_usuario' => $idUsuario,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'correo' => $correo,
        'celular' => $celular,
        'id_categoria' => (int)$idCategoria,
        'tipo_documento_identidad' => $tipoDocumentoIdentidad,
        'numero_documento' => $numeroDocumento,
        'experiencia_anios' => (int)$experienciaAnios,
        'zona_trabajo' => $zonaTrabajo,
        'descripcion_servicio' => $descripcionServicio
    ]);

    $_SESSION['mensaje_admin'] = 'Profesional actualizado correctamente.';
    $this->redirect('admin/profesionales');
}
}