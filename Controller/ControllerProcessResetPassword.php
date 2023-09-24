<?php

include '../Model/ModelConnexion.php';
$conn = require "../Model/Database.php";


$token = $_POST['token'];
$utilisateur = tokenSearch($conn,$token);
$expire = strtotime($utilisateur['tokenExpiresAt']);

if ($expire <= time()) {
    echo '<script>
        alert("Expiration de la page !")
        document.location.href="ControllerConnexion.php";
    </script>
    ';
}

if (strlen($_POST['password']) < 6){
    die("Le mot de passe doit contenir au minimum 6 caractères");
}

if (strlen($_POST['password'])>21){
    die("Le mot de passe doit contenir au maximum 20 caractères");
}

if ($_POST["password"] !== $_POST["passwordConfirm"]){
    die("Les mot de passe doivent correspondre");
}

if (!preg_match("/[a-z]/i", $_POST["password"])){
    die("Il doit y avoir au moins 1 lettre");
}

if (!preg_match("/[A-Z]/i", $_POST["password"])){
    die("Il doit y avoir au moins 1 lettre");
}

if (!preg_match("/[0-9]/i",$_POST["password"])){
    die("Il doit y avoir au moins 1 chiffre");
}

if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/',$_POST["password"])){
    die("Il doit y avoir au moins 1 caractère spécial");
}

if ($_POST["password"] == $utilisateur["pswrd"]){
    die("Mot de passe déjà utilisé ");
}

//Hashage du mot de passe qui ne fonctionne pas on ne sait pas pourquoi
$password_hash = password_hash($_POST["password"],PASSWORD_DEFAULT);
updatePassword($conn,$utilisateur["login"],$password_hash);

echo '<script> 
        alert("Retour page de connection")
        document.location.href="../View/PageConnexion.php"
        </script>
        ';

