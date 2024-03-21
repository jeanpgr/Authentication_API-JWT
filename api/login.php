<?php
include_once '../config/database.php';
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$email_user = '';
$passw_user = '';

$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();

$data = json_decode(file_get_contents("php://input"));

$email_user = $data->email_user;
$passw_user = $data->passw_user;

$table_name = 'users';

$query = "SELECT id_user, nomb_user, apell_user, passw_user FROM " . $table_name . " WHERE email_user = ? LIMIT 0,1";

$stmt = $conn->prepare( $query );
$stmt->bindParam(1, $email_user);
$stmt->execute();
$num = $stmt->rowCount();

if($num > 0){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_user = $row['id_user'];
    $nomb_user = $row['nomb_user'];
    $apell_user = $row['apell_user'];
    $passw_db = $row['passw_user'];

    if(password_verify($passw_user, $passw_db))
    {
        $secret_key = "123api";
        $issuer_claim = "localhost"; // this can be the servername
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 1; //not before in seconds
        $expire_claim = $issuedat_claim + 90000; // expire time in seconds
        // $now = strtotime("now");
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "id_user" => $id_user,
                "nomb_user" => $nomb_user,
                "apell_user" => $apell_user,
                "email_user" => $email_user
        ));

        http_response_code(200);

        $jwt = JWT::encode($token, $secret_key, 'HS256');
        echo json_encode(
            array(
                "message" => "Inicio de sesión satisfactorio.",
                "jwt" => $jwt,
                "email" => $email_user,
                "expireAt" => $expire_claim
            ));
    }
    else{

        http_response_code(401);
        echo json_encode(array("message" => "Inicio de sesión fallido."));
    }
}
?>