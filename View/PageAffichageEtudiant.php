<?php
$conn = require "../Model/Database.php";
require "../Model/ModelSelectAffichage.php";
require "../Controller/ControllerAffichageEtudiant.php";


if (isset($_POST["submit"])) {
    $choixFormation = $_POST["formation"];
    $choixNom = $_POST["nameCandidates"];
    if (isset($_POST["isNotActive"])) {
        $isNotActive = 1;
    } else {
        $isNotActive = 0;
    }
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

    <header class="banner">
        <h1>
            Les profils candidats
        </h1>
    </header>

    <form method="POST" action="PageAffichageEtudiant.php">

    <section class="filtreCandidats">

            <div class="selection">
                <label for="formation" class="form-select-label"> Formation </label>
                <?php
                listAffichageSelect($conn);
                ?>

            </div>

            <div class="formName">
                <input type="text" class="form-control" name="nameCandidates" id="nameCandidates" placeholder="Filtrage par nom">
            </div>
            <div class="checkbox">
                <input class="form-check" type="checkbox" name="isNotActive" id="isNotActive">
                <label for="isNotActive" class="form-check-label"> Non-actif </label>
            </div>

            <div class="buttonSubmit">
                <button class="btn btn-primary" type="submit" name="submit" id="submit"> Rechercher</button>
            </div>
    </section>


    <section>
            <div class="affichage">
                <?php
                if (($choixFormation == "AucuneOption"  && !isset($choixNom) && !isset($isNotActive)) || (!isset($choixFormation) && !isset($choixNom) && !isset($isNotActive))) {
                    choiceAllOption($conn, $choixFormation, $choixNom, $isNotActive);
                }
                ?>
            </div>
    </section>

    </form>

    <footer class="bottomBanner"> </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
