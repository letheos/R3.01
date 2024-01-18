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
    <div class="row">
    <?php
    $dashboards = ControllerGetDashBoardPerUser($_SESSION['login']);
    foreach ($dashboards as $dashboard) {
            $idDashboard = $dashboard['idDashBoard'];
            $nameOfDashboard = $dashboard['nameOfDashBoard'];
            $isPermis = $dashboard['isPermis'];
            $isIne = $dashboard['isIne'];
            $isAddress = $dashboard['isAddress'];
            $isPhone = $dashboard['isPhone'];
            $isHeadcount = $dashboard['isHeadcount'];
    ?>
            <div class="rounded-box">
                <input onclick="changeDisplay(<?= $idDashboard ?>)" type="button" class="btnChangeDisplay" value="-"
                       id=<?= "btnChangeDisplay" . $idDashboard ?>>


                <h3 class="m-0">Titre : <?= (!empty($nameOfDashboard)) ? $nameOfDashboard : "SANS NOM" ?></h3>


                <div id= <?= $idDashboard ?> style="display:block">
                    <?php
                    echo $isPermis ? '<li>Information sur le permis : <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                      <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                      </svg></li>' : '<li>Information sur le permis :  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                      <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                        </svg></li>';
                    echo $isIne ? '<li>Information sur le L\'INE : <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                      <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                      </svg></li>' : '<li>Information sur le L\'INE :  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                      <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                        </svg></li>';
                    echo $isAddress ? '<li>Information sur l\'adresse : <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                      <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                      </svg></li>' : '<li>Information sur l\'adresse :  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                      <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                        </svg></li>';
                    echo $isPhone ? '<li>Information sur le numéro de téléphone : <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                      <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                      </svg></li>' : '<li>Information sur le numéro de téléphone :  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                      <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                      </svg></li>';
                    echo $isHeadcount ? '<li>Information sur les effectifs : <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                        </svg></li>' : '<li>Information sur les effectifs :  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                        </svg></li>'; ?>

                </div>
                    <script src="../Controller/JsDisplayDashBoard.js"></script>



            <div class="d-flex justify-content-between">
                    <!-- action="../Controller/ControllerAfficheTableau.php" -->
                    <form method="post" action="../Controller/ControllerAfficheTableau.php">
                        <button id="<?= "delete".$idDashboard ?>" class="btn btn-danger" >Supprimer</button>
                        <input type="hidden" value="<?= $idDashboard  ?>" name="idDashboard">

                    </form>


                    <a class="btn btn-primary" href="./dashboard.php?id=<?php echo $idDashboard; ?>">Accéder</a>


                    <form action="PageModifDashBoard.php" method="post">
                        <button type="submit" value="modifier"  id="<?= $idDashboard ?>" class="btn btn-secondary" "> Modifier
                        <input type="hidden" name="ine"         id="ine"         value="<?=$isIne?>">
                        <input type="hidden" name="address"     id="address"     value="<?= $isAddress ?>">
                        <input type="hidden" name="phone"       id="phone"       value="<?= $isPhone?>">
                        <input type="hidden" name="permis"      id="permis"      value="<?=  $isPermis ?>">
                        <input type="hidden" name="title"       id="title"       value="<?= $nameOfDashboard?>">
                        <input type="hidden" name="idDashboard" id="idDashboard" value="<?= $idDashboard ?>">

                        </button>
                    </form>
            </div>
        </div>

                <br>
            <?php
    }
    ?>
    </div>
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


