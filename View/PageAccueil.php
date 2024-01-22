<?php

session_start();
$conn = require '../Model/Database.php';
include '../Controller/ControllerAccueil.php';
include '../Controller/ClassUtilisateur.php';
include "../Controller/traduction.php";
$user = unserialize($_SESSION['user']);


if ($user->getRole() == "Chef de service") {
    $formations = getAllFormation();
} else {
    $formations = $user->getLesFormations();
}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <title>Accueil</title>
    <style>
        .bg-custom {
            background-color: #0f94b4;
        }


        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex-grow: 1;
        }

        .img-footer {
            max-width: 100%;
            height: auto;
            max-height: 60px;
        }

    </style>
</head>
<body>
<script src="../Controller/ControllerAccueilJS.js"></script>
<header class="jumbotron text-center bg-custom text-white d-flex justify-content-between">
    <h1 class="display-10">
        Bienvenue dans votre accueil M/Mme <?php echo $user->getFirstName() ?>
    </h1>
    <a class="nav-link" href="PageProfil.php">
        <i class="bi bi-person" style="font-size: 3em;"></i>
    </a>
</header>

    <section>
        <div>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Barre de navigation</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="PageAfficheTableau.php">Tableau de bord</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="PageAlertes.php">Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="PageCommunication.php">Accéder aux échanges</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="PageAffichageEtudiant.php">Afficher les étudiants</a>
                        </li>
                        <?php if ($user->getRole() == "Chef de service"): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="PageCreation.php">Créer un utilisateur</a>
                            </li>
                        <?php endif; ?>
                        <?php if ($user->getRole() == "Chef de service" || $user->getRole() == "Secretaire" || $user->getRole() == "Charge de developpement"): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="PageCreationCompte.php">Enregistrer un candidat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="PageSendCandidateCV.php">Envoyer un CV</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>

        </div>
    </section>

<main class="vh-100 d-flex justify-content-center">
    <?php $alerts = getActualAlert($user->getLogin()); ?>
    <div class="container <?php echo count($alerts) < 5 ? 'min-height-alerts' : ''; ?>">
        <div class="row">
            <div class="col-md-4" style="border: 1px solid #000; padding: 5px;">
                <h1 class="text-center">Rappel</h1>
                <?php foreach ($alerts as $alert) { ?>
                    <div class="alert alert-primary mb-3">
                        <p class="mb-0">Date: <?= $alert["remindAt"] ?></p>
                        <p class="mb-0">Note: <?= $alert["note"] ?></p>
                        <div class="mt-3">
                            <a class="btn btn-primary" href="./PageAlertes.php">Aller voir</a>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="col-md-8 container" style="border: 1px solid #000; padding: 5px;">
                <h2 class="text-center">Informations Générales</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Formations</th>
                        <th scope="col">Nombre Candidats</th>
                        <th scope="col">Actifs</th>
                        <th scope="col">Inactifs</th>
                        <th scope="col">Avec Contrat</th>
                        <th scope="col">Sans Contrat</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($formations as $formation){
                        $nbStudentFormation = getNbEtuPerFormation($formation['nameFormation']);?>
                        <tr>
                            <td><?= $formation['nameFormation'] ?></td>
                            <td><?= (isset($nbStudentFormation['effectifFormation'])) ? $nbStudentFormation['effectifFormation'] : "0"; ?></td>
                            <td style="color: green;"><?= isset($nbStudentFormation['actifs']) ? $nbStudentFormation['actifs'] : 0; ?></td>
                            <td style="color: red;"><?= isset($nbStudentFormation['inactifs']) ? $nbStudentFormation['inactifs'] : 0; ?></td>
                            <td style="color: green;"><?= isset($nbStudentFormation['alternants']) ? $nbStudentFormation['alternants'] : 0; ?></td>
                            <td style="color: red;"><?= isset($nbStudentFormation['non_alternants']) ? $nbStudentFormation['non_alternants'] : 0; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>




<footer class="bg-custom text-white mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div>
                    <p>
                        Timothée Allix, Nathan Strady, Theo Parent, Benjamin Massy, Loïck Morneau
                    </p>
                </div>
            </div>
            <div class="col-md-6 origineFooter text-end">
                <p>
                    2023/2024 UPHF
                </p>
                <img src="../image/logoUphf.png" alt="logo uphf" class="img-fluid img-footer">
            </div>
        </div>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
