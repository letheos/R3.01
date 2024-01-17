<?php

$conn = require "../Model/Database.php";

//This is used to setup the timezone of PHPStorm as the Europe/Paris one
date_default_timezone_set('Europe/Paris');
/**
 * @param $conn : Connection to the database
 * @param $login : User login
 * @return bool
 * This function verify if the login already exists in the database
 */


/**
 * @param $conn : Connection to the database
 * @param $login : User login
 * @return mixed
 * This function get the Email of a user using his login
 */
function searchEmail($conn, $login){
    $req = $conn->prepare("SELECT email from Utilisateur WHERE login = ?");
    $req->execute(array($login));
    return $req->fetch();
}

/**
 * @param $conn : Connection to the database
 * @param $login : User login
 * @param $password : User password
 * @return bool
 * This function will get the user using his login, and then verify if he entered the good password
 */
function searchUserHash($conn, $login, $password){
    $req = $conn->prepare("SELECT login, pswrd from Utilisateur WHERE login = ?");
    $req->execute(array($login));
    $result = $req->fetch();

    return password_verify($password,$result['pswrd']);
}

/**
 * @param $conn : Connection to the database
 * @param $login : User login
 * @param $newPassword : The new password of the user
 * @return void
 * This function use a SQL request to update the user password
 */
function updatePassword($conn, $login, $newPassword){
    $req = $conn->prepare("UPDATE Utilisateur SET pswrd=?, token = NULL, tokenExpiresAt = NULL WHERE login=?");
    $req->execute(array($newPassword,$login));
}

/**
 * @param $conn : Connection to the database
 * @param $login : User login
 * @return string
 * @throws Exception
 * This function initialize the user token
 */
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
 * @param $conn : Connection to the database
 * @param $tokenHash : Hashed token
 * @return mixed
 * This function search all the information about a User using a token
 */
function tokenSearch($conn,$tokenHash){
    $sql = 'SELECT * FROM Utilisateur 
            WHERE token = ?
           ';
    $req = $conn->prepare($sql);
    $req->execute(array($tokenHash));
    $result = $req->fetch();
    return $result;
}

/**
 * @param $conn : Connection to the databse
 * @param $ip : User IP
 * @return mixed
 * This function is used to protect ourselves from the DDOS, she check if there is a high attempt of connection in a limited time
 */

function securityDDOS($conn,$ip){
    $sql = 'SELECT count(*) as nbTentative FROM connectionAttempt
            WHERE DATE_SUB(CURRENT_TIMESTAMP,INTERVAL 1 HOUR) < date 
            AND ip = ?
    ;';
    $req = $conn->prepare($sql);
    $req->execute(array($ip));
    $result = $req->fetch();
    return $result;
}

/**
 * @param $conn : Connection to the database
 * @param $ip : User IP
 * @param $bool : Success or fail of the connection attempt
 * @return void
 * This function add the connection attempt to the database
 */
function addTentativeIp($conn,$ip,$bool){
    $sql='INSERT INTO connectionAttempt (ip,date,connectPass)
          VALUES (?,CURRENT_TIMESTAMP,?);';
    $req = $conn->prepare($sql);
    $req->execute(array($ip,$bool));
}

/**
 * @param $conn : Connection to the database
 * @param $ip : User IP
 * @return mixed
 * This function recover the number of connection attempts
 */
function nbTentative($conn, $ip){
    $sql = 'SELECT count(*) as nbTentative FROM connectionAttempt
            WHERE DATE_SUB(CURRENT_TIMESTAMP,INTERVAL 1 HOUR) < date 
                  AND connectPass = 0 AND ip = ?;
            ';
    $req = $conn->prepare($sql);
    $req->execute(array($ip));
    $nbTentative = $req->fetch();
    return $nbTentative;
}

/**
 * @param $conn : Connection to the database
 * @param $ip : User IP
 * @return void
 * This function delete all the connection attempts of a User
 */
function deleteTentativeIp($conn,$ip){
    $sql = 'DELETE FROM connectionAttempt WHERE connectPass = 0 AND ip = ? ';
    $req = $conn->prepare($sql);
    $req->execute(array($ip));
}

/**
 * @param $conn : Connection to the database
 * @param $ip : User IP
 * @return void
 * This function add an expiry time if a User fails too much connection attempt
 */
function addExpiration($conn,$ip){
    $dateExpires = date("Y-m-d H:i:s", time() + 60 * 20);
    $sql = 'INSERT INTO blockIp
           VALUES (?,?);
           ';
    $req = $conn->prepare($sql);
    $req->execute(array($ip,$dateExpires));
}

/**
 * @param $conn : Connection to the databse
 * @param $ip : User IP
 * @return bool
 * This function check up the expiry time
 */
function isExpire($conn, $ip){
    $sql = 'SELECT * FROM blockIp
            WHERE ip = ? ;';
    $req = $conn->prepare($sql);
    $req->execute(array($ip));
    $expire = $req->fetch();
    return time() > strtotime($expire['expiration']);
}

/**
 * @param $conn : Connection do the database
 * @param $ip : IP of the user
 * @return void
 * This function delete all the connection attempt of connection from the IP
 */
function delExpiration($conn, $ip){
    $sql = 'DELETE FROM blockIp WHERE ip= ?;';
    $req = $conn->prepare($sql);
    $req->execute(array($ip));

}

/**
 * @param $conn : Connection to the dabase
 * @param $login : user login
 * @return void
 * This function get the first name of a user using his login
 */

function getFirstName($conn, $login){
    try {
        $sql = 'SELECT firstName FROM utilisateur WHERE login = ?;';
        $req = $conn->prepare($sql);
        $req->execute(array($login));
        $resultat = $req->fetch();
        echo $resultat[0];
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}

/**
 * @param $conn : Connection to the Database
 * @param $login : User login
 * @return mixed|void
 * This function show all the required information of a user using his login
 */

function showUserProfile($conn, $login){
    try {
        $sql = 'SELECT * FROM utilisateur WHERE login = ?;';
        $req = $conn->prepare($sql);
        $req->execute(array($login));
        $result = $req->fetch();
        return $result;
    }catch (PDOException $e){
        echo $e->getMessage();
    }
}

/**
 * @param $conn : Connection to the database
 * @param $login : User login
 * @param $password
 * @return mixed
 * This function get the hashed password of the user using his login
 */
function getUserHash($conn, $login){
    $req = $conn->prepare("SELECT login, pswrd from Utilisateur WHERE login = ?");
    $req->execute(array($login));
    $result = $req->fetch();

    return $result;
}

?>