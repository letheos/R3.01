<?php

include '../Model/ModelConnexion.php';
include '../View/PageReinitialisation.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require '../PHPmailer/src/Exception.php';
require '../PHPmailer/src/PHPMailer.php';
require '../PHPmailer/src/SMTP.php';

/**
 * @throws Exception
 */
function reinitialisationPassword($conn)
{
    if (isset($_POST['login'])){
        if (isLoginExist($conn,$_POST['login'])){
            $email = searchEmail($conn,$_POST['login']);
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Username = 'bncorp.auto@gmail.com';
            $mail->Password = 'mucdemavdtypfesk';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('bncorp.auto@gmail.com');
            $mail->addAddress($email['email']);
            $mail->isHTML(true);

            $mail->Subject = 'TestSubject';
            $mail->Body = 'Bite';
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


        } else {
            print_r("Votre email n'existe pas");
        }
    }
}

$sgbd = ConnexionSGBD::creerInstance();
$conn= $sgbd->connect();
reinitialisationPassword($conn);



