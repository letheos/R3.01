<?php
session_start();
require_once '../Controller/ControllerModifierCompte.php';
$conn = require '../Model/Database.php';
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="ModifierCompte.css">
    <title>Modification du mot de passe</title>
</head>
<body>

<header class="banner">
    <h1 class="TexteProfil">
        Voici vos informartions
    </h1>
</header>
<section class="display">

    <div class="rounded-box">
        <?php showProfileInfos($conn,$_SESSION['login']) ?>
    </div>

</section>

<section class="modify">
    <div class="rounded-box">
        <p> Entrez les modifications que vous souhaitez effectuer dans les champs vides, si vous ne voulez rien modifier
        laissez le champs vide</p>
        <form action="../Controller/ControllerModifierCompte.php" method="post" id="modify" name="modify" >
            <input type="text" id="lastName" name="lastName" placeholder="Prenom">
            <br>
            <input type="text" id="firstName" name="firstName" placeholder="Nom de famille">
            <br>
            <input type="text" id="login" name="login" placeholder="Identifiant de connexion">
            <br>
            <button class="btn btn-primary" type="submit" name="submit" id="submit"> Valider les modifications </button>
        </form>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>

</html>
