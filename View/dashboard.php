<?php
require "../Controller/ControllerAffichageDashboard.php";
require "../Controller/ControllerAffichageEtudiant.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$formationHere = ["Génie mécanique et productique","Génie industriel et maintenance","Génie électrique et informatique industrielle"];
$parcoursHere = ["Parcours Informatique A","Parcours A - GEII","Parcours X - GIM", "Parcours 1 - GMP"];
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="AffichageDashBoard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="../Controller/JsDashBoard.js"></script>
    <title>Les Candidats</title>
</head>

<body>

<header class="banner">
    <h1>
        Les profils candidats
    </h1>
</header>

<form id="filter-form" method="POST" action="../View/dashboard.php">

    <section class="filtreCandidats">

        <div class="selection">
            <label for="formation" class="form-select-label"> Département </label>
            <div class="multiselect" >
                <div class="selectBox" onclick="showCheckboxes('checkboxesFormation')">
                    <select class="form-select" name="formation" id="formation">
                        <option>Selectionner plusieurs formations</option>
                    </select>
                    <div class="overSelect"></div>
                </div>
                <div class="checkboxes-container" id="checkboxesFormation">
                    <?php foreach ($formationHere as $formation) { ?>
                        <label for="<?php echo $formation; ?>">
                            <input type="checkbox" name="formation[]" onchange="onChangeUpdateDisplayMultiple('../Controller/ControllerDashboardAjax.php')" value="<?php echo $formation; ?>"> <?php echo $formation; ?>
                        </label>
                    <?php } ?>
                </div>
            </div>
        </div>


        <div class="selection">
            <label for="parcours" class="form-select-label"> Parcours </label>
            <div class="multiselect">
                <div class="selectBox" onclick="showCheckboxes('checkboxesParcours')">
                    <select class="form-select" name="parcours" id="parcours">
                        <option>Selectionner plusieurs parcours</option>
                    </select>
                    <div class="overSelect"></div>
                </div>
                <div class="checkboxes-container" id="checkboxesParcours">
                </div>
            </div>
        </div>

        <div class="formName">
            <input type="text" class="form-control" name="nameCandidates" id="nameCandidates" value="<?php echo isset($_POST['nameCandidates']) ? $_POST['nameCandidates'] : ''; ?>" placeholder="Filtrage par nom">
        </div>

        <div class="checkbox">
            <input class="form-check" type="checkbox" name="isActive" id="isActive" <?php echo (isset($_POST['isActive'])) ? 'checked' : ''; ?>>
            <label for="isNotActive" class="form-check-label"> Non-actif </label>
        </div>

        <div class="buttonSubmit">
            <button class="btn btn-primary" type="submit" name="submit" id="submit"> Rechercher</button>
        </div>
    </section>
</form>

<form id="delete-form" method="post" action="../Controller/ControllerGestionEtudiant.php">
    <section class="afficheCandidats">
        <div class="affichage" id="candidateList">
            <input type="hidden" id="candidateId" name="candidateId" value="">
        </div>
    </section>

    <footer class="bottomBanner">
        <div class="buttonActivationCandidates">
            <button class="btn btn-primary" type="submit" name="submit" id="submit"> Changer l'état des candidats</button>
        </div>
    </footer>

</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="../Controller/js/DashboardAjax.js"></script>
</body>
</html>
