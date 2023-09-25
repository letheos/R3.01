<?php

include '../Model/ModelConnexion.php';
$conn = require "../Model/Database.php";


$token = $_POST['token']; //Récupération du Token dans l'url
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
    die("Le mot de passe doit contenir au minimum 6 caractères");
}

//Le mot de passe doit avoir moins de 20 caractères
if (strlen($_POST['password'])>21){
    die("Le mot de passe doit contenir au maximum 20 caractères");
}

//Le mot de passe ne correspond pas à la confirmation du mot de passe
if ($_POST["password"] !== $_POST["passwordConfirm"]){
    die("Les mot de passe doivent correspondre");
}

//Le mot de passe doit avoir une lettre minuscule
if (!preg_match("/[a-z]/i", $_POST["password"])){
    die("Il doit y avoir au moins 1 lettre");
}

//Le mot de passe doit avoir une lettre majuscule
if (!preg_match("/[A-Z]/i", $_POST["password"])){
    die("Il doit y avoir au moins 1 lettre");
}

//Le mot de passe doit avoir un chiffre
if (!preg_match("/[0-9]/i",$_POST["password"])){
    die("Il doit y avoir au moins 1 chiffre");
}

//Le mot de passe doit avoir un caractère spéciale
if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/',$_POST["password"])){
    die("Il doit y avoir au moins 1 caractère spécial");
}

//Le mot de passe a déjà était utilisé
if ($_POST["password"] == $utilisateur["pswrd"]){
    die("Mot de passe déjà utilisé ");
}

//Hashage du mot de passe et changement du mot de passe de l'utilisateur
$password_hash = password_hash($_POST["password"],PASSWORD_DEFAULT);
updatePassword($conn,$utilisateur["login"],$password_hash);

//Alertbox de redirection sur la page de connection
echo '<script> 
        alert("Retour page de connection")
        document.location.href="../View/PageConnexion.php"
        </script>
        ';

