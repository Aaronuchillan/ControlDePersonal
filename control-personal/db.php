<?php
// db.php
$host = "127.0.0.1"; // Usar la IP a veces es más estable que 'localhost'
$user = "root";
$pass = "";
$db   = "control_personal_db";
$port = 3308; // <--- MIRA TU XAMPP, si dice 3308, cámbialo aquí a 3308

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
} 
// echo "✅ Conexión exitosa"; // Descomenta esta línea para probar si conecta
?>