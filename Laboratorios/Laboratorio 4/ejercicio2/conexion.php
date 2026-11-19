<?php
//Integrantes: Villarroel tarraga carlos matias y Gutierrez Torricos Adalid

$servidor = "localhost";
$usuario  = "root";
$clave    = "";
$bd       = "bd_cafeteria26";
$puerto   = 3306;

$conn = new mysqli($servidor, $usuario,$clave, $bd,$puerto);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["exito" => false, "mensaje" => "Error de conexión: " . $conn->connect_error], JSON_UNESCAPED_UNICODE);
    exit();
}

$conn->set_charset("utf8mb4");