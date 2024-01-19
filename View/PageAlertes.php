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
        <style>
            .bg-custom {
                background-color: #0f94b4;
            }

            footer {
                position: fixed;
                bottom: 0;
                width: 100%;
            }

            .affichage {
                padding: 20px;
            }

            .alert-box {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
            }

            .alert {
                border: 1px solid #dee2e6;
                padding: 15px;
                border-radius: 5px;
                background-color: #f8f9fa;
            }

            #lanote {
                margin-top: 10px;
            }
        </style>
    </head>
    <body>

    <header class="bg-custom text-white">
        <form action="PageAccueil.php" method="post">
            <button class="btn btn-light" type="submit" name="retourAccueil">
                Retour à l'accueil
            </button>

        </form>
        <div class="text-center">
            <h1>Alertes</h1>
        </div>
    </header>

    <section>
        <div id="add" class="container">
            <h1>Ajouter une nouvelle alerte :</h1>
            <form method="POST" action="../Controller/ControllerAlert.php">
                <!-- Add your existing form for adding alerts here -->
                <div class="form-group">
                    <input type="date" class="form-control" name="Date" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="form-group">
                    <label for="Note">Note:</label>
                    <textarea class="form-control" name="Note" maxlength="300" required></textarea>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="Global" id="Global" value="on">
                    <label class="form-check-label" for="Global">Alerte générale (Tous les utilisateurs seront notifiés)</label>
                </div>
                <button type="submit" class="btn btn-primary" name="Add">Ajouter</button>
            </form>
        </div>
    </section>


    <section class="affichage">
        <div class="container">
            <h1>Les alertes :</h1>
            <form method="POST" action="../Controller/ControllerAlert.php">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="Future" id="Future" value="on">
                    <label class="form-check-label" for="Future">Montrer alertes prévues</label>
                    <button type="submit" class="btn btn-primary" name="Apply" value="<?= isset($_POST['Apply']) ? 'checked' : '' ?>">Appliquer</button>
                </div>
            </form>
            <div class="alert-box">
                <?php
                $results = ListAlert($user->getLogin(), $f);
                foreach ($results as $row) {
                    ?>
                    <div class="alert">
                        <p>Date: <?= $row[2] ?></p>
                        <p id="lanote">Note: <?= $row["note"] ?></p>
                        <form method="POST" action="../Controller/ControllerAlert.php">
                            <input type="submit" class="btn btn-danger" name="Delete" value="Supprimer">
                            <input type="hidden" name="id" value="<?= $row[0] ?>">
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>


    <footer class="bg-custom text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div>
                        <p>
                            Timothée Allix, Nathan Strady, Theo Parent, Benjamin Massy, Loïck Morneau
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <p>
                            2023/2024 UPHF
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
