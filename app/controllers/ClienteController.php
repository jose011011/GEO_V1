<?php

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
}