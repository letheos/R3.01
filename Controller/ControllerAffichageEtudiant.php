<?php
$conn = require "../Model/Database.php";
require '../Model/ModelSelect.php';


/**
 * Controller de la page affichage étudiant
 * @author : Nathan Strady
 */


function getAllFormation(){
    global $conn;
    return allFormation($conn);
}

/**
 * Fonction qui gère le filtrage pour afficher des candidats en fonction de critères précis
 * @param $conn : Connection à la base de donnée
 * @return void Modifie l'affichage en fonction d'un filtrage
 */
function filtrage()
{
    global $conn;
    if (isset($_POST["submit"])) {
        $choixFormation = $_POST["formation"];
        $choixNom = $_POST["nameCandidates"];
        $parcours = $_POST['parcours'];
    }



    //Traitement de la checkbox
    if (isset($_POST["isActive"])) {
        $isActive = 0;
    } else {
        $isActive = 1;
    }

    $hasFormationFilter = !empty($choixFormation) && $choixFormation !== "Aucune Option";
    $hasNomFilter = !empty($choixNom);
    $hasParcoursFilter = !empty($parcours);

    // Exécuter les requêtes en fonction des critères de filtrage
    if ($hasFormationFilter && $hasNomFilter && $hasParcoursFilter) {
        // Filtrage par formation, nom et parcours
        return selectCandidatesByNameFormationAndParcours($conn, $parcours, $choixNom, $choixFormation, $isActive);
    } elseif ($hasFormationFilter && $hasNomFilter) {
        // Filtrage par formation et nom
        return selectCandidatesByNameAndFormation($conn, $choixFormation, $choixNom, $isActive);
    } elseif ($hasFormationFilter && $hasParcoursFilter) {
        // Filtrage par formation et parcours
        return selectCandidateByFormationAndParcours($conn, $choixFormation, $parcours, $isActive);
    } elseif ($hasNomFilter && $hasParcoursFilter) {
        // Filtrage par nom et parcours
        return selectCandidatesByNameAndParcours($conn, $parcours, $choixNom, $isActive);
    } elseif ($hasFormationFilter) {
        // Filtrage par formation uniquement
        return selectCandidatesByFormation($conn, $choixFormation, $isActive);
    } elseif ($hasNomFilter) {
        // Filtrage par nom uniquement
        return selectCandidatesByName($conn, $choixNom, $isActive);
    } elseif ($hasParcoursFilter) {
        // Filtrage par parcours uniquement
        return selectCandidatesByParcours($conn, $parcours, $isActive);
    } else {
        // Aucun critère de filtrage sélectionné, afficher tous les candidats
        return selectCandidatesActives($conn, $isActive);
    }
}









