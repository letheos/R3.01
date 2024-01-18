<?php
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Télécharger et traiter un fichier CSV</title>
</head>
<body>

<h2>Télécharger un fichier CSV</h2>

<form action="../Controller/csv.php" method="post" enctype="multipart/form-data">
    <label for="fichierCSV">Choisissez un fichier CSV :</label>
    <input type="file" id="fichierCSV" name="fichierCSV" accept=".csv">
    <br>
    <input type="submit" value="Télécharger et traiter">
</form>

</body>
</html>

