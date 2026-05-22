<?php

require_once __DIR__ . '/../models/Categoria.php';

class CategoriaController extends Controller
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

    public function index()
    {
        $this->validarAdmin();

        $categoriaModel = new Categoria();
        $categorias = $categoriaModel->listarTodas();

        $this->view('admin/categorias', [
            'categorias' => $categorias
        ]);
    }

    public function crear()
    {
        $this->validarAdmin();

        $this->view('admin/form_categoria', [
            'modo' => 'crear',
            'categoria' => null
        ]);
    }

    public function guardar()
    {
        $this->validarAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('categoria/index');
        }

        $nombre = trim($_POST['nombre_categoria'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        $errores = [];

        if ($nombre === '') {
            $errores[] = 'El nombre de la categoría es obligatorio.';
        } elseif (strlen($nombre) < 3) {
            $errores[] = 'El nombre debe tener al menos 3 caracteres.';
        } elseif (strlen($nombre) > 100) {
            $errores[] = 'El nombre no debe superar los 100 caracteres.';
        }

        if ($descripcion === '') {
            $errores[] = 'La descripción es obligatoria.';
        } elseif (strlen($descripcion) < 10) {
            $errores[] = 'La descripción debe tener al menos 10 caracteres.';
        }

        $categoriaModel = new Categoria();

        if ($nombre !== '' && $categoriaModel->nombreExiste($nombre)) {
            $errores[] = 'Ya existe una categoría con ese nombre.';
        }

        $categoria = [
            'nombre_categoria' => $nombre,
            'descripcion' => $descripcion
        ];

        if (!empty($errores)) {
            $this->view('admin/form_categoria', [
                'modo' => 'crear',
                'categoria' => $categoria,
                'errores' => $errores
            ]);
            return;
        }

        $categoriaModel->crear($categoria);

        $_SESSION['mensaje_admin'] = 'Categoría creada correctamente.';
        $this->redirect('categoria/index');
    }

    public function editar($idCategoria)
    {
        $this->validarAdmin();

        $categoriaModel = new Categoria();
        $categoria = $categoriaModel->obtenerPorId($idCategoria);

        if (!$categoria) {
            die('Categoría no encontrada.');
        }

        $this->view('admin/form_categoria', [
            'modo' => 'editar',
            'categoria' => $categoria
        ]);
    }

    public function actualizar($idCategoria)
    {
        $this->validarAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('categoria/index');
        }

        $nombre = trim($_POST['nombre_categoria'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        $errores = [];

        if ($nombre === '') {
            $errores[] = 'El nombre de la categoría es obligatorio.';
        } elseif (strlen($nombre) < 3) {
            $errores[] = 'El nombre debe tener al menos 3 caracteres.';
        } elseif (strlen($nombre) > 100) {
            $errores[] = 'El nombre no debe superar los 100 caracteres.';
        }

        if ($descripcion === '') {
            $errores[] = 'La descripción es obligatoria.';
        } elseif (strlen($descripcion) < 10) {
            $errores[] = 'La descripción debe tener al menos 10 caracteres.';
        }

        $categoriaModel = new Categoria();

        if ($nombre !== '' && $categoriaModel->nombreExiste($nombre, $idCategoria)) {
            $errores[] = 'Ya existe otra categoría con ese nombre.';
        }

        $categoria = [
            'id_categoria' => $idCategoria,
            'nombre_categoria' => $nombre,
            'descripcion' => $descripcion
        ];

        if (!empty($errores)) {
            $this->view('admin/form_categoria', [
                'modo' => 'editar',
                'categoria' => $categoria,
                'errores' => $errores
            ]);
            return;
        }

        $categoriaModel->actualizar($idCategoria, $categoria);

        $_SESSION['mensaje_admin'] = 'Categoría actualizada correctamente.';
        $this->redirect('categoria/index');
    }

    public function desactivar($idCategoria)
    {
        $this->validarAdmin();

        $categoriaModel = new Categoria();
        $categoriaModel->cambiarEstado($idCategoria, 0);

        $_SESSION['mensaje_admin'] = 'Categoría desactivada correctamente.';
        $this->redirect('categoria/index');
    }

    public function activar($idCategoria)
    {
        $this->validarAdmin();

        $categoriaModel = new Categoria();
        $categoriaModel->cambiarEstado($idCategoria, 1);

        $_SESSION['mensaje_admin'] = 'Categoría activada correctamente.';
        $this->redirect('categoria/index');
    }
}