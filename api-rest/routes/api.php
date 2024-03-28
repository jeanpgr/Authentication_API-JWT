<?php

require_once '../api-rest/controllers/UserController.php';
require_once '../api-rest/models/User.php';
include_once '../api-rest/config/constants.php';

require 'vendor/autoload.php';

function getUserController() {
    return $userController = new UserController();
}

// Recibe json con el email y contraseña
Flight::route('POST /login', function () {
    
    $data = Flight::request()->data; // Obtener los datos JSON del cuerpo de la solicitud

    if (isset($data['email']) && isset($data['password'])) {
        
        Flight::json(getUserController()->login($data['email'], $data['password']));

    } else {
        
        Flight::json(["error" => "Se requiere email y password"], BAD_REQUEST);
    }
});

// Recibe json con los datos del usuario a registrar
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

Flight::route('GET /getUsers', function() {

    $headers = apache_request_headers(); // Obtener encabezado con el token authorization

    $response = getUserController()->getUsers($headers); // Obtener respuesta de la capa de datos

    if ($response["status"] == 'error' ) {  // Si el estado es error muestra el mensaje del error que se produjo 
        Flight::halt(FORBIDDEN, $response["error"]);
    } else {
        Flight::json($response); // Si el estado es OK devuelve la lista de usuarios
    }

});

Flight::start();

?>