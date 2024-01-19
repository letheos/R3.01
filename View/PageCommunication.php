<?php
require "../Controller/ControllerCommunication.php";
require "../Controller/ControllerAffichageEtudiant.php";


if (empty($_SESSION['user'])) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}

$user = unserialize($_SESSION['user']);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="AffichageCandidats.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Echange</title>
    <style>
        .bg-custom {
            background-color: #0f94b4;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }

    </style>
</head>
<body>
<header class="banner">
    <button class="btn btn-light" type="submit" name="retourAccueil"
            onclick="window.location.href='PageAccueil.php'">Retour à l'accueil
    </button>
        <h1 class="TexteProfil">
            Communication
        </h1>
</header>
    <form id="filter-form" method="POST" action="../View/PageCommunication.php">

        <section class="bg-custom rounded p-2 mt-4 text-white">

            <div class="container mt-2">

                <div class="row">

                    <div class="col-md-4">
                        <label for="formation" class="form-label text-white label-white">Département</label>
                        <select class="form-select" name="formation" id="formation" onchange="onChangeUpdateDisplayParcours('../Controller/ControllerParcoursAffichage.php')">
                            <option value="" selected="selected" disabled>Choisir la formation</option>
                            <?php
                            if ($user->getRole() == "Chef de service") {
                                $formations = getAllFormation();
                            } else {
                                $formations = $user->getLesFormations();
                            }
                            $selected = '';
                            $selectedFormation = (isset($_POST['formation'])) ? $_POST['formation'] : '';
                            foreach ($formations as $formation) {
                                $selected = ($selectedFormation == $formation['nameFormation']) ? 'selected' : ''; ?>
                            <option value="<?php echo $formation['nameFormation']; ?>" <?php echo $selected ?>> <?php echo $formation['nameFormation']; ?></option><?php
                            } ?>
                            <option value="Aucune Option">Aucune Option</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="parcours" class="form-label text-white label-white">Parcours</label>
                        <select class="form-select" name="parcours" id="parcours">
                            <option value="">Choisir un parcours</option>
                            <option value="<?php echo $_POST['parcours']; ?>" <?php echo (isset($_POST['parcours'])) ? 'selected' : ''; ?>><?php echo $_POST['parcours']; ?></option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="nameCandidates" class="form-label text-white label-white">Filtrage par nom</label>
                        <input type="text" class="form-control" name="nameCandidates" id="nameCandidates" value="<?php echo isset($_POST['name']) ?>" placeholder="Filtrage par nom">
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit" name="submit" id="submit">Rechercher</button>
                    </div>
                </div>

            </div>

        </section>

    </form>



<section class="afficheCandidats">
    <table class="table" id="candidateTable">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Formation</th>
            <th>Parcours</th>
            <th>Voir les échanges</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $candidates = filtrageCommunication();
        foreach ($candidates as $candidate) {
            ?>
            <tr class="candidates" id="candidats">
                <td><?php echo $candidate['name']; ?></td>
                <td><?php echo $candidate['firstName']; ?></td>
                <td><?php echo $candidate['nameFormation']; ?></td>
                <td><?php echo $candidate['nameParcours']; ?></td>
                <td>
                    <a class="btn btn-primary" href="./PageCommunicationPrecise.php?id=<?php echo $candidate["idCandidate"]; ?>">Voir les échanges</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</section>
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


<script src="../Controller/js/Ajax.js"></script>
</body>
</html>
