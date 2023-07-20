<?php include "includes/redirect.php"; ?>
<?php include "includes/getFoodId.php"; ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="common.css">
    <script src="js/food.js" defer></script>
</head>
<body>
    <img src="images/house.png" onclick="window.location.href = 'index.php'" class="menubar" alt="home">
    <h2>Gericht bearbeiten</h2>

    <label for="name">Name</label>
    <input type="text" id="name" value="<?php echo $name; ?>">

    <label for="cooktime">Kochzeit</label>
    <input type="number" id="cooktime" value="<?php echo $cooktime; ?>">

    <?php include "includes/letUserAddImage.php"; ?>

    <input type="hidden" id="foodId" value="<?php echo $id;?>"/>
    <input type="hidden" id="recipeName" value="<?php echo $recipeName;?>"/>
    <input type="hidden" id="foodName" value="<?php echo $foodName;?>"/>
    
    <button id="editFood">Änderungen Speichern</button>
    <div id="reply"></div>
</body>
</html>