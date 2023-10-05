<?php
$conn = require "../Model/Database.php";
require "../Model/ModelSelectAffichage.php";
require "../Controller/ControllerAffichageEtudiant.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $choixFormation = $_POST["formation"];
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="AffichageCandidats.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <title>Les Candidats</title>
</head>

<body>
<section class="affichage">

    <header class="banner">
        <h1>
            Les profils candidats
        </h1>
    </header>
    <form method="POST" action="PageAffichageEtudiant.php">
        <div class="filtreCandidats">
            <label for="formation"> Formation :  </label>
            <?php
                listAffichage($conn);
            ?>
            <input type="text" class="form-control" name="nameCandidates" id="nameCandidates" placeholder="Filtrage par nom">
            <input type="checkbox" class="form-checkbox" name="isActive"
            <button class="btn btn-primary" type="submit" name="submit" id="submit"> Rechercher</button>
        </div>
            <div class="affichage">
                <?php
                choice($conn,$choixFormation);
                ?>
            </div>
        </form>
</section>

<footer class="bottomBanner"> </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
