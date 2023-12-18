<?php
$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';
$mail = require '../Controller/ControllerMailConfig.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

function sendEmail($from, $to, $msg){
    //Création et envoie du from
    $from->setFrom('bncorp.auto@gmail.com');
    $from->addAddress($to);
    $from->isHTML(true);
    $from->Subject = "Envoie de CV etudiant.";
    $from->Body = $msg;
        try {
            $from->send();
        }
        catch (Exception $exception){
            print_r($exception->getMessage());
        }
}

$success = 1;
if (!empty($_POST['to'])){
    $msg = "Mail envoyée avec succés";
    sendEmail($mail, $_POST['to'], $_POST['message']);
} else {
    $msg = "Manque le destinataire";
    $success = 0;
}

session_start();
$_SESSION['success'] = $success;
$_SESSION['message'] = $msg;
header('Location: ../View/PageSendCandidateCV.php');






