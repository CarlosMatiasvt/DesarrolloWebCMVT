<?php
require_once "conexion.php";
//Integrantes: Villarroel tarraga carlos matias y Gutierrez Torricos Adalid

$buscar = isset($_GET["buscar"]) ? trim($_GET["buscar"]) : "";
$categoria = isset($_GET["categoria"]) ? (int)$_GET["categoria"] : 0;

$like = "%" . $buscar . "%";

$sql = "SELECT p.id, p.nombre, p.precio, p.imagen, p.disponible, c.nombre AS categoria
        FROM productos p
        INNER JOIN categorias c ON p.categoria_id = c.id
        WHERE p.nombre LIKE ? AND (? = 0 OR p.categoria_id = ?)
        ORDER BY p.id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $like, $categoria, $categoria);
$stmt->execute();
$resultado = $stmt->get_result();

$productos = [];
while ($fila = $resultado->fetch_assoc()) {
    $productos[] = [
        "id" => (int)$fila["id"],
        "nombre" => $fila["nombre"],
        "precio" => (float)$fila["precio"],
        "imagen" => $fila["imagen"],
        "disponible" => (bool)$fila["disponible"],
        "categoria" => $fila["categoria"]
    ];
}

$stmt->close();
echo json_encode($productos, JSON_UNESCAPED_UNICODE);