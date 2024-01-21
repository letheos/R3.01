<?php

$conn = require "../Model/Database.php";
require_once  "../Controller/ControllerAffichageEtudiant.php";session_start();

$user = unserialize($_SESSION['user']);

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="SendCandidateCV.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        .bg-custom {
            background-color: #0f94b4;
        }


        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }

    </style>
    <title>SendMail</title>
</head>

<body>

<header class="banner">
    <form action="PageAccueil.php" class="container">
        <h1 class="TexteProfil">
            Envoi de CV
        </h1>
        <button class="btn btn-light" type="submit" name="retourAccueil">Retour à l'accueil</button>
    </form>
</header>





<form id="send-form" method="POST" action="../Controller/ControllerSendCandidateCV.php">





    <section class="filtreCandidats">

        <div class="selection mb-3">
            <label for="formation" class="form-label">Département</label>
            <select class="form-select" name="formation" id="formation" onchange="onChangeUpdateDisplayParcours('../Controller/ControllerParcoursAffichage.php')">
                <option value="" selected disabled>Choisir la formation</option>
                <?php
                if ($user->getRole() == "Chef de service") {
                    $formations = getAllFormation();
                } else {
                    $formations = $user->getLesFormations();
                }

                $selected = '';
                $selectedFormation = (isset($_POST['formation'])) ? $_POST['formation'] : '';
                foreach ($formations as $formation) {
                    $selected = ($selectedFormation == $formation['nameFormation']) ? 'selected' : ''; ?>
                    <option value="<?php echo $formation['nameFormation']; ?>" <?php echo $selected ?>><?php echo $formation['nameFormation']; ?></option>
                <?php } ?>
                <option value="Aucune Option">Aucune Option</option>
            </select>

            <label for="parcours" class="form-label">Parcours</label>
            <select class="form-select" name="parcours" id="parcours">
                <option value="" selected disabled>Choisir un parcours</option>
                <option value="<?php echo $_POST['parcours']; ?>" <?php echo (isset($_POST['parcours'])) ? 'selected' : ''; ?>><?php echo $_POST['parcours']; ?></option>
            </select>

            <label for="year" class="form-label">Année de formation</label>
            <select class="form-select" name="year" id="year">
                <option value="1ère Année">1ère Année</option>
                <option value="2ème Année">2ème Année</option>
                <option value="3ème Année">3ème Année</option>
            </select>
        </div>

        <div class="buttonSubmit">
            <button class="btn btn-primary" type="button" name="submit" id="add" onclick="addText()">Envoyer le(s) CV(s)</button>
        </div>

        <div class="buttonSubmit">
            <button class="btn btn-primary" type="button" name="DlButton" id="DlButton" onclick="dl()">Télécharger le(s) CV(s)</button>
        </div>

    </section>

    <?php
    if(isset($_SESSION["message"])){
        if ($_SESSION['success'] == 0) {?>
            <div class="alert alert-danger">
                <?php echo $_SESSION["message"]; ?>
            </div>
        <?php } else { ?>
            <div class="alert alert-success">
                <?php echo $_SESSION["message"]; ?>
            </div>
            <?php
        }
        unset($_SESSION["erreur"]);
        unset( $_SESSION["message"]);
    }
    ?>


    <section class="sendMail container">
        <div class="from" id="from">
            <ol id="fromCV" style="list-style-type: none;"></ol>
        </div>

        <div class="destinataire row">
            <div class="col-12">
                <label for="to" class="form-label">Destinataire</label>
                <textarea class="form-control" name="to" placeholder="Destinataire"></textarea>
            </div>
        </div>

        <div class="corps row mt-3">
            <div class="col-12">
                <label for="message" class="form-label">Message du Mail</label>
                <textarea class="form-control" name="message" placeholder="Ecrivez le mail"></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary" type="submit" name="submit" id="submit">Envoyer</button>
        </div>
    </section>




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
                <div class="col-md-6 d-flex justify-content-between align-items-center text-end">
                    <div>
                        <p>
                            2023/2024 UPHF
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>


</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="../Controller/js/ControllerSendCandidateCVJS.js"></script>
<script src="../Controller/js/Ajax.js"></script>


</body>
</html>
