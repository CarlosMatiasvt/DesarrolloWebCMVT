<?php
require_once "conexion.php";
//Integrantes: Villarroel tarraga carlos matias y Gutierrez Torricos Adalid

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

if ($id <= 0) {
    http_response_code(404);
    echo json_encode(["exito" => false, "mensaje" => "ID no válido."], JSON_UNESCAPED_UNICODE);
    exit();
}

$sql = "SELECT p.id, p.nombre, p.precio, p.descripcion, p.imagen, p.disponible, c.nombre AS categoria
        FROM productos p
        INNER JOIN categorias c ON p.categoria_id = c.id
        WHERE p.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$fila = $resultado->fetch_assoc();
$stmt->close();

if (!$fila) {
    http_response_code(404);
    echo json_encode(["exito" => false, "mensaje" => "Producto no encontrado."], JSON_UNESCAPED_UNICODE);
    exit();
}

echo json_encode([
    "id" => (int)$fila["id"],
    "nombre" => $fila["nombre"],
    "precio" => (float)$fila["precio"],
    "descripcion" => $fila["descripcion"],
    "imagen" => $fila["imagen"],
    "disponible" => (bool)$fila["disponible"],
    "categoria" => $fila["categoria"]
], JSON_UNESCAPED_UNICODE);