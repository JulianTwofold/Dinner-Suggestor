<?php include "includes/shortcut.php"; ?>
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
    <h2>Login</h2>
    <label for="emailLogin">E-Mail Adresse</label>
    <input type="email" id="emailLogin">

    <label for="passwordLogin">Passwort</label>
    <input type="password" id="passwordLogin">

    <button id="login">Anmelden</button>
    <p class="link" id="resetButton">Passwort vergessen?</p>
    <div id="replyLogin"></div>

    <h2>Registrieren</h2>
    <label for="emailRegister">E-Mail Adresse</label>
    <input type="email" id="emailRegister">

    <label for="passwordRegister">Passwort</label>
    <input type="password" id="passwordRegister">

    <button id="register">Registrieren</button>
    <div id="replyRegister"></div>
</body>

</html>