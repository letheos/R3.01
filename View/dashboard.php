<?php
require "../Controller/ControllerAffichageEtudiant.php";

if (isset($_POST['parcours'])) {
    // Récupère la valeur de $_POST['parcours'] dans la variable $selectedParcours
    $selectedParcours = $_POST['parcours'];
} else {
    // Si 'parcours' n'est pas défini, initialise $selectedParcours à une valeur par défaut ou laissez-le vide.
    $selectedParcours = '';
}

$formationHere = ["Informatique","Génie industriel et maintenance","Génie électrique et informatique industrielle"];
$parcoursHere = ["Parcours Informatique A","Parcours A - GEII","Parcours Informatique B", "Parcours X - GIM" , "Parcours A - GEII"];
?>
<script>
    const data = <?php echo json_encode($parcoursHere); ?>;
    const selectedParcours = <?php echo json_encode($selectedParcours); ?>
</script>

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
        NOM DU DASHBOARD
    </h1>
</header>

<form id="filter-form" method="POST" action="../View/dashboard.php">

    <section class="filtreCandidats">

        <div class="selection">
            <label for="formation" class="form-select-label"> Département </label>
            <div class="multiselect" >
                <div class="selectBox" onclick="showCheckboxes('checkboxesFormation')">
                    <select class="form-select" id="formation">
                        <option>Selectionner plusieurs formations</option>
                    </select>
                    <div class="overSelect"></div>
                </div>
                <div class="checkboxes-container" id="checkboxesFormation">
                    <?php foreach ($formationHere as $formation) { ?>
                        <label for="<?php echo $formation; ?>">
                            <input type="checkbox" name="formation[]" onchange="onChangeUpdateDisplayMultiple('../Controller/ControllerDashboardAjax.php', data, selectedParcours)" value="<?php echo $formation; ?>" <?php echo (isset($_POST['formation']) && in_array($formation, $_POST['formation'])) ? 'checked' : ''; ?>> <?php echo $formation; ?>
                        </label>
                    <?php } ?>
                </div>
            </div>
        </div>


        <div class="selection">
            <label for="parcours" class="form-select-label"> Parcours </label>
            <div class="multiselect">
                <div class="selectBox" onclick="showCheckboxes('checkboxesParcours')">
                    <select class="form-select"  id="parcours">
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
            <label for="isNotActive" class="form-check-label"> Affiche les Non-actifs </label>
        </div>

        <div class="checkbox">
            <input class="form-check" type="checkbox" name="isFound" id="isFound" <?php echo (isset($_POST['isFound'])) ? 'checked' : ''; ?>>
            <label for="isFound" class="form-check-label"> Affiche ceux qui ont une alternance </label>
        </div>

        <div class="buttonSubmit">
            <button class="btn btn-primary" type="submit" name="submit" id="submit"> Rechercher</button>
        </div>
    </section>
</form>

<form id="delete-form" method="post" action="../Controller/ControllerGestionDashboard.php">
    <section class="afficheCandidats">
        <div class="affichage" id="candidateList">
            <?php
            $candidates = filtrageMultiple();
            foreach ($candidates as $candidate) {
                ?>
                <div class="candidates" id="candidats">
                    <p>
                        <?php echo $candidate['firstName'] . " " . $candidate['name'] . " " . $candidate['nameParcours']; ?> <br>
                        <a class="btn btn-primary" href="./PageAffichageCandidatDashboardPrecis.php?id=<?php echo $candidate["idCandidate"]; ?>">Détail</a>

                        <?php
                        if ($candidate['isInActiveSearch']) {
                            ?>
                            <input type="checkbox" name="checkboxActif[]" value="<?php echo $candidate['idCandidate']; ?>"> Rendre Inactif
                            <?php
                        } else {
                            ?>
                            <input type="checkbox" name="checkboxNonActif[]" value="<?php echo $candidate['idCandidate']; ?>"> Rendre Actif
                            <?php
                        }
                        ?>

                        <?php if ($candidate['foundApp'] == 0) { ?>
                            <input type="checkbox" name="checkboxNoAlternance[]" value="<?php echo $candidate['idCandidate']; ?>">
                            Enlever la recherche d'alternance
                        <?php } else { ?>
                            <input type="checkbox" name="checkboxWithAlternance[]" value="<?php echo $candidate['idCandidate']; ?>">
                            Rendre en recherche d'alternance
                        <?php } ?>

                        <br>

                        <span style="color: <?php echo ($candidate['foundApp'] == 0) ? '#bb2323' : 'green'; ?>">
                        <?php echo ($candidate['foundApp'] == 0) ? 'N\'a pas d\'alternance' : 'A une Alternance'; ?>
                        </span>
                    </p>
                </div>
            <?php } ?>
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