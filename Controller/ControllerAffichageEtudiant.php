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
    echo '<select class="form-select" name="formation" id="formation" onchange="onChangeUpdateDisplayParcours()">',"\n";
    foreach($results as $row)
    {
        $selected = 'selected="selected"';
        echo "\t",'<option value="', $row['nameFormation'] ,'"', $selected ,'>', $row['nameFormation'] ,'</option>',"\n";
        $selected='';
    }
    echo '<option value="AucuneOption" selected="selected"> Aucune Option </option>';
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
        <p class="candidates" id="candidats"> '. $row['firstName'] . " " . $row['name'] . " " . $row['nameFormation'] .'<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id='.$row["idCandidate"].'">Détail</a>'.'
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" '.  $row['idCandidate'] .' " onclick="showAlert(this)">Supprimer</button> ';

    }

}

function choiceAllCandidatesByNameAndParcours($conn, $parcours, $isActive){
    $results = selectCandidatesByNameAndParcours($conn, $parcours,  $isActive);
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

    if (isset($choixNom) && !empty($choixNom) && isset($choixFormation) && $choixFormation != "AucuneOption") {
        choiceAllCandidatesByNameAndParcours($conn, $choixFormation, $isActive, $choixNom);

    } elseif (isset($choixNom) && !empty($choixNom)) {
        choiceAllCandidatesByName($conn, $isActive, $choixNom);

    } elseif (isset($choixFormation) && $choixFormation != "AucuneOption") {
        choiceAllCandidatesByParcours($conn, $choixFormation, $isActive);

    } else {
        choiceAllOptionWithActive($conn, $isActive);
    }
}





