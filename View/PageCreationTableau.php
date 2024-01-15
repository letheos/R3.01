<?php
require "../Controller/ControllerCreationTableau.php";
session_start();
$conn = require "../Model/Database.php";


if(isset($_SESSION['role'])){
    $Role = $_SESSION['role'];
}else{
    $Role = $_SESSION['role'] = 'Admin';
}


error_reporting(E_ALL);
ini_set('display_errors', 1);
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
    <link rel="stylesheet" href="StylePageCreationTableau.css">
    <title>creationTableauDeBord</title>
    <script src="../Controller/JsCreationTableau.js"></script>
</head>
<body>

<header class="banner">
    <form>
        <h1 class="TexteProfil">
            Création de tableau de bord
        </h1>
        <button class="btn btn-light" type="submit" name="retourAccueil"
                onclick="window.location.href='PageAccueil.php'">Retour à l'accueil
        </button>
    </form>
    <form action="PageAfficheTableau.php">
        <button  >Retourner voir les autres tableaux de bords</button>
    </form>
</header>

<form id = "infostableau"  method="post" action="../Controller/ControllerCreationTableau.php">
        <button type="submit" id = "envoyer" class = "centered">Valider Paramètres </button>


    <div class=container>
        <div class=column>
            <div class="rounded-box">
                <h2>Choix des parcours</h2>
                <div class="accordion" id="choicesDep">
                    <?php
                    $formations = selectAllFormation($conn);
                    if(isset($_SESSION['formations']) and isset($_SESSION['idDashBoard'])){
                        $formationsDuDashBoard = ControllerGetFormationForADashBoard($_SESSION['idDashBoard']);
                    }
                    foreach ($formations as $index => $formation) {
                        $parcours = selectParcours($conn, $formation['nameFormation']);
                        $checkboxId = $formation['nameFormation'];
                        $collapseId = 'collapse' . $index;
                        ?>
                        <div class="accordion-item">
                            <strong class="accordion-header" id="<?= 'heading' . $index ?>">
                                <input class="form-check-input" type="checkbox" name="selectedFormation[]" id="<?= $checkboxId ?>" onchange="toggleAccordion('<?= $checkboxId ?>')" data-formation="<?= $formation['nameFormation'] ?>">
                                <?= $formation['nameFormation'] ?>
                            </strong>
                            <div id="<?= $collapseId ?>" class="accordion-collapse collapse" aria-labelledby="<?= 'heading' . $index ?>">
                                <div class="accordion-body">
                                    <?php
                                    foreach ($parcours as $indexParcours => $parcour) {
                                        ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="<?= 'parcours' . $indexParcours ?>" name="selectedParcours[]" value="<?= $parcour['nameParcours'] ?>"  >
                                            <label class="form-check-label" for="<?= 'parcours' . $indexParcours ?>"><?= $parcour['nameParcours'] ?></label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

    </div>
        <!--bonnes fermetures de balises -->

        <div class=column>
            <div class=rounded-box>
                <h2 class="titreAffichage"> valeur pour l'affichage</h2>

                <div id="checkBoxIne">
                    <input type="checkbox" id="ine" name="isIne" value="1" >

                    <label for="ine">ine affiché (par défaut non)</label>

                    <input hidden="hidden" type="checkbox" id="ine" name="isIne" value="0">
                </div>
                <script>
                    function updateValue(checkbox) {
                        var inputElement = document.getElementById('ine');

                        // Si la case à cocher est cochée, utilisez la valeur '1', sinon utilisez une autre valeur
                        var newValue = checkbox.checked ? '1' : 'valeur_alternative';

                        inputElement.value = newValue;

                        console.log("Nouvelle valeur de la case à cocher : " + newValue);
                    }
                </script>

                <div id="checkBoxAddress">
                    <input type="checkbox" id="address" name="isAddress" value="1"  >
                    <label for="address"> Adresse affichée (par défaut non)</label>

                </div>

                <div class="checkBoxPhone">
                    <input type="checkbox" id="phone" name="isPhone" value="1" >
                    <label for="phone"> numéro de téléphone (par défaut non) </label>

                </div>

                <div class = "checkboxpermis">
                    <input type="checkbox" id ="permis" name="ispermis" value="1" >
                    <label for="permis">permis affiché (par défaut non)</label>
                </div>


            </div>
        </div>

            <form method="post" action="../Controller/ControllerCreationTableau.php">
                <div class="rounded-box"  <?= ($_SESSION['role'] != 'Admin') ? 'style="display: none;"' : '' ?> >
                    <!-- si l'utilisateur est pas admin il ne peut pas crée de tableau pour tout le monde -->
                    <h2>Role à inclure dans la création du tableau de bord</h2>


                    <input type="checkbox" id="secretaire" name="secretaire" value="secretaire" <?php if((isset($_SESSION['role'])) and $_SESSION['role'] == "secretaire") echo 'checked' ?> >
                    <label for="secretaire"> inclure secretaire</label>
                    <br>

                    <input type="checkbox" id="Admin" name="Admin" value="secretaire" <?php if((isset($_SESSION['role'])) and $_SESSION['role'] == "Admin") echo 'checked' ?> >
                    <label for="Admin"> inclure Admin</label>
                    <br>

                    <input type="checkbox" id="role2" name="role2" value="role2" <?php if((isset($_SESSION['role'])) and $_SESSION['role'] == "role2") echo 'checked' ?> >
                    <label for="role2"> inclure role2</label>
                    <br>

                    <input type="checkbox" id="role3" name="role3" value="role3" <?php if((isset($_SESSION['role'])) and $_SESSION['role'] == "role3") echo 'checked' ?> >
                    <label for="role3"> inclure role3</label>
                    <br>

            </div>


    <div class=column>
        <div class="rounded-box">
            <h2 class="titreAffichage">Paramètres diagrammes</h2>
            <input type="checkbox" id="histo" name="histo" value="1">
            <label for="histo">afficher histogramme</label>
            <br>
            <input type="checkbox" id="graphe" name="graphe" value="1">
            <label for="graphe">afficher graphe effectifs
            </label>
        </div>
    </div>

<div class="column">
    <div class="rounded-box">
        <label for="title" >entrée le nom du tableau de bord</label>
        <input id="title" type="text">
    </div>
</div>
</div>
</form>

<footer class="bottomBanner">
    <div class="nomFooter">
        <p>
            Timothée Allix, Nathan Strady, Theo Parent, Benjamin Massy, Loïck Morneau
        </p>
    </div>
    <div class="origineFooter">
        <p>
            2023/2024 UPHF
        </p>
    </div>

</footer>

<script src="../Controller/JsCreationTableau.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>


</body>
</html>


