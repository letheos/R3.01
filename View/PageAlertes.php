<?php
$conn = require "../Model/Database.php";

require "../Controller/ControllerAlert.php";
$f=false;
if(isset($_SESSION["futur"])){
    $f=$_SESSION["futur"];
}
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="StylePageAlerte.css">
        <title>Alertes</title>
    </head>
    <body>
    <header class="banner">
        <form>
            <h1 class="TexteProfil">
                Alertes
            </h1>
            <button class="btn btn-light" type="submit" name="retourAccueil"
                    onclick="window.location.href='PageAccueil.php'">Retour à l'accueil
            </button>
        </form>
    </header>

        <section class="gestion">
            <div id="show">
                <form method='POST' action="../Controller/ControllerAlert.php">
                    Montrer alertes futures
                    <input type='checkbox' name='Future' value='on'> <br>
                    <input type='submit' name='Appliquer' value='Appliquer'>
                </form>
            </div>
            <div id="add">
                <form method="POST" action="../Controller/ControllerAlert.php">
                    <p>Ajouter une nouvelle alerte:</p>
                    <input type="date" name="date" min= <?php echo Date('Y-m-d')  ?> value=<?php echo Date('Y-m-d') ?> >
                    <input type="textarea" name="note"  >
                    <input type='submit' name='Ajouter' value='Ajouter'>
                </form>
            </div>
        </section>
        <section class="affichage">


            <?php
            remindAlert($conn,$_SESSION["login"]);
            $results=ListAlert($conn,$_SESSION["login"],$f);
            foreach ($results as $row) { ?>
            <div class="alert"> Date :<?=$row[2]?>
                <br> Note:<?=$row["note"]?>
                <form method="POST" action="../Controller/ControllerAlert.php">
                    <input type="submit" name="Supprimer" value="Supprimer" >
                    <input type="hidden" name="id" value="<?=$row[0]?>" >
                    </form>
                </div>
            <?php } ?>

        </section>
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
