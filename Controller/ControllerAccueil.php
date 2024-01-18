<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

//On passe la valeur a null si elle n'existe pas
if(!isset($_SESSION["login"])){
    $_SESSION['login'] = null;
}
//On passe la valeur a null si elle n'existe pas
if(!isset($_SESSION["password"])){
    $_SESSION['password'] = null;
}
//Cette condition sert à verifier que la personne accedant a la page d'accueil
if ($_SESSION['login'] == null || $_SESSION['password'] == null) {
    //$_SESSION['provenance'] = 'Accueil';
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}
$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';

function ControllerGetRole($login){
    global $conn;
    return getRole($conn,$login);
}

$_SESSION['role'] = ControllerGetRole($_SESSION['login'])
?>

