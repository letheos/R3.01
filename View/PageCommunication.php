<?php


require "../Controller/ControllerCommunication.php";
require "../Controller/ControllerAffichageEtudiant.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION["nomr"])) {
    $_SESSION["nomr"] = "%";
}
if (!isset($_SESSION["formationr"])) {
    $_SESSION["formationr"] = "%";
}
if (!isset($_SESSION["parcoursr"])) {
    $_SESSION["parcoursr"] = "%";
}
if (!isset($_SESSION["yearr"])) {
    $_SESSION["yearr"] = "%";
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="StylePageCommunication.css">
    <title>Echange</title>
</head>
<body>
<header class="banner">
    <button class="btn btn-light" type="submit" name="retourAccueil"
            onclick="window.location.href='PageAccueil.php'">Retour à l'accueil
    </button>
        <h1 class="TexteProfil">
            Communication
        </h1>
        <form id="send-form" method="POST" action="../Controller/ControllerCommunication.php">
            <section class="filtreCandidats">

                <div class="selection">
                    <label for="formation" class="form-select-label"> Département </label>
                    <label for="parcours" class="form-select-label"> Parcours </label>
                    <select class="form-select" name="formation" id="formation" onchange="onChangeUpdateDisplayParcours('../Controller/ControllerParcoursAffichage.php')">
                        <option value="" selected="selected" disabled> Choisir la formation </option>
                        <?php $formations = getAllFormation();
                        $selected = '';
                        $selectedFormation = (isset($_POST['formation'])) ? $_POST['formation'] : '';
                        foreach ($formations as $formation)
                        {
                            $selected = ($selectedFormation == $formation['nameFormation']) ? 'selected' : '';?>
                        <option value="<?php echo $formation['nameFormation']; ?>" <?php echo $selected ?>> <?php echo $formation['nameFormation']; ?></option><?php
                        } ?>
                        <option value="Aucune Option" > Aucune Option </option>
                    </select>
                    <label for="year" class="form-select-label"> Année de formation</label>
                    <select class="form-select" name="year" id="year">
                        <option value="1ère Année"> 1ère Année</option>
                        <option value="2ème Année"> 2ème Année</option>
                        <option value="3ème Année"> 3ème Année</option>
                    </select>
                    <label for="name" class="form-select-label"> Nom</label>
                        <input type="text" id="name" name="name">

                    <button class="btn btn-outline-primary" type="submit" name="filtrer">Filtrer</button>
                </div>
            </section>candidate
        </form>
</header>

<section class="Candidats">
<?php showCandidate($_SESSION["nomr"],$_SESSION["formationr"], $_SESSION["parcoursr"], $_SESSION["yearr"]);?>
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
