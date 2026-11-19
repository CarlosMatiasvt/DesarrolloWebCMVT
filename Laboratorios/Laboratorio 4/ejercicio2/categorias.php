<?php
//Integrantes: Villarroel tarraga carlos matias y Gutierrez Torricos Adalid
require_once "conexion.php";

$sql = "SELECT id, nombre FROM categorias ORDER BY id ASC";
$resultado = $conn->query($sql);

$categorias = [];
while ($fila = $resultado->fetch_assoc()) {
    $categorias[] = [
        "id" => (int)$fila["id"],
        "nombre" => $fila["nombre"]
    ];
}

echo json_encode($categorias, JSON_UNESCAPED_UNICODE);
?>
