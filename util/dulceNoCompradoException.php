<?php

require_once 'pasteleriaException.php';

// Excepción cuando el dulce no ha sido comprado

class dulceNoCompradoException extends pasteleriaException {
    
    // No es necesario agregar nada más. 
    // Esta clase hereda de PasteleriaException y se usa para casos donde un dulce no ha sido comprado.
}
?>
