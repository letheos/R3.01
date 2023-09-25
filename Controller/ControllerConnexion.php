<?php

include '../Model/ModelConnexion.php';
include '../View/PageConnexion.php';
$conn = require "../Model/Database.php";

$ip = $_SERVER['REMOTE_ADDR'];
$nbTentative = nbTentative($conn,$ip);
$nbTentativeDDOS = securityDDOS($conn, $ip);

//Cas où les forms sont vides
if ($_POST['login'] == null || $_POST['password'] == null ) {
    die("Login ou Mot de passe non renseignée");
}


//Cas de tentative de connection trop brutale
if ($nbTentativeDDOS['nbTentative'] >= 20){
    die("Tentative DDOS, trop de connection");
}

//Bloquer la connection s'il y a déjà eu trois tentatives de connection
if ($nbTentative['nbTentative'] >= 3){
    addExpiration($conn,$ip);
    deleteTentativeIp($conn,$ip);
    die("Nombre de tentative expirée");
}

//Vérification de la présence de l'expiration
if (!isExpire($conn,$ip)){
    die ("Trop de tentative, veuillez attendre 20 minutes");
}

//Vérification de la présence de l'expiration
if (isExpire($conn,$ip)){
    delExpiration($conn,$ip);
}

//Cas où le login est erronée
if (!isLoginExist($conn, $_POST['login'])) {
    addTentativeIp($conn,$ip,0);
    die("Mauvais login");
}

//Cas où le mot de passe est erronée
if (!searchUserHash($conn, $_POST['login'], $_POST['password'])){
    addTentativeIp($conn,$ip,0);
    sleep(3);
    die("Mauvais mot de passe");
}

//Connection à la session
session_start();
addTentativeIp($conn,$ip,1);
$_SESSION["login"] = $_POST['login'];
$_SESSION["password"] = $_POST['password'];
header("location: ../View/PageAccueil.php");



?>