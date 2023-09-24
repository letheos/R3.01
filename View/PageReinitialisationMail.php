<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" >
    <title>Reinitialisation du mot de passe</title>
</head>
<body>
    <h1> Reinitialisation </h1>
    <form method="get" action="../Controller/ControllerReinistialisationEmail.php">
        <div class="champ">
            <input type="password" id="password" name="password" placeholder="Mot de passe"> <br>
            <input type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Confirmez le mot de passe"> <br>
        </div>
        <div class="button">
            <button type="submit" id="submit" name="submit"> Connexion </button>
        </div>
    </form>
</body>
</html>
