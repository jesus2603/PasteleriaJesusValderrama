<?php
require_once 'dulce.php';

class chocolate extends dulce {
    // Propiedades adicionales
    private $porcentajeCacao;
    private $peso;

    // Constructor sobrescrito
    public function __construct($nombre, $precio, $descripcion, $porcentajeCacao, $peso) {
        // Llamada al constructor de la clase padre
        parent::__construct($nombre, $precio, $descripcion);
        $this->porcentajeCacao = $porcentajeCacao;
        $this->peso = $peso;
    }

    // Getters para las propiedades adicionales
    public function getPorcentajeCacao() {
        return $this->porcentajeCacao;
    }

    public function getPeso() {
        return $this->peso;
    }

    // Método muestraResumen sobrescrito
    public function muestraResumen(): void {
        echo "Chocolate: " . $this->getNombre() . ", Número: " . $this->getNumero() . ", Precio: " . $this->getPrecio() . "€, Cacao: " . $this->porcentajeCacao . "%, Peso: " . $this->peso . "g.<br>";
    }
}

?>