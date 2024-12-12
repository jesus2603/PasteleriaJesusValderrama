<?php
require_once __DIR__ . '/cliente.php';
require_once __DIR__ . '/dulce.php';
require_once __DIR__ . '/../util/DulceNoCompradoException.php';
require_once __DIR__ . '/../util/DulceNoEncontradoException.php';
require_once __DIR__ . '/../util/ClienteNoEncontradoException.php';

// La clase Pasteleria representa una pastelería
class pasteleria {
    private $productos;
    private $clientes;

    public function __construct() {
        $this->productos = [];
        $this->clientes = [];
    }

    private function incluirProducto(dulce $producto) {
        $this->productos[] = $producto;
    }

    public function agregarProducto(dulce $producto) {
        $this->incluirProducto($producto);
        echo "Producto '{$producto->getNombre()}' agregado a la pastelería.<br>";
    }

    public function mostrarProductos() {
        echo "Productos disponibles:<br>";
        foreach ($this->productos as $producto) {
            echo "- {$producto->getNombre()}<br>";
        }
    }

    public function agregarCliente(cliente $cliente) {
        $this->clientes[] = $cliente;
        echo "Cliente '{$cliente->getNombre()}' agregado a la pastelería.<br>";
    }

    public function mostrarClientes() {
        echo "Clientes registrados:<br>";
        foreach ($this->clientes as $cliente) {
            echo "- {$cliente->getNombre()}<br>";
        }
    }

    public function gestionarCompra(cliente $cliente, dulce $dulce) {
        try {
            $cliente->comprar($dulce);
        } catch (dulceNoEncontradoException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }
    }

    public function gestionarValoracion(cliente $cliente, dulce $dulce, string $comentario) {
        try {
            $cliente->valorar($dulce, $comentario);
        } catch (dulceNoCompradoException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }
    }

    public function listarPedidosCliente(cliente $cliente) {
        $cliente->listarPedidos();
    }
}

?>