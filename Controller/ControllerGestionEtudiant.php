<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';
require '../Model/ModelInsertUpdateDelete.php';



$delete = $_POST['delete'];
$checkboxActif = $_POST['checkboxActif'];
$checkboxNonActif = $_POST['checkboxNonActif'];

error_reporting(E_ALL);
ini_set('display_errors', 1);


if (!empty($delete)) {
    $idCandidateToDelete = $_POST['candidateId'];

    // Récupérer les informations du candidat, y compris le chemin du fichier CV
    $candidateInfo = selectCandidatById($conn, $idCandidateToDelete);

    // Supprimer le candidat de la base de données
    deleteCandidate($conn, $idCandidateToDelete);

    // Supprimer le fichier CV s'il existe
    if (isset($candidateInfo['cv'])) {
        $cvFilePath = $candidateInfo['cv'];

        if (file_exists($cvFilePath)) {
            unlink($cvFilePath); // Supprimer le fichier CV
        }
    }

    header("Location: ../View/PageAffichageEtudiant.php");
}
else
{
    print_r($_POST);
}

if (!empty($checkboxActif)){
    foreach($checkboxActif as $idCandidate){
        setEtatFalse($conn, $idCandidate);
    }
    header("Location: ../View/PageAffichageEtudiant.php");

} else if (!empty($checkboxNonActif)){
    foreach($checkboxNonActif as $idCandidate){
        setEtatTrue($conn, $idCandidate);
    }
    header("Location: ../View/PageAffichageEtudiant.php");
}
