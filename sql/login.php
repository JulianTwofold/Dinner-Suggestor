<?php
include "../includes/prepareLogin.php" ;

$sql = "SELECT id, password FROM user where email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result(); 

if (mysqli_num_rows($result) > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user["password"])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['id'] = $user["id"];
        $response['message'] = "";
        $response['success'] = true;
        $response['destination'] = "index.php";
        die(json_encode($response));
    }
}

$response['message'] = "Falsche E-Mail oder falsches Passwort";
die(json_encode($response));