<?php

include '../Model/ModelConnexion.php';
include '../View/PageReinitialisation.php';


$sgbd = ConnexionSGBD::creerInstance();
$conn= $sgbd->connect();
reinitialisationPassword($conn);



