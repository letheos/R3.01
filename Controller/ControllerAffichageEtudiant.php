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
    echo '<select class="form-select" name="formation" id="formation">',"\n";
    foreach($results as $row)
    {
        $selected = 'selected="selected"';
        echo "\t",'<option value="', $row['nameFormation'] ,'"', $selected ,'>', $row['nameFormation'] ,'</option>',"\n";
        $selected='';
    }
    echo '<option value="AucuneOption" selected="selected" > Aucune Option </option>';
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
function  choiceAllOptionWithActive($conn, $isActive){
    $results = selectCandidatesActives($conn, $isActive);
    foreach ($results as $row) {
        echo '<p class="candidates"> INE : ' . $row['INE'] . " " . $row['firstName'] . " " . $row['name'] . " " . $row['nameFormation'] .'<br> <button class="btn btn-primary" name="detail" id="detail"> Détail </button>'.'</p>';

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
        echo '<p class="candidates"> INE : ' . $row['INE'] . " " . $row['firstName'] . " " . $row['name'] . " " . $row['nameFormation'] .'<br> <button class="btn btn-primary" name="detail" id="detail"> Détail </button>'.'</p>';

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
        echo '<p class="candidates"> INE : ' . $row['INE'] . " " . $row['firstName'] . " " . $row['name'] . " " . $row['nameFormation'] .'<br> <button class="btn btn-primary" type="submit" name="detail" id="detail"> Détail </button>'.'</p>';

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
        echo '<p class="candidates"> INE : ' . $row['INE'] . " " . $row['firstName'] . " " . $row['name'] . " " . $row['nameFormation'] .'<br> <button class="btn btn-primary" name="detail" id="detail"> Détail </button>'.'</p>';

    }

}





