<?php
require "../Controller/ControllerCreationTableau.php";
session_start();


if (empty($_SESSION['user'])) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}

$user = unserialize($_SESSION['user']);

?>

<!--
TODO pour tout les input de type option, avoir les données de manières dynamique et non fixe*
TODO formation dynamique : en cours
TODO relier au controller qui relie au model
TODO faire un input qui passe avec une api pour la ville
TODO réussir à récupérer une valeur de la bdd et de la mettre en selectionner
-->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Consider avoiding viewport values that prevent users from resizing documents. from w3 validator-->
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>creationTableauDeBord</title>
    <script src="../Controller/JsCreationTableau.js"></script>
    <style>
        .bg-custom {
            background-color: #0f94b4;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .container {
            border: 1px solid #0f94b4;
        }

        .rounded-box {

            border: 1px solid #0f94b4;
        }


    </style>
</head>
<body>

<header class="jumbotron text-center bg-custom text-white">
    <form action="PageAccueil.php">
        <h1 class="TexteProfil">
            Affichage des tableaux de bord
        </h1>
        <button class="btn btn-light" type="submit" name="retourAccueil">Retour à l'accueil</button>
    </form>

    <!-- Ajout d'un espace vertical entre les deux formulaires -->
    <div class="mb-2"></div>

    <form action="PageAfficheTableau.php">
        <button class="btn btn-light mb-2">Retourner voir les autres tableaux de bords</button>
    </form>
</header>

<form id="infostableau" method="post" action="../Controller/ControllerCreationTableau.php">
    <div class="container overflow-auto mt-4 mb-4 p-3 rounded-box d-flex flex-column">
        <!-- Première section: Entrer le nom du tableau de bord -->
        <div class="rounded-box p-3 mb-4">
            <h2>Le nom du tableau</h2>
            <label for="title">Nom du tableau de bord :</label>
            <input id="title" name="title" type="text" class="form-control">
        </div>

        <!-- Deuxième section: Paramètres effectif -->
        <div class="rounded-box p-3 mb-4">
            <h2>Paramètres statistique</h2>
            <div class="form-check">
                <input type="checkbox" id="isHeadcount" name="isHeadcount" value="1" class="form-check-input">
                <label class="form-check-label" for="isHeadcount">Afficher les effectifs des formations</label>
            </div>
        </div>


        <div class="rounded-box p-3 mb-4">
            <h2>Affichage détaillé des candidats</h2>
            <div id="checkBoxIne" class="form-check mb-2">
                <input type="checkbox" id="ine" name="isIne" value="1" class="form-check-input">
                <label class="form-check-label" for="ine">Afficher l'INE (par défaut non)</label>
            </div>
            <div id="checkBoxAddress" class="form-check mb-2">
                <input type="checkbox" id="address" name="isAddress" value="1" class="form-check-input">
                <label class="form-check-label" for="address">Afficher les addresses (par défaut non)</label>
            </div>
            <div class="checkBoxPhone form-check mb-2">
                <input type="checkbox" id="phone" name="isPhone" value="1" class="form-check-input">
                <label class="form-check-label" for="phone">Afficher les numéros de téléphone (par défaut non)</label>
            </div>
            <div class="checkboxpermis form-check mb-2">
                <input type="checkbox" id="permis" name="isPermis" value="1" class="form-check-input">
                <label class="form-check-label" for="permis">Afficher le permis (par défaut non)</label>
            </div>
        </div>

        <div class="rounded-box p-3 mb-4">
            <h2>Choix des parcours</h2>
            <div class="accordion" id="choicesDep">
                <?php
                if ($user->getRole() == "Chef de service") {
                    $formations = controllerGetAllFormations();
                } else {
                    $formations = $user->getLesFormations();
                }
                if (isset($_SESSION['formations']) and isset($_SESSION['idDashBoard'])) {
                    $formationsDuDashBoard = ControllerGetFormationForADashBoard($_SESSION['idDashBoard']);
                }
                foreach ($formations as $index => $formation) {
                    $parcours = controllerGetParcours($formation['nameFormation']);
                    $checkboxId = $formation['nameFormation'];
                    $collapseId = 'collapse' . $index;
                    ?>
                    <div class="accordion-item">
                        <div class="accordion-header" id="<?= 'heading' . $index ?>">
                            <input class="form-check-input" type="checkbox" name="selectedFormation[]" id="<?= $checkboxId ?>" onchange="toggleAccordion('<?= $checkboxId ?>')" data-formation="<?= $formation['nameFormation'] ?>">
                            <label class="form-check-label" for="<?= $checkboxId ?>"><?= $formation['nameFormation'] ?></label>
                        </div>
                        <div id="<?= $collapseId ?>" class="accordion-collapse collapse" aria-labelledby="<?= 'heading' . $index ?>">
                            <div class="accordion-body">
                                <?php
                                foreach ($parcours as $indexParcours => $parcour) {
                                    ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="<?= 'parcours' . $indexParcours ?>" name="selectedParcours[]" value="<?= $parcour['nameParcours'] ?>">
                                        <label class="form-check-label" for="<?= 'parcours' . $indexParcours ?>"><?= $parcour['nameParcours'] ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="rounded-box p-3">
            <div class="text-center">
                <h2>Validation</h2>
                <button type="submit" id="envoyer" name="validate" class="btn btn-primary">Valider Paramètres</button>
            </div>
        </div>
    </div>

</form>


    <footer class="bg-custom text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div>
                        <p>
                            Timothée Allix, Nathan Strady, Theo Parent, Benjamin Massy, Loïck Morneau
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <p>
                            2023/2024 UPHF
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

<script src="../Controller/JsCreationTableau.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>


</body>
</html>


