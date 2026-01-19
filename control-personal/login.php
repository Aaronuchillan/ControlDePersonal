<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="login-page-body">

    <main class="login-card">
        <div class="login-header">
            <h2>¡Hola de nuevo!</h2>
            <p>Ingresa tus credenciales para continuar</p>
        </div>

        <?php if(isset($_GET['error'])): ?>
            <div class="error-banner">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <span>Usuario o contraseña incorrectos.</span>
            </div>
        <?php endif; ?>
        
        <form action="auth_process.php" method="POST" class="login-form">
            <div class="input-group">
                <input type="email" name="email" placeholder="Correo electrónico" required autocomplete="email">
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Contraseña" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn-primary">Iniciar Sesión</button>
        </form>

        <div style="margin-top: 2rem; font-size: 0.85rem; color: #999;">
            <p>Usuarios Demo: admin@ / super@ / user@ (+sistema.com)<br>Pass: admin123 / super123 / user123</p>
        </div>
    </main>

</body>
</html>