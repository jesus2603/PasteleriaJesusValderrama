<?php
require_once '../src/conexion.php';

$usuario = $_POST['usuario'];
var_dump($usuario);
$password = $_POST['password'];
$conexion = Conexion::obtenerInstancia()->obtenerConexion();
$sql = "INSERT INTO usuarios(usuario, password,isAdmin) VALUES (:usr,:pss, 0)";

$sentencia = $conexion->prepare($sql);
$isOkay = $sentencia->execute([
    'usr' => $usuario,
    'pss' => password_hash($password, PASSWORD_DEFAULT),
]);
if ($isOkay) {
    session_start();
    $_SESSION['usuario'] = $usuario;

    // Redirigir según el tipo de usuario
    if ($usuario == 'admin') {
        header('Location: mainAdmin.php');
        exit;
    } else {
        header('Location: main.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container text-center mt-5">
    <p>¿No tienes una cuenta?</p>
    <a href="signin.php" class="btn btn-primary">Regístrate</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
