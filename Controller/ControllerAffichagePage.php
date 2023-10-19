<?php
require "../Model/ModelCreationCompte.php";

function displayCheckboxes($conn){
    $result = selectAllFormation($conn);
    foreach ($result as $rows){
        $formationName = $rows['nameFormation'];

        echo '<label class="choices" draggable="false">';
        echo '<input class="choices-formation" type="checkbox" name="'. $formationName .'" value="' . $formationName . '" draggable="false">';
        echo $formationName;
        echo '</label>';
    }
}

function displayDropdown($conn) {
    $result = selectAllFormation($conn);

    echo '<select class="form-select" name="formation">';

    foreach ($result as $rows) {
        $formationName = $rows['nameFormation'];
        echo '<option value="' . $formationName . '">' . $formationName . '</option>';
    }

    echo '</select>';
}