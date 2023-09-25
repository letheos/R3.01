<?php include '../Model/ModelConnexion.php';
$conn = require "../Model/Database.php";

//Récupération du token dans l'url
$token = $_GET['token'];
$utilisateur = tokenSearch($conn,$token);
$expire = strtotime($utilisateur['tokenExpiresAt']);

//Verification de l'expiration via le token
if ($expire <= time()) {
    echo '<script>
        alert("Expiration de la page !")
        document.location.href="ControllerConnexion.php";
    </script>
    ';
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" >
    <title>Reinitialisation du mot de passe</title>
</head>
<body>
    <h1> Reinitialisation </h1>
    <form method="post" action="../Controller/ControllerProcessResetPassword.php">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <div class="champ">
            <input type="password" id="password" name="password" placeholder="Mot de passe"> <br>
            <input type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Confirmez le mot de passe"> <br>
        </div>
        <div class="button">
            <button type="submit" id="submit" name="submit"> Reset password </button>
        </div>
    </form>
</body>
</html>
