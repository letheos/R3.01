<?php
require "../Controller/ControllerAffichageEtudiantPrecis.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];

} else {
    exit("ERREUR : LOGIN MANQUANT");
}

$result = getStudentId($id);
$alternanceText = ($result['foundApp'] == 0) ? "N'as pas d'alternance" : "A une alternance";
$style = ($result['foundApp'] == 0) ? 'background-color: #ED2939;' : 'background-color: green;';
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
    <a class="btn btn-light" href="./dashboard.php" style="position: absolute; top: 0; left: 0;"> Retour au tableau de bord </a>
    <h1>
        Candidat : <?php echo $result["firstName"] . " " . $result["name"]; ?>
    </h1>
</header>

<section class="Affiche">
    <div class="rounded-box">
        <div class="enteteBox" style="<?php echo $style; ?>">
            <h2> Informations </h2>
            <p class="candidates">
                Email : <?php echo $result["candidateMail"]; ?>
                <br> Numéro de téléphone : <?php echo $result['phoneNumber']; ?>
                <br> Formation : <?php echo $result['nameFormation']; ?>
                <br> Parcours : <?php echo $result['nameParcours']; ?>
                <br> Année de formation : <?php echo $result['yearOfFormation']; ?>
                <br> <span><?php echo $alternanceText; ?> </span>
            </p>
        </div>

        <div class="informationBox">
            <p>
                <br> <?php echo (isset($result['INE']) ? 'INE : ' . $result['INE'] : 'INE non disponible'); ?>
                <br> Type d'entreprise recherchée : <?php echo $result['typeCompanySearch']; ?>
                <br> Adresse : <?php echo $result['addresses']; ?>
                <br> Zone : <?php echo $result['zones']; ?>
                <br> <?php echo ($result['permisB'] ? "A obtenu le permis B" : "N'a pas obtenu le permis B"); ?>
                <br> <?php echo ($result['isInActiveSearch'] ? "Est en recherche active" : "N'est pas en recherche active"); ?>
                <br> <?php echo (isset($result['cv']) ? "<a href='../Controller/ControllerGeneratePreview.php?id=$id' target='_blank'> Voir le CV </a>" : "CV non disponible"); ?>
            </p>
        </div>

        <form method="post" action="../Controller/ControllerActifInactif.php">
            <div class="buttonIsActivate">
                <?php
                if ($result["isInActiveSearch"] == 1){?>
                    <button type="submit" class="btn btn-outline-danger" name="desactivate" >Rendre Inactif</button>
                    <?php
                } else {?>

                    <button type="submit" class="btn btn-outline-success" name="activate">Rendre Actif</button>
                    <?php
                }
                ?>

                <?php
                if ($result["foundApp"] == 1){?>
                    <button type="submit" class="btn btn-outline-danger" name="noalternance">N'a pas d'alternance</button>
                    <?php
                } else {?>

                    <button type="submit" class="btn btn-outline-success" name="alternance">A une alternance</button>
                    <?php
                }
                ?>
                <input type="hidden" id="idValue" name="idValue" value="<?php echo $id ?>">
            </div>
        </form>

        <?php
        session_start();
        if(isset($_SESSION["message"])){ ?>
            <div class="alert alert-success">
                <?php echo $_SESSION["message"]; ?>
            </div>
            <?php
        }
        session_destroy();
        ?>
    </div>
</section>



<footer class="bottomBanner"> </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>

