<?php

//TODO faire le controller pour pouvoir crée un tableau de bord dans la bdd quand théo aura fini
//TODO faire le code qui ajoute le tableau de bord à l'utilisateur et à tout les roles (attention il ne faut pas que le user est 2 fois le même erreurs)
require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['finish'])) {
        echo '<script>alert("a")</script>';
    } else {
        $page = require_once "../View/PageAfficheTableau.php";
        header($page);

    }
}


function addValuesOfADashBoard(){}

/**
 * @return int
 */
function ControlerLastInsert(){
    $conn = require "../Model/Database.php";
    return getLastIdDashBoard($conn);
}

/**
 * @param $conn PDO
 * @return mixed
 * take a PDO connection and return the values of getAllParcours
 */
function controllerGetAllParcours($conn){
    return getAllParcours($conn);
}

/**
 * @param $conn PDO
 * @return String[]
 * take a PDO connection and return the values of getAllFormation
 */
function controllerGetAllFormations($conn){
    return getAllFormation($conn);
}

/**
 * @param $conn PDO
 * @return String[]
 * tkae a PDO connection and return the values of getAllRole
 */
function controllerGetAllRole($conn){
    return getAllRole($conn);
}
//
function generateAccordion($conn)
{
    $formations = getAllFormation($conn);
    foreach ($formations as $index => $formation) {
        $parcours = selectParcours($conn, $formation['nameFormation']);
        $checkboxId = $formation['nameFormation'];
        $collapseId = 'collapse' . $index;
        echo '<div class="accordion-item">';
        echo '<strong class="accordion-header" id="heading' . $index . '">';
        echo '<input class="form-check-input" type="checkbox" name="selectedFormation[]" id="' . $checkboxId . '" onchange="toggleAccordion(\'' . $checkboxId . '\')" data-formation="' . $formation['nameFormation'] . '"> ';
        echo $formation['nameFormation'];
        echo "</input>";
        echo '</strong>';
        echo '<div id="' . $collapseId . '" class="accordion-collapse collapse" aria-labelledby="heading' . $index . '"">';
        echo '<div class="accordion-body">';
        foreach($parcours as $indexParcours => $parcour){
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="checkbox" id="parcours' . $indexParcours . '" name="selectedParcours[]" value="' . $parcour['nameParcours'] . '">';
            echo '<label class="form-check-label" for="parcours' . $indexParcours . '">' . $parcour['nameParcours'] . '</label>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

}

/**
 * @param $idDashBoard
 * @return Array
 * this function return the value that GetFormationForADashBoard return with the parameter idDashBoard
 */
function ControllerGetFormationForADashBoard($idDashBoard): array
{
    $conn = require "../Model/Database.php";
    return GetFormationForADashBoard($conn,$idDashBoard);
}
