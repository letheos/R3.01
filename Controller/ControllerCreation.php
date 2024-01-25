<?php
/**
 * @author Théo Parent
 */
session_start();
$conn = require '../Model/Database.php';
$objmail = require '../Controller/ControllerMailConfig.php';
include '../Model/ModelSelect.php';
include '../Controller/ClassUtilisateur.php';


//We check if any user is connected to his account , if not we redirect the user to the conection page
if(!isset($_SESSION['user'])){
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}


/**
 * @param $mail
 * the source mail
 * @param $emailuser
 * the destinatory mail
 * @return void
 * This function goal is to send an email when the admin creates his account
 */
function sendmailinscription($mail,$emailuser){
    $mail->setFrom('bncorp.auto@gmail.com');
    // we set the source mail
    $mail->addAddress($emailuser);
    //we add to the object mail the user e-mail;
    $mail->isHTML(true);
    //we set the title of the mail
    $mail->Subject = "bienvenue";
    // we set the content of the mail
    $mail->Body = "Votre inscription dans le système est bien réalisée .";
    try {

        $mail->send();
    }
    catch(Exception $exception){
        print_r($exception->getMessage());
    }
}


/**
 * @param $conn
 * the connection to the database
 * @param $pswd
 * the variable corresponding to the user's password
 * @param $confirmation
 * the variable corresponding to the user's confirmation password
 * @param $lastName
 * the variable corresponding to the user's lastname
 * @param $firstName
 * the variable corresponding to the user's firstname
 * @param $mail
 * the variable corresponding to the user's email
 * @param $login
 * the variable corresponding to the user's login
 * @param $formation
 * the variable corresponding to the user's formation(only used if he could selected one)
 * @param $formations
 * the variable corresponding to the user's formation(only used if he could select many)
 * @param $role
 * the variable corresponding to the user's (role)
 * @param $objmail
 * the variable corresponding to the mail subject
 * @return string
 */
function registerCreation($conn,$pswd,$confirmation,$lastName,$firstName,$mail,$login,$formation,$formations,$role,$objmail)
{
    //we modify the value of the role according to the selected one in the page
    if (empty($role)){
        $idRole = null;
    }else{
        $idRole = $role;
    }


    $Errormsg = "";
    $sucessMessage = "";


    //we check that the password and the confirmation are identicals
    if ($pswd != $confirmation) {
        $Errormsg="les deux mots de passe doivent être identiques";

        //we check if lastname contains a special symbol or a number
    } elseif (preg_match('/[^A-Za-z0-9"\'\,\;]/', $lastName
    )) {
        $Errormsg = "Le nom contient un caractère spécial";

    } elseif (preg_match("/[0-9]/", $lastName
    )) {
        $Errormsg =
            "Le nom contient un chiffre";

        //we check if firstname contains a special symbol or a number
    } elseif (preg_match('/[^A-Za-z0-9"\'\,\;]/', $firstName
    )) {
        $Errormsg =
            "Le prénom contient un caractère spécial";


    } elseif (preg_match("/[0-9]/", $firstName
    )) {
        $Errormsg = "Le prénom contient un chiffre";

        //we check that the password doesn't contains a forbidden symbol
    } elseif (preg_match('/[;\'"]/', $pswd
    )) {
        $Errormsg =
            "Le mot de passe contient un caractère interdit";

        //on regarde si le mot de passe contient bien un caractère spécial
    } elseif (!preg_match('/[^A-Za-z0-9"\'\,\;]/', $pswd
    )) {
        $Errormsg = "Le mot de passe doit au moins comprendre un caractère spécial";

        //we check that the password contains a special caracter
    } elseif (!preg_match("/[0-9]/", $pswd
    )) {
        $Errormsg =
            "Le mot de passe doit au moins comprendre un chiffre";

        // we check that all inputs are used
    } elseif ($pswd
        == null || $confirmation == null || $lastName == null || $mail == null || $mail == null || $login == null || $formation == null) {
        $Errormsg =
            "Tous les champs de texte doivent être remplis";

    }

    // we check that the password length is between 6 and 20 caracters
    elseif(strlen($pswd) > 20 or strlen($pswd) < 6){

        $Errormsg = "le mot de passe doit être compris entre 8 et 20 caractères";
    }

    //we check if the person is not already registered
    elseif(exist($conn,$mail,$login) == true){
        $Errormsg = "L'utilisateur existe déjà";


    }
    else {
        //we passed all the checks , we can send a success message
        $sucessMessage = 'Enregistré avec succès !';
        /*ajouter($_POST['pswd'],$_POST['lastName'],$_POST['firstName'],$_POST['email'],$_POST['login'],$_POST['formation']);*/

        //creation of the user


        /*
        $etu->setConn($conn);
        $etu->setIdRole($idRole);
        $etu->setNameFormation($nameFormation);
        $etu->getLogin($login);
        $etu->setPassword($pswd);
        $etu->setEmail($mail);
        $etu->setFirstName($firstName);
        $etu->setLastName($lastName);
        */


        $userObject = unserialize($_SESSION['user']);
        if ($role != 4){
            $userObject->createUser($_POST['pswd'],$_POST['lastName'],$_POST['firstName'],$_POST['email'],$_POST['login'],$idRole,$formations);
        } else {
            $userObject->createUser($_POST['pswd'],$_POST['lastName'],$_POST['firstName'],$_POST['email'],$_POST['login'],$idRole,$formation);
        }

        echo "je vais essayer d'envoyer le mail avec ".$mail;

        try{
            //we send the mail
            sendmailinscription($objmail,$mail);
        }
        catch (Exception $e){
            //in the case when the mail doesn't send
            echo $e->getMessage();
        }

    }
    //we check if we have an error message , if we have one we send it to the user
    if ($Errormsg != null){
        return $Errormsg;
        // else , we send the success message
    } else {
        return $sucessMessage;
    }

}
?>

<?php

if (isset($_POST['login'])) {
    /** TODO:
    -Remplacer les infos de sessions afin d'y stocker uniquement un objet Utilisateur
    -Finir la classe Candidat
    -Modifier l'enregistrement d'un candidat via la classe Candidat
    -Commenter les fonctions
    -Règler les quelques bugs existants
     **/

    //on vérifie que les critères rentrés par l'utilisateur sont valides et si c'est le cas on l'enregistre dans la base
    $message = registerCreation($conn,$_POST['pswd'], $_POST['confirmation'], $_POST['lastName'], $_POST['firstName'], $_POST['email'], $_POST['login'], $_POST['selectFormation'],$_POST['formations'],$_POST['selectRole'],$objmail);
    $_SESSION['message'] = $message;
    $_SESSION['confirmation'] = $_POST['confirmation'];
    header('Location: ../View/PageCreation.php');
}


function affichageRadioButton($conn){
    $result = selectAllFormation($conn);

    foreach ($result as $rows){
        $formationName = $rows['nameFormation'];

        echo '<label class="choices">';
        echo '<input type="checkbox"" name="formations[]" value="' . $formationName . '">';
        echo $formationName;
        echo '</label>';
    };
}

function displayformations($conn)
{
    $formations = selectAllFormation($conn);

    foreach ($formations as $row) {
        $name = $row['nameFormation'];
        echo "<option id='$name' value='$name'>$name</option>";
        echo $name;
    }
}

?>


