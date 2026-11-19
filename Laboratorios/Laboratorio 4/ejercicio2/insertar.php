<?php
require_once "conexion.php";
//Integrantes: Villarroel tarraga carlos matias y Gutierrez Torricos Adalid

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["exito" => false, "mensaje" => "Método no permitido."], JSON_UNESCAPED_UNICODE);
    exit();
}

$nombre = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : "";
$categoria_id = isset($_POST["categoria_id"]) ? (int)$_POST["categoria_id"] : 0;
$precio = isset($_POST["precio"]) ? (float)$_POST["precio"] : 0;
$descripcion = isset($_POST["descripcion"]) ? trim($_POST["descripcion"]) : "";
$disponible = isset($_POST["disponible"]) ? (int)$_POST["disponible"] : 1;

$errores = [];

if (mb_strlen($nombre) < 3) {
    $errores[] = "El nombre debe tener al menos 3 caracteres.";
}
if ($categoria_id <= 0) {
    $errores[] = "Seleccione una categoría válida.";
}
if ($precio <= 0) {
    $errores[] = "El precio debe ser mayor a cero.";
}

$nombreImagen = "";
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
        $permitidas = ["jpg", "jpeg", "png", "webp"];
        if (in_array($ext, $permitidas, true) && $_FILES["imagen"]["size"] <= 2 * 1024 * 1024) {
            $nombreImagen = uniqid("prod_") . "." . $ext;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], "../images/" . $nombreImagen);
        } else {
            $errores[] = "Imagen no válida o mayor a 2 MB.";
        }
    }
}

if (count($errores) > 0) {
    http_response_code(422);
    echo json_encode(["exito" => false, "errores" => $errores], JSON_UNESCAPED_UNICODE);
    exit();
}

$sql = "INSERT INTO productos (nombre, categoria_id, precio, descripcion, imagen, disponible) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sidssi", $nombre, $categoria_id, $precio, $descripcion, $nombreImagen, $disponible);
$stmt->execute();
$nuevoId = (int)$stmt->insert_id;
$stmt->close();

http_response_code(201);
echo json_encode(["exito" => true, "id" => $nuevoId, "mensaje" => "Producto registrado correctamente."], JSON_UNESCAPED_UNICODE);