<?php
$conn = require "../Model/Database.php";
require "../Controller/ControllerAffichageEtudiantPrecis.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_GET['id'])){
    $id = $_GET['id'];

}

$infotCandidat = selectCandidatById($conn, $id);
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="AffichageCandidatsPrecis.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Affichage précis</title>
</head>
<body>

    <header class="banner">
        <a class="btn btn-light" href="./PageAffichageEtudiant.php" style="position: absolute; top: 0; left: 0;"> Retour à l'affichage candidat </a>
        <h1>
            Le candidat
        </h1>
    </header>


    <section class="Affiche">
        <div class="rounded-box">
            <?php
            afficherEtudiant($conn,$id);
            ?>

            <form method="post" action="../Controller/ControllerActifInactif.php">
                <div class="buttonIsActivate">
                    <?php
                    $donnes = isInActiveSearch($conn,$id);
                    if ($donnes["isInActiveSearch"] == 1){?>
                        <button type="submit" class="btn btn-outline-danger" name="desactivate" >Rendre Inactif</button>
                    <?php
                    } else {?>

                    <button type="submit" class="btn btn-outline-success" name="activate"> Rendre Actif </button>
                    <?php
                    }
                    ?>
                    <input type="hidden" id="idValue" name="idValue" value="<?php echo $id ?>">
                    <a class="btn btn-primary" href="./PageModifierCandidat.php?id=<?php echo $id ?>"> Modifier le candidat</a>
                </div>
            </form>
        </div>
    </section>

    <footer class="bottomBanner"> </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
