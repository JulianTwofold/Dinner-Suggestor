<?php include "includes/redirect.php"; ?>
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

    <h2>Gericht Hinzufügen</h2>
    <label for="name">Name</label>
    <input type="text" id="name">

    <label for="cooktime">Kochzeit</label>
    <input type="number" id="cooktime">

    <?php include "includes/letUserAddImage.php"; ?>
    
    <button id="addFood">Gericht hinzufügen</button>
    <div id="reply"></div>
</body>

</html>