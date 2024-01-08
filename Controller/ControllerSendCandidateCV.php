<?php
$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';
$mail = require '../Controller/ControllerMailConfig.php';




error_reporting(E_ALL);
ini_set('display_errors', 1);

function sendEmail($conn, $from, $to, $msg, $infos_decode) {
    // Création et envoie du from
    $from->setFrom('bncorp.auto@gmail.com');
    $from->addAddress($to);
    $from->isHTML(true);

    // Add attachments
    foreach ($infos_decode as $info) {
        $candidate = selectCandidatesByParcoursWithYear($conn, $info['parcours'], $info['year'], 1);
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

function translateArray($infos){

    $infos_decode = [];
    for ($i = 0 ; $i<count($infos) ; $i++){
        $infos_decode[$i] = json_decode($infos[$i], true);
    }
    return $infos_decode;
}

$to = $_POST['to'];

$success = 1;

if(!empty($_POST['infos'])) {
    $infos_decode = translateArray($_POST['infos']);
    if (!empty($to)){
        $msg = "Mail envoyée avec succés";
        sendEmail($conn, $mail, $to, $_POST['message'], $infos_decode);
    } else {
        $msg = "Il manque le destinataire";
        $success = 0;
    }

}


session_start();

$_SESSION['success'] = $success;
$_SESSION['message'] = $msg;
header("Location: ../View/PageSendCandidateCV.php");








