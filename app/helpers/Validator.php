<?php

class Validator
{
    public static function limpiar($dato)
    {
        return htmlspecialchars(trim($dato), ENT_QUOTES, 'UTF-8');
    }

    public static function nombreValido($texto)
    {
        return preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $texto);
    }

    public static function maximoTresNombres($texto)
    {
        $partes = preg_split('/\s+/', trim($texto));
        return count($partes) <= 3;
    }

    public static function apellidoValido($texto)
    {
        return preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $texto);
    }

    public static function correoValido($correo)
    {
        return filter_var($correo, FILTER_VALIDATE_EMAIL);
    }

    public static function celularValido($celular)
    {
        return preg_match("/^[0-9]{7,15}$/", $celular);
    }

    public static function passwordSegura($password)
    {
        return strlen($password) >= 8
            && preg_match('/[A-Z]/', $password)
            && preg_match('/[a-z]/', $password)
            && preg_match('/[0-9]/', $password)
            && preg_match('/[!@#$%^&*.,;:_\-]/', $password);
    }

    public static function soloNumeros($valor)
    {
        return preg_match('/^[0-9]+$/', $valor);
    }
}