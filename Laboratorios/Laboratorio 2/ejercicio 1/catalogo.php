<?php
require_once "Producto.php";

function obtenerCatalogo() {
    return [
        new Producto("P01", "Teclado mecanico RGB", "Perifericos", 320.00, 12),
        new Producto("P02", "Mouse inalambrico", "Perifericos", 145.50, 8),
        new Producto("P03", "Monitor 24 pulgadas", "Pantallas", 1250.00, 5),
        new Producto("P04", "Monitor curvo 27 pulg.", "Pantallas", 2100.00, 0),
        new Producto("P05", "Disco solido 480 GB", "Almacenamiento", 380.00, 20),
        new Producto("P06", "Memoria USB 64 GB", "Almacenamiento", 75.00, 35),
        new Producto("P07", "Audifonos con microfono", "Perifericos", 210.00, 0),
        new Producto("P08", "Disco externo 1 TB", "Almacenamiento", 640.00, 6)
    ];
}

function obtenerCategorias() {
    return [
        "Perifericos" => "Perifericos",
        "Pantallas" => "Pantallas",
        "Almacenamiento" => "Almacenamiento"
    ];
}

function filtrarPorCategoria(array $productos, $categoria) {
    if (empty($categoria)) {
        return $productos;
    }

    $filtrados = [];
    foreach ($productos as $p) {
        if ($p->getCategoria() == $categoria) {
            $filtrados[] = $p;
        }
    }
    return $filtrados;
}

function estadisticas(array $productos) {
    if (empty($productos)) {
        return [
            'total' => 0,
            'stock' => 0,
            'promedio' => 0,
            'mayor' => 0,
            'menor' => 0
        ];
    }

    $precios = array_map(function($p) { return $p->getPrecio(); }, $productos);
    $stocks = array_map(function($p) { return $p->getStock(); }, $productos);

    return [
        'total' => count($productos),
        'stock' => array_sum($stocks),
        'promedio' => array_sum($precios) / count($precios),
        'mayor' => max($precios),
        'menor' => min($precios)
    ];
}

function contarPorCategoria(array $productos) {
    $conteo = [];
    foreach ($productos as $p) {
        $cat = $p->getCategoria();
        $conteo[$cat] = ($conteo[$cat] ?? 0) + 1;
    }
    return $conteo;
}