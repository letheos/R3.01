<?php

include '../Model/ModelConnexion.php';
include '../View/PageConnexion.php';
$conn = require "../Model/Database.php";

if ($_POST['login'] == null || $_POST['password'] == null ) {
    die("Login ou Mot de passe non renseignée");
}

if (!isLoginExist($conn, $_POST['login'])) {
    die("Mauvais login");
}

if (!searchUser($conn, $_POST['login'], $_POST['password'])){
    addTentative($conn,$_POST['login'],$_SERVER["REMOTE_ADDR"],0);
    die("Mauvais mot de passe");
}

session_start();
addTentative($conn,$_POST['login'],$_SERVER["REMOTE_ADDR"],1);
$_SESSION["login"] = $_POST['login'];
$_SESSION["password"] = $_POST['password'];
header("location: ../View/PageAccueil.php");



?>