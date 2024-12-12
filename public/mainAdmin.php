<?php
session_start();
include_once '../src/conexion.php';
require_once '../src/Cliente.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fef4f1;
        }
        .header {
            background-color: #f6b8b8;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            font-family: 'Arial', sans-serif;
            color: #4b4b4b;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }
        .btn-logout {
            background-color: #f7a4a4;
            color: white;
        }
        .btn-logout:hover {
            background-color: #f67979;
        }
        .table th {
            background-color: #f4c2c2;
            color: #4b4b4b;
        }
        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9e6e6;
        }
        .table td, .table th {
            text-align: center;
        }
        .text-muted {
            color: #d1c9c9;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Header -->
        <div class="header text-center">
            <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h1>
            <div class="text-end">
                <a href="logout.php" class="btn btn-logout">Cerrar sesión</a>
            </div>
        </div>

        

        <!-- Agregar Dulce -->
        <h2 class="mt-4 text-center text-secondary">Agregar un Dulce</h2>
        <form action="admin_panel.php" method="POST" class="mb-4">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Dulce</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio del Dulce</label>
                <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
            </div>
            <button type="submit" name="agregar" class="btn btn-primary">Agregar Dulce</button>
        </form>

        <?php
        // Conexión a la base de datos
        $conexion = Conexion::obtenerInstancia()->obtenerConexion();

        // Agregar un dulce
        if (isset($_POST['agregar'])) {
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $stmt = $conexion->prepare("INSERT INTO dulces (nombre, precio) VALUES (:nombre, :precio)");
            $stmt->execute([':nombre' => $nombre, ':precio' => $precio]);
            echo "<p class='text-success'>Dulce agregado correctamente.</p>";
        }

        // Eliminar un dulce
        if (isset($_GET['eliminar'])) {
            $id = $_GET['eliminar'];
            $stmt = $conexion->prepare("DELETE FROM dulces WHERE id = :id");
            $stmt->execute([':id' => $id]);
            echo "<p class='text-danger'>Dulce eliminado correctamente.</p>";
        }

        // Editar precio de un dulce
        if (isset($_POST['editar'])) {
            $id = $_POST['id'];
            $nuevoPrecio = $_POST['nuevo_precio'];
            $stmt = $conexion->prepare("UPDATE dulces SET precio = :precio WHERE id = :id");
            $stmt->execute([':precio' => $nuevoPrecio, ':id' => $id]);
            echo "<p class='text-success'>Precio actualizado correctamente.</p>";
        }

        // Listar Dulces
        $stmtDulces = $conexion->query("SELECT id, nombre, precio FROM dulces");
        $dulces = $stmtDulces->fetchAll(PDO::FETCH_ASSOC);

        if ($dulces) {
            echo '<h2 class="mt-4 text-center text-secondary">Listado de Dulces</h2>';
            echo '<table class="table table-striped">';
            echo '<thead><tr><th>Nombre</th><th>Precio</th><th>Acciones</th></tr></thead><tbody>';
            foreach ($dulces as $dulce) {
                echo "<tr><td>" . htmlspecialchars($dulce['nombre']) . "</td><td>" . number_format($dulce['precio'], 2) . " €</td>";
                echo "<td>
                    <a href='#' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editarModal' data-id='" . $dulce['id'] . "' data-precio='" . $dulce['precio'] . "'>Editar Precio</a>
                    <a href='?eliminar=" . $dulce['id'] . "' class='btn btn-danger btn-sm'>Eliminar</a>
                </td></tr>";
            }
            echo '</tbody></table>';
        } else {
            echo '<p class="text-muted">No hay dulces registrados.</p>';
        }
        ?>

        <!-- Modal para Editar Precio -->
        <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="admin_panel.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarModalLabel">Editar Precio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id" name="id">
                            <div class="mb-3">
                                <label for="nuevo_precio" class="form-label">Nuevo Precio</label>
                                <input type="number" class="form-control" id="nuevo_precio" name="nuevo_precio" step="0.01" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" name="editar" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Llenar el formulario del modal con los datos del dulce a editar
        const editarModal = document.getElementById('editarModal');
        editarModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const precio = button.getAttribute('data-precio');
            const modalTitle = editarModal.querySelector('.modal-title');
            const idInput = editarModal.querySelector('#id');
            const precioInput = editarModal.querySelector('#nuevo_precio');

            modalTitle.textContent = 'Editar Precio del Dulce';
            idInput.value = id;
            precioInput.value = precio;
        });
    </script>
</body>
</html>