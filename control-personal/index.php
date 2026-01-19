<?php
session_start();
// Si no hay sesión, mandarlo al login
if (!isset($_SESSION['user_role'])) {
    header("Location: login.php");
    exit();
}
$role = $_SESSION['user_role'];
$userName = $_SESSION['user_name'] ?? 'Usuario';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Personal</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo-area">
                <div style="width:20px; height:20px; background:#4F1FFF; border-radius:50%;"></div>
                ControlApp
            </div>
            <nav>
                <a href="#" class="nav-link active">Personal</a>
                <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="top-bar">
                <h2>Gestión de Personal</h2>
                <div class="user-badge">Hola, <span><?php echo $userName; ?></span> (<?php echo $role; ?>)</div>
            </header>

            <?php if($role === 'ADMIN' || $role === 'SUPERVISOR'): ?>
                <button id="btn-add-person" class="btn-primary" style="margin-bottom: 20px;">
                    + Añadir Personal
                </button>
            <?php endif; ?>

            <div class="card-widget">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Domicilio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="lista-personal-body">
                            </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div id="modal-personal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h3 id="modal-title">Registrar Personal</h3>
            <form id="form-personal">
                <input type="hidden" name="id" id="form-id">
                <input type="hidden" name="accion" id="form-accion" value="crear">
                
                <div class="input-group">
                    <input type="text" name="nombre" id="form-nombre" placeholder="Nombres" required>
                </div>
                <div class="input-group">
                    <input type="text" name="apellido" id="form-apellido" placeholder="Apellidos" required>
                </div>
                <div class="input-group">
                    <input type="text" name="telefono" id="form-telefono" placeholder="Teléfono">
                </div>
                <div class="input-group">
                    <textarea name="domicilio" id="form-domicilio" placeholder="Domicilio"></textarea>
                </div>
                <div class="input-group">
                    <label>Foto:</label>
                    <input type="file" name="foto" id="form-foto" accept="image/*">
                </div>
                <button type="submit" class="btn-primary" style="width:100%">Guardar</button>
            </form>
        </div>
    </div>

    <div id="session-data" data-role="<?php echo $role; ?>"></div>
    <script type="module" src="js/main.js"></script>
</body>
</html>