<?php
//TODO mettre dans la sessions les parametres du tableau de bord si tu clique sur modifier ou les envoyer en post
session_start();
require "../Controller/ControllerAfficheTableau.php";

if (isset($_SESSION['login'])) {
    $User = $_SESSION['login'];
} else {

    $_SESSION['login'] = "login1";
    $User = $_SESSION['login'];
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="StylePageAfficheTableau.css">
    <title>Page affiche les tableaux de bord</title>
</head>
<body>

<header class="banner">
    <form>
        <h1 class="TexteProfil">
            Affichage des tableaux de bord
        </h1>
        <button class="btn btn-light" type="submit" name="retourAccueil"
                onclick="window.location.href='PageAccueil.php'">Retour à l'accueil
        </button>
    </form>

    <form action="../View/PageCreationTableau.php">
        <button id="createDashboard">Ajouter un tableau de bord +</button>
    </form>
</header>

<section class="theDashBoards">

    <?php
    $dashBoards = ControllerGetDashBoardPerUser($_SESSION['login']);
    $i = 0;

    foreach ($dashBoards as $dashBoard) {

        $i += 1;

        foreach ($dashBoard as $valeur) { ?>

            <div class="rounded-box">
                <input onclick="changeDisplay(<?= $i ?>)" type="button" class="btnChangeDisplay" value="-"
                       id=<?= "btnChangeDisplay" . $i ?>>

                <li> <?= $valeur[0] ?>   </li>

                <div id= <?= $i ?> style="display:block">
                    <li>le tableau de bord numéro <?= $valeur[1] ?>   </li>
                    <?php
                    echo $valeur[2] ? "<li>ont le permis</li>" : "<li>n'ont pas le permis</li>";
                    echo $valeur[3] ? "<li> INE affiché</li>" : "<li > INE non affiché</li>";
                    echo $valeur[4] ? "<li>adresse affiché</li>" : "<li > adresse non affiché</li>";
                    echo $valeur[5] ? "<li>numéro de téléphone affiché</li>" : "<li > numéro de téléphone non affiché</li>"; ?>


                </div>
                <script src="../Controller/JsDisplayDashBoard.js"></script>




                <!-- action="../Controller/ControllerAfficheTableau.php" -->
                <form method="post" >
                    <!-- mettre en action la fonction supprimer -->

                    <button id="<?= "delete" . $i ?>" class="btnDelete"   onclick="showAlert(this)" >supprimer</button>
                    <input type="hidden" value="<?= $valeur[1] ?>" name="idDashboard">
                    <!-- mettre input hidden + validation -->
                    <!-- mettre en action la fonction modifier -->

                </form>

                <form action="">
                    <button id="<?= "show".$i ?>" type="submit" class="btnShow"> afficher tableau de bord</button>
                </form>

                <form action="PageCreationTableau.php" method="post">
                    <button type="submit" value="modifier" id="<?= $i ?>" class="btnModif" onclick="checked(<?=$valeur[2]?>,<?= $valeur[3] ?>,<?= $valeur[4] ?>,<?=$valeur[5] ?>,<?= $i ?>)"> modifier
                    <input type="hidden" id="ine" value="<?=$valeur[2]?>">
                    <input type="hidden" id="address" value="<?= $valeur[3] ?>">
                    <input type="hidden" id="phone" value="<?= $valeur[4]?>">
                    <input type="hidden" id="permis" value="<?= $valeur[5]?>">
                    </button>
                </form>
            </div>

            <br>
            <?php
        }
    }
    ?>

</section>

<footer class="bottomBanner">
    <div class="nomFooter">
        <p>
            Timothée Allix, Nathan Strady, Theo Parent, Benjamin Massy, Loïck Morneau

        </p>
        <p>
            <a href="https://www.uphf.fr/"  > site uphf </a> </p>
    </div>
    <div class="origineFooter">
        <p>
            2023/2024 UPHF
        </p>
    </div>
</footer>

</body>
</html>


