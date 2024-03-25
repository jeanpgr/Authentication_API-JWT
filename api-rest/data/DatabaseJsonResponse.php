<?php

include_once 'DatabaseConexion.php';
include_once '../api-rest/config/EnvironmentVariables.php';
include_once '../api-rest/config/constants.php';
include_once 'Queries.php';

require 'vendor/autoload.php';
use \Firebase\JWT\JWT;

class DatabaseJsonResponse {

    private $conexion;
    private $svDatabase;
    private $sqlQueries;
    private $envVariables;

    public function __construct() {
        $this->conexion = DatabaseConexion::getInstance()->getConnection();
        $this->svDatabase = Flight::database(); // solicita el servicio de bd registrado en DatabaseConexion
        $this->sqlQueries = new Queries();
        $this->envVariables = new EnvironmentVariables();
    }

    public function loginUser($email, $password) {
        $query = $this->svDatabase->prepare($this->sqlQueries->queryLogin()); // Obtiene y prepara la consulta declarada en la clase Queries
        $query->execute([":email_user" => $email]); // Ejecuta la consulta enviando el parametro necesario
        $rowCount = $query->rowCount();
        
        if ($rowCount != 0) {
            $data = $query->fetch();
            $passw_db = $data['passw_user'];
            if (password_verify($password, $passw_db)) {

                $token = array(
                    "iss" => ISS,
                    "aud" => AUD,
                    "iat" => IAT,
                    "nbf" => NBF,
                    "exp" => EXP,

                    "data" => array(
                        "id" => $data['id_user'],
                        "nombre" => $data['nomb_user'],
                        "apellido" => $data['apell_user'],
                        "email" => $data['email_user']
                ));

                http_response_code(SUCCESS_RESPONSE);

                $jwt = JWT::encode($token, $this->envVariables->getKeyJwt(), $this->envVariables->getAlgJwt());
                return array(
                    "message" => "Inicio de sesión satisfactorio.",
                    "jwt" => $jwt,
                    "id" => $data['id_user']
                );
                
            } else {
                http_response_code(ACCESS_DENIED);

                return array("message" => "Inicio de sesión fallido.");
            }
        }
    }

    public function registerUser($user) {

        $query = $this->svDatabase->prepare($this->sqlQueries->queryRegisterUser());

        $array = [
            "error" => "Error el registrar usuario.",
            "status" => "Error"
        ];

        $passw_hash = password_hash($user->getPasswUser(), PASSWORD_BCRYPT);

        $result = $query->execute([":nomb_user" => $user->getNombUser(), ":apell_user" => $user->getApellUser(), 
                                    ":nick_user" => $user->getNickUser(), ":email_user" => $user->getEmailUser(),
                                    ":passw_user" => $passw_hash]);
        
        if ($result) {

            $array = [
                "User" => [
                    "id" => $this->svDatabase->lastInsertId(),
                    "nombre" => $user->getNombUser(),
                    "apellido" => $user->getApellUser(),
                    "email" => $user->getEmailUser()
                ],
                "status" => "Registro satisfactorio."
            ];
        }

        Flight::json($array);

    }
}


?>