<?php
//Integrantes: Villarroel tarraga carlos matias y Gutierrez Torricos Adalid

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["exito" => false, "mensaje" => "Método no permitido."], JSON_UNESCAPED_UNICODE);
    exit();
}

$id = isset($_POST["id"]) ? (int)$_POST["id"] : 0;

$stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$afectadas = $stmt->affected_rows;
$stmt->close();

if ($afectadas === 0) {
    http_response_code(404);
    echo json_encode(["exito" => false, "mensaje" => "El producto no existe."], JSON_UNESCAPED_UNICODE);
    exit();
}

echo json_encode(["exito" => true, "mensaje" => "Producto eliminado correctamente."], JSON_UNESCAPED_UNICODE);