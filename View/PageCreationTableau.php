<?php
require_once "../Controller/ControllerCreationTableau.php";
$conn = require "../Model/Database.php";
?>

<!--
TODO pour tout les input de type option, avoir les données de manières dynamique et non fixe*
TODO formation dynamique : en cours
TODO relier au controller qui relie au model
TODO faire un input qui passe avec une api pour la ville
-->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Consider avoiding viewport values that prevent users from resizing documents. from w3 validator-->
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

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
</header>


<section class="settingsData" id="settingsData">
    <form class="parametre" method="post" action="../Controller/ControllerCreationTableau.php">
        <h2> Paramètres des données à afficher dans le tableau de bord</h2>
        <!-- section générale des paramètre de données -->
        <div class="formation">
            <div class="menuDeroulFormation">
                <label for="formations">formation :</label>
                <select name="formations" title="formations" id="formations" >

                    <option value="allFormations" selected>touts les formations</option>
                    <?php
                    $parcours = controllerGetAllFormations($conn);
                    foreach ($parcours as $parcour) { ?>
                        <option value="<?= $parcour[0] ?>"><?= $parcour[0] ?></option>
                    <?php } ?>
                </select>
            </div>

            <br>
            <div class="menuDeroulParcours">
                <label for="parcours">Parcours de l'étudiant</label>
                <select name="parcours" title="parcours" id="parcours">
                    <option value="allParcours" selected>tous les parcours</option>

                    <?php
                    $parcours = controllerGetAllParcours($conn);
                    foreach ($parcours as $parcour) { ?>
                        <option value="<?= $parcour[0] ?>"><?= $parcour[0] ?></option>
                    <?php } ?>on>parcours C
                    </option>
                </select>
            </div>
        </div>
        <div class="addFormation">
            <label for="addFormation"> Ajouter une formation</label>
            <button type="button" name="addFormation" id="addFormation">+</button>

        </div>
        <br>
        <div class="menuDeroulAnnee">
            <label for="formAnnee"> Année </label>
            <select name="formAnnee" title="formAnnee" id="formAnnee">
                <option value="all" selected>toutes les années</option>
                <option value="1">1er</option>
                <option value="2">2e</option>
                <option value="3">3e</option>
            </select>
        </div>

        <br>

        <div class="menuDeroulPermis">
            <label for="idPermis">Permis</label>
            <select name="isPermis" title="isPermis" id="idPermis">
                <option value="1">oui</option>
                <option value="0">non</option>
            </select>
        </div>









    <h2 class="titreAffichage"> valeur pour l'affichage</h2>



        <div id="checkBoxIne">
            <label for="ine">ine affiché (par défault non)</label>
            <input type="checkbox" id="ine" value="1">
        </div>

        <div id="checkBoxAddress">
            <label for="address"> Adresse affiché (par défault non)</label>
            <input type="checkbox" id="address" value="1">
        </div>

        <div class="checkBoxPhone">
            <label for="phone"> numéro de téléphone (par défault non) </label>
            <input type="checkbox" id="phone" value="1">
        </div>

        <button type="submit" id="valider" name="valider">Valider les paramètres</button>
    </form>

</section>

<footer>
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


</body>
</html>


