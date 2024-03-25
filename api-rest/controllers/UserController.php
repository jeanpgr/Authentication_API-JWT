<?php

//require_once '../models/User.php';
require_once '../api-rest/data/DatabaseJsonResponse.php';

class UserController {

    private $dbJsonResponse;

    public function __construct() {
        $this->dbJsonResponse = new DatabaseJsonResponse();
    }

    public function login($email, $password) {

        return $this->dbJsonResponse->loginUser($email, $password);

    }

    public function registerUser($user) {

        return $this->dbJsonResponse->registerUser($user);

    }

}

?>