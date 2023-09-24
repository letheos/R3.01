<?php

include '../Model/ModelConnexion.php';
include '../View/PageReinitialisationMail.php';
$conn = require "../Model/Database.php";



$token = $_GET['token'];

$utilisateur = tokenSearch($conn,$token);
echo $utilisateur['tokenExpiresAt'];

if ($utilisateur == null) {
    echo "Token n'existe pas";
} else if ( strtotime($utilisateur['tokenExpiresAt']) <= time()) {
    echo "Token a expiré";
} else {
    echo "token valide";
}