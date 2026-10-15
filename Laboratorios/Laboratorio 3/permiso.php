<?php
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    $_SESSION["mensaje_error"] = "Su rol ({$_SESSION['rol']}) no tiene permiso para realizar esa acción.";
    header("Location: listar.php");
    exit();
}
?>