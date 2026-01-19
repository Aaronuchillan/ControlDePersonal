<?php
session_start();
require 'db.php';

// Verificación de seguridad básica
if (!isset($_SESSION['user_role'])) {
    die(json_encode(['status' => 'error', 'msg' => 'No autorizado']));
}

$role = $_SESSION['user_role'];
$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

switch ($accion) {
    case 'crear':
        // Supervisor y Admin pueden crear
        if ($role === 'ADMIN' || $role === 'SUPERVISOR') {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $tel = $_POST['telefono'];
            $dir = $_POST['domicilio'];
            $fotoNombre = 'default.png';

            // Manejo de la imagen
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $fotoNombre = time() . "_" . $nombre . "." . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $fotoNombre);
            }

            $stmt = $conn->prepare("INSERT INTO personal (nombre, apellido, telefono, domicilio, foto, creado_por) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $nombre, $apellido, $tel, $dir, $fotoNombre, $_SESSION['user_id']);
            $stmt->execute();
            echo json_encode(['status' => 'success', 'msg' => 'Personal añadido']);
        }
        break;

    case 'eliminar':
        // EXCLUSIVO del Admin
        if ($role === 'ADMIN') {
            $id = $_GET['id'];
            // Primero buscamos la foto para borrarla del servidor
            $res = $conn->query("SELECT foto FROM personal WHERE id = $id");
            $p = $res->fetch_assoc();
            if ($p['foto'] !== 'default.png') unlink("uploads/" . $p['foto']);

            $conn->query("DELETE FROM personal WHERE id = $id");
            echo json_encode(['status' => 'success', 'msg' => 'Eliminado correctamente']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Solo el Admin puede eliminar']);
        }
        break;

    case 'leer':
        // Todos pueden ver
        $res = $conn->query("SELECT * FROM personal ORDER BY id DESC");
        $data = [];
        while($row = $res->fetch_assoc()) $data[] = $row;
        echo json_encode($data);
        break;
    
    case 'actualizar':
        if ($role === 'ADMIN' || $role === 'SUPERVISOR') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $tel = $_POST['telefono'];
            $dir = $_POST['domicilio'];

            // Si suben una foto nueva, la actualizamos
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $fotoNombre = time() . "_" . $nombre . "." . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $fotoNombre);
                
                // SQL con foto nueva
                $stmt = $conn->prepare("UPDATE personal SET nombre=?, apellido=?, telefono=?, domicilio=?, foto=? WHERE id=?");
                $stmt->bind_param("sssssi", $nombre, $apellido, $tel, $dir, $fotoNombre, $id);
            } else {
                // SQL sin cambiar la foto actual
                $stmt = $conn->prepare("UPDATE personal SET nombre=?, apellido=?, telefono=?, domicilio=? WHERE id=?");
                $stmt->bind_param("ssssi", $nombre, $apellido, $tel, $dir, $id);
            }
            $stmt->execute();
            echo json_encode(['status' => 'success', 'msg' => 'Datos actualizados']);
        }
        break;
}