<?php
//f
include '../Model/ModelConnexion.php';
include '../View/PageConnexion.php';
$conn = require "../Model/Database.php";

//Fonction de connection avec la clef de décryptage du hash
function connectionHash($conn)
{
    if ($_POST['login'] == null || $_POST['password'] == null ){
        $error = "Login ou Mot de passe non renseignée";
    } else {
        if (isLoginExist($conn, $_POST['login'])) {
            if (searchUserHash($conn, $_POST['login'], $_POST['password'])) {
                session_start();
                $_SESSION["login"] = $_POST['login'];
                $_SESSION["password"] = $_POST['password'];
                header("location: ../View/PageAccueil.php");
            } else {
                $error = "Mauvais mot de passe";
            }
        } else {
            $error = "Mauvais login";
        }
    }
    echo $error;
}

connectionHash($conn);

?>