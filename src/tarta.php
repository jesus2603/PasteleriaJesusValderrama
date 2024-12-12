<?php
require_once 'dulce.php';

class tarta extends dulce {
    private $relleno;
    private $numPisos;
    private $minNumComensales;
    private $maxNumComensales;

    public function __construct($nombre, $numero, $precio, $relleno, $numPisos, $minNumComensales = 2, $maxNumComensales = 10) {
        parent::__construct($nombre, $numero, $precio);
        $this->relleno = $relleno;
        $this->numPisos = $numPisos;
        $this->minNumComensales = $minNumComensales;
        $this->maxNumComensales = $maxNumComensales;
    }

    public function muestraComensalesPosibles() {
        if ($this->minNumComensales === $this->maxNumComensales) {
            echo "Para " . $this->minNumComensales . " comensales.<br>";
        } else {
            echo "De " . $this->minNumComensales . " a " . $this->maxNumComensales . " comensales.<br>";
        }
    }

    public function muestraResumen(): void {
        echo "Tarta: " . $this->getNombre() . ", Número: " . $this->getNumero() . ", Precio: " . $this->getPrecio() . "€, Relleno: " . implode(", ", $this->relleno) . ", Pisos: " . $this->numPisos . ".<br>";
        $this->muestraComensalesPosibles();
    }
}

?>
