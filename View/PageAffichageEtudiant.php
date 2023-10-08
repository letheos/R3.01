<?php
$conn = require "../Model/Database.php";
require "../Model/ModelSelectAffichage.php";
require "../Controller/ControllerAffichageEtudiant.php";

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

    <form id="filter-form" method="POST" action="../View/PageAffichageEtudiant.php">

    <section class="filtreCandidats">

            <div class="selection">
                <label for="formation" class="form-select-label"> Formation </label>
                <?php
                listAffichageSelect($conn); //
                ?>

            </div>

            <div class="formName">
                <input type="text" class="form-control" name="nameCandidates" id="nameCandidates" placeholder="Filtrage par nom">
            </div>
            <div class="checkbox">
                <input class="form-check" type="checkbox" name="isActive" id="isActive">
                <label for="isNotActive" class="form-check-label"> Non-actif </label>
            </div>

            <div class="buttonSubmit">
                <button class="btn btn-primary" type="submit" name="submit" id="submit"> Rechercher</button>
            </div>

        <script>
        </script>
    </section>

    <section class="afficheCandidats">
            <div class="affichage" id="candidateList">
                <?php filtrage($conn); ?>
            </div>
        <script>
            //Récupère toute les valeurs des balises candidats
            const candidateList = document.querySelectorAll(".candidates"); //Sélectionnez tous les éléments avec la classe "candidates"
            candidateList.forEach(candidate => { //Pour chaque balise candidat on l'écoute
                candidate.addEventListener("click", function(event) { //On ajoute un eventlistener click
                    //Empeche le refresh automatique de la page
                    event.preventDefault();
                    //On traite le click
                    const target = event.target;
                    if (target.tagName === "BUTTON") {
                        const candidateId = target.getAttribute("id");
                        window.location.href=`./PageAffichageEtudiantPrecis.php?id=${candidateId}`;
                    }
                });
            });
        </script>

    </section>

    </form>

    <footer class="bottomBanner"> </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>

