<?php
session_start();

$objmail = require '../Controller/ControllerMailConfig.php';
$conn = require '../Model/Database.php';

function sendmailinscription($mail,$emailuser){

    $mail->setFrom('bncorp.auto@gmail.com');
    $mail->addAddress($emailuser);
    $mail->isHTML(true);
    $mail->Subject = "bienvenue";

    $mail->Body = "Votre inscription dans le système est bien réalisée .";
    try {

        $mail->send();
    }
    catch(Exception $exception){
        print_r($exception->getMessage());
    }
}
function enregistrer_Creation($conn, $pswd,$confirmation,$lastName,$firstName,$mail,$login,$formation,$role,$objmail)
{

    if (isset($_POST['envoyer'])) {
        $pswd = $_POST['pswd'];
        $confirmation = $_POST['confirmation'];
        $lastName = $_POST['lastName'];
        $firstName = $_POST['firstName'];
        $mail = $_POST['email'];
        $login = $_POST['login'];
        if( $_POST['menu'] == "mph"){
            $formation = 'mph';
        }
        elseif ($_POST['menu'] == "BUT informatique"){
            $formation = 'Computer Science';
        }

        if ($_POST['role'] == "Chefdep"){
            $role = 1;
        }
        elseif ($_POST['role'] == 'Secretaire'){
            $role = 2;
        }
        elseif ($_POST['role'] == 'Chargedev'){
            $role = 3;
        }


        $messageErreur = "";
        $messageSucces = "";
        include '../Model/ModelCreation.php';
        echo" je suis avant les if de vérif";
        if ($pswd != $confirmation) {
            $messageErreur="les deux mots de passe doivent être identiques";


        } elseif (preg_match('/[^A-Za-z0-9"\'\,\;]/', $lastName
        )) {
            $messageErreur = "Le nom contient un caractère spécial";

        } elseif (preg_match("/[0-9]/", $lastName
        )) {
            $messageErreur =
                "Le nom contient un chiffre";

        } elseif (preg_match('/[^A-Za-z0-9"\'\,\;]/', $firstName
        )) {
            $messageErreur =
                "Le prénom contient un caractère spécial";

        } elseif (preg_match("/[0-9]/", $firstName
        )) {
            $messageErreur =
                "Le prénom contient un chiffre";

        } elseif (preg_match('/[;\'"]/', $pswd
        )) {
            $messageErreur =
                "Le mot de passe contient un caractère interdit";

        } elseif (!preg_match('/[^A-Za-z0-9"\'\,\;]/', $pswd
        )) {
            $messageErreur = "Le mot de passe doit au moins comprendre un caractère spécial";

        } elseif (!preg_match("/[0-9]/", $pswd
        )) {
            $messageErreur =
                "Le mot de passe doit au moins comprendre un chiffre";

        } elseif ($pswd
            == null || $confirmation == null || $lastName == null || $mail == null || $mail == null || $login == null || $formation == null) {
            $messageErreur =
                "Tous les champs de texte doivent être remplis";


        }
        elseif(strlen($pswd) > 20 or strlen($pswd) < 8){

            $messageErreur = "le mot de passe doit être compris entre 8 et 20 caractères";
        }
        elseif(existe($conn, $mail,$login) == true){
            $messageErreur = "l'utilisateur existe déja";
            //continuer bdd et ajouter personne a la bdd quand il n'existe pas

        }

        else {

            $messageSucces = "Enregistré avec succès";
            /*ajouter($_POST['pswd'],$_POST['lastName'],$_POST['firstName'],$_POST['email'],$_POST['login'],$_POST['formation']);*/
            echo "je vais essayer d'ajouter";
            ajouter($conn, $pswd,$lastName,$firstName,$mail,$login,$role,$formation);
            echo "je vais essayer d'envoyer le mail avec ".$mail;

            try{
                sendmailinscription($objmail,$mail);
            }
            catch (Exception $e){
                echo $e->getMessage();
            }
            echo "j'ai send le mail la ";
        }

        if ($messageErreur != null){
            return $messageErreur;

        } else {
            return $messageSucces;
        }
    }
}




if (isset($_POST['login'])) {
    echo "je suis arrivé dans le premier if";
    $message = enregistrer_Creation($conn, $_POST['pswd'], $_POST['confirmation'], $_POST['lastName'], $_POST['firstName'], $_POST['email'], $_POST['login'], $_POST['formation'],$_POST['role'],$objmail);
    echo "j'ai fait enregistrer creation";

    $_SESSION['message'] = $message;
    $_SESSION['confirmation'] = $_POST['confirmation'];
    $_SESSION['lastName'] = $_POST['lastName'];
    $_SESSION['firstName']= $_POST['firstName'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['menu'] = $_POST['menu'];
    header('Location: ../View/PageCreation.php');
}

?>


