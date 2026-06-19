<?php
// LandingController ya no es necesario para la landing del home.
// Se mantiene por compatibilidad en caso de que existan rutas previas.

class LandingController extends Controller
{
    public function index()
    {
        $this->view('landing/index');
    }
}


