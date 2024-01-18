<?php

/**
 * Fichier du Controller gérant les affichages html dans la page Création Candidat
 * @author Nathan Strady
 */

require "../Model/ModelSelect.php";
$conn = require '../Model/database.php';

/**
 * Fonction affichant une lise déroulante ayant tout les prcours
 * @param $conn : Connection à la base de donnée
 * @return void : Ne renvoie rien, sert seulement d'affichage
 */
function displayDropdown($conn) {
    $result = selectAllFormation($conn);

    echo '<select class="form-select" name="formation" id="formation" onchange="onChangeUpdateDisplayParcours(\'../Controller/ControllerParcours.php\')" required>';

    echo '<option value="AucuneOption" selected disabled> Choisir le département </option>';

    foreach ($result as $rows) {
        $formationName = $rows['nameFormation'];
        echo '<option value="' . $formationName . '">' . $formationName . '</option>';
    }
    echo '<option value="Aucune Option" > Aucune Option </option>';
    echo '</select>';
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

return selectCandidatById($conn, $_GET['id']);

