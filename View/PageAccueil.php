<?php
session_start();
$conn = require '../Model/Database.php';
include '../Controller/ControllerAccueil.php';
include '../Controller/ClassUtilisateur.php';
$user = unserialize($_SESSION['user']);



?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Accueil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
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


    </style>
</head>
<body>
<script src="../Controller/ControllerAccueilJS.js"></script>
    <header class="jumbotron text-center bg-custom text-white">
        <h1 class="display-10">
            Bienvenue dans votre accueil M/Mme <?php echo $user->getFirstName() ?>
        </h1>
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
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="PageProfil.php">Profil</a>
                            </li>
                        </ul>
                    </ul>
                </div>
            </nav>

        </div>
    </section>

<section class="vh-100 justify-content-center">
    <?php $alerts = getActualAlert($user->getLogin()); ?>
    <div class="container border p-4 <?php echo count($alerts) < 5 ? 'min-height-alerts' : ''; ?>">
        <h1 class="text-center">Rappel du jour</h1>

        <?php foreach ($alerts as $alert) { ?>
            <div class="alert alert-primary mt-3">
                <p class="mb-0">Date: <?= $alert["remindAt"] ?></p>
                <p class="mb-0">Note: <?= $alert["note"] ?></p>
                <div class="mt-3">
                    <a class="btn btn-primary" href="./PageAlertes.php">Aller voir</a>
                </div>
            </div>
        <?php } ?>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
