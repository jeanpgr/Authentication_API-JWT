<?php

include_once '../api-rest/config/EnvironmentVariables.php';
require 'vendor/autoload.php';

// Clase para realizar conexión con patron singleton
class DatabaseConexion {

    private static $instance = null;
    private $connection;
    private $envVariables;

    // Constructor privado para evitar instanciación directa
    private function __construct() {
        $this->envVariables = new EnvironmentVariables();
    }

    // Método estático para obtener la instancia única de la clase
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DatabaseConexion();
        }
        return self::$instance;
    }

    // Retorna la conexion, si es nula la crea
    public function getConnection() {
        if ($this->connection == null) {
            $this->connection = Flight::register('database', 'PDO', array(
                'mysql:host=' . $this->envVariables->getHost() . ';dbname=' . $this->envVariables->getNamedb(),
                $this->envVariables->getUserDb(),
                $this->envVariables->getPasswordDb()
            ));
        }
        return $this->connection;
    }
}

?>
