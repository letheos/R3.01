<?php
$conn = require "../Model/Database.php";
include "../Controller/ControllerAffichage.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="SendCandidateCV.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>SendMail</title>
</head>

<body>

<header class="banner">
    <h1>
        Envoyez un mail à une entreprise
    </h1>
</header>

<form id="filter-form" method="POST" action="">

    <section class="filtreCandidats">

        <div class="selection">
            <label for="formation" class="form-select-label"> Département </label>
            <?php
            listAffichageSelect($conn); //
            ?>

            <label for="parcours" class="form-select-label"> Parcours </label>
            <select class="form-select" name="parcours" id="parcours" >
                <option value="" selected disabled> Choisir un parcours </option>
                <option value="<?php echo $_POST['parcours']; ?>" <?php echo (isset($_POST['parcours'])) ? 'selected' : ''; ?>><?php echo $_POST['parcours']; ?></option>
            </select>

            <label for="year" class="form-select-label"> Année de formation</label>
            <select class="form-select" name="year" id="year">
                <option value="FirstYear"> 1ère Année</option>
                <option value="SecondYear"> 2ème Année</option>
                <option value="ThirdYear"> 3ème Année</option>
            </select>
        </div>


        <div class="buttonSubmit">
            <button class="btn btn-primary" type="submit" name="cancel" id="cancel"> Annuler </button>
            <button class="btn btn-primary" type="submit" name="submit" id="submit"> Envoyez les CV(s) de </button>
        </div>
    </section>
</form>

<form id="send-form" method="POST" action="../Controller/ControllerSendCandidateCV.php">

    <?php
    if(isset($_SESSION["message"])){
        if ($_SESSION['success'] == 0) {?>
            <div class="alert alert-danger">
                <?php echo $_SESSION["message"]; ?>
            </div>
        <?php } else { ?>
            <div class="alert alert-success">
                <?php echo $_SESSION["message"]; ?>
            </div>
            <?php
        }
        unset($_SESSION["erreur"]);
        session_destroy();
    }
    ?>


    <section class="sendMail">
        <div class="destinataire">
            <div class="input-container">
                <label for="to" class="form-select-label"> Destinataire </label>
                <textarea class="to" name="to" placeholder="Destinataire"></textarea>
            </div>
        </div>

        <div class="corps">
            <div class="input-container">
                <label for="message" class="form-select-label"> Message du Mail </label>
                <textarea class="message" name="message" placeholder="Ecrivez le mail"></textarea>
            </div>
        </div>



    </section>



    <footer class="bottomBanner">
        <button class="btn btn-primary" type="submit" name="submit" id="submit"> Envoyer</button>
    </footer>
</form>

<script src="../Controller/js/Ajax.js"></script>
</body>
</html>
