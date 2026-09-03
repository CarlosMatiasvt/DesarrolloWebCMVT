<?php
// Integrantes: Villarroel tarraga carlos matias y Delgado Roca Mauricio Félix

function guardarCookie($nombre, $valor, $duracion) {
    setcookie($nombre, $valor, time() + $duracion, "/");
}

function borrarCookie($nombre) {
    setcookie($nombre, "", time() - 3600, "/");
}

function obtenerTema() {
    return (isset($_COOKIE["tema"]) && $_COOKIE["tema"] === "oscuro")
        ? "oscuro"
        : "claro";
}

function obtenerCarrito() {
    if (isset($_SESSION["carrito"])) {
        $carrito = unserialize($_SESSION["carrito"]);
        if ($carrito instanceof Carrito) {
            return $carrito;
        }
    }
    return new Carrito();
}

function guardarCarrito(Carrito $carrito) {
    $_SESSION["carrito"] = serialize($carrito);
}
