<?php
$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';
require '../Model/ModelInsertUpdateDelete.php';



$delete = $_POST['delete'];
$checkboxActif = $_POST['checkboxActif'];
$checkboxNonActif = $_POST['checkboxNonActif'];



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
} else {
    echo '<script> alert("Veuillez selectionner un candidat") 
           document.location.href = "../View/PageAffichageEtudiant.php"; 
          </script> ';
}
