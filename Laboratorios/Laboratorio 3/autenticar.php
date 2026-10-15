<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'] ?? '';
    $clave_plana = $_POST['clave'] ?? '';
    $clave_sha1 = sha1($clave_plana);

    $sql = "SELECT id, correo, nombre, rol FROM usuarios WHERE correo = ? AND clave = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $correo, $clave_sha1);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) === 1) {
        $usuario = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
        session_start();
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['correo'] = $usuario['correo'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        header("Location: panel.php");
        exit();
    } else {
        header("Location: form_login.php?error=1");
        exit();
    }
} else {
    header("Location: form_login.php");
    exit();
}
?>