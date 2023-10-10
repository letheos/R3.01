<?php
session_start();
function enregistrerCreation($pswd,$confirmation,$lastName,$firstName,$mail,$login,$formation)
{

    if (isset($_POST['envoyer'])) {
        $pswd = $_POST['pswd'];
        $confirmation = $_POST['confirmation'];
        $lastName = $_POST['lastName'];
        $firstName = $_POST['firstName'];
        $mail = $_POST['email'];
        $login = $_POST['login'];
        $formation = $_POST['menu'];

        $messageErreur = "";
        $messageSucces = "";
        if ($pswd != $confirmation) {
            "les deux mots de passe doivent être identiques";


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
        } else {
            $messageSucces = "Enregistré avec succès";
        }
        if ($messageErreur != null) {
            return $messageErreur;
        } else {
            return $messageSucces;
        }
    }
}
?>

<?php

if (isset($_POST['login'])) {

    $message = enregistrerCreation($_POST['pswd'], $_POST['confirmation'], $_POST['lastName'], $_POST['firstName'], $_POST['email'], $_POST['login'], $_POST['formation']);
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


