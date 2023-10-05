<?php


date_default_timezone_set('Europe/Paris');
/**
 * @param $conn PDO
 * @param $login String
 * @return bool
 * Savoir si le login est dans la base de donnée.
 */

//Vérification du login
$conn = require "../Model/Database.php";

date_default_timezone_set('Europe/Paris');

//Fonction de vérification du login
function isLoginExist($conn, $login){
    $req = $conn->prepare("SELECT login FROM Utilisateur WHERE login = ?");
    $req->execute(array($login));
    $result = $req->fetch();
    return $result != null;
}


/**
 * @param $conn PDO
 * @param $login String
 * @param $password String
 * @return bool
 * Vérification si le login et l'utilisateur sont ceux de la base de donnée.
 */
function searchUser($conn, $login, $password){
    $req = $conn->prepare("SELECT login, pswrd from Utilisateur WHERE login = '?' AND pswrd= '?'");
    $req->execute(array($login, $password));
    $result = $req->fetch();
    return $result['login'] != null && $result['pswrd'] != null;

}

/**
 * @param $conn PDO
 * @param $login String
 * @return mixed
 * Renvoie l'email d'un utilisateur.
 */

//Fonction de recherche de l'email
function searchEmail($conn, $login){
    $req = $conn->prepare("SELECT email from Utilisateur WHERE login = ?");
    $req->execute(array($login));
    return $req->fetch();
}


/**
 * @param $conn PDO
 * @param $login string
 * @param $password string
 * @return bool
 * Recherche le mot de passe hashé d'un utilisateur et vérifie si il est bon.
 */

//Vérification du mot de passe de l'utilisateur

function searchUserHash($conn, $login, $password){
    $req = $conn->prepare("SELECT login, pswrd from Utilisateur WHERE login = ?");
    $req->execute(array($login));
    $result = $req->fetch();

    return password_verify($password,$result['pswrd']);
}


/**
 * @param $conn PDO
 * @param $login String
 * @return string
 * @throws Exception
 * Initialise un token.
 */
//Mise a jour du mot de passe
function updatePassword($conn, $login, $newPassword){
    $req = $conn->prepare("UPDATE Utilisateur SET pswrd=?, token = NULL, tokenExpiresAt = NULL WHERE login=?");
    $req->execute(array($newPassword,$login));
}

//Initialisation du token
function tokenInit($conn, $login){
    $token = bin2hex(random_bytes(16));
    $tokenHash = hash("sha256",$token);
    $tokenExpires = date("Y-m-d H:i:s", time() + 60 * 30);
    $sql = 'UPDATE Utilisateur 
            SET token = ?, 
                tokenExpiresAt = ? 
            WHERE login = ?
    ';
    $req = $conn->prepare($sql);
    $req->execute(array($tokenHash,$tokenExpires,$login));
    return $tokenHash;
}


/**
 * @param $conn PDO
 * @param $tokenHash
 * @return mixed
 * A partir du token recherche l'utilisateur.
 */
//Recherche de l'utilisateur par le token

function tokenSearch($conn,$tokenHash){
    $sql = 'SELECT * FROM Utilisateur 
            WHERE token = ?
           ';
    $req = $conn->prepare($sql);
    $req->execute(array($tokenHash));
    $result = $req->fetch();
    return $result;
}

//Contre mesure de connection deconnection vonlontaire dans un cours temps donné
function securityDDOS($conn,$ip){
    $sql = 'SELECT count(*) as nbTentative FROM tentativeconnection 
            WHERE DATE_SUB(CURRENT_TIMESTAMP,INTERVAL 1 HOUR) < date 
            AND ip = ?
    ;';
    $req = $conn->prepare($sql);
    $req->execute(array($ip));
    $result = $req->fetch();
    return $result;
}

//Ajout d'une tentative de connection dans la base de donnée
function addTentativeIp($conn,$ip,$bool){
    $sql='INSERT INTO TentativeConnection (ip,date,connectPass)
          VALUES (?,CURRENT_TIMESTAMP,?);';
    $req = $conn->prepare($sql);
    $req->execute(array($ip,$bool));
}

//Récupération du nombre de tentative
function nbTentative($conn, $ip){
    $sql = 'SELECT count(*) as nbTentative FROM tentativeconnection 
            WHERE DATE_SUB(CURRENT_TIMESTAMP,INTERVAL 1 HOUR) < date 
                  AND connectPass = 0 AND ip = ?;
            ';
    $req = $conn->prepare($sql);
    $req->execute(array($ip));
    $nbTentative = $req->fetch();
    return $nbTentative;
}

//Suppression du nombre de tentative
function deleteTentativeIp($conn,$ip){
    $sql = 'DELETE FROM tentativeConnection WHERE connectPass = 0 AND ip = ? ';
    $req = $conn->prepare($sql);
    $req->execute(array($ip));
}

//Ajout de l'expiration du nombre de tentative
function addExpiration($conn,$ip){
    $dateExpires = date("Y-m-d H:i:s", time() + 60 * 20);
    $sql = 'INSERT INTO blockIp
           VALUES (?,?);
           ';
    $req = $conn->prepare($sql);
    $req->execute(array($ip,$dateExpires));
}

//Vérification de l'expiration
function isExpire($conn, $ip){
    $sql = 'SELECT * FROM blockIp
            WHERE ip = ? ;';
    $req = $conn->prepare($sql);
    $req->execute(array($ip));
    $expire = $req->fetch();
    return time() > strtotime($expire['expiration']);
}

//Suppression de l'expiration
function delExpiration($conn, $ip){
    $sql = 'DELETE FROM blockIp WHERE ip= ?;';
    $req = $conn->prepare($sql);
    $req->execute(array($ip));

}


?>