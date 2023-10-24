<?php
$conn = require "../Model/Database.php";
require "../Model/ModelSelectAffichage.php";
require "../Controller/ControllerAffichageEtudiantPrecis.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_GET['id'])){
    $id = $_GET['id'];
}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="AffichageCandidatsPrecis.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Affichage précis</title>
</head>
<body>

    <header class="banner">
        <a class="btn btn-light" href="./PageAffichageEtudiant.php" style="position: absolute; top: 0; left: 0;"> Retour à l'affichage candidat </a>
        <h1>
            Le candidat
        </h1>
    </header>

    <section class="Affiche">
        <div class="rounded-box">
            <?php
            afficherEtudiant($conn,$id);
            ?>

    <footer class="bottomBanner"> </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
