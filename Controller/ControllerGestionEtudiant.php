<?php
$conn = require '../Model/Database.php';
require '../Model/ModelSelectAffichage.php';

if (isset($_POST['delete'])) {
    $idCandidateToDelete = $_POST['candidateId'];
    deleteCandidate($conn, $idCandidateToDelete);
    header("Location: ../View/PageAffichageEtudiant.php");
}