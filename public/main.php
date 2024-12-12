<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

// Mensaje de bienvenida
echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Bienvenido a la Pastelería</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>
<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
    <div class='container-fluid'>
        <a class='navbar-brand' href='#'>Pastelería</a>
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarNav'>
            <ul class='navbar-nav ms-auto'>
                <li class='nav-item'>
                    <a class='nav-link' href='logout.php'>Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class='container mt-4'>
    <h1 class='text-center mb-4'>¡Bienvenido, {$_SESSION['nombre']}!</h1>
    <p class='text-center'>Explora nuestra deliciosa selección de pasteles.</p>

    <div class='row'>";
        // Aquí puedes usar una conexión a la base de datos para cargar los pasteles
        require_once '../src/conexion.php';
        $conexion = Conexion::obtenerInstancia()->obtenerConexion();

        $stmt = $conexion->query("SELECT nombre, precio FROM dulces");
        $pasteles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($pasteles as $pastel) {
            echo "
            <div class='col-md-4 mb-4'>
                <div class='card'>
                    <img src='placeholder.jpg' class='card-img-top' alt='{$pastel['nombre']}' style='height: 200px; object-fit: cover;'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$pastel['nombre']}</h5>
                        <p class='card-text'>Precio: {$pastel['precio']}€</p>
                        <a href='#' class='btn btn-primary'>Añadir al carrito</a>
                    </div>
                </div>
            </div>";
        }

echo "</div>
</div>

<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>";
?>