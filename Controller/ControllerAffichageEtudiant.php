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

function filtrageMultiple()
{
    global $conn;
    if (isset($_POST["submit"])) {
        $choixFormations = isset($_POST["formation"]) ? $_POST["formation"] : [];
        $choixNom = isset($_POST["nameCandidates"]) ? $_POST["nameCandidates"] : "";
        $choixParcours = isset($_POST["parcours"]) ? $_POST["parcours"] : [];
    }

    // Traitement de la checkbox
    $isActive = isset($_POST["isActive"]) ? 0 : 1;

    $hasFormationFilter = !empty($choixFormations) && $choixFormations[0] !== "Aucune Option";
    $hasNomFilter = !empty($choixNom);
    $hasParcoursFilter = !empty($choixParcours);

    // Exécuter les requêtes en fonction des critères de filtrage
    if ($hasFormationFilter && $hasNomFilter && $hasParcoursFilter) {
        // Filtrage par formation, nom, et parcours
        $result = [];
        foreach ($choixFormations as $formation) {
            foreach ($choixParcours as $parcours) {
                $result = array_merge($result, selectCandidatesByNameFormationAndParcours($conn, $parcours, $choixNom, $formation, $isActive));
            }
        }
        return $result;
    } elseif ($hasFormationFilter && $hasNomFilter) {
        // Filtrage par formation et nom
        $result = [];
        foreach ($choixFormations as $formation) {
            $result = array_merge($result, selectCandidatesByNameAndFormation($conn, $formation, $choixNom, $isActive));
        }
        return $result;
    } elseif ($hasFormationFilter && $hasParcoursFilter) {
        // Filtrage par formation et parcours
        $result = [];
        foreach ($choixFormations as $formation) {
            foreach ($choixParcours as $parcours) {
                $result = array_merge($result, selectCandidateByFormationAndParcours($conn, $formation, $parcours, $isActive));
            }
        }
        return $result;
    } elseif ($hasNomFilter && $hasParcoursFilter) {
        // Filtrage par nom et parcours
        $result = [];
        foreach ($choixParcours as $parcours) {
            $result = array_merge($result, selectCandidatesByNameAndParcours($conn, $parcours, $choixNom, $isActive));
        }
        return $result;
    } elseif ($hasFormationFilter) {
        // Filtrage par formation uniquement
        $result = [];
        foreach ($choixFormations as $formation) {
            $result = array_merge($result, selectCandidatesByFormation($conn, $formation, $isActive));
        }
        return $result;
    } elseif ($hasNomFilter) {
        // Filtrage par nom uniquement
        return selectCandidatesByName($conn, $choixNom, $isActive);
    } elseif ($hasParcoursFilter) {
        // Filtrage par parcours uniquement
        $result = [];
        foreach ($choixParcours as $parcours) {
            $result = array_merge($result, selectCandidatesByParcours($conn, $parcours, $isActive));
        }
        return $result;
    } else {
        // Aucun critère de filtrage sélectionné, afficher tous les candidats
        return selectCandidatesActives($conn, $isActive);
    }
}








