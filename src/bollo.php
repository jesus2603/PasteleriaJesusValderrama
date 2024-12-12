<?php
require_once 'dulce.php';

class bollo extends dulce {
    
    private $relleno;

    // Constructor que inicializa las propiedades de Bollo
    public function __construct(string $nombre, float $precio, string $relleno) {
        parent::__construct($nombre, $precio);
        $this->relleno = $relleno;
    }

    // función relleno
    public function gerRelleno(): mixed {
        return $this->relleno;
}

    // Implementación del método muestraResumen
    public function muestraResumen(): void {
        echo "Bollo: " . $this->getNombre() . ", Número: " . $this->getNumero() . ", Precio: " . $this->getPrecio() . "€, Relleno: " . $this->relleno . ".<br>";
    }
}
?>