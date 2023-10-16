<?php
session_start();
include '../Controller/ControllerPageProfil.php';
$conn = require '../Model/Database.php';
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="Profil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Profil</title>
</head>
<body>

<header class="banner">
    <h1>
        Votre profil
    </h1>
</header>

<form method="POST" id="form" action="PageProfil.php">

    <section class="Affiche">
        <div class="rounded-box">
            <?php showProfile($conn,$_SESSION['login']); ?>
            <button class="btn btn-outline-primary" type="submit" name="modifierMotdePasse">Modifier mot de passe</button>
            <br>
        </div>
    </section>

    <button class="btn btn-outline-primary" type="submit" name="retourAccueil">Retour à l'accueil</button>


</form>

<footer class="bottomBanner"> </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>