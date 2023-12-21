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


/**
 * @param $conn PDO
 * @return String[]
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

