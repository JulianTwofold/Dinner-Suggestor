<?php
include "../includes/prepareLogin.php";

$response['success'] = true;
$response['message'] = "Eine E-Mail mit Anweisungen zum Zurücksetzen Ihres Passworts wurde an die angegebene Adresse gesendet.<br>
Bitte überprüfen Sie Ihre E-Mails und folgen Sie den Anweisungen, um fortzufahren.<br>
Falls Sie innerhalb weniger Minuten keine E-Mail erhalten, stellen Sie bitte sicher, dass die E-Mail-Adresse korrekt ist und überprüfen Sie Ihren Spam-Ordner.";

$query = "SELECT COUNT(*) AS count FROM user WHERE email = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count == 0) {
    die(json_encode($response));
}

$token = bin2hex(random_bytes(32));
$token_expiration_date = time() + (24 * 60 * 60);

$sql = "UPDATE user SET token = ?, token_expiration_date = ? WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sis", $token, $token_expiration_date, $email);
$stmt->execute();

require '../phpMailer/PHPMailer.php';
require '../phpMailer/SMTP.php';
require '../phpMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Read the configuration file
$config = parse_ini_file('../config.ini', true);

// Get the email configuration values
$emailHost = $config['email']['host'];
$emailUsername = $config['email']['username'];
$emailPassword = $config['email']['password'];
$emailPort = $config['email']['port'];

$mail = new PHPMailer(true); // Passing `true` enables exceptions

try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = $emailHost;
    $mail->SMTPAuth = true;
    $mail->Username = $emailUsername;
    $mail->Password = $emailPassword;
    $mail->SMTPSecure = 'tls';
    $mail->Port = $emailPort;
    $mail->CharSet = 'UTF-8';
    // Email content
    $mail->setFrom('sender@example.com', 'Dinner Suggestor');
    $mail->addAddress($email);
    $mail->Subject = 'Dinner Suggestor Passwort Reset';
    $mail->Body = "Sie haben eine neues Passwort angefordert. Klicken sie bitte auf diesen Link um das Passwort zu ändern: http://localhost/dinner-suggestor/changePassword.php?token=" . $token;
    // Send the email
    $mail->send();
    die(json_encode($response));
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = 'Email konnte nicht gesendet werden!';
    die(json_encode($response));
}
