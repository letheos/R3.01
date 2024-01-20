<?php
session_start();
include '../Controller/ControllerPageProfil.php';
$conn = require '../Model/Database.php';
include '../Controller/ClassUtilisateur.php';
$user = unserialize($_SESSION['user']);
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../Controller/ControllerPageProfilJS.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <title>Profil</title>
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

<header class="banner d-flex bg-custom justify-content-between align-items-center">
    <div>
        <a style="font-size: 3em; color: white;" type="submit" href="PageAccueil.php">
            <i class="bi bi-arrow-left"></i>
        </a>
    </div>
    <div>
        <h1 class="text-white">Votre Profil</h1>
    </div>
    <div class="d-flex">
        <div class="d-inline-block">
            <a id="modification" style="font-size: 3em; color: white;" type="submit" name="modification" onclick="modificate()">
                <i class="bi bi-gear"></i>
            </a>
            <a id="disconnect" style="font-size: 3em; color: white;" type="submit" name="disconnect" onclick="disconnect()">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </div>
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
                        <a class="nav-link" href="PageCommunication.php"> Accéder aux échanges </a>
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

<form method="POST" id="form" action="PageProfil.php">
    <section>
        <div class="container">
            <div class="card bg-custom">
                <?php $result = getUserProfile($user->getLogin()); ?>
                <div class="card-header text-white">
                    <h2 class="card-title">Information du profil</h2>
                </div>
                <div class="card-body bg-white">
                    <p class="card-text">
                        <strong>Utilisateur :</strong> <?= $result["userName"] . " " . $result["firstName"]; ?> <br>
                        <strong>Login :</strong> <?= $result['login'] ?><br>
                        <strong>Email :</strong> <?= $result['email']; ?> <br>
                        <strong>Rôle :</strong> <?= $user->getRole(); ?>
                    </p>
                    <button class="btn btn-primary" type="submit" name="modifierMotdePasse">Modifier mot de passe</button>
                </div>
            </div>
        </div>
    </section>
</form>


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