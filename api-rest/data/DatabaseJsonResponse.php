<?php

include_once 'DatabaseConexion.php';
include_once '../api-rest/config/EnvironmentVariables.php';
include_once '../api-rest/config/constants.php';
include_once 'Queries.php';

require 'vendor/autoload.php';
use \Firebase\JWT\JWT;

// Clase para retornar los datos traidos de la db en json
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

    // Función para iniciar sesión, recibe email y contraseña
    public function loginUser($email, $password) {
        $query = $this->svDatabase->prepare($this->sqlQueries->queryLogin()); // Obtiene y prepara la consulta declarada en la clase Queries
        $query->execute([":email_user" => $email]); // Ejecuta la consulta enviando el parametro necesario
        $rowCount = $query->rowCount();
        
        /* Si mi contador de filas obtenidas es diferente de cero verifico 
          si la contraseña recibida es la misma con la que esta en la db */
        if ($rowCount != 0) { 
            $data = $query->fetch();
            $passw_db = $data['passw_user'];
            // Metodo password_verify descodifica la contraseña traida de la db y la compara con la recibida
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

                // Codifica el token 
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

    // Función para registrar usuario, recibe el modelo user
    public function registerUser($user) {

        $query = $this->svDatabase->prepare($this->sqlQueries->queryRegisterUser());

        // Array de respuesta por defecto con estado de error
        $array = [
            "error" => "Error el registrar usuario.",
            "status" => "Error"
        ];

        $passw_hash = password_hash($user->getPasswUser(), PASSWORD_BCRYPT); // Encripta la contraseña

        $result = $query->execute([":nomb_user" => $user->getNombUser(), ":apell_user" => $user->getApellUser(), 
                                    ":nick_user" => $user->getNickUser(), ":email_user" => $user->getEmailUser(),
                                    ":passw_user" => $passw_hash]);

        // Si el resultado es satisfactorio modifica el array de respuesta por mensaje satisfactorio
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

    public function protectResources() {
        
    }
}


?>