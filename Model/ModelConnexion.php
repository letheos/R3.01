<?php
//Vérification du login

date_default_timezone_set('Europe/Paris');
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

function tokenInit($conn, $login){
    $token = uniqid();
    $tokenHash = hash("sha256",$token);
    $tokenExpires = date("Y-m-d H:i:s", time() + 60 * 30);
    echo $tokenExpires;
    $sql = 'UPDATE Utilisateur 
            SET token = ?, 
                tokenExpiresAt = ? 
            WHERE login = ?
    ';
    $req = $conn->prepare($sql);
    $req->execute(array($tokenHash,$tokenExpires,$login));
    return $tokenHash;
}



tokenInit($conn=require_once "../Model/Database.php",'johndoe123');






?>