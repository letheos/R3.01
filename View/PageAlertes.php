<?php
$conn = require "../Model/Database.php";
require "../Controller/ControllerAlert.php";
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Alertes</title>
</head>
<section class="params">
    <div>
        <form method='POST' action="../Controller/ControllerAlert.php">
            <input type='checkbox' name='Seen' value='on'>
                Montrer alerte futures<br>
            <input type='submit' name='Appliquer' value='Appliquer'>
        </form>
    </div>
</section>

<section class="affichage">
    <div>
        <?php
        showListAlert($conn,$_SESSION["login"]);
        ?>
    </div>
</section>



<body>
































    /h1>

</body>
</html>
