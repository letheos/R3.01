<?php
require_once "../Controller/ControllerActiveDesactiveCompte.php";
require_once "../Model/ModelActivationDesactivationCompte.php";
//include "../Controller/ControllerActiveDesactiveCompte.php";
$conn = require "../Model/Database.php";

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

<?php
$results = getAllStudents();

foreach ($results as $row) {
    ?>

    <section class="affichEtu">
        <div class="rounded-box">
            <form method="post" action="../Controller/ControllerActiveDesactiveCompte.php">
                <!--input de nom à faire --><input name="name" type="hidden" value="'.$row['name'].'">
                <input name="firstname" type="hidden" value=" <?= $row['3'] ?>">
                <input name="lastname" type="hidden" value=" <?= $row['name'] ?>">
                <p> nom : <?= $row['name'] ?></p>
                <p> prénom : <?= $row[3] ?></p>
                <button id="delete" name="delete" type="button">supprime</button>
                <?php
                if ($row[7] == 1) { ?>

                    <button class="desactive"  name="bool" value="0" type="submit"> désactive</button>
                    <p class="notSearch">n'est pas en recher active</p>
                    <?php
                } else {
                    ?>
                    <button class="active" name="bool" value="1" type="submit"> active</button>
                    <p class="isSearch">est en recherche active</p>
                    <?php
                }
                ?>

            </form>
        </div>
    </section>
    <?php
}
//
?>


<form method="POST" action=" ">

    <section class="filtreCandidats">

        <div class="selection">
            <label for="formation" class="form-select-label"> Formation </label>
            <?php

            //getAllFormation();


            ?>


        </div>

        <div class="formName">
            <input type="text" class="form-control" name="nameCandidates" id="nameCandidates"
                   placeholder="Filtrage par nom">
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


<section class="bas">

    <footer>
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

</section>

</body>
</html>
