<?php
require_once "../Controller/ControllerActiveDesactiveCompte.php";
//include "../Controller/ControllerActiveDesactiveCompte.php";
$conn = require "../Model/Database.php"
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styleActivDesacSuprEtudiant.css">
    <title>afficheLesEtudiants</title>
</head>



<body>
<section class="haut">
    <div class="titre">
        <header>
            <p>
                Affiche étudiant
            </p>
        </header>

    </div>
</section>

<form method="POST" action=" ">

    <section class="filtreCandidats">

        <div class="selection">
            <label for="formation" class="form-select-label"> Formation </label>
            <?php

            getAllFormation();


            ?>


        </div>

        <div class="formName">
            <input type="text" class="form-control" name="nameCandidates" id="nameCandidates" placeholder="Filtrage par nom">
        </div>
        <div class="checkbox">
            <input class="form-check" type="checkbox" name="isActive" id="isActive">
            <label for="isNotActive" class="form-check-label"> Non-actif </label>
        </div>

        <div class="buttonSubmit">
            <button class="btn btn-primary" type="submit" name="submit" id="submit"> Rechercher</button>
        </div>
    </section>
</form>


<section class="donnees">



    <div class="affiche">
        <?php
        listAffichageSelect();
        ?>
    </div>

</section>


<section class="bas">

    <footer>
        <div class="nomFooter" >
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

</section>

</body>
</html>
