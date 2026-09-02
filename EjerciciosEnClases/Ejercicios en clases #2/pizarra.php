<?php
class Pizarra {
    public $palabra;
    public $color;
    public $color_fondo;

    public function __construct($palabra, $color, $color_fondo) {
        $this->palabra = $palabra;
        $this->color = $color;
        $this->color_fondo = $color_fondo;
    }

    public function triangulo() {
        $longitud = strlen($this->palabra);
        echo "<table border='1' style='border-collapse: collapse; text-align: center;'>";
        for ($i = 0; $i < $longitud; $i++) {
            echo "<tr>";
            for ($j = 0; $j < $longitud; $j++) {
                if ($j <= $i) {
                    $caracter = mb_substr($this->palabra, $j, 1);
                    echo "<td style='background-color: {$this->color_fondo}; color: {$this->color}; width: 30px; height: 30px;'>{$caracter}</td>";
                } else {
                    echo "<td style='width: 30px; height: 30px;'></td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
    }
}
?>