<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "../Controller/ControllerCommunicationPrecise.php";
include "../Controller/traduction.php";
include "../Controller/ClassUtilisateur.php";

$_SESSION['idCandidate'] = $_GET["id"];

$user = unserialize($_SESSION['user']);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="StylePageCommunicationPrecise.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Echange</title>
    <style>
        .bg-custom {
            background-color: #0f94b4;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<header class="banner bg-custom text-white text-center py-4">
    <h1 class="mb-0">
        Communication
    </h1>
    <a class="btn btn-light" type="submit" href="./PageCommunication.php">Retour arrière</a>
</header>


<section>
    <h1> Ajouter une information </h1>
    <div id="add" class="col-md-6">
        <form method="POST" action="../Controller/ControllerCommunicationPrecise.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="Note">Ajouter une nouvelle information :</label>
                <textarea class="form-control" name="Note" maxlength="300"></textarea>
            </div>
            <div class="form-group">
                <label for="imgbutton">Ajouter une pièce jointe</label>
                <input type="file" class="form-control-file" name="imgbutton" id="imgbutton" accept=".pdf, .png, .jpg, .jpeg">
            </div>
            <button type="submit" name="Add" class="btn btn-primary btn-sm">Ajouter</button>
        </form>
    </div>
</section>

<section class="container mt-4">
    <?php
    $results = getComm($_SESSION['idCandidate']);
    $candidat = getCandidate($_SESSION['idCandidate']);
    ?>

    <h1>Liste des échanges avec <?= $candidat['name'] . " " . $candidat["firstname"] ?></h1>

    <?php
    foreach ($results as $row) {
        if ($row[4]!=null){
            $str="Modifié le :".date('Y-m-d H:i', strtotime($row[4]));
        }
        else {
            $str = "";
        }
        ?>
        <form action="../Controller/ControllerCommunicationPrecise.php" method="POST" id="<?= $row[2] ?>">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="candidates" id="candidates<?= $row[2] ?>">
                        <?php
                        if ($row[0] == "") {
                            ?>
                            <img src="../upload/<?= $row[3] ?>" class="img-fluid" alt="Image" style="max-height: 100px; object-fit: cover;">
                            <?php
                        } else {
                            echo $row[0];
                        }
                        ?>
                    </div>
                    <small class="text-muted"><?= date('Y-m-d H:i', strtotime($row[1]))?></small>
                    <br>
                    <small class="text-muted"> <?php echo $str ?> </small>
                    <input type="hidden" name="idmessage" value="<?= $row[2] ?>">
                    <div class="mt-3" id="bouton_candidates<?= $row[2] ?>">
                        <button class="btn btn-primary btn-sm" type="button" name="Modify" id="Modify" onclick="transformToTextarea('candidates<?= $row[2] ?>')">Modifier</button>
                        <button class="btn btn-primary btn-sm" type="button" name="Validate" id="Validate" value="Valider" style="display:none" onclick="executerFormulaire(<?= $row[2] ?>)"> Valider </button>
                        <input type="submit" class="btn btn-danger btn-sm" name="Delete" value="Supprimer">
                    </div>
                </div>
            </div>
        </form>
        <?php
    }
    ?>
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
</body>
</html>
<script src="../Controller/js/ControllerCommunicationJS.js"></script>