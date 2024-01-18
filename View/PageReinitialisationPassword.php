<?php
include '../Model/ModelSelect.php';
$conn = require "../Model/Database.php";

session_start();

//Récupération du token dans l'url
if (isset($_SESSION['token'])){
    $token = $_SESSION['token'];
} else {
    $token = $_GET['token'];
}

$utilisateur = tokenSearch($conn,$token);
$expire = strtotime($utilisateur['tokenExpiresAt']);

//Verification de l'expiration via le token

if ($expire <= time()) {
    echo '<script>
        alert("Expiration de la page !")
        document.location.href="../View/PageConnexion.php";
    </script>
    ';
}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8" >
    <title>Reinitialisation du mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="StyleConnexion.css">
</head>
<body>
<section class="login">
    <div>
        <header>
            <h1> Reinitialisation </h1>
        </header>
        <form method="post" action="../Controller/ControllerProcessResetPassword.php">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <input type="password" id="password" name="password" placeholder="Mot de passe"> <br>
            <input type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Confirmez le mot de passe"> <br>
            <button class='btn btn-outline-primary' type="submit" id="submit" name="submit"> Reset password </button>
            <?php
            if(isset($_SESSION["erreur"])){
                ?>

                <div class="alert alert-danger">
                    <?php echo $_SESSION["erreur"]; ?>
                </div>

                <?php
                unset($_SESSION["erreur"]);
            }
            ?>
        </form>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
