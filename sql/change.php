<?php 
include "../includes/prepareLogin.php";

$response['message'] = "Ungültiger Token!";

if(!isset($_GET['token'])) {
    die(json_encode($response));
}

$token = $_GET['token'];

$sql = "SELECT id, token_expiration_date FROM user where token=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result(); 

if (mysqli_num_rows($result) == 0) {
    die(json_encode($response));
}

$expirationTime = strtotime('-1 day');

$user = $result->fetch_assoc();

if ($user["token_expiration_date"] < $expirationTime) {
    $response['message'] = "Token ist schon abgelaufen!";
    die(json_encode($response));
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE user SET password = ?, token = null, token_expiration_date = 0 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $hashedPassword, $user["id"]);
$stmt->execute();

$response['message'] = "Das Passwort wurde erfolgreich geändert!";
$response['success'] = true;
$response['destination'] = "index.php";
die(json_encode($response));
