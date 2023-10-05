<?php
$conn = require "../Model/Database.php";
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

function  choiceAllOptionWithActive($conn, $isNotActive){
    $results = selectCandidatesActives($conn, $isNotActive);
    foreach ($results as $row) {
        echo '<p class="candidates"> INE : ' . $row['INE'] . " " . $row['firstName'] . " " . $row['name'] . " " . $row['nameFormation'] . '</p>';
    }
}

function choiceAllCandidatesByFormation($conn, $choixFormation,  $isActive){
    $results = selectCandidatesByFormation($conn, $choixFormation,  $isActive);
    foreach ($results as $row) {
        echo '<p class="candidates"> INE : ' . $row['INE'] . " " . $row['firstName'] . " " . $row['name'] . " " . $row['nameFormation'] . '</p>';
    }

}

function choiceAllCandidatesByNameAndFormation($conn, $choixFormation,  $isActive, $choixNom){
    $results = selectCandidatesByNameAndFormation($conn, $choixFormation,  $isActive, $choixNom);
    foreach ($results as $row) {
        echo '<p class="candidates"> INE : ' . $row['INE'] . " " . $row['firstName'] . " " . $row['name'] . " " . $row['nameFormation'] . '</p>';
    }

}

function choiceAllCandidatesByName($conn, $isActive, $choixNom){
    $results = selectCandidatesByName($conn, $choixNom,  $isActive);
    foreach ($results as $row) {
        echo '<p class="candidates"> INE : ' . $row['INE'] . " " . $row['firstName'] . " " . $row['name'] . " " . $row['nameFormation'] . '</p>';
    }

}



