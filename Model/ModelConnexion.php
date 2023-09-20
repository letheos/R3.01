<?php
include "ConnexionSGBD.php";

//Fonction de connexion à la base de donnée
function connSGBD(){
    $sgbd = ConnexionSGBD::creerInstance();
    $bdd = $sgbd->connect();
    return $bdd;
}

//Vérification du login
function isLoginExist($conn, $login){
    $req = $conn->prepare("SELECT login FROM Identification WHERE login = ?");
    $req->execute(array($login));
    $result = $req->fetch();
    return $result != null;
}

//Vérification de l'utilisateur
function searchUser($conn, $login, $password){
    $req = $conn->prepare("SELECT login, pswrd from Identification WHERE login = ? AND pswrd= ?");
    $req->execute(array($login, $password));
    $result = $req->fetch();
    return $result['login'] != null && $result['pswrd'] != null;

}

//Recherche de l'user en HASH
function searchUserHash($conn, $login, $password){
    $req = $conn->prepare("SELECT login, pswrd from Identification WHERE login = ?");
    $req->execute(array($login));
    $result = $req->fetch();

    return password_verify($password,$result['pswrd']);
}

function updatePassword($conn, $login){
    $newPassword = rand(10000000,99999999);
    $req = $conn->prepare("UPDATE identification SET pswrd=? WHERE login=?");
    $req->execute(array(password_hash($newPassword)),$login);
}

//Fonction de connection avec la clef de décryptage du hash
function connectionHash()
{
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $conn = connSGBD();
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

function reinitialisationPassword()
{
    if (isset($_POST['login'])){
        $conn = connSGBD();
        if (isLoginExist($conn,$_POST['login'])){
            updatePassword($conn, $_POST['login']);
        } else {
            print_r("Votre email n'existe pas");
        }
    }
}

?>