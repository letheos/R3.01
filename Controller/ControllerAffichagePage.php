<?php

/**
 * Fichier du Controller gérant les affichages html dans la page Création Candidat
 * @author Nathan Strady
 */

require "../Model/ModelSelect.php";
$conn = require '../Model/database.php';

function getCandidatById($id){
    global $conn;
    return selectCandidatById($conn, $id);
}

function listAffichageSelectUpdate($conn, $candidat){
    $selectedFormation = (isset($candidat['nameFormation'])) ? $candidat['nameFormation'] : '';
    $results = allFormation($conn);

    echo '<select class="form-select" name="formation" id="formation" onchange="onChangeUpdateDisplayParcours(\'../Controller/ControllerParcoursAffichage.php\')">', "\n";
    echo '<option value="" selected="selected" disabled> Choisir la formation </option>';
    foreach($results as $row)
    {
        $optionValue = $row['nameFormation'];
        $selected = ($selectedFormation == $optionValue) ? 'selected' : '';
        echo "\t", '<option value="', $optionValue, '"', $selected, '>', $optionValue, '</option>', "\n";
    }
    echo '<option value="Aucune Option" > Aucune Option </option>';
    echo '</select>',"\n";
}




