<?php

class conexion {
    private static $instancia = null;
    private $conexion;

    // Configuración de la base de datos
    private $host = 'localhost';
    private $usuario = 'root';
    private $password = '';
    private $baseDatos = 'pasteleria';

    // Constructor privado para evitar instanciación externa
    private function __construct() {
        try {
            $this->conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->baseDatos}", 
                $this->usuario, 
                $this->password
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    

    // Método estático para obtener la única instancia
    public static function obtenerInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new Conexion();
        }
        return self::$instancia;
    }

    // Obtener la conexión PDO
    public function obtenerConexion() {
        return $this->conexion;
    }

    // Evitar la clonación
    private function __clone() {}

    // Evitar la deserialización
    public function __wakeup() {}

    // Agregar un dulce
    public function agregarDulce($nombre, $precio) {
        $stmt = $this->conexion->prepare("INSERT INTO dulces (nombre, precio) VALUES (:nombre, :precio)");
        $stmt->execute([':nombre' => $nombre, ':precio' => $precio]);
    }

    // Eliminar un dulce
    public function eliminarDulce($id) {
        $stmt = $this->conexion->prepare("DELETE FROM dulces WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    // Editar el precio de un dulce
    public function editarPrecioDulce($id, $nuevoPrecio) {
        $stmt = $this->conexion->prepare("UPDATE dulces SET precio = :precio WHERE id = :id");
        $stmt->execute([':precio' => $nuevoPrecio, ':id' => $id]);
    }

    // Obtener la lista de todos los dulces
    public function obtenerDulces() {
        $stmt = $this->conexion->query("SELECT id, nombre, precio FROM dulces");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
