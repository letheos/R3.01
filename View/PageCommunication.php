<?php


require "../Controller/ControllerCommunication.php";
require "../Controller/ControllerAffichageEtudiant.php";



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="AffichageCandidats.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Echange</title>
</head>
<body>
<header class="banner">
    <button class="btn btn-light" type="submit" name="retourAccueil"
            onclick="window.location.href='PageAccueil.php'">Retour à l'accueil
    </button>
        <h1 class="TexteProfil">
            Communication
        </h1>
</header>
    <form id="filter-form" method="POST" action="../View/PageCommunication.php">

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
                <input type="text" class="form-control" name="nameCandidates" id="nameCandidates" value="<?php echo isset($_POST['name']) ?>" placeholder="Filtrage par nom">
            </div>


            <div class="buttonSubmit btn-right">
                <button class="btn btn-primary" type="submit" name="submit" id="submit"> Rechercher</button>
            </div>
        </section>
    </form>



<section class="afficheCandidats">
    <div class="affichage" id="candidateList">
        <?php
        $candidates = filtrageCommunication();
        foreach ($candidates as $candidate) {
            ?>
            <div class="candidates" id="candidats">
                <p>
                    <?php echo $candidate['firstName'] . " " . $candidate['name'] . " " . $candidate['nameParcours']; ?> <br> <a class="btn btn-primary" href="./PageCommunicationPrecise.php?id=<?php echo $candidate["idCandidate"]; ?>">Voir</a>
                </p>
            </div>
        <?php } ?>
    </div>
</section>

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


<script src="../Controller/js/Ajax.js"></script>
</body>
</html>
