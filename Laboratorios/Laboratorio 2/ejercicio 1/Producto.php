<?php
class Producto {
    private $codigo;
    private $nombre;
    private $categoria;
    private $precio;
    private $stock;

    public function __construct($codigo, $nombre, $categoria, $precio, $stock) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->categoria = $categoria;
        $this->precio = $precio;
        $this->stock = $stock;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getPrecioConDescuento($porcentaje = 10) {
        $descuento = $this->precio * ($porcentaje / 100);
        return round($this->precio - $descuento, 2);
    }

    public function hayStock() {
        return $this->stock > 0;
    }

    public function mostrarTarjeta() {
        $estadoStock = "";
        if ($this->hayStock()) {
            $estadoStock = "<p>Stock disponible: " . $this->stock . " unidades</p>";
        } else {
            $estadoStock = "<p class='agotado'>AGOTADO</p>";
        }

        return "
            <div class='tarjeta'>
                <div class='cabecera-tarjeta'>
                    <h3>" . htmlspecialchars($this->codigo) . "</h3>
                </div>
                <div class='cuerpo-tarjeta'>
                    <span class='categoria'>" . htmlspecialchars(strtoupper($this->categoria)) . "</span>
                    <h4>" . htmlspecialchars($this->nombre) . "</h4>
                    <p class='precio'>Bs " . number_format($this->precio, 2) . "</p>
                    <p class='descuento'>Con 10% de descuento: Bs " . number_format($this->getPrecioConDescuento(10), 2) . "</p>
                    " . $estadoStock . "
                </div>
            </div>
        ";
    }
}