<?php

$conn = require 'Database.php';

/**
 * @param $conn : Connection to the database
 * @param $login : User login
 * @return the user's infos
 * This function get all the infos of the user by his login
 */
function getInfosLogin($conn,$login){
    $req = $conn->prepare("SELECT * FROM Utilisateur WHERE login=?");
    $req->execute(array($login));
    $result = $req->fetch();
    return $result;
}

/**
 * @param $conn : Connection to the database
 * @param $login : User login
 * @return the role of the user
 * This function get the role of the user by his login
 */
function getRole($conn,$login){
    $reqObtenirIdRole = $conn->prepare("SELECT idRole FROM Utilisateur WHERE login=?");
    $reqObtenirIdRole->execute(array($login));
    $idRole = $reqObtenirIdRole->fetch();

    $reqObtenirNomRole = $conn->prepare("SELECT nameRole FROM Role WHERE idRole=?");
    $reqObtenirNomRole->execute(array((int)$idRole));
    $result = $reqObtenirNomRole->fetch();
    return $result;
}

function modifLastName($conn,$login,$lastName){
    $req = $conn->prepare("UPDATE Utilisateur SET userName = ? WHERE login = ?");
    $req->execute(array($lastName,$login));
}

function modifFirstName($conn,$login,$firstName){
    $req = $conn->prepare("UPDATE Utilisateur SET firstName = ? WHERE login = ?");
    $req->execute(array($firstName,$login));
}

function modifLogin($conn,$oldLogin,$newLogin){
    $req = $conn->prepare("UPDATE Utilisateur SET login = ? WHERE login = ?");
    $req->execute(array($oldLogin,$newLogin));
}
