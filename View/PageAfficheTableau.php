<?php

require "../Controller/ControllerAfficheTableau.php";

if (isset($_SESSION['login'])) {
    $User = $_SESSION['login'];
}
else{
    session_start();
    $_SESSION['login'] = "user1";
    $User = $_SESSION['login'];
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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
</header>


    <?php
    $dashBoards = ControllerGetDashBoardPerUser($_SESSION['login']);
   $i = 0;
    foreach ($dashBoards as $dashBoard) {
        $i+=1;

        foreach ($dashBoard as $valeur) {?>

    <div class="rounded-box" >
        <li> <?= $valeur[0] ?>   </li>

        <div id= <?= $i ?> style="display: block">
        <li >le tableau de bord numéro <?= $valeur[1] ?>   </li>
    <?php
    echo $valeur[2] ? "<li>ont le permis</li>" : "<li>n'ont pas le permis</li>";
    echo $valeur[3] ? "<li> INE affiché</li>" : "<li > INE non affiché</li>";
    echo $valeur[4] ? "<li>adresse affiché</li>" : "<li > adresse non affiché</li>";
    echo $valeur[5] ? "<li>numéro de téléphone affiché</li>" : "<li > numéro de téléphone non affiché</li>"; ?>


    </div>
            <script src="../Controller/JsDisplayDashBoard.js"></script>


            <input onclick="changeDisplay(<?=$i?>)" type="button" value="-" id=<?="btnChangeDisplay".$i?>>




            <form >
                 <!-- mettre en action la fonction supprimer -->

                <button>supprimer</button>

                <!-- mettre en action la fonction modifier -->
                <button>modifier</button>
                </form>
        </div>

<br>
<?php
}
}
?>


<form action="../View/PageCreationTableau.php">
    <button>Ajouter un tableau de bord</button>
</form>
<footer class="bottomBanner">
    <div class="nomFooter">
        <p>
            Timothée Allix, Nathan Strady, Theo Parent, Benjamin Massy, Loïck Morneau

        </p>
    </div>
    <div class="origineFooter">
        <p>
            2023/2024 UPHF
        </p>
    </div>
</footer>

</body>
</html>


