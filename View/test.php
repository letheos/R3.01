<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MultiSelect Example</title>
</head>
<body>

<form action="traitement.php" method="post">
    <label for="fruits">Sélectionnez des fruits :</label>
    <select id="fruits" name="fruits[]" multiple>
        <option value="pomme">Pomme</option>
        <option value="orange">Orange</option>
        <option value="banane">Banane</option>
        <option value="fraise">Fraise</option>
        <option value="raisin">Raisin</option>
    </select>
    <br>
    <input type="submit" value="Soumettre">
</form>

</body>
</html>
