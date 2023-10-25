<?php
require "../Model/modelCreationTableau.php";
/**
 * @param $conn PDO
 * @return mixed
 * take a PDO connection and return the values of getAllParcours
 */
function controllerGetAllParcours(){
    $conn = require "../Model/database.php";
    return getAllParcours($conn);
}

function controllerGetAllFormations(){
    $conn = require "../Model/database.php";
    return getAllFormation($conn);
}