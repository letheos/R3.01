<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['finish'])) {
        echo '<script>alert("a")</script>';
    } else {
        $page = require_once "../View/PageAfficheTableau.php";
        header($page);

    }
}


/**
 * @param $conn PDO
 * @return mixed
 * take a PDO connection and return the values of getAllParcours
 */
function controllerGetAllParcours($conn){
    return getAllParcours($conn);
}

function controllerGetAllFormations($conn){

    return getAllFormation($conn);
}

