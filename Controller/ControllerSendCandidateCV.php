<?php
$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';
$mail = require '../Controller/ControllerMailConfig.php';




error_reporting(E_ALL);
ini_set('display_errors', 1);

function sendEmail($conn, $from, $to, $msg, $infos) {
    // Création et envoie du from
    $from->setFrom('bncorp.auto@gmail.com');
    $from->addAddress($to);
    $from->isHTML(true);

    // Add attachments
    foreach ($infos as $info) {
        $candidate = selectCvById($conn, $info);
        foreach ($candidate as $cv) {
            $from->AddAttachment($cv['cv']);
        }
    }

    $from->Subject = "Envoie de CV étudiant";
    $from->Body = $msg;

    try {
        $from->send();
        echo "Email envoyée";
    } catch (Exception $exception) {
        echo "Error: " . $exception->getMessage();
    }
}

function dlArchive($infos)
{
    global $conn;
    $val = array();
    foreach ($infos as $candidat) {
        $val[] = selectCandidatById($conn,$candidat);
    }
    $archivePath = createImageArchive($val,"please.zip");
    if (file_exists($archivePath)) {
        ob_end_clean();
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="marcheparpitier.zip"');
        header('Content-Length: ' . filesize($archivePath));

        readfile($archivePath);

        unlink($archivePath);
    } else {
        die("Impossible de trouver l'archive.");
    }
}

function createImageArchive($userandcv, $outputArchiveName) {

    global $conn;
    // Créer un objet ZipArchive
    $zip = new ZipArchive();
    if ($zip->open($outputArchiveName, ZipArchive::CREATE) !== TRUE) {
        die ("Impossible de créer l'archive");
    }

    // Parcourir les résultats et ajouter chaque image à l'archive
    foreach ($userandcv as $val){
        if($val['cv']!= null and $val['cv']!="") {
            $imageId = $val['name'] . $val['firstName']."." . pathinfo($val['cv'], PATHINFO_EXTENSION);
            $imagePath = $val['cv'];
            echo $imageId . ":" . $imagePath;
            $zip->addFile($imagePath,$imageId);
        }
    }

    $zip->close();
    return $outputArchiveName;
}

$to = $_POST['to'];

$success = 1;

if(!empty($_POST['candidateCheckbox'])) {
    /*if (!empty($to)){
        $msg = "Mail envoyée avec succés";
        sendEmail($conn, $mail, $to, $_POST['message'], $_POST['candidateCheckbox']);
    } else {
        $msg = "Il manque le destinataire";
        $success = 0;
    }
    */
    dlArchive($_POST['candidateCheckbox']);
} else {
    $msg = "Vous n'avez pas selectionné de CV";
    $success = 0;
}


session_start();

$_SESSION['success'] = $success;
$_SESSION['message'] = $msg;
//header("Location: ../View/PageSendCandidateCV.php");









