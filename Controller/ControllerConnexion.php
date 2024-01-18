<?php
include 'ClassUtilisateur.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include '../Model/ModelInsertUpdateDelete.php';
include '../Model/ModelSelect.php';
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
    exit();
}

//Bloquer la connection s'il y a déjà eu trois tentatives de connection
if ($nbTentative['nbTentative'] >= 3){
    addExpiration($conn,$ip);
    deleteTentativeIp($conn,$ip);
    $_SESSION['erreur'] ='Nombre de tentative expirée';
    header('Location: ../View/PageConnexion.php');
    exit();
}

//Vérification de la présence de l'expiration
if (!isExpire($conn,$ip)){
    $_SESSION['erreur'] ='Trop de tentative, veuillez attendre 20 minutes';
    header('Location: ../View/PageConnexion.php');
    exit ();
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
    exit();
}

//Cas où le mot de passe est erronée
if (!searchUserHash($conn, $_POST['login'], $_POST['password'])){
    addTentativeIp($conn,$ip,0);
    sleep(3);
    $_SESSION['erreur'] ='Mauvais mot de passe';
    header('Location: ../View/PageConnexion.php');
    exit();
}
/*
if (isset($_SESSION['provenance']) && $_SESSION['provenance'] == 'Accueil') {
    echo '<script>
        alert("Veuillez vous connecter");
        </script>';
}*/

//Connection à la session
session_start();
addTentativeIp($conn,$ip,1);
deleteTentativeIp($conn,$ip);

$user = getUserWithId($_POST['login'],$conn);

$userFormation = getFormationOfUser($conn,$_POST['login']);
$role = getRole($conn,$_POST['login']);

$userObject = new Utilisateur($_POST['login'],$_POST['password'],$user[0]['firstName'],$user[0]['userName'],$user[0]['idRole'],$user[0]['email'],$userFormation);
$_SESSION['user'] = serialize($userObject);

var_dump(isset($_SESSION['user']));
header("location: ../View/PageAccueil.php");




?>