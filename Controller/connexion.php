<?php
function connection($login, $password)
{
    if (isset($_POST['login']) && isset($_POST['password'])) {
        if ($_POST["login"] == $login && $_POST["password"] == $password) {
            session_start();
            $_SESSION["login"] = $_POST['login'];
            $_SESSION["password"] = $_POST['password'];
            header("location: ../View/Accueil.php");
        } else {
            echo "CONNECTION IMPOSSIBLE : MAUVAIS LOGIN OU MOT DE PASSE !";
        }
    }
}

connection('nathan','1234')

?>