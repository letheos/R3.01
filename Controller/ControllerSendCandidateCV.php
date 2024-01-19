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


$to = $_POST['to'];

$success = 1;

if(!empty($_POST['candidateCheckbox'])) {
    if (!empty($to)){
        $msg = "Mail envoyée avec succés";
        sendEmail($conn, $mail, $to, $_POST['message'], $_POST['candidateCheckbox']);
    } else {
        $msg = "Il manque le destinataire";
        $success = 0;
    }

} else {
    $msg = "Vous n'avez pas selectionné de CV";
    $success = 0;
}


session_start();

$_SESSION['success'] = $success;
$_SESSION['message'] = $msg;
header("Location: ../View/PageSendCandidateCV.php");









