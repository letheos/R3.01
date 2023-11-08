<?php
$conn = require "../Model/Database.php";


/**
 * @param $conn
 * @return void
 * Créer la liste déroulante dynamiquement en fonction des formations.
 */
//Fonction d'affichage des candidats
function listAffichageSelect($conn){
    $selected = '';
    $results = allFormation($conn);
    echo '<select class="form-select" name="formation" id="formation" onchange="onChangeUpdateDisplayParcours(\'../Controller/ControllerParcoursAffichage.php\')">', "\n";
    foreach($results as $row)
    {
        $selected = 'selected="selected"';
        echo "\t",'<option value="', $row['nameFormation'] ,'"', $selected ,'>', $row['nameFormation'] ,'</option>',"\n";
        $selected='';
    }
    echo '<option value="Aucune Option" selected="selected"> Aucune Option </option>';
    echo '</select>',"\n";
}


/**
 * @param $conn
 * @param $choixFormation
 * @param $isActive
 * @return void
 * Affiche dans le php les candidats en fonction du filtrage
 */
//Fonction d'affichage des candidats en fonction d'un filtrage
function choiceAllOptionWithActive($conn, $isActive){
    $results = selectCandidatesActives($conn, $isActive);
    foreach ($results as $row) {
        // Utilisez un lien vers la page des détails du candidat
        echo '
        <p class="candidates" id="candidats"> '. $row['firstName'] . " " . $row['name'] . " " . $row['nameParcours'] .'<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id='.$row["idCandidate"].'">Détail</a>'.'
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" '.  $row['idCandidate'] .' " onclick="showAlert(this)">Supprimer</button> ';
    }
}



/**
 * @param $conn
 * @param $choixFormation
 * @param $isActive
 * @return void
 * Affiche dans le php les candidats en fonction du filtrage sur la formation
 */
//Fonction d'affichage des candidats en fonction d'un filtrage sur la formation
function choiceAllCandidatesByFormation($conn, $choixFormation,  $isActive){
    $results = selectCandidatesByFormation($conn, $choixFormation,  $isActive);
    foreach ($results as $row) {
        echo '
        <p class="candidates" id="candidats"> '. $row['firstName'] . " " . $row['name'] . " " . $row['nameParcours'] .'<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id='.$row["idCandidate"].'">Détail</a>'.'
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" '.  $row['idCandidate'] .' " onclick="showAlert(this)">Supprimer</button> ';

    }

}

function choiceAllCandidatesByParcours($conn, $parcours, $isActive){
    $results = selectCandidatesByParcours($conn, $parcours,  $isActive);
    foreach ($results as $row) {
        echo '
        <p class="candidates" id="candidats"> '. $row['firstName'] . " " . $row['name'] . " " . $row['nameParcours'] .'<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id='.$row["idCandidate"].'">Détail</a>'.'
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" '.  $row['idCandidate'] .' " onclick="showAlert(this)">Supprimer</button> ';

    }

}

function choiceAllCandidatesByNameAndParcours($conn, $choixNom,$parcours, $isActive){
    $results = selectCandidatesByNameAndParcours($conn, $choixNom,$parcours,  $isActive);
    foreach ($results as $row) {
        echo '
        <p class="candidates" id="candidats"> '. $row['firstName'] . " " . $row['name'] . " " . $row['nameParcours'] .'<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id='.$row["idCandidate"].'">Détail</a>'.'
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" '.  $row['idCandidate'] .' " onclick="showAlert(this)">Supprimer</button> ';

    }

}

/**
 * @param $conn
 * @param $choixFormation
 * @param $isActive
 * @return void
 * Affiche dans le php les candidats en fonction du filtrage sur le nom et la formation
 */
//Fonction d'affichage des candidats en fonction d'un filtrage sur la formation et le nom
function choiceAllCandidatesByNameAndFormation($conn, $choixFormation,  $isActive, $choixNom){
    $results = selectCandidatesByNameAndFormation($conn, $choixFormation, $choixNom, $isActive);
    foreach ($results as $row) {
        echo '
        <p class="candidates" id="candidats"> '. $row['firstName'] . " " . $row['name'] . " " . $row['nameParcours'] .'<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id='.$row["idCandidate"].'">Détail</a>'.'
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" '.  $row['idCandidate'] .' " onclick="showAlert(this)">Supprimer</button> ';

    }
}

/**
 * @param $conn
 * @param $choixFormation
 * @param $isActive
 * @return void
 * Affiche dans le php les candidats en fonction du filtrage sur le nom
 */
//Fonction d'affichage des candidats en fonction d'un filtrage sur le nom
function choiceAllCandidatesByName($conn, $isActive, $choixNom){
    $results = selectCandidatesByName($conn, $choixNom,  $isActive);
    foreach ($results as $row) {
        echo '
        <p class="candidates" id="candidats"> '. $row['firstName'] . " " . $row['name'] . " " . $row['nameParcours'] .'<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id='.$row["idCandidate"].'">Détail</a>'.'
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" '.  $row['idCandidate'] .' " onclick="showAlert(this)">Supprimer</button> ';


    }

}

function choiceAllCandidatesByNameFormationAndParcours($conn, $choixNom, $choixFormation, $parcours, $isActive){
    $results = selectCandidatesByNameFormationAndParcours($conn,$parcours, $choixNom, $choixFormation, $isActive);
    foreach ($results as $row) {
        echo '
        <p class="candidates" id="candidats"> '. $row['firstName'] . " " . $row['name'] . " " . $row['nameParcours'] .'<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id='.$row["idCandidate"].'">Détail</a>'.'
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" '.  $row['idCandidate'] .' " onclick="showAlert(this)">Supprimer</button> ';


    }
}



function filtrage($conn)
{
    if (isset($_POST["submit"])) {
        $choixFormation = $_POST["formation"];
        $choixNom = $_POST["nameCandidates"];
        $parcours = $_POST['parcours'];
    }


    //Traitement de la checkbox
    if (isset($_POST["isActive"])) {
        $isActive = 0;
    } else {
        $isActive = 1;
    }

    $hasFormationFilter = !empty($choixFormation) && $choixFormation !== "Aucune Option";
    $hasNomFilter = !empty($choixNom);
    $hasParcoursFilter = !empty($parcours);


    // Exécuter les requêtes en fonction des critères de filtrage
    if ($hasFormationFilter && $hasNomFilter && $hasParcoursFilter) {
        // Filtrage par formation, nom et parcours
        choiceAllCandidatesByNameFormationAndParcours($conn, $choixFormation, $choixNom, $parcours, $isActive);
    } elseif ($hasFormationFilter && $hasNomFilter) {
        // Filtrage par formation et nom
        choiceAllCandidatesByNameAndFormation($conn, $choixFormation, $isActive, $choixNom);
    } elseif ($hasFormationFilter && $hasParcoursFilter) {
        // Filtrage par formation et parcours
        choiceAllCandidatesByFormationAndParcours($conn, $choixFormation, $parcours, $isActive);
    } elseif ($hasNomFilter && $hasParcoursFilter) {
        // Filtrage par nom et parcours
        choiceAllCandidatesByNameAndParcours($conn, $choixNom, $parcours, $isActive);
    } elseif ($hasFormationFilter) {
        // Filtrage par formation uniquement
        choiceAllCandidatesByFormation($conn, $choixFormation, $isActive);
    } elseif ($hasNomFilter) {
        // Filtrage par nom uniquement
        choiceAllCandidatesByName($conn, $isActive, $choixNom);
    } elseif ($hasParcoursFilter) {
        // Filtrage par parcours uniquement
        choiceAllCandidatesByParcours($conn, $parcours, $isActive);
    } else {
        // Aucun critère de filtrage sélectionné, afficher tous les candidats
        choiceAllOptionWithActive($conn, $isActive);
    }
}





