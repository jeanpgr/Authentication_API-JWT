<?php

include_once 'environment_variables.php';

class DatabaseService{
    
    private $connection;

    public function getConnection() {

        $env_variables = new EnvironmentVariables();
        $this->connection = null;

        try{
            $this->connection = new PDO("mysql:host=" . $env_variables->getHost() . ";dbname=" . $env_variables->getNamedb(), 
                                        $env_variables->getUserDb(), $env_variables->getPasswordDb());
        }catch(PDOException $exception){
            echo "Connection failed: " . $exception->getMessage();
        }

        return $this->connection;
    }
}
?>