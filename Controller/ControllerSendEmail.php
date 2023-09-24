<?php


//import des requêtes et des connections
include "../Model/ModelConnexion.php";
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




    //Affichage d'une alert box d'envoie du mail
    echo "
           <script>
           alert('Allez voir dans votre boîte mail')
           document.location.href = 'ControllerSendEmail.php';
           </script>
           ";
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
    } else {
        echo "Login inexistant";
    }
} else {
    echo "Vous n'avez pas rentré votre login.";
}




