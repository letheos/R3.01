<?php
require_once "../Controller/ControllerActiveDesactiveCompte.php";
//include "../Controller/ControllerActiveDesactiveCompte.php";

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="PageCreationcss.css">
    <title>afficheLesEtudiants</title>
</head>

<header>
    <p>
        Affiche étudiant
    </p>
</header>


<body>
<section class="donnees">
    <form method="post" action="../Controller/ControllerActiveDesactiveCompte.php">


    <div class="affiche">
        <?php
            listAffichageSelect();

        ?>

        <script>

        </script>
    </div>
    </form>
</section>

</body>
</html>

