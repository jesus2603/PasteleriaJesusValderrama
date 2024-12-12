<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h2 class="text-center">Iniciar Sesión</h2>
                <form action="register.php" method="POST" class="p-3 border rounded bg-white shadow">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password2" class="form-label">Vuelva a repetir la contraseña</label>
                        <input type="password" class="form-control" id="password2" required="password" name="password2" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>

                </form>
                
            </div>
        </div>
    </div>
</body>
</html>
