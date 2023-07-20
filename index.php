<?php include "includes/redirect.php"; ?>
<?php
    include "includes/createDatabaseConnection.php";
    $sql = "SELECT * FROM food WHERE user_id = ?";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $_SESSION["id"]); 
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="js/index.js" defer></script>
</head>

<body>
    <div id="lightbox" class="hidden">
        <div id="cross" class="cross hidden"></div>
        <img class="lightRecipe" id='recipeImg' src='' />
    </div>
    <div class="menubar visible" id="plus" onclick="window.location.href = 'createFood.php'">
        <div class="horizontal-rectangle"></div>
        <div class="vertical-rectangle"></div>
    </div>
    <h1>Top Vorschläge:</h1>
    <?php
    if(empty($data)){
        echo "<p id='welcome'>Willkommen bei Dinner Suggestor!<br><br> Sie haben im Moment kein Gericht erstellt. Falls sie Gerichte vorgeschlagen bekommen wollen sollen sie ein paar erstellen. Sie können auf den Namen des Gerichtes klicken um es zu bearbeiten. Wenn Sie auf das Bild drücken erscheint das dazugehörige Rezept.</p><br> <a class='link' style='font-size:22px;' href='createFood.php'>Gericht erstellen</a>";
        exit();
    }
    ?>
    <div id="imageSlider">
        <?php include "includes/printFood.php"; ?>
    </div>
</body>

</html>