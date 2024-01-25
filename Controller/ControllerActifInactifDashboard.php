<?php
/**
 * Fichier qui s'occupe de l'affichage des infos candidats
 * @author Nathan Strady, Theo Parent
 */

$conn = require '../Model/Database.php';
require '../Model/ModelInsertUpdateDelete.php';

$id = $_POST['idCandidate'];
$idDashboard = $_POST['idDashboard'];


if(isset($_POST['activate'])){
    setEtatTrue($conn, $id);
    header("Location: ../View/PageAffichageCandidatDashboardPrecis.php?idCandidate=$id&idDashboard=$idDashboard");
}

if (isset($_POST['desactivate'])){
    setEtatFalse($conn, $id);
    header("Location: ../View/PageAffichageCandidatDashboardPrecis.php?idCandidate=$id&idDashboard=$idDashboard");
}

if(isset($_POST['alternance'])){
    setAppTrue($conn, $id);
    header("Location: ../View/PageAffichageCandidatDashboardPrecis.php?idCandidate=$id&idDashboard=$idDashboard");
}

if (isset($_POST['noalternance'])){
    setAppFalse($conn, $id);
    header("Location: ../View/PageAffichageCandidatDashboardPrecis.php?idCandidate=$id&idDashboard=$idDashboard");
}

