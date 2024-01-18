<?php

$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';
require '../Model/ModelInsertUpdateDelete.php';

$checkboxActif = $_POST['checkboxActif'];
$checkboxNonActif = $_POST['checkboxNonActif'];
$checkboxWithAlternance = $_POST['checkboxWithAlternance'];
$checkboxNoAlternance = $_POST['checkboxNoAlternance'];
$idDashboard = $_GET['idDashboard'];



if (!empty($checkboxActif)) {
    foreach ($checkboxActif as $idCandidate) {
        setEtatFalse($conn, $idCandidate);
    }
    header("Location: ../View/dashboard.php?id=".$idDashboard);

} elseif (!empty($checkboxNonActif)) {
    foreach ($checkboxNonActif as $idCandidate) {
        setEtatTrue($conn, $idCandidate);
    }
    header("Location: ../View/dashboard.php?id=".$idDashboard);

} elseif (!empty($checkboxWithAlternance)) {
    foreach ($checkboxWithAlternance as $idCandidate) {
        setAppFalse($conn, $idCandidate);
    }
    header("Location: ../View/dashboard.php?id=".$idDashboard);

} elseif (!empty($checkboxNoAlternance)) {
    foreach ($checkboxNoAlternance as $idCandidate) {
        setAppTrue($conn, $idCandidate);
    }
    header("Location: ../View/dashboard.php?id=".$idDashboard);

} else {
    echo '<script> alert("Veuillez sélectionner un candidat") 
           document.location.href = "../View/dashboard.php"; 
          </script> ';
}
