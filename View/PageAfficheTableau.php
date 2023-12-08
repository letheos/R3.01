<?php

require "../Controller/ControllerAfficheTableau.php";

if (isset($_SESSION['login'])) {
    $User = $_SESSION['login'];
}
else{
    session_start();
    $_SESSION['login'] = "utilisateur2";
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
    <title>Document</title>
</head>
<body>

<header class="banner">
    <form>
        <h1 class="TexteProfil">
            Affichage des tableau de bord
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
    <link rel="stylesheet" href="StylePageAfficheTableau.css">
    <title>PageAfficheDashBoard</title>
</head>
<p>


    <?php
    $dashBoards = ControlerGetDashBoardPerUser($_SESSION['login']);

    foreach ($dashBoards as $dashBoard) {
    //print_r($dashBoard);
    foreach ($dashBoard as $valeur) {
    ?>
<div class="rounded-box">
    <li><?= $valeur[0] ?>   </li>
    <li style="display: none">le tableau de bord numéro <?= $valeur[1] ?>   </li>
    <?php if ($valeur[2]) {
        echo '<li style="display: none">ont le permis</li>';
    } else {
        echo "<li style='display: none' >n'ont pas le permis</li>";
    } ?>
    <li style="display: none"> année d'étude : <?= $valeur[3] ?>   </li>
    <li style="display: none"> formation : <?= $valeur[4] ?>   </li>
    <li style='display: none'>>recherche les étudiants ayant comme parcours : <?= $valeur[5] ?>   </li>
    <?php echo $valeur[6] ? "<li style='display: none'> INE affiché</li>" : "<li style='display: none'> INE non affiché</li>"; ?>
    <?php echo $valeur[7] ? "<li style='display: none'>adresse affiché</li>" : "<li style='display: none'> adresse non affiché</li>"; ?>
    <?php echo $valeur[8] ? "<li style='display: none'>numéro de téléphone affiché</li>" : "<li style='display: none'> numéro de téléphone non affiché</li>"; ?>

    <button > <img src="C:\document\but2\sae\stest.png" alt="+" /> </button>
    <form <!-- mettre en action la fonction supprimer -->>
        <button>supprimer</button>
    </form>

    <form <!-- mettre en action la fonction modifier -->>
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


