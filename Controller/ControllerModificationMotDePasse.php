<?php

include '../Model/ModelConnexion.php';
$conn = require "../Model/Database.php";
session_start();

$utilisateur = getUserHash($conn,$_SESSION['login'],$_POST['password']);//Récupération de l'utilisateur via le token
$correctPassword = password_verify($_POST['password'],$utilisateur['pswrd']);


if(isset($_POST['backAccueil'])){
    header("Location: ../View/PageAccueil.php");
}
if(isset($_POST['resetPswd'])) {
//Le mot de passe doit avoir plus de 6 caractères
    if (strlen($_POST['password']) < 6) {
        $_SESSION["erreur"] = "Le mot de passe doit contenir au minimum 6 caractères";
        header("Location: ../View/PageModifierMotDePasse.php");
    }

//Le mot de passe doit avoir moins de 20 caractères
    elseif (strlen($_POST['password']) > 21) {
        $_SESSION["erreur"] = "Le mot de passe doit contenir au maximum 20 caractères";
        header("Location: ../View/PageModifierMotDePasse.php");
    }

//Le mot de passe ne correspond pas à la confirmation du mot de passe
    elseif ($_POST["password"] !== $_POST["passwordConfirm"]) {
        $_SESSION["erreur"] = "Les mot de passe doivent correspondre";
        header("Location: ../View/PageModifierMotDePasse.php");
    }

//Le mot de passe doit avoir une lettre minuscule et majuscule
    elseif (!preg_match("/[a-z]/i", $_POST["password"]) || !preg_match("/[A-Z]/i", $_POST["password"])) {
        $_SESSION["erreur"] = "Il doit y avoir au moins 1 lettre minuscule et 1 lettre majuscule";
        header("Location: ../View/PageModifierMotDePasse.php");
    }


//Le mot de passe doit avoir un chiffre
    elseif (!preg_match("/[0-9]/i", $_POST["password"])) {
        $_SESSION["erreur"] = "Il doit y avoir au moins 1 chiffre";
        header("Location: ../View/PageModifierMotDePasse.php");
    }

//Le mot de passe doit avoir un caractère spéciale
    elseif (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $_POST["password"])) {
        $_SESSION["erreur"] = "Il doit y avoir au moins 1 caractère spécial";
        header("Location: ../View/PageModifierMotDePasse.php");
    }

//Le mot de passe a déjà était utilisé
    elseif ($_POST["password"] == $utilisateur["pswrd"]) {
        $_SESSION["erreur"] = "Mot de passe déjà utilisé ";
        header("Location: ../View/PageModifierMotDePasse.php");
    }

//Hashage du mot de passe et changement du mot de passe de l'utilisateur
    else {
        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        updatePassword($conn, $utilisateur["login"], $password_hash);
    }

//Alertbox de redirection sur la page de connection
    echo '<script> 
        alert("Retour accueil")
        document.location.href="../View/PageAccueil.php"
        </script>
        ';
}