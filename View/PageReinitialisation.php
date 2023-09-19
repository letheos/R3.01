<?php
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mot de passe oublié</title>
</head>

<body>
<h1>Mot de passe oublié</h1>
<form method="post" action="../Controller/ControllerReinitialisation.php">
    <div class="form">
        <input type="text" placeholder="Entrez email" name="login" id="login"> <br>
    </div>
    <div class="hyperlink">
        <button type="submit" name="back" id="back"> Retour </button>
    </div>
</form>
</body>

</html>

