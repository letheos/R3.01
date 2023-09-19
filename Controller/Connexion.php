<?php

include '../Model/ConnexionDatabase.php';
function connection()
{
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $conn = conn();
        if (isLoginExist($conn, $_POST['login'])) {
            if (searchUser($conn, $_POST['login'], $_POST['password'])) {
                session_start();
                $_SESSION["login"] = $_POST['login'];
                $_SESSION["password"] = $_POST['password'];
                header("location: ../View/PageAccueil.php");
            } else {
                echo "Vous avez renseigné le mauvais mot de passe";
            }
        } else {
            echo "Vous avez renseigné le mauvais Login";
        }
    }
}

function connectionHash()
{
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $conn = conn();
        if (isLoginExist($conn, $_POST['login'])) {
            if (searchUserHash($conn, $_POST['login'], $_POST['password'])) {
                session_start();
                $_SESSION["login"] = $_POST['login'];
                $_SESSION["password"] = $_POST['password'];
                header("location: ../View/PageAccueil.php");
            } else {
                echo "Vous avez renseigné le mauvais mot de passe";
            }
        } else {
            echo "Vous avez renseigné le mauvais Login";
        }
    }
}

connection();

?>