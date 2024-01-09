<?php
require "../Controller/ControllerCommunicationPrecise.php";
$conn = require "../Model/database.php";


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="StylePageAlerte.css">
    <title>Echange</title>
</head>
<body>
<header class="banner">
    <form>
        <h1 class="TexteProfil">
            Communication
        </h1>
        <button class="btn btn-light" type="submit" name="retourAccueil"
                onclick="window.location.href='PageAccueil.php'">Retour à l'accueil

        </button>
    </form>
</header>

<?php showComm($conn,$_SESSION["candidate"]); ?>

<section>
    <div id="add">
        <form method="POST" action="../Controller/ControllerCommunicationPrecise.php" enctype="multipart/form-data">
            <p>Ajouter une nouvelle information:</p>
            <label>
                <textarea name="Note" maxlength="300" ></textarea>
            </label>
            <div class="downloadButton">
                <label for="img">Ajouter une piece jointe</label>
                <input type="file" name="imgbutton" id="imgbutton" accept=".pdf, .png, .jpg, .jpeg">
            </div>
            <br>
            <input type='submit' name='Add' value='Ajouter'>

        </form>
    </div>
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
<script src="../Controller/js/ControllerCommunicationJS.js"></script>