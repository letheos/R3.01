<?php
$conn = require "../Model/Database.php";
require '../Model/ModelSelect.php';



/**
 * Controller de la page affichage étudiant
 * @author : Nathan Strady
 */

/**
 * @param $conn
 * @return void
 * Créer la liste déroulante dynamiquement en fonction des formations.
 */
//Fonction d'affichage des candidats
function listAffichageSelect($conn){
    $selected = '';
    $selectedFormation = (isset($_POST['formation'])) ? $_POST['formation'] : '';
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