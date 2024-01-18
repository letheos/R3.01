<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn = require "../Model/Database.php";
require "../Controller/ControllerAlert.php";
$f=false;
if(isset($_SESSION["Future"])){
    $f=$_SESSION["Future"];
}

$user = unserialize($_SESSION['user']);

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="StylePageAlerte.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <title>Alertes</title>
    </head>
    <body>
    <header class="banner">
        <form action = PageAccueil.php>
            <h1 class="TexteProfil">
                Alertes
            </h1>
            <button class="btn btn-light" type="submit" name="retourAccueil"
                    >Retour à l'accueil
            </button>
        </form>
    </header>

        <section class="gestion">
            <div id="add">
                <form method="POST" action="../Controller/ControllerAlert.php">
                    <!-- Add your existing form for adding alerts here -->
                    <p>Ajouter une nouvelle alerte:</p>
                    <label>
                        <input type="date" name="Date" min=<?php echo Date('Y-m-d') ?> value=<?php echo Date('Y-m-d') ?>>
                    </label>
                    <label>
                        <textarea name="Note" maxlength="300" required></textarea>
                    </label>
                    <br>
                    Alerte générale (Tous les utilisateurs seront notifiés):
                    <label>
                        <input type='checkbox' name='Global' value='on'>
                    </label> <br>
                    <input type='submit' name='Add' value='Ajouter'>
                </form>
            </div>
            <div id="show">
                <form method='POST' action="../Controller/ControllerAlert.php">
                    Montrer alertes prévues
                    <label>
                        <input type='checkbox' name='Future' value='on'>
                    </label> <br>
                    <input type='submit' name='Apply' value='Appliquer'>
                </form>
            </div>
        </section>

    <section class="affichage">
        <div class="alert-box">
            <?php
            $results = ListAlert($user->getLogin(), $f);
            foreach ($results as $row) {
                ?>
                <div class="alert"> Date: <?= $row[2] ?>
                    <br> <p id="lanote"> Note: <?= $row["note"] ?> </p>
                    <form method="POST" action="../Controller/ControllerAlert.php">
                        <input type="submit" name="Delete" value="Supprimer">
                        <input type="hidden" name="id" value="<?= $row[0] ?>">
                    </form>
                </div>
            <?php } ?>
        </div>
    </section>


    <footer>
        <div class="bottomBanner">
            <p>
                Timothée Allix, Nathan Strady, Theo Parent, Benjamin Massy, Loïck Morneau

            </p>
            <p>
                2023/2024 UPHF
            </p>
        </div>

    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
