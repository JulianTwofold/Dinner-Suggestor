<?php
include "../includes/createDatabaseConnection.php";

session_start();

$response = array(
  'success' => false,
  'message' => 'Änderungen wurden vorgenommen!'
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

$new_name = $_POST["name"];
$new_cooktime = $_POST["cooktime"];
$id = $_POST["foodId"];
$recipeName = $_POST["recipeName"];
$foodName = $_POST["foodName"];

function uploadImage($category, $germanCategory, $deleteFile)
{
  global $response;

  if (!isset($_FILES[$category]["name"])) {
    return null;
  }

  $target_dir = "../images/user_images/" . $_SESSION["id"] . "/" . $category . "/";
  $target_file = $target_dir . basename($_FILES[$category]["name"]);
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Allow certain file formats
  $allowedFormats = ["jpg", "jpeg", "png", "gif"];
  if (!in_array($imageFileType, $allowedFormats)) {
    $response['message'] = "Nur JPG, JPEG, PNG & GIF sind erlaubt!";
    die(json_encode($response));
  }

  // Give Image Name that can be saved and used. Prevent issues with ö,ä,ü and spaces in name
  $filename = uniqid().".".$imageFileType;
  $target_file = $target_dir.$filename;

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
  if (file_exists($target_dir . $deleteFile && $deleteFile !== "")) {
    unlink($target_dir . $deleteFile);
  }

  return $filename;
}

$new_recipe_name = uploadImage("recipe", "Rezept", $recipeName);
$new_food_name = uploadImage("food", "Essen", $foodName);

$sql = "UPDATE food SET name = ?, cooktime = ?, recipe_name = COALESCE(?, recipe_name), food_name = COALESCE(?, food_name) WHERE id = ? AND user_id = ?";

$stmt = $db->prepare($sql);
$stmt->bind_param("sissii", $new_name, $new_cooktime, $new_recipe_name, $new_food_name, $id, $_SESSION["id"]);
$stmt->execute();

if ($stmt->affected_rows > 0) {
  $response['success'] = true;
  $response['message'] = "Das Gericht wurde bearbeitet!";
}

$stmt->close();

die(json_encode($response));
