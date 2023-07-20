<?php
session_start();

$response = array(
  'success' => false,
  'message' => 'Das Gericht konnte nicht abgespeichert werden!'
);

if ($_POST["name"] == null) {
  $response['message'] = "Geben Sie dem Gericht bitte einen Namen!";
  die(json_encode($response));
}

if ($_POST["cooktime"] == null) {
  $response['message'] = "Geben Sie bitte eine Kochzeit an!";
  die(json_encode($response));
}

if (!is_numeric($_POST["cooktime"])) {
  $response['message'] = "Die kochzeit muss eine Zahl sein!";
  die(json_encode($response));
}
function uploadImage($category, $germanCategory)
{
  global $response;
  if (!isset($_FILES[$category]["name"])) {
    return null;
  }

  $filename = basename($_FILES[$category]["name"]);

  $target_dir = "../images/user_images/" . $_SESSION["id"] . "/" . $category . "/";
  $target_file = $target_dir . $filename;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Allow certain file formats
  $allowedFormats = ["jpg", "jpeg", "png", "gif"];
  if (!in_array($imageFileType, $allowedFormats)) {
    $response['message'] = "Nur JPG, JPEG, PNG & GIF sind erlaubt!";
    die(json_encode($response));
  }

  // Give Image Name that can be saved and used. Prevent issues with ö,ä,ü and spaces in name
  $filename = uniqid() . "." . $imageFileType;
  $target_file = $target_dir . $filename;

  // Check if image file is a actual image or fake image
  if (getimagesize($_FILES[$category]["tmp_name"]) === false) {
    $response['message'] = "Das " . $germanCategory . " ist kein bild!";
    die(json_encode($response));
  }

  if (file_exists($target_file)) {
    return $filename;
  }
  
  // Check file size
  if ($_FILES[$category]["size"] > 500000) {
    $response['message'] = "Das Bild von dem " . $germanCategory . " ist zu gross!";
    die(json_encode($response));
  }

  //Everything is ok so its time to safe the image in the desired directory
  move_uploaded_file($_FILES[$category]["tmp_name"], $target_file);
  return $filename;
}

$recipe = uploadImage("recipe", "Rezept");
$food = uploadImage("food", "Essen");

// Create a mysqli connection
$db = new mysqli('localhost', 'root', '', 'dinner_suggestor');

$sql = "INSERT INTO food (name, cooktime, recipe_name, food_name, user_id) VALUES ('" . $_POST["name"] . "', " . $_POST["cooktime"] . ", '" . $recipe . "',  '" . $food . "',  " . $_SESSION["id"] . ")";

if ($db->query($sql) === TRUE) {
  $response['message'] = "Das Gericht wurde erstellt!";
  $response['success'] = true;
} else {
  $response['message'] = "Error: " . $db->error;
  $response['success'] = false;
}

$db->close();

die(json_encode($response));