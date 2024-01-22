<?php



require "../Controller/ControllerAffichageEtudiant.php";



if (isset($_POST['parcours'])) {
    $selectedParcours = $_POST['parcours'];
} else {
    $selectedParcours = '';
}

$idDashboard = $_GET['id'];
$dashboardInfo = getDashboardById($idDashboard);

$dashboardFormations = getFormationOfADashboard($idDashboard);
$courses = [];
foreach(getParcoursOfADashboard($idDashboard) as $parcours){
    $courses[] = $parcours["nameParcours"];
}

?>

<script>
    const data = <?php echo json_encode($courses); ?>;
    const selectedParcours = <?php echo json_encode($selectedParcours); ?>
</script>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="AffichageDashBoard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="../Controller/JsDashBoard.js"></script>
    <title>Les Candidats</title>
</head>

<body>

<header class="banner">
    <h1>
        <?php echo !empty($dashboardInfo['nameOfDashBoard']) ? $dashboardInfo['nameOfDashBoard'] : "SANS NOM" ?>
    </h1>
    <form action="PageAfficheTableau.php">
        <button  >Retourner voir les autres tableaux de bords</button>
    </form>
</header>

<form id="filter-form" method="POST" action="../View/dashboard.php?id=<?php echo $idDashboard ?>">

    <section class="filtreCandidats">

        <div class="selection">
            <label for="formation" class="form-select-label"> Département </label>
            <div class="multiselect" >
                <div class="selectBox" onclick="showCheckboxes('checkboxesFormation')">
                    <select class="form-select" id="formation">
                        <option>Selectionner plusieurs formations</option>
                    </select>
                    <div class="overSelect"></div>
                </div>
                <div class="checkboxes-container" id="checkboxesFormation">
                    <?php foreach ($dashboardFormations as $formation) {?>
                        <label for="<?php echo $formation['nameFormation']; ?>">
                            <input type="checkbox" name="formation[]" onchange="onChangeUpdateDisplayMultiple('../Controller/ControllerDashboardAjax.php', data, selectedParcours)" value="<?php echo $formation['nameFormation']; ?>" <?php echo (isset($_POST['formation']) && in_array($formation['nameFormation'], $_POST['formation'])) ? 'checked' : ''; ?>> <?php echo $formation['nameFormation']; ?>
                        </label>
                    <?php } ?>
                </div>
            </div>
        </div>


        <div class="selection">
            <label for="parcours" class="form-select-label"> Parcours </label>
            <div class="multiselect">
                <div class="selectBox" onclick="showCheckboxes('checkboxesParcours')">
                    <select class="form-select"  id="parcours">
                        <option>Selectionner plusieurs parcours</option>
                    </select>
                    <div class="overSelect"></div>
                </div>
                <div class="checkboxes-container" id="checkboxesParcours">
                </div>
            </div>
        </div>

        <div class="formName">
            <input type="text" class="form-control" name="nameCandidates" id="nameCandidates" value="<?php echo isset($_POST['nameCandidates']) ? $_POST['nameCandidates'] : ''; ?>" placeholder="Filtrage par nom">
        </div>

        <div class="checkbox">
            <input class="form-check" type="checkbox" name="isActive" id="isActive" <?php echo (isset($_POST['isActive'])) ? 'checked' : ''; ?>>
            <label for="isNotActive" class="form-check-label"> Affiche les Non-actifs </label>
        </div>

        <div class="checkbox">
            <input class="form-check" type="checkbox" name="isFound" id="isFound" <?php echo (isset($_POST['isFound'])) ? 'checked' : ''; ?>>
            <label for="isFound" class="form-check-label"> Affiche ceux qui ont une alternance </label>
        </div>

        <div class="buttonSubmit">
            <button class="btn btn-primary" type="submit" name="submit" id="submit"> Rechercher</button>
        </div>
    </section>
</form>

<form id="delete-form" method="post" action="../Controller/ControllerGestionDashboard.php?idDashboard=<?php echo $idDashboard ?>">
    <section class="afficheCandidats">
        <table class="table" id="candidateTable">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Parcours</th>
                <th>Rendre Inactif/Actif</th>
                <th>Recherche d'Alternance</th>
                <th>Télécharger CV</th>
                <th>Statut Alternance</th>
                <th>Statut Actif</th>
                <th>Détail</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $candidates = filtrageMultiple($courses);
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
                            N'a pas le contrat
                        <?php } ?>
                    </td>
                    <td>
                        <input type="checkbox" name="checkboxWithCV[]" value="<?php echo $candidate['idCandidate']; ?>"> Télécharger le CV
                    </td>
                    <td>
                        <span style="color: <?php echo ($candidate['foundApp'] == 0) ? '#bb2323' : 'green'; ?>">
                            <?php echo ($candidate['foundApp'] == 0) ? 'Sans contrat' : 'A un contrat'; ?>
                        </span>
                    </td>
                    <td>
                        <span style="color: <?php echo ($candidate['isInActiveSearch'] == 0) ? '#bb2323' : 'green'; ?>">
                            <?php echo ($candidate['isInActiveSearch'] == 1) ? 'Actif' : 'Inactif'; ?>
                        </span>
                    </td>
                    <td>
                        <a class="btn btn-primary" href="./PageAffichageCandidatDashboardPrecis.php?idCandidate=<?php echo $candidate["idCandidate"]; ?>&idDashboard=<?php echo $idDashboard ?>">
                            Détail
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </section>

    <!--
    Code du modal repris de la documentation boostrap : Réadapté par Nathan Strady
    https://getbootstrap.com/docs/5.0/components/modal/
    -->
    <section>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Les effectifs du tableau : <?= !empty($dashboardInfo['nameOfDashBoard']) ? $dashboardInfo['nameOfDashBoard'] : "SANS NOM" ?> </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5> Informations sur tous les candidats</h5>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Nombre de candidats</th>
                                <th>Actifs</th>
                                <th>Non-actifs</th>
                                <th>Alternants</th>
                                <th>Non-Alternants</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?= getNbEtuWithFormation($dashboardFormations); ?></td>
                                <td style="color: green;"><?= getNbEtuActivesWithFormation($dashboardFormations, 1); ?></td>
                                <td style="color: red;"><?= getNbEtuActivesWithFormation($dashboardFormations, 0); ?></td>
                                <td style="color: green;"><?= getNbEtuFoundAppWithFormation($dashboardFormations, 1); ?></td>
                                <td style="color: red;"><?=  getNbEtuFoundAppWithFormation($dashboardFormations, 0); ?></td>
                            </tr>
                            </tbody>
                        </table>
                        <?php foreach ($dashboardFormations as $formation) {
                            $nbStudentFormation = getNbEtuPerFormation($formation['nameFormation']);
                            $nbStudentParcours = getNbEtuPerParcours($formation['nameFormation']);
                            ?>
                            <div class="rounded-box">
                                <hr>
                                <h5><?= $formation['nameFormation'] ?></h5>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Nombre de candidat.e.s</th>
                                        <th>Actifs</th>
                                        <th>Non-actifs</th>
                                        <th>Alternants</th>
                                        <th>Non-Alternants</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?= (isset($nbStudentFormation['effectifFormation'])) ? $nbStudentFormation['effectifFormation'] : "0"; ?></td>
                                        <td style="color: green;"><?= isset($nbStudentFormation['actifs']) ? $nbStudentFormation['actifs'] : 0; ?></td>
                                        <td style="color: red;"><?= isset($nbStudentFormation['inactifs']) ? $nbStudentFormation['inactifs'] : 0; ?></td>
                                        <td style="color: green;"><?= isset($nbStudentFormation['alternants']) ? $nbStudentFormation['alternants'] : 0; ?></td>
                                        <td style="color: red;"><?= isset($nbStudentFormation['non_alternants']) ? $nbStudentFormation['non_alternants'] : 0; ?></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Parcours</th>
                                        <th>Nombre de candidat.e.s</th>
                                        <th>Actifs</th>
                                        <th>Non-actifs</th>
                                        <th>Alternants</th>
                                        <th>Non-Alternants</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($nbStudentParcours as $nbStudent) {
                                        if (in_array($nbStudent['nameParcours'], $courses)) { ?>
                                            <tr>
                                                <td><?= $nbStudent['nameParcours'] ?></td>
                                                <td><?= (isset($nbStudent['nombreetudiants'])) ? $nbStudent['nombreetudiants'] : "0"; ?></td>
                                                <td style="color: green;"><?= isset($nbStudent['actifs']) ? $nbStudent['actifs'] : 0; ?></td>
                                                <td style="color: red;"><?= isset($nbStudent['inactifs']) ? $nbStudent['inactifs'] : 0; ?></td>
                                                <td style="color: green;"><?= isset($nbStudent['alternants']) ? $nbStudent['alternants'] : 0; ?></td>
                                                <td style="color: red;"><?= isset($nbStudent['non_alternants']) ? $nbStudent['non_alternants'] : 0; ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit" name="submit" id="submit">Changer l'état des candidats</button>
                    <div class="mb-2"></div>
                    <button class="btn btn-primary" type="submit" name="cvs" id="submit">Télecharger les CVs</button>
                </div>
            </div>
        </div>
    </section>

    <footer class="bottomBanner">
        <?php if ($dashboardInfo['isHeadcount'] == 1)  : ?>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Afficher les effectifs
            </button>
        <?php endif; ?>
    </footer>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="../Controller/js/DashboardAjax.js"></script>
</body>
</html>