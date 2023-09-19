<?php

include '../Model/Database.php';
function connection()
{
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $conn = conn();
        if (isLoginExist($conn, $_POST['login'])) {
            if (searchUser($conn, $_POST['login'], $_POST['password'])) {
                session_start();
                $_SESSION["login"] = $_POST['login'];
                $_SESSION["password"] = $_POST['password'];
                header("location: ../View/Accueil.php");
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
                header("location: ../View/Accueil.php");
            } else {
                echo "Vous avez renseigné le mauvais mot de passe";
            }
        } else {
            echo "Vous avez renseigné le mauvais Login";
        }
    }
}
$password = "1234";
$hash = password_hash($password,PASSWORD_DEFAULT);
if(password_verify($password, $hash)){
    echo 'c vrai';
} else {
    echo 'c fo';
}
connection();

?>