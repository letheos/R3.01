<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../Model/ModelInsertUpdateDelete.php';
include '../Model/ModelSelect.php';
$conn = require "../Model/Database.php";
session_start();

if (isset($_SESSION['token'])){
    $token = $_SESSION['token'];
} else {
    $token = $_POST['token']; //Récupération du Token dans l'url
}
$utilisateur = tokenSearch($conn,$token); //Récupération de l'utilisateur via le token
$expire = strtotime($utilisateur['tokenExpiresAt']);

//Vérification de l'expiration de la page via l'expiration du token
if ($expire <= time()) {
    echo '<script>
        alert("Expiration de la page !")
        document.location.href="ControllerConnexion.php";
    </script>
    ';
}


//Le mot de passe doit avoir plus de 6 caractères
if (strlen($_POST['password']) < 6){
    $_SESSION["erreur"] = "Le mot de passe doit contenir au minimum 6 caractères";
    $_SESSION['token'] = $token;
    header ("Location: ../View/PageReinitialisationPassword.php");
    exit();
}

//Le mot de passe doit avoir moins de 20 caractères
if (strlen($_POST['password'])>21){
    $_SESSION["erreur"] = "Le mot de passe doit contenir au maximum 20 caractères";
    $_SESSION['token'] = $token;
    header ("Location: ../View/PageReinitialisationPassword.php");
    exit();
}

//Le mot de passe ne correspond pas à la confirmation du mot de passe
if ($_POST["password"] !== $_POST["passwordConfirm"]){
    $_SESSION["erreur"] = "Les mot de passe doivent correspondre";
    $_SESSION['token'] = $token;
    header ("Location: ../View/PageReinitialisationPassword.php");
    exit();
}

//Le mot de passe doit avoir une lettre minuscule et majuscule
if (!preg_match("/[a-z]/i", $_POST["password"]) || !preg_match("/[A-Z]/i", $_POST["password"])){
    $_SESSION["erreur"] = "Il doit y avoir au moins 1 lettre minuscule et 1 lettre majuscule";
    $_SESSION['token'] = $token;
    header ("Location: ../View/PageReinitialisationPassword.php");
    exit();
}


//Le mot de passe doit avoir un chiffre
if (!preg_match("/[0-9]/i",$_POST["password"])){
    $_SESSION["erreur"] = "Il doit y avoir au moins 1 chiffre";
    $_SESSION['token'] = $token;
    header ("Location: ../View/PageReinitialisationPassword.php");
    exit();
}

//Le mot de passe doit avoir un caractère spéciale
if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/',$_POST["password"])){
    $_SESSION["erreur"] = "Il doit y avoir au moins 1 caractère spécial";
    $_SESSION['token'] = $token;
    header ("Location: ../View/PageReinitialisationPassword.php");
    exit();
}

//Le mot de passe a déjà était utilisé
if ($_POST["password"] == $utilisateur["pswrd"]){
    $_SESSION["erreur"] = "Mot de passe déjà utilisé ";
    $_SESSION['token'] = $token;
    header ("Location: ../View/PageReinitialisationPassword.php");
    exit();
}

//Hashage du mot de passe et changement du mot de passe de l'utilisateur
$password_hash = password_hash($_POST["password"],PASSWORD_DEFAULT);
updatePassword($conn,$utilisateur["login"],$password_hash);
session_destroy();

//Alertbox de redirection sur la page de connection
echo '<script> 
        alert("Retour page de connection")
        document.location.href="../View/PageConnexion.php"
        </script>
        ';