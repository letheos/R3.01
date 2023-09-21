<?php
//f
include '../Model/ModelConnexion.php';
include '../View/PageConnexion.php';
$sgbd = ConnexionSGBD::creerInstance();
$conn= $sgbd->connect();
connectionHash($conn);

?>