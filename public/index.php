<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Router.php';

// Landing home (solo en public, sin usar views/controladores extra)
// Si no viene /public/<controller>/<method> (url vacía), mostramos landing.
$hasUrl = isset($_GET['url']) && trim($_GET['url']) !== '';
if (!$hasUrl) {
    require_once __DIR__ . '/landing_home.php';
    exit;
}

new Router();
