<?php
include_once '../config/database.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$nomb_user = '';
$apell_user = '';
$nick_user = '';
$email_user = '';
$password = '';
$conn = null;

$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();

$data = json_decode(file_get_contents("php://input"));

$nomb_user = $data->nomb_user;
$apell_user = $data->apell_user;
$nick_user = $data->nick_user;
$email_user = $data->email_user;
$password = $data->password;

$table_name = 'users';

$query = "INSERT INTO " . $table_name . "
                SET nomb_user = :nomb_user,
                    apell_user = :apell_user,
                    nick_user = :nick_user,
                    email_user = :email_user,
                    passw_user = :password";

$stmt = $conn->prepare($query);

$stmt->bindParam(':nomb_user', $nomb_user);
$stmt->bindParam(':apell_user', $apell_user);
$stmt->bindParam(':nick_user', $nick_user);
$stmt->bindParam(':email_user', $email_user);

$password_hash = password_hash($password, PASSWORD_BCRYPT);

$stmt->bindParam(':password', $password_hash);

if($stmt->execute()){

    http_response_code(200);
    echo json_encode(array("message" => "Usuario registrado correctamente."));
}
else{
    http_response_code(400);

    echo json_encode(array("message" => "Error al registrar usuario."));
}
?>

