<?php
//TODO mettre dans la sessions les parametres du tableau de bord si tu clique sur modifier ou les envoyer en post
session_start();
include '../Controller/ClassUtilisateur.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

require "../Controller/ControllerModifTableau.php";


if (empty($_SESSION['user'])) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}

$user = unserialize($_SESSION['user']);


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="StylePageAfficheTableau.css">
    <title>Page affiche les tableaux de bord</title>
    <style>
        .bg-custom {
            background-color: #0f94b4;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .card.collapsed {
            height: 100px;
            width: 450px;
            overflow: hidden;
            transition: height 0.3s ease, width 0.3s ease; /* Ajoutez une transition en douceur */
        }

    </style>

</head>
<body>

<header class="jumbotron text-center bg-custom text-white">
    <form action="PageAccueil.php">
        <h1 class="TexteProfil">
            Affichage des tableaux de bord
        </h1>
        <button class="btn btn-light" type="submit" name="retourAccueil">Retour à l'accueil
        </button>
    </form>

    <form action="../View/PageCreationTableau.php">
        <button class="btn btn-light" id="createDashboard">Ajouter un tableau de bord +</button>
    </form>
</header>


<section class="theDashBoards">
    <div class="row">
        <?php
        $dashboards = ControllerGetDashBoardPerUser($user->getLogin());
        foreach ($dashboards as $dashboard) {
            $idDashboard = $dashboard['idDashBoard'];
            $nameOfDashboard = $dashboard['nameOfDashBoard'];
            $isPermis = $dashboard['isPermis'];
            $isIne = $dashboard['isIne'];
            $isAddress = $dashboard['isAddress'];
            $isPhone = $dashboard['isPhone'];
            $isHeadcount = $dashboard['isHeadcount'];
            $formations = ControllerGetParcoursDashboard($idDashboard);
            ?>

            <div class="col-md-6 mb-4">
                <div class="card h-100 d-flex flex-column">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="m-0">Titre: <?= (!empty($nameOfDashboard)) ? $nameOfDashboard : "SANS NOM" ?></h3>
                        <button onclick="changeDisplay(<?= $idDashboard ?>)" class="btn btn-outline-dark btn-sm"
                                id="<?= "btnChangeDisplay" . $idDashboard ?>">-</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="<?= $idDashboard ?>">
                            <thead>
                            <tr>
                                <th>Nom Formation</th>
                                <th>Nbr Étudiants Total</th>
                                <th>Nbr Étudiants Actifs</th>
                                <th>Nbr Étudiants Alternance</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (empty($formations)) { ?>
                                <tr>
                                    <td colspan="4"><p class="text-danger">Pas de formations liées</p></td>
                                </tr>
                            <?php } else {
                                foreach ($formations as $formation) {
                                    $info = getNbEtuPerParcours($formation[0]);
                                    ?>
                                    <tr>
                                        <td><?= $formation[0] ?></td>
                                        <td><?= (!empty($info) && $info[0]['nombreetudiants'] > 0) ? $info[0]['nombreetudiants'] : '<p class="text-danger">0</p>' ?></td>
                                        <td><?= (!empty($info) && $info[0][3] > 0) ? $info[0][3] : '<p class="text-danger">0</p>' ?></td>
                                        <td><?= (!empty($info) && $info[0][2] > 0) ? $info[0][2] : '<p class="text-danger">0</p>' ?></td>
                                    </tr>
                                <?php }
                            } ?>
                            </tbody>
                        </table>

                        <ul>
                            <li>Information sur le permis: <?= $isPermis ? '<span class="text-success"><i class="bi bi-check"></i></span>' : '<span class="text-danger"><i class="bi bi-x"></i></span>' ?></li>
                            <li>Information sur le L'INE: <?= $isIne ? '<span class="text-success"><i class="bi bi-check"></i></span>' : '<span class="text-danger"><i class="bi bi-x"></i></span>' ?></li>
                            <li>Information sur l'adresse: <?= $isAddress ? '<span class="text-success"><i class="bi bi-check"></i></span>' : '<span class="text-danger"><i class="bi bi-x"></i></span>' ?></li>
                            <li>Information sur le numéro de téléphone: <?= $isPhone ? '<span class="text-success"><i class="bi bi-check"></i></span>' : '<span class="text-danger"><i class="bi bi-x"></i></span>' ?></li>
                            <li>Information sur les effectifs: <?= $isHeadcount ? '<span class="text-success"><i class="bi bi-check"></i></span>' : '<span class="text-danger"><i class="bi bi-x"></i></span>' ?></li>
                        </ul>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <form method="post" action="../Controller/ControllerAfficheTableau.php">
                            <button id="<?= "delete" . $idDashboard ?>" class="btn btn-danger">Supprimer</button>
                            <input type="hidden" value="<?= $idDashboard ?>" name="idDashboard">
                        </form>
                        <a class="btn btn-primary" href="./dashboard.php?id=<?= $idDashboard ?>">Accéder</a>
                        <form action="PageModifDashBoard.php" method="post">
                            <button type="submit" value="modifier" id="<?= $idDashboard ?>" class="btn btn-secondary">
                                Modifier
                                <input type="hidden" name="ine" id="ine" value="<?= $isIne ?>">
                                <input type="hidden" name="address" id="address" value="<?= $isAddress ?>">
                                <input type="hidden" name="phone" id="phone" value="<?= $isPhone ?>">
                                <input type="hidden" name="permis" id="permis" value="<?= $isPermis ?>">
                                <input type="hidden" name="title" id="title" value="<?= $nameOfDashboard ?>">
                                <input type="hidden" name="idDashboard" id="idDashboard" value="<?= $idDashboard ?>">
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <?php
        }
        ?>
    </div>
</section>



<footer class="bg-custom text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div>
                    <p>
                        Timothée Allix, Nathan Strady, Theo Parent, Benjamin Massy, Loïck Morneau
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <p>
                        2023/2024 UPHF
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
<script src="../Controller/JsDisplayDashBoard.js"></script>
</body>
</html>


