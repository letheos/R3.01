<?php
session_start();
if (empty($_SESSION['user'])) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Télécharger et traiter un fichier CSV</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="PageCreationcss.css">

    <title>Page création utilisateur</title>

    <script src = "../Controller/jsCreation.js"></script>
    <style>
        .bg-custom {
            background-color: #0f94b4;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .img-footer {
            max-width: 200px;
        }

    </style>


</head>
<body>

<header class="banner">
    <form action="PageAccueil.php" class="d-flex flex-column align-items-center">
        <h1 class="TexteProfil">
            Création d'un utilisateur
        </h1>
        <button class="btn btn-light btn-action" type="submit" name="retourAccueil">Retour à l'accueil</button>
    </form>

    <div class="d-flex flex-column align-items-center">
        <form action="PageAffichageEtudiant.php" class="btn-action">
            <button class="btn btn-light" type="submit">Voir les utilisateurs déjà existants</button>
        </form>

        <form action="csv.php" class="btn-action">
            <button class="btn btn-light" type="submit">Inserer plusieurs étudiants grâce à un CSV</button>
        </form>
    </div>
</header>



<div class="container">
    <section class="section-container">
        <h2>Télécharger un fichier CSV</h2>

        <form action="../Controller/csv.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="fichierCSV" class="form-label">Choisissez un fichier CSV :</label>
                <input type="file" id="fichierCSV" name="fichierCSV" class="form-control" accept=".csv">
            </div>

            <div class="file-input-group">
                <input type="submit" value="Télécharger et traiter" class="btn btn-primary">
            </div>
        </form>
    </section>
</div>



    <footer class="bg-custom text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-6 nomFooter">
                    <p>
                        Timothée Allix, Nathan Strady, Theo Parent, Benjamin Massy, Loïck Morneau
                    </p>
                    <p>
                        <a href="https://www.uphf.fr/" class="text-white">Site UPHF</a>
                    </p>
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>

</body>
</html>

