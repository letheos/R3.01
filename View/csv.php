<?php
/*
//On passe la valeur a null si elle n'existe pas
if(!isset($_SESSION["login"])){
    $_SESSION['login'] = null;
}
//On passe la valeur a null si elle n'existe pas
if(!isset($_SESSION["password"])){
    $_SESSION['password'] = null;
}
//Cette condition sert à verifier que la personne accedant a la page d'accueil
if ($_SESSION['login'] == null || $_SESSION['password'] == null) {
    //$_SESSION['provenance'] = 'Accueil';
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}
*/
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

</head>
<body>

<header class="banner">
    <form action="PageAccueil.php">
        <h1 class="TexteProfil">
            Création d'un utilisateur
        </h1>
        <button class="btn btn-light" type="submit" name="retourAccueil">Retour à l'accueil
        </button>
    </form>

    <form action="PageAfficheTableau.php">
        <button>Voir les utilisateurs déjà existants</button>
    </form>

    <form action="csv.php">
        <button>Inserer plusieurs étudiants grace à un CSV</button>
    </form>


</header>




<h2>Télécharger un fichier CSV</h2>

<form action="../Controller/csv.php" method="post" enctype="multipart/form-data">
    <label for="fichierCSV">Choisissez un fichier CSV :</label>
    <input type="file" id="fichierCSV" name="fichierCSV" accept=".csv">
    <br>
    <input type="submit" value="Télécharger et traiter">
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>


<footer class="bottomBanner">
    <div class="nomFooter">
        <p>
            Timothée Allix, Nathan Strady, Theo Parent, Benjamin Massy, Loïck Morneau

        </p>
        <p>
            <a href="https://www.uphf.fr/"> site uphf </a></p>
    </div>
    <div class="origineFooter">
        <p>
            2023/2024 UPHF
        </p>
        <img src="logoUphf.png" alt="logo uphf">

    </div>
</footer>

</body>
</html>

