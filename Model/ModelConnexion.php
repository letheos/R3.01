<?php
include "ConnexionSGBD.php";

//Fonction de connexion à la base de donnée

//Vérification du login
function isLoginExist($conn, $login){
    $req = $conn->prepare("SELECT login FROM Utilisateur WHERE login = ?");
    $req->execute(array($login));
    $result = $req->fetch();
    return $result != null;
}

//Vérification de l'utilisateur
function searchUser($conn, $login, $password){
    $req = $conn->prepare("SELECT login, pswrd from Utilisateur WHERE login = '?' AND pswrd= '?'");
    $req->execute(array($login, $password));
    $result = $req->fetch();
    return $result['login'] != null && $result['pswrd'] != null;

}

function searchEmail($conn, $login){
    $req = $conn->prepare("SELECT email from Utilisateur WHERE login = ?");
    $req->execute(array($login));
    return $req->fetch();
}

//Recherche de l'user en HASH
function searchUserHash($conn, $login, $password){
    $req = $conn->prepare("SELECT login, pswrd from Utilisateur WHERE login = ?");
    $req->execute(array($login));
    $result = $req->fetch();

    return password_verify($password,$result['pswrd']);
}

function updatePassword($conn, $login){
    $newPassword = rand(10000000,99999999);
    $req = $conn->prepare("UPDATE Utilisateur SET pswrd=? WHERE login=?");
    $password = password_hash($newPassword, PASSWORD_DEFAULT);
    $req->execute(array($password,$login));
    return $newPassword;
}

//Fonction de connection avec la clef de décryptage du hash
function connectionHash($conn)
{
    if (isset($_POST['login']) && isset($_POST['password'])) {
        if (isLoginExist($conn, $_POST['login'])) {
            if (searchUserHash($conn, $_POST['login'], $_POST['password'])) {
                session_start();
                $_SESSION["login"] = $_POST['login'];
                $_SESSION["password"] = $_POST['password'];
                header("location: ../View/PageAccueil.php");
            } else {
                print_r("Vous avez renseigné le mauvais mot de passe");
            }
        } else {
            print_r("Vous avez renseigné le mauvais Login");
        }
    }
}



function reinitialisationPassword($conn)
{
    if (isset($_POST['login'])){
        if (isLoginExist($conn,$_POST['login'])){
            $email = searchEmail($conn, $_POST['login']);
            mail($email['email'],"Test","Test 123");
        } else {
            print_r("Votre email n'existe pas");
        }
    }
}

?>