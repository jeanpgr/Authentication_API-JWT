<?php

require_once '../api-rest/controllers/UserController.php';
require_once '../api-rest/models/User.php';
include_once '../api-rest/config/constants.php';

require 'vendor/autoload.php';

function getUserController() {
    return $userController = new UserController();
}

Flight::route('POST /login', function () {
    
    $data = Flight::request()->data; // Obtener los datos JSON del cuerpo de la solicitud

    if (isset($data['email']) && isset($data['password'])) {
        
        Flight::json(getUserController()->login($data['email'], $data['password']));

    } else {
        
        Flight::json(["error" => "Se requiere email y password"], BAD_REQUEST);
    }
});

Flight::route('POST /registerUser', function () {

    $data = Flight::request()->data;

    if ($data != null) {

        $user = new User(0, $data['nombre'], $data['apellido'], 
                        $data['nick'], $data['email'], $data['password']);

        Flight::json(getUserController()->registerUser($user));

    } else {

        Flight::json(["error" => "Se requiere todos los campos", BAD_REQUEST]);
    }

});

Flight::start();

?>