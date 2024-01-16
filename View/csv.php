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

