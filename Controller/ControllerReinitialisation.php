<?php



include "../Model/ModelConnexion.php";
$conn = require "../Model/Database.php";
$mail = require '../Controller/ControllerMailConfig.php';

function sendReinitialisationPasswordMail($mail,$email,$token)
{
    $url =  "http://localhost:63342/R3.01/View/PageReinitialisationMail?token=$token";
    $mail->setFrom('bncorp.auto@gmail.com');
    $mail->addAddress($email['email']);
    $mail->isHTML(true);

    $mail->Subject = 'Reinitialisation mot de passe';
    $mail->Body = "Pour reinitialiser votre mot de passe : $url";




    echo "
           <script>
           alert('Allez voir dans votre boîte mail')
           document.location.href = 'ControllerReinitialisation.php';
           </script>
           ";
    try {
        $mail->send();
    }
    catch (Exception $exception){
        print_r($exception->getMessage());
    }
}

if (isset($_POST['login'])){
    $login = $_POST['login'];
    if (isLoginExist($conn,$login)){
        $email = searchEmail($conn,$login);
        $tokenHash = tokenInit($conn,$login);
        sendReinitialisationPasswordMail($mail,$email,$tokenHash);
    } else {
        echo "Login inexistant";
    }
} else {
    echo "Vous n'avez pas rentré votre login.";
}




