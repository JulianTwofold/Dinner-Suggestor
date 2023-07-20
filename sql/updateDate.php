<?php
include "../includes/createDatabaseConnection.php";

session_start();

$currentDay = date('Y-m-d');

$sql = "UPDATE food SET eat_date = DATE(?) WHERE id = ? AND user_id = ?";

$stmt = $db->prepare($sql);
$stmt->bind_param("sii", $currentDay, $_GET["foodId"], $_SESSION["id"]);
$stmt->execute();

$stmt->close();