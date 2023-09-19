<?php

//Fonction de connexion à la base de donnée
function conn(){
     $bdd = new PDO("mysql:host=localhost;dbname=BDDInterne", 'root', 'root');
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
    $req = $conn->prepare("SELECT login, password from Identification WHERE login = ? AND password = ?");
    $req->execute(array($login, $password));
    $result = $req->fetch();

    return $result['login'] != null && $result['password'] != null;

}


function searchUserHash($conn, $login, $password){
    $req = $conn->prepare("SELECT login, password from Identification WHERE login = ?");
    $req->execute(array($login));
    $result = $req->fetch();

    return password_verify($password,$result['password']);
}