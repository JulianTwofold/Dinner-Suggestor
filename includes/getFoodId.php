<?php

if(!isset($_GET["id"])){
    header('Location: index.php');
}

include "includes/createDatabaseConnection.php";

$sql = "SELECT * FROM food WHERE id = ? AND user_id = ?";

$stmt = $db->prepare($sql);
$stmt->bind_param("ii", $_GET["id"], $_SESSION["id"]); 
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();

if(empty($row)){
    header('Location: index.php');
}

$id = $row["id"];
$name = $row["name"];
$cooktime = $row["cooktime"];
$eatDate = $row["eat_date"];
$recipeName = $row["recipe_name"];
$foodName = $row["food_name"];

$stmt->close();