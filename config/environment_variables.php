
<?php

class EnvironmentVariables {

    private $DB_HOST = "localhost";
    private $DB_NAME = "testeoapi_db";
    private $DB_USER = "root";
    private $DB_PASSWORD = "";
    
    private $KEY_JWT = "asdfghjkl_k1";

    public function getHost() {
        return $this->DB_HOST;
    }

    public function getNameDb() {
        return $this->DB_NAME;
    }

    public function getUserDb() {
        return $this->DB_USER;
    }

    public function getPasswordDb() {
        return $this->DB_PASSWORD;
    }

    public function getKeyJwt() {
        return $this->KEY_JWT;
    }

}

?>