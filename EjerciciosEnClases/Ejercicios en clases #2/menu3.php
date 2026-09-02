<?php
require_once 'pizarra.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $palabra = $_POST['palabra'] ?? '';
    $color = $_POST['color'] ?? '';
    $color_fondo = $_POST['color_fondo'] ?? '';

    $pizarra = new Pizarra($palabra, $color, $color_fondo);
    $_SESSION['pizarra'] = $pizarra;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Pizarra</title>
</head>
<body>
    <h1>Opciones disponibles</h1>
    <ul>
        <li><a href="ejecutar.php?accion=triangulo">Triángulo</a></li>
    </ul>
</body>
</html>