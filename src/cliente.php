<?php
require_once __DIR__ . '/dulce.php';
require_once __DIR__ . '/../util/clienteNoEncontradoException.php';
require_once __DIR__ . '/../util/dulceNoCompradoException.php';
require_once __DIR__ . '/../util/dulceNoEncontradoException.php';
require_once __DIR__ . '/../util/pasteleriaException.php';

// Clase cliente
class cliente {
    private $nombre;
    private $numero;
    private $numPedidosEfectuados;
    private $dulcesComprados;
    private $usuario; 
    private $password; 

    public function __construct($nombre, $numero, $numPedidosEfectuados = 0, $usuario = null, $password = null) {
        $this->nombre = $nombre;
        $this->numero = $numero;
        $this->numPedidosEfectuados = $numPedidosEfectuados;
        $this->dulcesComprados = [];
        $this->usuario = $usuario; 
        $this->password = $password; 
    }

    // Métodos existentes
    public function getNombre() {
        return $this->nombre;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function incrementarPedidos() {
        $this->numPedidosEfectuados++;
    }

    public function agregarDulceComprado(dulce $dulce) {
        $this->dulcesComprados[] = $dulce;
        $this->incrementarPedidos();
    }

    public function listaDeDulces(dulce $dulce): bool {
        foreach ($this->dulcesComprados as $comprado) {
            if ($comprado->getNombre() === $dulce->getNombre()) {
                return true;
            }
        }
        return false;
    }

    public function comprar(dulce $dulce): self {
        if ($this->listaDeDulces($dulce)) {
            throw new dulceNoEncontradoException("El dulce '{$dulce->getNombre()}' ya está en la lista de dulces comprados.");
        }
        $this->agregarDulceComprado($dulce);
        echo "El dulce '{$dulce->getNombre()}' ha sido comprado.<br>";
        return $this;
    }

    public function valorar(dulce $dulce, string $comentario): self {
        if (!$this->listaDeDulces($dulce)) {
            throw new dulceNoCompradoException("El dulce '{$dulce->getNombre()}' no ha sido comprado.");
        }
        echo "Comentario sobre el dulce '{$dulce->getNombre()}': $comentario<br>";
        return $this;
    }

    public function listarPedidos(): self {
        echo "Pedidos efectuados por {$this->nombre}:<br>";
        foreach ($this->dulcesComprados as $dulce) {
            echo "- {$dulce->getNombre()}<br>";
        }
        return $this;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}

?>
