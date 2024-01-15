<?php
//TODO mettre dans la sessions les parametres du tableau de bord si tu clique sur modifier ou les envoyer en post
session_start();


error_reporting(E_ALL);
ini_set('display_errors', 1);
require "../Controller/ControllerModifTableau.php";

/*
if (isset($_SESSION['login'])) {
    $User = $_SESSION['login'];
} else {
    $_SESSION['login'] = "user1";
    $User = $_SESSION['login'];
}
if (isset($_SESSION['role'])) {
    $Role = $_SESSION['role'];
} else {
    $_SESSION['role'] = 'User';
    $Role = $_SESSION['login'];
}
*/
$_SESSION['login'] = "admin";


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
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
    $dashboards = ControllerGetDashBoardPerUser($_SESSION['login']);
    foreach ($dashboards as $dashboardEntry) {
        foreach ($dashboardEntry as $dashboard) {
            $idDashboard = $dashboard['idDashBoard'];
            $nameOfDashboard = $dashboard['nameOfDashBoard'];
            $isPermis = $dashboard['isPermis'];
            $isIne = $dashboard['isIne'];
            $isAddress = $dashboard['isAddress'];
            $isPhone = $dashboard['isPhone'];
    ?>
        <div class="rounded-box">
            <input onclick="changeDisplay(<?= $idDashboard ?>)" type="button" class="btnChangeDisplay" value="-"
                   id=<?= "btnChangeDisplay" . $idDashboard ?>>

                    <li> <?= $nameOfDashboard ?>   </li>

                    <div id= <?= $idDashboard ?> style="display:block">
                        <?php
                        echo $isPermis ? "<li>ont le permis</li>" : "<li>n'ont pas le permis</li>";
                        echo $isIne ? "<li> INE affiché</li>" : "<li > INE non affiché</li>";
                        echo $isAddress ? "<li>adresse affiché</li>" : "<li > adresse non affiché</li>";
                        echo $isPhone ? "<li>numéro de téléphone affiché</li>" : "<li > numéro de téléphone non affiché</li>"; ?>
                    </div>
                    <script src="../Controller/JsDisplayDashBoard.js"></script>




                    <!-- action="../Controller/ControllerAfficheTableau.php" -->
                    <form method="post" action="../Controller/ControllerAfficheTableau.php">
                        <!-- mettre en action la fonction supprimer -->

                        <button id="<?= "delete".$idDashboard ?>" class="btnDelete" >supprimer</button>
                        <input type="hidden" value="<?= $nameOfDashboard  ?>" name="idDashboard">
                        <!-- mettre input hidden + validation -->
                        <!-- mettre en action la fonction modifier -->

                    </form>

                    <form action="">
                        <a class="btn btn-primary" href="./dashboard.php?id=<?php echo $idDashboard; ?>">Détail</a>
                    </form>

                    <form action="PageModifDashBoard.php" method="post">
                        <button type="submit" value="modifier"  id="<?= $idDashboard ?>" class="btnModif" "> modifier
                        <input type="hidden" name="ine"         id="ine"         value="<?=$isIne?>">
                        <input type="hidden" name="address"     id="address"     value="<?= $isAddress ?>">
                        <input type="hidden" name="phone"       id="phone"       value="<?= $isPhone?>">
                        <input type="hidden" name="permis"      id="permis"      value="<?=  $isPermis ?>">
                        <input type="hidden" name="title"       id="title"       value="<?= $nameOfDashboard?>">
                        <input type="hidden" name="idDashboard" id="idDashboard" value="<?= $idDashboard ?>">

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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>


