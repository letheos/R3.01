<?php
$conn = require '../Model/Database.php';
require '../Model/ModelSelectAffichage.php';

$delete = $_POST['delete'];
$checkboxActif = $_POST['checkboxActif'];
$checkboxNonActif = $_POST['checkboxNonActif'];


if (isset($delete)) {
    $idCandidateToDelete = $_POST['candidateId'];
    deleteCandidate($conn, $idCandidateToDelete);
    header("Location: ../View/PageAffichageEtudiant.php");
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
