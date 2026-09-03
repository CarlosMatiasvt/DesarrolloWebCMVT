<?php
// Integrantes: Delgado Roca Mauricio Félix y villarroel tarraga carlos matias
session_start();

require_once __DIR__ . "/inc/Producto.php";
require_once __DIR__ . "/inc/Carrito.php";
require_once __DIR__ . "/inc/catalogo.php";
require_once __DIR__ . "/inc/funciones.php";

if (!isset($_COOKIE["cliente"])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombre = trim($_POST["nombre"] ?? "");

        if ($nombre !== "") {
            guardarCookie("cliente", $nombre, 7 * 24 * 60 * 60);
            header("Location: tienda.php");
            exit();
        }
    }
}

if (isset($_GET["tema"])) {
    $tema = $_GET["tema"] === "oscuro" ? "oscuro" : "claro";
    guardarCookie("tema", $tema, 30 * 24 * 60 * 60);
    header("Location: tienda.php");
    exit();
}

if (!isset($_SESSION["visita_registrada"])) {
    $_SESSION["visita_registrada"] = true;
    $visitas = isset($_COOKIE["visitas"]) ? (int)$_COOKIE["visitas"] + 1 : 1;
    guardarCookie("visitas", $visitas, 30 * 24 * 60 * 60);
}

if (isset($_POST["accion"]) && $_POST["accion"] === "agregar" && isset($_COOKIE["cliente"])) {
    $carrito = obtenerCarrito();
    $codigo = $_POST["codigo"] ?? "";
    $cantidad = $_POST["cantidad"] ?? 1;
    $producto = buscarProducto(obtenerCatalogo(), $codigo);

    if ($producto && $producto->hayStock()) {
        $carrito->agregar($codigo, min((int)$cantidad, $producto->getStock()));
        guardarCarrito($carrito);
        $_SESSION["mensaje"] = "Producto agregado al carrito.";
    }

    header("Location: tienda.php");
    exit();
}

$catalogo = obtenerCatalogo();
$tema = obtenerTema();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TecnoStore USFX - Tienda</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="<?php echo htmlspecialchars($tema); ?>">
<?php if (!isset($_COOKIE["cliente"])): ?>
    <h1>TecnoStore USFX</h1>
    <h2>Identificación del cliente</h2>
    <p>Ingrese su nombre para continuar.</p>
    <form method="post">
        <input type="text" name="nombre" required>
        <button type="submit">Ingresar</button>
    </form>
<?php else: ?>
    <h1>TecnoStore USFX</h1>
    <p>
        Hola <strong><?php echo htmlspecialchars($_COOKIE["cliente"]); ?></strong>.
        Número de visita: <strong><?php echo (int)($_COOKIE["visitas"] ?? 1); ?></strong>
    </p>

    <p>
        <a href="tienda.php?tema=<?php echo $tema === "claro" ? "oscuro" : "claro"; ?>">
            Tema <?php echo $tema === "claro" ? "oscuro" : "claro"; ?>
        </a> |
        <a href="carrito.php">Ver carrito</a> |
        <a href="salir.php">Salir</a>
    </p>

    <?php if (isset($_SESSION["mensaje"])): ?>
        <p class="resaltado"><?php echo htmlspecialchars($_SESSION["mensaje"]); ?></p>
        <?php unset($_SESSION["mensaje"]); ?>
    <?php endif; ?>

    <h2>Catálogo</h2>
    <div class="galeria">
        <?php foreach ($catalogo as $p): ?>
            <div>
                <?php echo $p->mostrarTarjeta(); ?>
                <?php if ($p->hayStock()): ?>
                    <form method="post">
                        <input type="hidden" name="accion" value="agregar">
                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($p->getCodigo()); ?>">
                        <label>Cantidad:
                            <input type="number" name="cantidad" value="1" min="1" max="<?php echo $p->getStock(); ?>">
                        </label>
                        <button type="submit">Agregar</button>
                    </form>
                <?php else: ?>
                    <span class="agotado">Agotado</span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
</body>
</html>
