<?php
session_start();
require_once '../Model/ModelConnexion.php';
$conn = require '../Model/Database.php';
include '../Controller/ControllerAccueil.php';
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Accueil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Accueil</title>
</head>
<body>
<script>
    const aDejaVisite = sessionStorage.getItem('aDejaVisite');
    if (!aDejaVisite) {
        window.location.href = 'PageProfil.php';
        sessionStorage.setItem('aDejaVisite','true');
    }
</script>
    <header class="banner">
        <h1>
            Bienvenue dans votre accueil M/Mme <?php getFirstName($conn,$_SESSION['login']) ?>
        </h1>
    </header>
    <section class="barreNavigation">
        <div class="laBarre">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Barre de navigation</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Tableau de bord <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="PageProfil.php">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Liste des candidats</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </section>

    <footer class="bottomBanner"> </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
