<?php
// Integrantes: Villarroel tarraga carlos matias y Delgado Roca Mauricio Félix
require_once "Producto.php";

function obtenerCatalogo() {
    return [
        new Producto("P001", "Laptop Lenovo", "Computadoras", 5200, 5),
        new Producto("P002", "Mouse Logitech", "Perifericos", 120, 12),
        new Producto("P003", "Teclado Redragon", "Perifericos", 280, 8),
        new Producto("P004", "Monitor Samsung", "Monitores", 1450, 4),
        new Producto("P005", "SSD 1TB", "Almacenamiento", 650, 0),
        new Producto("P006", "Disco Duro 2TB", "Almacenamiento", 590, 6),
        new Producto("P007", "Memoria RAM 16GB", "Componentes", 480, 7),
        new Producto("P008", "Tarjeta Grafica", "Componentes", 3200, 0)
    ];
}

function buscarProducto(array $catalogo, $codigo) {
    foreach ($catalogo as $producto) {
        if ($producto->getCodigo() === $codigo) {
            return $producto;
        }
    }
    return null;
}
