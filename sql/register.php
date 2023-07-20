<?php
include "../includes/prepareLogin.php";

$password = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO user (email, password) VALUES (?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);

if ($stmt->execute()) {
    $userId = $stmt->insert_id;

    // Create the user folder if it doesn't exist
    $userFolder = '../images/user_images/' . $userId;
    if (!file_exists($userFolder)) {
        mkdir($userFolder, 0777, true);
    }

    // Create the food folder if it doesn't exist
    $foodFolder = $userFolder . '/food';
    if (!file_exists($foodFolder)) {
        mkdir($foodFolder, 0777, true);
    }

    // Create the recipes folder if it doesn't exist
    $recipesFolder = $userFolder . '/recipe';
    if (!file_exists($recipesFolder)) {
        mkdir($recipesFolder, 0777, true);
    }

    // Check if the folders were successfully created
    if (!file_exists($foodFolder) || !file_exists($recipesFolder)) {
        $response['message'] = "Etwas ist schiefgelaufen. versuchen Sie es bitte nochmal!";
        die(json_encode($response));
    } 

    $_SESSION['logged_in'] = true;
    $_SESSION['id'] = $userId;

    $response['success'] = true;
    $response['message'] = "";
    $response['destination'] = "index.php";
    
    die(json_encode($response));
}

$response['message'] = "Die Email wird schon verwendet!";
die(json_encode($response));