<?php
include "../Controller/ControllerAffichageEtudiant.php";


//Cette condition sert à verifier que la personne accedant a la page d'accueil
if (empty($_SESSION['user'])) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}


$user = unserialize($_SESSION['user']);
if ($user->getRole() == "Chef de service") {
    $formations = getAllFormation();
    $candidates = filtrage();
} else {
    $formations = $user->getLesFormations();
    $candidates = filtrageUser($formations);
}



?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="AffichageCandidats.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Les Candidats</title>
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

<header class="banner bg-custom text-white text-center py-4">
    <h1 class="mb-0">
        Les profils candidats
    </h1>
    <form action="PageAccueil.php" class="mt-3">
        <button class="btn btn-light" type="submit" name="retourAccueil">Retour à l'accueil</button>
    </form>

    <form action="csv.php" class="btn-action">
        <button class="btn btn-light" type="submit">Inserer plusieurs étudiants grâce à un CSV</button>
    </form>
</header>

<form id="filter-form" method="POST" action="../View/PageAffichageEtudiant.php">

    <section class="bg-custom rounded p-3 mt-4">

        <div class="container mt-4">

            <div class="row align-items-center">
                <div class="col-md-3">
                    <label for="formation" class="form-label">Département</label>
                    <select class="form-select" name="formation" id="formation" onchange="onChangeUpdateDisplayParcours('../Controller/ControllerParcoursAffichage.php')">
                        <option value="" selected="selected" disabled>Choisir la formation</option>
                        <?php
                        $selected = '';
                        $selectedFormation = (isset($_POST['formation'])) ? $_POST['formation'] : '';
                        foreach ($formations as $formation) {
                            $selected = ($selectedFormation == $formation['nameFormation']) ? 'selected' : ''; ?>
                        <option value="<?php echo $formation['nameFormation']; ?>" <?php echo $selected ?>> <?php echo $formation['nameFormation']; ?></option><?php
                        } ?>
                        <option value="Aucune Option">Aucune Option</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="parcours" class="form-label">Parcours</label>
                    <select class="form-select" name="parcours" id="parcours">
                        <option value="">Choisir un parcours</option>
                        <option value="<?php echo $_POST['parcours']; ?>" <?php echo (isset($_POST['parcours'])) ? 'selected' : ''; ?>><?php echo $_POST['parcours']; ?></option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="nameCandidates" class="form-label">Filtrage par nom</label>
                    <input type="text" class="form-control" name="nameCandidates" id="nameCandidates" value="<?php echo $_POST['nameCandidates'] ?>" placeholder="Filtrage par nom">
                </div>

                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="isActive" id="isActive" <?php echo ($_POST['isActive'] === 'on') ? 'checked' : ''; ?>>
                        <label for="isActive" class="form-check-label">Non-actif</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="isFound" id="isFound" <?php echo (isset($_POST['isFound'])) ? 'checked' : ''; ?>>
                        <label for="isFound" class="form-check-label">Affiche ceux qui ont une alternance</label>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12 d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit" name="submit" id="submit">Rechercher</button>
                </div>
            </div>

        </div>

    </section>

</form>

<form id="delete-form" method="post" action="../Controller/ControllerGestionEtudiant.php">
    <section class="afficheCandidats">
        <table class="table" id="candidateTable">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Parcours</th>
                <th>Rendre Inactif/Actif</th>
                <th>Recherche d'Alternance</th>
                <th>Statut Alternance</th>
                <th>Statut Actif</th>
                <th>Détail</th>
                <th>Supprimer</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($candidates as $candidate) {

                ?>
                <tr class="candidates" id="candidats">
                    <td><?php echo $candidate['name']; ?></td>
                    <td><?php echo $candidate['firstName']; ?></td>
                    <td><?php echo $candidate['nameParcours']; ?></td>

                    <td>
                        <?php if ($candidate['isInActiveSearch']) { ?>
                            <input type="checkbox" name="checkboxActif[]" value="<?php echo $candidate['idCandidate']; ?>"> Rendre Inactif
                        <?php } else { ?>
                            <input type="checkbox" name="checkboxNonActif[]" value="<?php echo $candidate['idCandidate']; ?>"> Rendre Actif
                        <?php } ?>
                    </td>
                    <td>
                        <?php if ($candidate['foundApp'] == 0) { ?>
                            <input type="checkbox" name="checkboxNoAlternance[]" value="<?php echo $candidate['idCandidate']; ?>">
                            Obtient le contrat
                        <?php } else { ?>
                            <input type="checkbox" name="checkboxWithAlternance[]" value="<?php echo $candidate['idCandidate']; ?>">
                            N'a pas de contrat
                        <?php } ?>
                    </td>
                    <td>
                        <span style="color: <?php echo ($candidate['foundApp'] == 0) ? '#bb2323' : 'green'; ?>">
                            <?php echo ($candidate['foundApp'] == 0) ? 'Sans contrat' : 'Contrat'; ?>
                        </span>
                    </td>
                    <td>
                        <span style="color: <?php echo ($candidate['isInActiveSearch'] == 0) ? '#bb2323' : 'green'; ?>">
                            <?php echo ($candidate['isInActiveSearch'] == 1) ? 'Actif' : 'Inactif'; ?>
                        </span>
                    </td>
                    <td><a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id=<?php echo $candidate["idCandidate"]; ?>">Détail</a></td>
                    <td>
                        <button class="btn btn-outline-danger" name="delete" type="submit" data-id="<?php echo $candidate['idCandidate']; ?>" onclick="showAlert(this)">X</button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </section>

    <section>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit" name="submit" id="submit"> Changer l'état des candidats</button>
                </div>
            </div>
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
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="../Controller/jsAffichage.js"></script>
<script src="../Controller/js/Ajax.js"></script>
</body>
</html>
