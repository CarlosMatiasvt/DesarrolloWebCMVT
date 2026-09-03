<?php
require_once "catalogo.php";

$catalogoCompleto = obtenerCatalogo();
$categoriasDisponibles = obtenerCategorias();

$catSeleccionada = $_GET["categoria"] ?? "";
if (!array_key_exists($catSeleccionada, $categoriasDisponibles)) {
    $catSeleccionada = ""; 
}

$productosMostrar = filtrarPorCategoria($catalogoCompleto, $catSeleccionada);
$stats = estadisticas($productosMostrar);
$totalCategoriasGlobal = count(obtenerCategorias());
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TecnoStore USFX - Catalogo</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

    <h1>TecnoStore USFX - Catalogo</h1>

    <h2>1. Filtro de productos</h2>
    <form method="get" action="index.php">
        <label for="categoria">Categoria:</label>
        <select name="categoria" id="categoria">
            <option value="">-- Todas las categorias --</option>
            <?php foreach ($categoriasDisponibles as $valor => $texto): ?>
                <option value="<?= htmlspecialchars($valor) ?>" <?= ($catSeleccionada == $valor) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($texto) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrar</button>
    </form>
    <p>URL generada: <code><?= htmlspecialchars($_SERVER['REQUEST_URI']) ?></code></p>

    <h2>2. Productos (<?= count($productosMostrar) ?> encontrados)</h2>
    
    <?php if (empty($productosMostrar)): ?>
        <p>No se encontraron productos en esta categoria.</p>
    <?php else: ?>
        <div class="galeria">
            <?php foreach ($productosMostrar as $p): ?>
                <?= $p->mostrarTarjeta() ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <h2>3. Resumen calculado con funciones de arreglo</h2>
    <h3>Estadisticas de los productos mostrados</h3>
    
    <table>
        <thead>
            <tr>
                <th>INDICADOR</th>
                <th>VALOR</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Productos listados</td>
                <td><?= $stats['total'] ?></td>
            </tr>
            <tr>
                <td>Unidades en stock</td>
                <td><?= $stats['stock'] ?></td>
            </tr>
            <tr>
                <td>Precio promedio</td>
                <td>Bs <?= number_format($stats['promedio'], 2) ?></td>
            </tr>
            <tr>
                <td>Precio mas alto</td>
                <td>Bs <?= number_format($stats['mayor'], 2) ?></td>
            </tr>
            <tr>
                <td>Precio mas bajo</td>
                <td>Bs <?= number_format($stats['menor'], 2) ?></td>
            </tr>
            <tr class="resaltado">
                <td>Categorias del catalogo completo</td>
                <td><?= $totalCategoriasGlobal ?></td>
            </tr>
        </tbody>
    </table>

    <h3>Contenido del arreglo $_GET</h3>
    <pre><?php print_r($_GET); ?></pre>

</body>
</html>