<?php

require_once __DIR__ . '/../config/database.php';

$db = Database::connect();

$nombre = 'Jose';
$apellido = 'Mamani';
$correo = 'admin@gmail.com';
$celular = '70000000';
$password = password_hash('Admin123@', PASSWORD_DEFAULT);

$stmtRol = $db->prepare("SELECT id_rol FROM roles WHERE nombre_rol = 'SUPER_ADMIN' LIMIT 1");
$stmtRol->execute();
$rol = $stmtRol->fetch();

if (!$rol) {
    die('No existe el rol SUPER_ADMIN.');
}

$stmtExiste = $db->prepare("SELECT id_usuario FROM usuarios WHERE correo = :correo LIMIT 1");
$stmtExiste->execute([':correo' => $correo]);

if ($stmtExiste->rowCount() > 0) {
    die('El superadmin ya existe.');
}

$stmt = $db->prepare("
    INSERT INTO usuarios 
    (id_rol, nombre, apellido, correo, celular, password, estado)
    VALUES 
    (:id_rol, :nombre, :apellido, :correo, :celular, :password, 'ACTIVO')
");

$stmt->execute([
    ':id_rol' => $rol['id_rol'],
    ':nombre' => $nombre,
    ':apellido' => $apellido,
    ':correo' => $correo,
    ':celular' => $celular,
    ':password' => $password
]);

echo "<h2>Superadmin creado correctamente</h2>";
echo "<p>Correo: admin@gmail.com</p>";
echo "<p>Contraseña: Admin123@</p>";
echo "<a href='" . BASE_URL . "auth/login'>Ir al login</a>";