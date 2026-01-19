<?php
session_start();
require 'db.php'; // Importamos la conexión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Preparamos la consulta para buscar el email (Seguridad anti-hackeo SQL)
    $stmt = $conn->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // 2. Verificamos si existe el usuario
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // 3. Verificamos la contraseña encriptada
        if (password_verify($password, $user['password'])) {
            // LOGIN ÉXITO
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = $user['rol'];
            
            header("Location: index.php");
            exit();
        }
    }

    // Si falla algo:
    header("Location: login.php?error=1");
    exit();
}
?>