<?php
// Integrantes: Delgado Roca Mauricio Félix y villarroel tarraga carlos matias
session_start();

require_once __DIR__ . "/inc/funciones.php";

$_SESSION = [];
session_destroy();

borrarCookie("cliente");
borrarCookie("tema");

header("Location: tienda.php");
exit();
