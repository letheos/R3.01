<?php
include '../View/PageCreation.php';
require_once '../View/PageCreation.php';
function enregistrer_Creation($pswd,$confirmation,$lastName,$firstName,$mail,$login,$formation)
{

    if (isset($_POST['envoyer'])) {
        $pswd = $_POST['pswd'];
        $confirmation = $_POST['confirmation'];
        $lastName = $_POST['lastName'];
        $firstName = $_POST['firstName'];
        $mail = $_POST['email'];
        $login = $_POST['login'];
        $formation = $_POST['menu'];


        if ($pswd != $confirmation) {
            "les deux mots de passe doivent être identiques";



        } elseif (preg_match('/[^A-Za-z0-9"\'\,\;]/', $lastName
        )) {
            $messageErreur=
        "le nom contient un caractère spécial";

        } elseif (preg_match("/[0-9]/", $lastName
        )) {
            $messageErreur=
                "le nom contient un chiffre";

        } elseif (preg_match('/[^A-Za-z0-9"\'\,\;]/', $firstName
        )) {
            $messageErreur=
        "le prénom contient un caractère spécial";

        } elseif (preg_match("/[0-9]/", $firstName
        )) {
            $messageErreur=
                "le prénom contient un chiffre";

        } elseif (preg_match('/[;\'"]/', $pswd
        )) {
            $messageErreur=
        "le mot de passe contient un caractère interdit";

        } elseif (!preg_match('/[^A-Za-z0-9"\'\,\;]/', $pswd
        )) {
            $messageErreur= "le mot de passe doit au moins comprendre un caractère spécial";

        } elseif (!preg_match("/[0-9]/", $pswd
        )) {
            $messageErreur=
                "le mot de passe doit au moins comprendre un chiffre";

        } elseif ($pswd
            == null || $confirmation == null || $lastName == null || $mail == null || $mail == null || $login == null || $formation == null) {
            $messageErreur=
        "tout les champs de texte doivent être remplis";


        }
        else{
           $messageSucces = "enregistré avec succès";
        }
        require 'view.php';
    }

}

if (isset($_POST['login'])){
    enregistrer_Creation($_POST['pswd'],$_POST['confirmation'],$_POST['lastName'],$_POST['firstName'],$_POST['email'],$_POST['login'],$_POST['formation']);
    //$pswd,$confirmation,$lastName,$firstName,$mail,$login,$formation
}
?>