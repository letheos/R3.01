<?php
/**
 * @author Nathan Strady et Timothée Allix
 * Page gérant la gestion des états des candidats d'un tableau de bord
 */
$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';
require '../Model/ModelInsertUpdateDelete.php';
require "../Controller/ControllerGestionArchive.php";
$idDashboard = $_GET['idDashboard'];

// Si le bouton "télécharger les cvs" est soumis
if (isset($_POST['cvs'])) {
    // Si le bouton "Télécharger les CVs" est soumis
    $checkboxWithCV = $_POST['checkboxWithCV'];
    if (!empty($checkboxWithCV)) {
        dlArchive($checkboxWithCV);
        header("Location: ../View/dashboard.php?id=" . $idDashboard);
    } else {
        echo '<script> alert("Veuillez sélectionner un candidat") 
           document.location.href = "../View/PageAffichageEtudiant.php"; 
          </script> ';
    }
// Si le bouton "Changer l'état des candidats" est soumis
} elseif (isset($_POST['submit'])) {
    $checkboxActif = $_POST['checkboxActif'];
    $checkboxNonActif = $_POST['checkboxNonActif'];
    $checkboxWithAlternance = $_POST['checkboxWithAlternance'];
    $checkboxNoAlternance = $_POST['checkboxNoAlternance'];
    if (!empty($checkboxActif)) {
        foreach ($checkboxActif as $idCandidate) {
            setEtatFalse($conn, $idCandidate);
        }
        header("Location: ../View/dashboard.php?id=" . $idDashboard);

    } elseif (!empty($checkboxNonActif)) {
        foreach ($checkboxNonActif as $idCandidate) {
            setEtatTrue($conn, $idCandidate);
        }
        header("Location: ../View/dashboard.php?id=" . $idDashboard);

    } elseif (!empty($checkboxWithAlternance)) {
        foreach ($checkboxWithAlternance as $idCandidate) {
            setAppFalse($conn, $idCandidate);
        }
        header("Location: ../View/dashboard.php?id=" . $idDashboard);

    } elseif (!empty($checkboxNoAlternance)) {
        foreach ($checkboxNoAlternance as $idCandidate) {
            setAppTrue($conn, $idCandidate);
        }
        header("Location: ../View/dashboard.php?id=" . $idDashboard);

    } else {
        echo '<script> alert("Veuillez sélectionner un candidat") 
           document.location.href = "../View/dashboard.php"; 
          </script> ';
    }
}
