<?php

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
}