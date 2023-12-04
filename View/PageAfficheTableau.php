<?php


//tableau = require "../Controller/ControllerAfficheTableau.php";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<header class="banner">
    <form>
        <h1 class="TexteProfil">
            Création de tableau de bord
        </h1>
        <button class="btn btn-light" type="submit" name="retourAccueil"
                onclick="window.location.href='PageAccueil.php'">Retour à l'accueil
        </button>
    </form>
</header>

</body>
</html>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="StylePageCreationTableau.css">
    <title>Document</title>
</head>
<p>


    <?php

    //$conn = require "../Model/Database.php";
    require "../Controller/ControllerAfficheTableau.php";
    /*
    $test = getStudentsWithConditions(0,"1er","Informatique","Parcours Informatique B",$conn,1,0,0);
    $p = getUserWithId("user1",$conn);

    foreach ($p as $t) {

        print_r($p);

    }
    */
    $dashBoards = ControlerGetDashBoardPerUser("utilisateur1");

    foreach ($dashBoards

    as $dashBoard) {
    foreach ($dashBoard

    as $valeur) {
    ?>
<div class="rounded-box">
    <li>le tableau de bord numéro <?= $valeur[0] ?>   </li>
    <?php if ($valeur[1]) {
        echo '<li>ont le permis</li>';
    } else {
        echo "<li>n'ont pas le permis</li>";
    } ?>
    <li> année d'étude : <?= $valeur[2] ?>   </li>
    <li> formation : <?= $valeur[3] ?>   </li>
    <li>recherche les étudiants ayant comme parcours : <?= $valeur[4] ?>   </li>
    <?php echo $valeur[5] ? "<li>affiche l'INE</li>" : "<li> n'affiche pas l'INE</li>"; ?>
    <?php echo $valeur[6] ? "<li>affiche l'adresse</li>" : "<li> n'affiche pas l'adresse</li>"; ?>
    <?php echo $valeur[7] ? "<li>affiche le téléphone</li>" : "<li> n'affiche pas le téléphone</li>"; ?>
    <button>supprimer</button>
    <button>modifier</button>
</div>
<br>
<?php

}
//var_dump($dashBoard);

}
?>
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


