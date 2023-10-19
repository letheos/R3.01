<?php
require "../Model/ModelCreationCompte.php";

function displayDropdown($conn) {
    $result = selectAllFormation($conn);


    echo '<select class="form-select" name="formation">';

    echo '<option selected disabled> Choisir son parcours </option>';

    foreach ($result as $rows) {
        $formationName = $rows['nameFormation'];
        echo '<option value="' . $formationName . '">' . $formationName . '</option>';
    }
    echo '<option value="undefined" > Non-défini </option>';
    echo '</select>';
}