<?php
//Fichier de config du mail automatique
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require '../PHPmailer/src/Exception.php';
require '../PHPmailer/src/PHPMailer.php';
require '../PHPmailer/src/SMTP.php';


//Informations du mail automatique
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Username = 'bncorp.auto@gmail.com';
$mail->Password = 'mucdemavdtypfesk';
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

return $mail;
