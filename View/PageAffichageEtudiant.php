<?php
include "../Controller/ControllerAffichageEtudiant.php";

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
            <label for="formation" class="form-select-label"> Département </label>
            <select class="form-select" name="formation" id="formation" onchange="onChangeUpdateDisplayParcours('../Controller/ControllerParcoursAffichage.php')">
                <option value="" selected="selected" disabled> Choisir la formation </option>
                <?php $formations = getAllFormation();
                $selected = '';
                $selectedFormation = (isset($_POST['formation'])) ? $_POST['formation'] : '';
                foreach ($formations as $formation)
                {
                    $selected = ($selectedFormation == $formation['nameFormation']) ? 'selected' : '';?>
                    <option value="<?php echo $formation['nameFormation']; ?>" <?php echo $selected ?>> <?php echo $formation['nameFormation']; ?></option><?php
                } ?>
                <option value="Aucune Option" > Aucune Option </option>
            </select>

            <label for="parcours" class="form-select-label"> Parcours </label>
            <select class="form-select" name="parcours" id="parcours">
                <option value=""> Choisir un parcours </option>
                <option value="<?php echo $_POST['parcours']; ?>" <?php echo (isset($_POST['parcours'])) ? 'selected' : ''; ?>><?php echo $_POST['parcours']; ?></option>
            </select>
        </div>

        <div class="formName">
            <input type="text" class="form-control" name="nameCandidates" id="nameCandidates" value="<?php echo $_POST['nameCandidates'] ?>" placeholder="Filtrage par nom">
        </div>

        <div class="checkbox">
            <input class="form-check" type="checkbox" name="isActive" id="isActive" <?php echo ($_POST['isActive'] === 'on') ? 'checked' : ''; ?>>
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
        <?php
        $candidates = filtrage();
        foreach ($candidates as $candidate)
        {   ?>
            <p class="candidates" id="candidats"> <?php echo $candidate['firstName'] . " " . $candidate['name'] . " " . $candidate['nameParcours']; ?> <br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id=<?php echo $candidate["idCandidate"]; ?>">Détail</a>
            <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id="<?php echo $candidate['idCandidate']; ?>" onclick="showAlert(this)">Supprimer</button>
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
        } ?>
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
<script src="../Controller/jsAffichage.js"></script>
<script src="../Controller/js/Ajax.js"></script>
</body>
</html>
