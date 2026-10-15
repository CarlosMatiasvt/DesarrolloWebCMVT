<?php
require_once "proteger.php";
require_once "conexion.php";

$res_pacientes = mysqli_query($conn, "SELECT COUNT(*) FROM pacientes");
$fila_pacientes = mysqli_fetch_row($res_pacientes);
$total_pacientes = $fila_pacientes[0];

$res_medicos = mysqli_query($conn, "SELECT COUNT(*) FROM medicos");
$fila_medicos = mysqli_fetch_row($res_medicos);
$total_medicos = $fila_medicos[0];

$res_citas = mysqli_query($conn, "SELECT COUNT(*) FROM citas WHERE estado = 'pendiente'");
$fila_citas = mysqli_fetch_row($res_citas);
$total_citas_pendientes = $fila_citas[0];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel - Consultorio USFX</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <?php include "menu.php"; ?>

    <div class="contenedor">
        <h2>Bienvenido/a, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
        
        <div class="panel">
            <p><strong>Correo:</strong> <?php echo htmlspecialchars($_SESSION['correo']); ?> | <strong>Rol:</strong> <span class="etiqueta <?php echo ($_SESSION['rol'] === 'admin') ? 'et-admin' : 'et-user'; ?>"><?php echo strtoupper(htmlspecialchars($_SESSION['rol'])); ?></span></p>
            <p style="margin: 4px 0 0; font-size: 12px; color: #5a6a7e;">Identificador de la sesión: <?php echo session_id(); ?></p>
        </div>

        <h3>Resumen del consultorio</h3>
        <div class="tarjetas">
            <div class="tarjeta">
                <div class="numero"><?php echo $total_pacientes; ?></div>
                <div class="texto">Pacientes registrados</div>
            </div>
            <div class="tarjeta">
                <div class="numero"><?php echo $total_medicos; ?></div>
                <div class="texto">Médicos</div>
            </div>
            <div class="tarjeta">
                <div class="numero"><?php echo $total_citas_pendientes; ?></div>
                <div class="texto">Citas pendientes</div>
            </div>
        </div>
    </div>

    <footer class="pie">
        SIS 256 - Tecnología y Desarrollo Web - Ing. Carlos David Montellano Barriga
    </footer>
</body>
</html>