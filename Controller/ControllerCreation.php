<?php
session_start();
$conn = require '../Model/Database.php';
$objmail = require '../Controller/ControllerMailConfig.php';
include '../Model/ModelInsertUpdateDelete.php';
include '../Model/ModelSelect.php';
//include  '../Model/ModelCreation.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);


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
    $formation = array($formation);
    //on modifie la valeur de formaiton selon la valeur selectionnée dans la formation
    if( $_POST['selectFormation'] == "mph"){
        $formation = 'mph';
    }
    elseif ($_POST['selectFormation'] == "BUT informatique"){
        $formation = 'Computer Science';
    }
    if (!($_POST)['selectFormation']){
        $formation = null;
    }


    //on modifie la valeur de role selon le role sélectionné dans le select
    if ($_POST['role'] == "Chef de Département"){
        $role = 1;
    }
    elseif ($_POST['role'] == 'Secrétaire'){
        $role = 2;
    }
    elseif ($_POST['role'] == 'Chargé de Développement'){
        $role = 3;
    }


    $role = intval($role);
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
    elseif(strlen($pswd) >= 20 or strlen($pswd) <= 8){

        $Errormsg = "le mot de passe doit être compris entre 8 et 20 caractères";
    }

    //on vérifie dans la base de donnée si l'utilisateur concerné n'existe pas déja
    elseif(exist($conn,$mail,$login) == true){
        $Errormsg = "l'utilisateur existe déja";
        //continuer bdd et ajouter personne a la bdd quand il n'existe pas

    }

    else {
        //nous avons passé toutes les conditions , on renvoie donc un message de succès
        $sucessMessage = "Enregistré avec succès";
        /*ajouter($_POST['pswd'],$_POST['lastName'],$_POST['firstName'],$_POST['email'],$_POST['login'],$_POST['formation']);*/

        adduserbdd($conn,$pswd,$lastName,$firstName,$mail,$login,$role);
        if($role != 1){
            addrolesbdd($conn,$login,$formations);
        }
        else{
            addrolesbdd($conn,$login,$formation);
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

    //on vérifie que les critères rentrés par l'utilisateur sont valides et si c'est le cas on l'enregistre dans la base
    $message = registerCreation($conn,$_POST['pswd'], $_POST['confirmation'], $_POST['lastName'], $_POST['firstName'], $_POST['email'], $_POST['login'], $_POST['selectFormation'],$_POST['formations'],$_POST['selectRole'],$objmail);
    $_SESSION['message'] = $message;
    $_SESSION['confirmation'] = $_POST['confirmation'];
    $_SESSION['lastName'] = $_POST['lastName'];
    $_SESSION['firstName']= $_POST['firstName'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['selectFormation'] = $_POST['selectFormation'];
    $_SESSION['selectRole'] = $_POST['selectRole'];

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
function displayformations($conn) {
    $formations = selectAllFormation($conn);

    foreach ($formations as $row) {
        $name = $row['nameFormation'];
        echo "<option id='$name' value='$name'>$name</option>";
        echo $name;
    }
}

function displaycandidatescount()
{
    $conn = require("../Model/Database.php");
    $namesoformation = selectAllFormationnames($conn);


    echo "<div>";
    foreach ($namesoformation as $formationName) {
        echo "<div class='rounded-box'>";
        echo '<h3>' . $formationName['nameFormation'] . ' :'.countformation($conn,$formationName['nameFormation']) .'</h3>';
        foreach (selectallstudies($conn, $formationName['nameFormation']) as $parcours) {
            echo "<p>{$parcours['nameParcours']} : " . countstudentsstudies($conn, $parcours['nameParcours']) . "</p>";
        }
        echo "</div>";
    }
    echo "</div>";
}




/*
 * fonction qui permet d'afficher les effectifs d'élèves sur une page
 */
function displaycounts(){
    $conn = require("../Model/Database.php");
    //appel à une bdd
    $namesofformation = selectAllFormationnames($conn);
    //on récupère tout les noms des formations
    echo "<div class = 'rounded-box'>";
    foreach ($namesofformation as $formationName){
        //on fait une boucle pour afficher les noms de chaque formation dans une grille
        echo "<div class = grid-container>";
        echo "<div class = grid-item><p class = formation>".$formationName['nameFormation']."</p></div>";
        echo "<div class = grid-item>Actifs</div>";
        echo "<div class = grid-item>Non-actifs</div>";
        echo "<div class = grid-item>total</div>";

        echo "</div>";
        //si notre formation actuelle possède des parcours style parcours A/B on affiche les parcours 1 à 1 avec l'effectif correspondant
        if (!empty(selectallstudies($conn,$formationName['nameFormation']))){
            foreach (selectallstudies($conn,$formationName['nameFormation']) as $parcours){
                echo "<div class = grid-container>";
                echo "<div class = grid-item>".$parcours['nameParcours']."</p></div>";
                echo "<div class = grid-item>".countstudentstudiesactive($conn,$parcours['nameParcours'])."</div>";
                echo "<div class = grid-item>".countstudentsstudies($conn,$parcours['nameParcours'])-countstudentstudiesactive($conn,$parcours['nameParcours'])."</div>";
                echo "<div class = grid-item>".countstudentsstudies($conn,$parcours['nameParcours'])."</div>";
                echo "</div>";
            }
        }
        //si aucun parcours n'existe alors on affiche "parcours unique" et l'effectif de la formation entière
        else{
            echo "<div class = grid-container>";
            echo "<div class = grid-item> Parcours unique</div>";
            echo "<div class = grid-item>".countformationactive($conn,$formationName['nameFormation'])."</div>";
            echo "<div class = grid-item>".countformation($conn,$formationName['nameFormation'])-countformationactive($conn,$formationName['nameFormation'])."</div>";
            echo "<div class = grid-item>".countformation($conn,$formationName['nameFormation'])."</div>";
            echo "</div>";
        }

    }
    echo "</div>";
    //TODO terminer la répartition des éléments dans le tableau et afficher les counts
}


?>
