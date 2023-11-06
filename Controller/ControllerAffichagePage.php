<?php

/**
 * Fichier du Controller gérant les affichages html dans la page Création Candidat
 * @author Nathan Strady
 */

require "../Model/ModelCreationCompte.php";

/**
 * Fonction affichant une lise déroulante ayant tout les prcours
 * @param $conn : Connection à la base de donnée
 * @return void : Ne renvoie rien, sert seulement d'affichage
 */
function displayDropdown($conn) {
    $result = selectAllFormation($conn);

    echo '<select class="form-select" name="formation" id="formation" onchange="onChangeUpdateDisplayParcours()" required>';

    echo '<option value="AucuneOption" selected disabled> Choisir le département </option>';

    foreach ($result as $rows) {
        $formationName = $rows['nameFormation'];
        echo '<option value="' . $formationName . '">' . $formationName . '</option>';
    }
    echo '<option value="Aucune Option" > Aucune Option </option>';
    echo '</select>';
}

