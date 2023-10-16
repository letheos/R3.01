<?php
//$conn = require "../Model/Database.php";
//require "../Controller/ControllerAlert.php";
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="StylePageAlerte.css">
    <title>Alertes</title>
</head>
<body>
<header>
<h1>Gestion des alertes</h1>
</header>


<section class="gestion">
    <div id="show">
        <form method='POST' action="../Controller/ControllerAlert.php">
            Montrer alerte futures
            <input type='checkbox' name='Future' value='on'>
            <br>
            <input type='submit' name='Appliquer' value='Appliquer'>
        </form>
    </div>

    <div id="add">
        <form method="POST" action="../Controller/ControllerAlert.php">
            <p>Ajouter une nouvelle alerte:</p>
            <input type="date" name="date">
            <input type="textarea" name="note">
            <input type='submit' name='Ajouter' value='Ajouter'>
        </form>


    </div>
</section>

<section class="affichage">
    <div>
        <?php
        //showListAlert($conn,$_SESSION["login"]);
        ?>

        <p class="alert"> Date : 12/11/23 Note: test
            <form method="POST" action="../Controller/ControllerAlert.php">
                <input type="submit" name="Supprimer" value="Supprimer" >
                <input type="hidden" value="1" name="id">
        </form>
        </p>
        <p class="alert"> Date : 17/11/23 Note: test
        <form method="POST" action="../Controller/ControllerAlert.php">
            <input type="submit" name="Supprimer" value="Supprimer">
            <input type="hidden" value="2" name="id">
        </form>

        </p>
    </div>
</section>
</body>
</html>
