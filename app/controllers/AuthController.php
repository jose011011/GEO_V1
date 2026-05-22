<?php

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../models/Profesional.php';
require_once __DIR__ . '/../models/DocumentoProfesional.php';
require_once __DIR__ . '/../helpers/Validator.php';

class AuthController extends Controller
{
    public function login()
    {
        if (isset($_SESSION['usuario'])) {
            $this->redirigirPorRol($_SESSION['usuario']['rol']);
        }

        $this->view('auth/login');
    }

    public function autenticar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/login');
        }

        $correo = Validator::limpiar($_POST['correo'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $errores = [];

        if ($correo === '') {
            $errores[] = 'El correo electrónico es obligatorio.';
        } elseif (!Validator::correoValido($correo)) {
            $errores[] = 'Ingrese un correo electrónico válido.';
        }

        if ($password === '') {
            $errores[] = 'La contraseña es obligatoria.';
        }

        if (!empty($errores)) {
            $this->view('auth/login', [
                'errores' => $errores,
                'correo' => $correo
            ]);
            return;
        }

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->buscarPorCorreo($correo);

        if (!$usuario) {
            $this->view('auth/login', [
                'errores' => ['El correo no está registrado.'],
                'correo' => $correo
            ]);
            return;
        }

        if ($usuario['estado'] !== 'ACTIVO') {
            $this->view('auth/login', [
                'errores' => ['La cuenta no está activa.'],
                'correo' => $correo
            ]);
            return;
        }

        if (!password_verify($password, $usuario['password'])) {
            $this->view('auth/login', [
                'errores' => ['La contraseña es incorrecta.'],
                'correo' => $correo
            ]);
            return;
        }

        $_SESSION['usuario'] = [
            'id_usuario' => $usuario['id_usuario'],
            'id_rol' => $usuario['id_rol'],
            'rol' => $usuario['nombre_rol'],
            'nombre' => $usuario['nombre'],
            'apellido' => $usuario['apellido'],
            'correo' => $usuario['correo']
        ];

        $this->redirigirPorRol($usuario['nombre_rol']);
    }

    public function registroCliente()
    {
        if (isset($_SESSION['usuario'])) {
            $this->redirigirPorRol($_SESSION['usuario']['rol']);
        }

        $this->view('auth/registro_cliente');
    }

    public function guardarCliente()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/registroCliente');
        }

        $nombre = Validator::limpiar($_POST['nombre'] ?? '');
        $apellido = Validator::limpiar($_POST['apellido'] ?? '');
        $correo = Validator::limpiar($_POST['correo'] ?? '');
        $celular = Validator::limpiar($_POST['celular'] ?? '');
        $zona = Validator::limpiar($_POST['zona'] ?? '');
        $direccion = Validator::limpiar($_POST['direccion_referencia'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirmarPassword = trim($_POST['confirmar_password'] ?? '');

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
        } elseif ($usuarioModel->correoExiste($correo)) {
            $errores[] = 'El correo ya está registrado.';
        }

        if ($celular === '') {
            $errores[] = 'El celular es obligatorio.';
        } elseif (!Validator::celularValido($celular)) {
            $errores[] = 'El celular debe tener solo números y entre 7 a 15 dígitos.';
        } elseif ($usuarioModel->celularExiste($celular)) {
            $errores[] = 'El celular ya está registrado.';
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

        if ($password === '') {
            $errores[] = 'La contraseña es obligatoria.';
        } elseif (!Validator::passwordSegura($password)) {
            $errores[] = 'La contraseña debe tener mínimo 8 caracteres, mayúscula, minúscula, número y símbolo.';
        }

        if ($confirmarPassword === '') {
            $errores[] = 'Debe confirmar la contraseña.';
        } elseif ($password !== $confirmarPassword) {
            $errores[] = 'Las contraseñas no coinciden.';
        }

        $datosFormulario = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'correo' => $correo,
            'celular' => $celular,
            'zona' => $zona,
            'direccion_referencia' => $direccion
        ];

        if (!empty($errores)) {
            $this->view('auth/registro_cliente', [
                'errores' => $errores,
                'datos' => $datosFormulario
            ]);
            return;
        }

        $idRolCliente = $usuarioModel->obtenerIdRol('CLIENTE');

        if (!$idRolCliente) {
            $this->view('auth/registro_cliente', [
                'errores' => ['No existe el rol CLIENTE.'],
                'datos' => $datosFormulario
            ]);
            return;
        }

        try {
            $db = Database::connect();
            $db->beginTransaction();

            $idUsuario = $usuarioModel->crearUsuario([
                'id_rol' => $idRolCliente,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'correo' => $correo,
                'celular' => $celular,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            if (!$idUsuario) {
                throw new Exception('No se pudo crear el usuario.');
            }

            $clienteModel = new Cliente();

            $clienteCreado = $clienteModel->crearCliente([
                'id_usuario' => $idUsuario,
                'direccion_referencia' => $direccion,
                'zona' => $zona
            ]);

            if (!$clienteCreado) {
                throw new Exception('No se pudo crear el cliente.');
            }

            $db->commit();

            $_SESSION['mensaje_exito'] = 'Cuenta de cliente creada correctamente. Ahora puede iniciar sesión.';
            $this->redirect('auth/login');

        } catch (Exception $e) {
            if (isset($db) && $db->inTransaction()) {
                $db->rollBack();
            }

            $this->view('auth/registro_cliente', [
                'errores' => ['Error al registrar cliente: ' . $e->getMessage()],
                'datos' => $datosFormulario
            ]);
        }
    }

    public function registroProfesional()
    {
        if (isset($_SESSION['usuario'])) {
            $this->redirigirPorRol($_SESSION['usuario']['rol']);
        }

        $categoriaModel = new Categoria();

        $this->view('auth/registro_profesional', [
            'categorias' => $categoriaModel->obtenerActivas()
        ]);
    }

    public function guardarProfesional()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/registroProfesional');
        }

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
        $tipoDocumentoArchivo = Validator::limpiar($_POST['tipo_documento_archivo'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirmarPassword = trim($_POST['confirmar_password'] ?? '');

        $errores = [];

        $usuarioModel = new Usuario();
        $categoriaModel = new Categoria();
        $profesionalModel = new Profesional();

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
        } elseif ($usuarioModel->correoExiste($correo)) {
            $errores[] = 'El correo ya está registrado.';
        }

        if ($celular === '') {
            $errores[] = 'El celular es obligatorio.';
        } elseif (!Validator::celularValido($celular)) {
            $errores[] = 'El celular debe tener solo números y entre 7 a 15 dígitos.';
        } elseif ($usuarioModel->celularExiste($celular)) {
            $errores[] = 'El celular ya está registrado.';
        }

        if ($idCategoria === '') {
            $errores[] = 'Debe seleccionar una categoría técnica.';
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
        } elseif ($profesionalModel->numeroDocumentoExiste($numeroDocumento)) {
            $errores[] = 'El número de documento ya está registrado.';
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

        $tiposArchivoValidos = [
            'CERTIFICADO_TECNICO',
            'REFERENCIA_LABORAL',
            'CI_ANVERSO',
            'CI_REVERSO',
            'NIT',
            'OTRO'
        ];

        if ($tipoDocumentoArchivo === '') {
            $errores[] = 'Debe seleccionar el tipo de documento que subirá.';
        } elseif (!in_array($tipoDocumentoArchivo, $tiposArchivoValidos)) {
            $errores[] = 'El tipo de archivo seleccionado no es válido.';
        }

        if ($password === '') {
            $errores[] = 'La contraseña es obligatoria.';
        } elseif (!Validator::passwordSegura($password)) {
            $errores[] = 'La contraseña debe tener mínimo 8 caracteres, mayúscula, minúscula, número y símbolo.';
        }

        if ($confirmarPassword === '') {
            $errores[] = 'Debe confirmar la contraseña.';
        } elseif ($password !== $confirmarPassword) {
            $errores[] = 'Las contraseñas no coinciden.';
        }

        $archivoDocumento = $_FILES['documento_tecnico'] ?? null;

        if (!$archivoDocumento || $archivoDocumento['error'] === UPLOAD_ERR_NO_FILE) {
            $errores[] = 'Debe subir un documento del profesional.';
        } elseif ($archivoDocumento['error'] !== UPLOAD_ERR_OK) {
            $errores[] = 'Error al subir el documento.';
        } else {
            $permitidos = ['application/pdf', 'image/jpeg', 'image/png'];
            $maximo = 2 * 1024 * 1024;

            if (!in_array($archivoDocumento['type'], $permitidos)) {
                $errores[] = 'El documento debe ser PDF, JPG o PNG.';
            }

            if ($archivoDocumento['size'] > $maximo) {
                $errores[] = 'El documento no debe superar los 2 MB.';
            }
        }

        $datosFormulario = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'correo' => $correo,
            'celular' => $celular,
            'id_categoria' => $idCategoria,
            'tipo_documento_identidad' => $tipoDocumentoIdentidad,
            'numero_documento' => $numeroDocumento,
            'experiencia_anios' => $experienciaAnios,
            'zona_trabajo' => $zonaTrabajo,
            'descripcion_servicio' => $descripcionServicio,
            'tipo_documento_archivo' => $tipoDocumentoArchivo
        ];

        $categorias = $categoriaModel->obtenerActivas();

        if (!empty($errores)) {
            $this->view('auth/registro_profesional', [
                'errores' => $errores,
                'datos' => $datosFormulario,
                'categorias' => $categorias
            ]);
            return;
        }

        $idRolProfesional = $usuarioModel->obtenerIdRol('PROFESIONAL');

        if (!$idRolProfesional) {
            $this->view('auth/registro_profesional', [
                'errores' => ['No existe el rol PROFESIONAL.'],
                'datos' => $datosFormulario,
                'categorias' => $categorias
            ]);
            return;
        }

        try {
            $db = Database::connect();
            $db->beginTransaction();

            $idUsuario = $usuarioModel->crearUsuario([
                'id_rol' => $idRolProfesional,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'correo' => $correo,
                'celular' => $celular,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            if (!$idUsuario) {
                throw new Exception('No se pudo crear el usuario.');
            }

            $idProfesional = $profesionalModel->crearProfesional([
                'id_usuario' => $idUsuario,
                'id_categoria' => (int)$idCategoria,
                'tipo_documento_identidad' => $tipoDocumentoIdentidad,
                'numero_documento' => $numeroDocumento,
                'experiencia_anios' => (int)$experienciaAnios,
                'descripcion_servicio' => $descripcionServicio,
                'zona_trabajo' => $zonaTrabajo
            ]);

            if (!$idProfesional) {
                throw new Exception('No se pudo crear el profesional.');
            }

            $extension = strtolower(pathinfo($archivoDocumento['name'], PATHINFO_EXTENSION));
            $nombreArchivo = 'prof_' . $idProfesional . '_' . time() . '.' . $extension;

            $carpetaDestino = __DIR__ . '/../../public/assets/uploads/documentos/';

            if (!is_dir($carpetaDestino)) {
                mkdir($carpetaDestino, 0777, true);
            }

            $rutaDestino = $carpetaDestino . $nombreArchivo;

            if (!move_uploaded_file($archivoDocumento['tmp_name'], $rutaDestino)) {
                throw new Exception('No se pudo guardar el archivo subido.');
            }

            $documentoModel = new DocumentoProfesional();

            $documentoCreado = $documentoModel->crearDocumento([
                'id_profesional' => $idProfesional,
                'tipo_documento_archivo' => $tipoDocumentoArchivo,
                'archivo' => $nombreArchivo
            ]);

            if (!$documentoCreado) {
                throw new Exception('No se pudo registrar el documento.');
            }

            $db->commit();

            $_SESSION['mensaje_exito'] = 'Registro profesional enviado correctamente. Un administrador revisará sus datos.';
            $this->redirect('auth/login');

        } catch (Exception $e) {
            if (isset($db) && $db->inTransaction()) {
                $db->rollBack();
            }

            $this->view('auth/registro_profesional', [
                'errores' => ['Error al registrar profesional: ' . $e->getMessage()],
                'datos' => $datosFormulario,
                'categorias' => $categorias
            ]);
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('auth/login');
    }

    private function redirigirPorRol($rol)
    {
        switch ($rol) {
            case 'SUPER_ADMIN':
            case 'ADMIN':
                $this->redirect('admin/dashboard');
                break;

            case 'CLIENTE':
                $this->redirect('cliente/dashboard');
                break;

            case 'PROFESIONAL':
                $this->redirect('profesional/dashboard');
                break;

            default:
                session_destroy();
                $this->redirect('auth/login');
                break;
        }
    }
}