<?php
/**
 * @author Nathan Strady et Timothée Allix
 * Page gérant l'envoie de mail automatique contenant les CVs des candidats
 */
$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';
$mail = require '../Controller/ControllerMailConfig.php';
require "../Controller/ControllerGestionArchive.php";

/**
 * @param $conn PDO connecxion à la BDD
 * @param $from String Expérditeur
 * @param $to String Destinataire
 * @param $msg String corps du mail
 * @param $infos mixed Les candidats
 * @return void envoie un mail automatique
 */
function sendEmail($conn, $from, $to, $msg, $infos) {
    // Création et envoie du from
    $from->setFrom('bncorp.auto@gmail.com');
    $from->addAddress($to);
    $from->isHTML(true);

    // Add attachments
    $val = array();
    foreach ($infos as $candidat) {
        $val[] = selectCandidatById($conn,$candidat);
    }
    $from->AddAttachment(createImageArchive($val,"cvs.zip"));


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









