
<?php
$conn = require "../Model/Database.php";
require '../Model/ModelSelect.php';
include '../Controller/ClassUtilisateur.php';
session_start();

/**
 * Controller de la page affichage étudiant
 * @author : Nathan Strady
 */



function getDashboardById($id){
    global $conn;
    return selectDashboardById($conn, $id);
}

function getParcoursOfADashboard($id){
    global $conn;
    return selectParcoursOfDashboard($conn, $id);
}


function getFormationOfADashboard($id){
    global $conn;
    return selectFormationOfDashboard($conn, $id);
}

function getAllFormation(){
    global $conn;
    return allFormation($conn);
}


function getNbEtuPerFormation($formation){
    global $conn;
    return selectNbStudentPerFormation($conn, $formation);
}

function getNbEtuPerParcours($formation){
    global $conn;
    return selectNbStudentPerParcours($conn, $formation);
}

function getNbEtuActives(){
    global $conn;
    return countNbStudentActives($conn, 1);
}

function getNbEtuFoundApp(){
    global $conn;
    return countNbStudentFoundApp($conn, 1);
}

function getNbEtuNotActives(){
    global $conn;
    return countNbStudentActives($conn, 0);
}

function getNbEtuNotFoundApp(){
    global $conn;
    return countNbStudentFoundApp($conn, 0);
}

function getNbEtu(){
    global $conn;
    return countAllStudents($conn);
}


function getNbEtuWithFormation($formation){
    global $conn;
    $count = 0;
    foreach($formation as $formations){
        $count += selectNbStudentPerFormation($conn, $formations)['effectifFormation'];
    }
    return $count;
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

    $isFound = isset($_POST["isFound"]) ? 1 : 0;

    $hasFormationFilter = !empty($choixFormation) && $choixFormation !== "Aucune Option";
    $hasNomFilter = !empty($choixNom);
    $hasParcoursFilter = !empty($parcours);

    // Exécuter les requêtes en fonction des critères de filtrage
    if ($hasFormationFilter && $hasNomFilter && $hasParcoursFilter) {
        // Filtrage par formation, nom et parcours
        return selectCandidatesByNameFormationAndParcours($conn, $parcours, $choixNom, $choixFormation, $isActive, $isFound);
    } elseif ($hasFormationFilter && $hasNomFilter) {
        // Filtrage par formation et nom
        return selectCandidatesByNameAndFormation($conn, $choixFormation, $choixNom, $isActive, $isFound);
    } elseif ($hasFormationFilter && $hasParcoursFilter) {
        // Filtrage par formation et parcours
        return selectCandidateByFormationAndParcours($conn, $choixFormation, $parcours, $isActive, $isFound);
    } elseif ($hasNomFilter && $hasParcoursFilter) {
        // Filtrage par nom et parcours
        return selectCandidatesByNameAndParcours($conn, $parcours, $choixNom, $isActive, $isFound);
    } elseif ($hasFormationFilter) {
        // Filtrage par formation uniquement
        return selectCandidatesByFormation($conn, $choixFormation, $isActive, $isFound);
    } elseif ($hasNomFilter) {
        // Filtrage par nom uniquement
        return selectCandidatesByName($conn, $choixNom, $isActive, $isFound);
    } elseif ($hasParcoursFilter) {
        // Filtrage par parcours uniquement
        return selectCandidatesByParcours($conn, $parcours, $isActive, $isFound);
    } else {
        // Aucun critère de filtrage sélectionné, afficher tous les candidats
        return selectCandidatesActives($conn, $isActive, $isFound);
    }
}

function filtrageMultiple($selectedParcours)
{
    global $conn;

    if (isset($_POST["submit"])) {
        $choixFormations = isset($_POST["formation"]) ? $_POST["formation"] : [];
        $choixNom = isset($_POST["nameCandidates"]) ? $_POST["nameCandidates"] : "";
        $choixParcours = isset($_POST["parcours"]) ? $_POST["parcours"] : [];
    }

    // Traitement de la checkbox
    $isActive = isset($_POST["isActive"]) ? 0 : 1;
    $isFound = isset($_POST["isFound"]) ? 1 : 0;

    $hasFormationFilter = !empty($choixFormations) && $choixFormations[0] !== "Aucune Option";
    $hasNomFilter = !empty($choixNom);
    $hasParcoursFilter = !empty($choixParcours);

    // Exécuter les requêtes en fonction des critères de filtrage
    if ($hasFormationFilter && $hasNomFilter && $hasParcoursFilter) {
        // Filtrage par formation, nom, et parcours
        $result = [];
        foreach ($choixFormations as $formation) {
            foreach ($choixParcours as $parcours) {
                $result = array_merge($result, selectCandidatesByNameFormationAndParcours($conn, $parcours, $choixNom, $formation, $isActive, $isFound));
            }
        }
        return $result;
    } elseif ($hasFormationFilter && $hasNomFilter) {
        // Filtrage par formation et nom
        $result = [];
        foreach ($choixFormations as $formation) {
            $result = array_merge($result, selectCandidatesByNameAndFormation($conn, $formation, $choixNom, $isActive, $isFound));
        }
        return $result;
    } elseif ($hasFormationFilter && $hasParcoursFilter) {
        // Filtrage par formation et parcours
        $result = [];
        foreach ($choixFormations as $formation) {
            foreach ($choixParcours as $parcours) {
                $result = array_merge($result, selectCandidateByFormationAndParcours($conn, $formation, $parcours, $isActive, $isFound));
            }
        }
        return $result;
    } elseif ($hasNomFilter && $hasParcoursFilter) {
        // Filtrage par nom et parcours
        $result = [];
        foreach ($choixParcours as $parcours) {
            $result = array_merge($result, selectCandidatesByNameAndParcours($conn, $parcours, $choixNom, $isActive, $isFound));
        }
        return $result;
    } elseif ($hasFormationFilter) {
        // Filtrage par formation uniquement
        $result = [];
        foreach ($choixFormations as $formation) {
            $result = array_merge($result, selectCandidatesByFormation($conn, $formation, $isActive, $isFound));
        }
        return $result;
    } elseif ($hasNomFilter) {
        // Filtrage par nom uniquement
        return selectCandidatesByName($conn, $choixNom, $isActive, $isFound);
    } elseif ($hasParcoursFilter) {
        // Filtrage par parcours uniquement
        $result = [];
        foreach ($choixParcours as $parcours) {
            $result = array_merge($result, selectCandidatesByParcours($conn, $parcours, $isActive, $isFound));
        }
        return $result;
    } else {
        // Aucun critère de filtrage sélectionné, afficher tous les candidats des parcours sélectionnés
        $result = [];
        foreach ($selectedParcours as $parcours) {
            $result = array_merge($result, selectCandidatesByParcours($conn, $parcours, $isActive, $isFound));
        }
        return $result;
    }
}


/**
 * Fonction qui gère le filtrage pour afficher des candidats en fonction de critères précis
 * @param $conn : Connection à la base de donnée
 * @return void Modifie l'affichage en fonction d'un filtrage
 */
function filtrageCommunication()
{
    global $conn;
    if (isset($_POST["submit"])) {
        $choixFormation = $_POST["formation"];
        $choixNom = $_POST["nameCandidates"];
        $parcours = $_POST['parcours'];
    }


    $hasFormationFilter = !empty($choixFormation) && $choixFormation !== "Aucune Option";
    $hasNomFilter = !empty($choixNom);
    $hasParcoursFilter = !empty($parcours);

    // Exécuter les requêtes en fonction des critères de filtrage
    if ($hasFormationFilter && $hasNomFilter && $hasParcoursFilter) {
        // Filtrage par formation, nom et parcours
        return selectCandidatesByNameFormationAndParcoursComm($conn, $parcours, $choixNom, $choixFormation);
    } elseif ($hasFormationFilter && $hasNomFilter) {
        // Filtrage par formation et nom
        return selectCandidatesByNameAndFormationComm($conn, $choixFormation, $choixNom);
    } elseif ($hasFormationFilter && $hasParcoursFilter) {
        // Filtrage par formation et parcours
        return selectCandidateByFormationAndParcoursComm($conn, $choixFormation, $parcours);
    } elseif ($hasNomFilter && $hasParcoursFilter) {
        // Filtrage par nom et parcours
        return selectCandidatesByNameAndParcoursComm($conn, $parcours, $choixNom);
    } elseif ($hasFormationFilter) {
        // Filtrage par formation uniquement
        return selectCandidatesByFormationComm($conn, $choixFormation);
    } elseif ($hasNomFilter) {
        // Filtrage par nom uniquement
        return selectCandidatesByNameComm($conn, $choixNom);
    } elseif ($hasParcoursFilter) {
        // Filtrage par parcours uniquement
        return selectCandidatesByParcoursComm($conn, $parcours);
    } else {
        // Aucun critère de filtrage sélectionné, afficher tous les candidats
        return selectCandidatesActivesComm($conn);
    }
}

