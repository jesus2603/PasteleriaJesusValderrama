<?php
session_start();
require_once '../src/conexion.php'; // Incluimos la conexión a la base de datos

// Habilitar errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['usuario'];
    $password = $_POST['password'];

    // Obtenemos la conexión a la base de datos
    $conexion = Conexion::obtenerInstancia()->obtenerConexion();

    // Preparamos la consulta para buscar el usuario
    $sql = ("SELECT * FROM usuarios WHERE usuario = ?");
    $sentencia = $conexion-> prepare($sql);
    $sentencia->execute([$username]);

    $usuario = $sentencia->fetch();

    // Si encontramos el usuario y la contraseña coincide
    if ( $usuario && password_verify($password,$usuario['password'] )) {
        $_SESSION['usuario'] = $usuario; // Guardamos el usuario en sesión
        $_SESSION['nombre'] = $usuario;  // Puedes modificar esto según cómo guardes el nombre

        // Redirigir según el tipo de usuario
        if ($username == 'admin') {
            header('Location: mainAdmin.php');
            exit;
        } else {
            header('Location: main.php');
            exit;
        }
    } else {
        // Si el usuario o la contraseña son incorrectos
        echo "Usuario o contraseña incorrectos.";
        echo '<a href="index.php">Volver al login</a>';
    }
}
?>
