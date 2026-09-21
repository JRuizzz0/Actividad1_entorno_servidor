<?php
$host = 'pgsql:host=localhost;dbname=PruebaPHP';
$usuario = 'postgres';
$password = 'postgres';

try {
   
$conexion = new PDO($host, $usuario, $password);
    
} catch (PDOException $e) {
    
    echo "Error de conexión: " . $e->getMessage();
}

?>