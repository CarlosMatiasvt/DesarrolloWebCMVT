<?php
// Integrantes: Villarroel tarraga carlos matias y Delgado Roca Mauricio Félix

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

    public function getCodigo() { return $this->codigo; }
    public function getNombre() { return $this->nombre; }
    public function getCategoria() { return $this->categoria; }
    public function getPrecio() { return $this->precio; }
    public function getStock() { return $this->stock; }

    public function getPrecioConDescuento($porcentaje = 10) {
        return round($this->precio * (1 - $porcentaje / 100), 2);
    }

    public function hayStock() {
        return $this->stock > 0;
    }

    public function mostrarTarjeta() {
        $codigo = htmlspecialchars($this->codigo);
        $nombre = htmlspecialchars($this->nombre);
        $categoria = htmlspecialchars($this->categoria);

        $html = '<div class="tarjeta">';
        $html .= '<div class="cabecera-tarjeta">' . $nombre . '</div>';
        $html .= '<div class="cuerpo-tarjeta">';
        $html .= '<span class="categoria">' . $categoria . '</span>';
        $html .= '<p><strong>Código:</strong> ' . $codigo . '</p>';
        $html .= '<p class="precio">$' . number_format($this->precio, 2) . '</p>';
        $html .= '<p class="descuento">Con 10% de descuento: $' .
                 number_format($this->getPrecioConDescuento(), 2) . '</p>';
        $html .= '<p><strong>Stock:</strong> ' . $this->stock . '</p>';
        $html .= '</div></div>';

        return $html;
    }
}
