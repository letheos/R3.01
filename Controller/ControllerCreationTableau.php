<?php
require "../Model/ModelCreationTableau.php";


if(isset($_POST['finish'])){

}else{
    $page = require_once "../View/PageCreationTableau.php";

    header($page);
}

/**
 * @param $conn PDO
 * @return mixed
 * take a PDO connection and return the values of getAllParcours
 */
function controllerGetAllParcours(){
    $conn = require "../Model/Database.php";
    return getAllParcours($conn);
}

function controllerGetAllFormations(){
    $conn = require "../Model/Database.php";
    return getAllFormation($conn);
}