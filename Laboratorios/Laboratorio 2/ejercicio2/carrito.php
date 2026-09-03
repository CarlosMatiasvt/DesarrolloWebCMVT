<?php
// Integrantes: Villarroel tarraga carlos matias y Delgado Roca Mauricio Félix
session_start();

require_once __DIR__ . "/inc/Producto.php";
require_once __DIR__ . "/inc/Carrito.php";
require_once __DIR__ . "/inc/catalogo.php";
require_once __DIR__ . "/inc/funciones.php";

if (!isset($_COOKIE["cliente"])) {
    header("Location: tienda.php");
    exit();
}

$carrito = obtenerCarrito();
$catalogo = obtenerCatalogo();

if (isset($_GET["quitar"])) {
    $carrito->quitar($_GET["quitar"]);
    guardarCarrito($carrito);
    header("Location: carrito.php");
    exit();
}

if (isset($_GET["vaciar"])) {
    $carrito->vaciar();
    guardarCarrito($carrito);
    header("Location: carrito.php");
    exit();
}

$tema = obtenerTema();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito - TecnoStore USFX</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="<?php echo htmlspecialchars($tema); ?>">
<h1>Carrito de compras</h1>
<p>Cliente: <strong><?php echo htmlspecialchars($_COOKIE["cliente"]); ?></strong></p>

<p><a href="tienda.php">Volver a la tienda</a> | <a href="salir.php">Salir</a></p>

<?php if ($carrito->estaVacio()): ?>
    <p>El carrito está vacío.</p>
<?php else: ?>
    <table>
        <tr>
            <th>Código</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($carrito->getItems() as $codigo => $cantidad): ?>
            <?php $producto = buscarProducto($catalogo, $codigo); ?>
            <?php if ($producto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto->getCodigo()); ?></td>
                    <td><?php echo htmlspecialchars($producto->getNombre()); ?></td>
                    <td>$<?php echo number_format($producto->getPrecio(), 2); ?></td>
                    <td><?php echo (int)$cantidad; ?></td>
                    <td>$<?php echo number_format($producto->getPrecio() * $cantidad, 2); ?></td>
                    <td><a href="carrito.php?quitar=<?php echo urlencode($codigo); ?>">Quitar</a></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>

    <h2>Total: $<?php echo number_format($carrito->total($catalogo), 2); ?></h2>
    <p>
        Cantidad total de productos: <?php echo $carrito->cantidadTotal(); ?> |
        <a href="carrito.php?vaciar=1">Vaciar carrito</a>
    </p>
<?php endif; ?>

<h2>Comprobación de sesión y cookies</h2>
<p><strong>session_id():</strong> <?php echo htmlspecialchars(session_id()); ?></p>
<h3>$_SESSION</h3>
<pre><?php print_r($_SESSION); ?></pre>
<h3>$_COOKIE</h3>
<pre><?php print_r($_COOKIE); ?></pre>
</body>
</html>
