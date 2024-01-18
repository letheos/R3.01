<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//import des requêtes et des connections
include "../Model/ModelInsertUpdateDelete.php";
include "../Model/ModelSelect.php";
include "../View/PageReinitialisation.php";
$conn = require "../Model/Database.php";
$mail = require '../Controller/ControllerMailConfig.php';



//Fonction d'envoie de mail
function sendReinitialisationPasswordMail($conn,$login,$mail,$email)
{
    //Génère le token unique de la page de redirection
    $token = tokenInit($conn,$login);

    //Création et envoie du mail
    $mail->setFrom('bncorp.auto@gmail.com');
    $mail->addAddress($email['email']);
    $mail->isHTML(true);
    $mail->Subject = 'Reinitialisation mot de passe, utilisateur : '.$login;
    $mail->Body = "Pour reinitialiser votre mot de passe : <a href='http://localhost/R3.01/View/PageReinitialisationPassword.php?token=$token'> Cliquez ici </a>";
    try {
        $mail->send();
    }
    catch (Exception $exception){
        print_r($exception->getMessage());
    }
}

//Gestion de l'envoie de mail
if (isset($_POST['login'])){ //Test de présence du login dans le champ
    $login = $_POST['login'];
    if (isLoginExist($conn,$login)){ //Test d'existence du login dans notre base de donnée
        $email = searchEmail($conn,$login);
        sendReinitialisationPasswordMail($conn,$_POST['login'],$mail,$email);
        $_SESSION["success"] = "Envoie du mail";
        header("Location: ../View/PageReinitialisation.php");
    } else {
        $_SESSION["erreur"] = "Login inexistant";
        header("Location: ../View/PageReinitialisation.php");
    }
} else {
    $_SESSION["erreur"] = "Veuillez remplir le champ";
    header("Location: ../View/PageReinitialisation.php");
}




