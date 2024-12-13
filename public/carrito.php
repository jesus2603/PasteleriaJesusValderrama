<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
} elseif ($_SESSION['usuario'] == "admin") {
    header('Location: mainAdmin.php');
    exit;
}

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Manejar las acciones del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? 0;

    if ($action === 'add' && $nombre) {
        if (isset($_SESSION['carrito'][$nombre])) {
            // Incrementar la cantidad si ya existe
            $_SESSION['carrito'][$nombre]['cantidad']++;
        } else {
            // Agregar un nuevo producto
            $_SESSION['carrito'][$nombre] = [
                'precio' => $precio,
                'cantidad' => 1,
            ];
        }
    } elseif ($action === 'remove' && $nombre) {
        // Eliminar producto del carrito
        unset($_SESSION['carrito'][$nombre]);
    } elseif ($action === 'update' && $nombre) {
        $cantidad = (int) ($_POST['cantidad'] ?? 1);
        if ($cantidad > 0) {
            $_SESSION['carrito'][$nombre]['cantidad'] = $cantidad;
        } else {
            unset($_SESSION['carrito'][$nombre]);
        }
    }
}

// Calcular el total del carrito
$total = 0;
foreach ($_SESSION['carrito'] as $producto) {
    $total += $producto['precio'] * $producto['cantidad'];
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="main.php">Pastelería</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h1 class="text-center">Carrito de Compras</h1>
    <?php if (!empty($_SESSION['carrito'])): ?>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['carrito'] as $nombre => $producto): ?>
                    <tr>
                        <td><?= htmlspecialchars($nombre) ?></td>
                        <td><?= number_format($producto['precio'], 2) ?>€</td>
                        <td>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="nombre" value="<?= htmlspecialchars($nombre) ?>">
                                <input type="number" name="cantidad" value="<?= $producto['cantidad'] ?>" min="1" class="form-control d-inline" style="width: 70px;">
                                <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                            </form>
                        </td>
                        <td><?= number_format($producto['precio'] * $producto['cantidad'], 2) ?>€</td>
                        <td>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="nombre" value="<?= htmlspecialchars($nombre) ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3 class="text-end">Total: <?= number_format($total, 2) ?>€</h3>
    <?php else: ?>
        <p class="text-center">Tu carrito está vacío.</p>
    <?php endif; ?>
    <div class="text-center mt-4">
        <a href="main.php" class="btn btn-secondary">Volver a la tienda</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>