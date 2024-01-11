<?php

$conn = require "../Model/Database.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);


/**
 * Controller de la page affichage étudiant
 * @author : Nathan Strady
 */

/**
 * @param $conn
 * @return void
 * Créer la liste déroulante dynamiquement en fonction des formations version multiselection.
 */
//Fonction d'affichage des candidats
function getFormation(){
    global $conn;
    return allFormation($conn);
}
