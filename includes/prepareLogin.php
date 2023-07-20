<?php
session_set_cookie_params(7 * 24 * 60 * 60); // 7 days

session_start();

$response = array(
    'success' => false,
    'message' => 'Es ist ein fehler beim Login aufgetreten!',
    'destination' => ''
);

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    die(json_encode($response));
}

$email = $_POST['email'];
$password = $_POST['password'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = "Ungültige Emailadresse!";
    die(json_encode($response));
}

if ($password == "") {
    $response['message'] = "Geben Sie bitte ein Passwort ein!";
    die(json_encode($response));
}

$conn = new mysqli("localhost", "root", "", "dinner_suggestor");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}