<?php
require "../Controller/ControllerModifTableau.php";
//empécher de modifier les dashboard par défault si l'utilisateur est pas admin
session_start();
$conn = require "../Model/Database.php";
if(isset($_POST['ine']) and isset($_POST['address']) and isset($_POST['phone']) and isset($_POST['permis'])){
    //fonction qui change les valuers et je l'appelle la avec les valeurs en paramètres
    //condition php avec un $_POST qui appelle une fonction js
}

if(isset($_SESSION['login'])){
    $Role = $_SESSION['login'];
}else{
    $Role = $_SESSION['login'] = 'user1';
}


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
    <title>modificationTableauDeBord</title>
    <script src="../Controller/JsCreationTableau.js"></script>
</head>
<body>

<header class="banner">
    <form>
        <h1 class="TexteProfil">
            Modification de tableau de bord numéro <?=$_POST['idDashboard'] ?>

        </h1>

        <button class="btn btn-light" type="submit" name="retourAccueil"
                onclick="window.location.href='PageAccueil.php'">Retour à l'accueil
        </button>
    </form>

    <form action="PageAfficheTableau.php">
        <button >Retourner voir les autres tableaux de bords</button>
    </form>



</header>
<form method="post" action="../Controller/ControllerModifTableau.php">
    <button
            type="submit" id="validate" name="validate"  onclick="window.location.href='PageAfficheTableau.php'">Valider les paramètres
    </button>

    <input type="hidden" name="idDashboard" value="<?=$_POST['idDashboard'] ?>" >


    <div class=container>
    <div class=column>
        <div class="rounded-box">
            <h2>Choix des parcours</h2>
            <div class="accordion" id="choicesDep">
                <?php
                $formations = getAllFormation($conn);
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
            <br>
            <label for="choix">choix de l'année des étudiants</label>
            <select id="choix" name="choix">
                <option value="1er"> 1er année </option>
                <option value="2e"> 2e année  </option>
                <option value="3e"> 3e année </option>
            </select>
        </div>

    </div>
    <!--bonnes fermetures de balises -->

    <div class=column>
        <div class=rounded-box>
            <h2 class="titreAffichage"> valeur pour l'affichage</h2>

            <div id="checkBoxIne">
                <input type="checkbox" id="ine" name="ine"
                    <?php if((isset($_POST['ine'])) and $_POST['ine']) echo 'checked ' ?>>
                <label for="ine">ine affiché (par défaut non)</label>
            </div>


            <div id="checkBoxAddress">
                <input type="checkbox" id="address" name="address" )"
                    <?php if((isset($_POST['address']) && $_POST['address'])) echo 'checked' ?>>
                <label for="address"> Adresse affichée (par défaut non)</label>
            </div>

            <div class="checkBoxPhone">
                <input type="checkbox" id="phone" name="phone"
                    <?php if((isset($_POST['phone'])) and $_POST['phone']) echo 'checked' ?> >
                <label for="phone"> numéro de téléphone (par défaut non) </label>
            </div>

            <div class = "checkboxpermis">
                <input type="checkbox" id ="permis" name="permis"
                    <?php if((isset($_POST['permis'])) and $_POST['permis']) echo 'checked' ?>>
                <label for="permis">permis affiché (par défaut non)</label>
            </div>


        </div>
    </div>


        <div class="rounded-box"  <?= ($_SESSION['role'] != 'Admin') ? 'style="display: none;"' : '' ?> >
            <h2>Role à inclure dans la création du tableau de bord</h2>
            <?php
            $roles = controllerGetAllRole($conn);
            $id = 0;
            foreach ($roles as $role) {
                $id += 1;

                ?>
                <input type="checkbox" id="<?= 'role' . $id ?>" name="<?= $role[1] ?>" value="1" <?php if((isset($_SESSION['role'])) and $_SESSION['role'] === $role[1]) echo 'checked' ?> >
                <label for="<?= 'role' . $id ?>"> inclure <?php echo $role[1] ?></label>
                <br>
                <?php
            } ?>

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
        <label for="title">entrée le nom du tableau de bord</label>
        <input id="title" name="title" type="text" value="<?=$_POST['title']?>">
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


