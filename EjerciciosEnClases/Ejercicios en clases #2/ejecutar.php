<?php
require_once 'pizarra.php';
session_start();

if (isset($_SESSION['pizarra']) && isset($_GET['accion'])) {
    $pizarra = $_SESSION['pizarra'];
    
    if ($_GET['accion'] === 'triangulo') {
        $pizarra->triangulo();
    }
} else {
    echo "No existe una instancia de Pizarra en sesión.";
}
?>