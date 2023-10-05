<?php

include '../Model/ModelConnexion.php';
include '../View/PageConnexion.php';
$conn = require "../Model/Database.php";

$ip = $_SERVER['REMOTE_ADDR'];
$nbTentative = nbTentative($conn,$ip);
$nbTentativeDDOS = securityDDOS($conn, $ip);



//Cas où les forms sont vides
if ($_POST['login'] == null || $_POST['password'] == null ) {
    $_SESSION['erreur'] = 'Login ou Mot de passe non renseignée';
    header('Location: ../View/PageConnexion.php');
    exit();
}


//Cas de tentative de connection trop brutale
if ($nbTentativeDDOS['nbTentative'] >= 20){
    $_SESSION['erreur'] = 'Tentative DDOS, trop de connection';
    header('Location: ../View/PageConnexion.php');
    die();
}

//Bloquer la connection s'il y a déjà eu trois tentatives de connection
if ($nbTentative['nbTentative'] >= 3){
    addExpiration($conn,$ip);
    deleteTentativeIp($conn,$ip);
    $_SESSION['erreur'] ='Nombre de tentative expirée';
    header('Location: ../View/PageConnexion.php');
    die();
}

//Vérification de la présence de l'expiration
if (!isExpire($conn,$ip)){
    $_SESSION['erreur'] ='Trop de tentative, veuillez attendre 20 minutes';
    header('Location: ../View/PageConnexion.php');
    die ();
}

//Vérification de la présence de l'expiration
if (isExpire($conn,$ip)){
    delExpiration($conn,$ip);
}

//Cas où le login est erronée
if (!isLoginExist($conn, $_POST['login'])) {
    addTentativeIp($conn,$ip,0);
    $_SESSION['erreur'] ='Mauvais login';
    header('Location: ../View/PageConnexion.php');
    die();
}

//Cas où le mot de passe est erronée
if (!searchUserHash($conn, $_POST['login'], $_POST['password'])){
    addTentativeIp($conn,$ip,0);
    sleep(3);
    $_SESSION['erreur'] ='Mauvais mot de passe';
    header('Location: ../View/PageConnexion.php');
    die();
}

//Connection à la session
session_start();
addTentativeIp($conn,$ip,1);
deleteTentativeIp($conn,$ip);
$_SESSION["login"] = $_POST['login'];
$_SESSION["password"] = $_POST['password'];
header("location: ../View/PageAccueil.php");




?>