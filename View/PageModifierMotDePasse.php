<?php include '../Model/ModelConnexion.php';
$conn = require "../Model/Database.php";

session_start();

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
        <form method="post" action="../Controller/ControllerModificationMotDePasse.php">
            <input type="password" id="password" name="password" placeholder="Mot de passe"> <br>
            <input type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Confirmez le mot de passe"> <br>
            <button class='btn btn-outline-primary' type="submit" id="submit" name="resetPswd"> Reset password </button>
            <br>
            <button class='btn btn-outline-primary' type="submit" id="submit" name="backAccueil"> Retour à l'accueil </button>
            <?php
            if(isset($_SESSION["erreur"])){
                ?>

                <div class="alert alert-danger">
                    <?php echo $_SESSION["erreur"]; ?>
                </div>

                <?php
                unset($_SESSION["erreur"]);
                session_destroy();
            }
            ?>
        </form>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
