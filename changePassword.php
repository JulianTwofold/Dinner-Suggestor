<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="common.css">
    <script src="js/login.js" defer></script>
</head>

<body>
    <h2>Change Password</h2>

    <label for="password">Neues Passwort</label>
    <input type="password" id="password">

    <input type="hidden" id="token" value="<?php echo $_GET['token']; ?>"/>
    
    <button id="changePassword">Passwort ändern</button>
    <div id="reply"></div>
</body>

</html>