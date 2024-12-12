<?php

require_once 'Resumible.php';

abstract class Dulce {
    private $nombre;
    private $numero;
    private $precio;
    private static $IVA = 0.21;

    public function __construct($nombre, $numero, $precio) {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->precio = $precio;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public static function getIVA() {
        return self::$IVA;
    }

    public function getPrecioConIVA() {
        return $this->precio * (1 + self::$IVA);
    }

    // Método abstracto de Resumible (debe implementarse en los hijos)
    public abstract function muestraResumen(): void;

    /**
     * Hacer Dulce abstracto nos asegura que esta clase no puede instanciarse directamente.
     * Esto nos obliga a usar clases específicas como Bollo, Tarta o Chocolate, haciendo
     * el diseño más organizado y limitando la creación de objetos genéricos.
     */

    
     /**
 * La clase Dulce implementa el interfaz Resumible, lo que obliga a que todas las clases hijas (Bollo, Tarta, Chocolate)
 * implementen el método muestraResumen(). 
 * Sin embargo, no es necesario que cada hijo implemente directamente el interfaz, 
 * ya que la clase Dulce actúa como intermediaria. Los hijos solo necesitan sobrescribir
 * el método abstracto definido en Dulce.
 * 
 * Esto asegura un diseño consistente y reutilizable, donde todas las clases derivadas 
 * de Dulce comparten el contrato del interfaz Resumible sin redundancia.
 */

}

?>
