<?php
session_start();
$conn = require '../Model/Database.php';
$objmail = require '../Controller/ControllerMailConfig.php';
include '../Model/ModelSelect.php';
include '../Controller/ClassUtilisateur.php';

if(!isset($_SESSION['user'])){
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}



function sendmailinscription($mail,$emailuser){
    //fonction pour envoyer des mails
    $mail->setFrom('bncorp.auto@gmail.com');
    //on set l'adresse d'envoi
    $mail->addAddress($emailuser);
    //on ajoute à l'objet mail l'adresse
    $mail->isHTML(true);
    //on set le nom du mail
    $mail->Subject = "bienvenue";
    //on set le message du mail
    $mail->Body = "Votre inscription dans le système est bien réalisée .";
    try {

        $mail->send();
    }
    catch(Exception $exception){
        print_r($exception->getMessage());
    }
}

function registerCreation($conn,$pswd,$confirmation,$lastName,$firstName,$mail,$login,$formation,$formations,$role,$objmail)
{
    //on modifie la valeur de role selon le role sélectionné dans le select
    if (empty($role)){
        $idRole = null;
    }else{
        $idRole = $role;
    }


    $Errormsg = "";
    $sucessMessage = "";

    //on importe le fichier utilisé pour la base de donnée



    // on vérifie que le mot de passe est identique a la confirmation
    if ($pswd != $confirmation) {
        $Errormsg="les deux mots de passe doivent être identiques";

        // on vérifie que le nom de famille contient un caractère spécial
    } elseif (preg_match('/[^A-Za-z0-9"\'\,\;]/', $lastName
    )) {
        $Errormsg = "Le nom contient un caractère spécial";

        // on vérifie si le nom contient un chiffre
    } elseif (preg_match("/[0-9]/", $lastName
    )) {
        $Errormsg =
            "Le nom contient un chiffre";

        //on vérifie si le prénom contient un caractère spécial
    } elseif (preg_match('/[^A-Za-z0-9"\'\,\;]/', $firstName
    )) {
        $Errormsg =
            "Le prénom contient un caractère spécial";

        // on vérifie si le prénom contient un chiffre
    } elseif (preg_match("/[0-9]/", $firstName
    )) {
        $Errormsg = "Le prénom contient un chiffre";

        //on vérifie que le mot de passe ne contienne pas un caractère interdit
    } elseif (preg_match('/[;\'"]/', $pswd
    )) {
        $Errormsg =
            "Le mot de passe contient un caractère interdit";

        //on regarde si le mot de passe contient bien un caractère spécial
    } elseif (!preg_match('/[^A-Za-z0-9"\'\,\;]/', $pswd
    )) {
        $Errormsg = "Le mot de passe doit au moins comprendre un caractère spécial";

        // on vérifie que le mot de passe contient bien un chiffre
    } elseif (!preg_match("/[0-9]/", $pswd
    )) {
        $Errormsg =
            "Le mot de passe doit au moins comprendre un chiffre";

        // on vérifie que tout les critères sont remplis
    } elseif ($pswd
        == null || $confirmation == null || $lastName == null || $mail == null || $mail == null || $login == null || $formation == null) {
        $Errormsg =
            "Tous les champs de texte doivent être remplis";

    }

    // on vérifie que le mot de passe soit bien entre 8 et 20 caractères
    elseif(strlen($pswd) > 20 or strlen($pswd) < 6){

        $Errormsg = "le mot de passe doit être compris entre 8 et 20 caractères";
    }

    //on vérifie dans la base de donnée si l'utilisateur concerné n'existe pas déja
    elseif(exist($conn,$mail,$login) == true){
        $Errormsg = "L'utilisateur existe déjà";
        //continuer bdd et ajouter personne a la bdd quand il n'existe pas

    }
    else {
        //nous avons passé toutes les conditions , on renvoie donc un message de succès
        $sucessMessage = 'Enregistré avec succès !';
        /*ajouter($_POST['pswd'],$_POST['lastName'],$_POST['firstName'],$_POST['email'],$_POST['login'],$_POST['formation']);*/

        //Creation du candidat


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
            //on envoie le mail
            sendmailinscription($objmail,$mail);
        }
        catch (Exception $e){
            //dans le cas ou le mail n'est pas envoyé
            echo $e->getMessage();
        }
        echo "j'ai send le mail la ";
    }
    //on vérifie si on a un message d'erreur si oui on l'envoie
    if ($Errormsg != null){
        return $Errormsg;
        // sinon on renvoie un message de succès
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


