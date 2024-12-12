<?php
require_once '../src/conexion.php';

$usuario = $_POST['usuario'];
$password = $_POST['password'];
$conexion = Conexion::obtenerInstancia()->obtenerConexion();
$sql = "INSERT INTO usuarios(usuario, password) VALUES (:usr,:pss)";

$sentencia = $conexion->prepare($sql);
$isOkay = $sentencia->execute([
    "usr" => $usuario,
    "pss" => password_hash($password, PASSWORD_DEFAULT),
]);
if ($isOkay) {
session_start();
    $_SESSION['usuario'] = $usuario;

    // Redirigir según el tipo de usuario
    if ($usuario === 'admin') {
        header('Location: mainAdmin.php');
        exit;
    } else {
        header('Location: main.php');
        exit;
    }

}
