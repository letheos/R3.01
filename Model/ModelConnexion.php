<?php


date_default_timezone_set('Europe/Paris');
/**
 * @param $conn PDO
 * @param $login String
 * @return bool
 * Savoir si le login est dans la base de donnée.
 */
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
function searchUserHash($conn, $login, $password){
    $req = $conn->prepare("SELECT login, pswrd from Utilisateur WHERE login = ?");
    $req->execute(array($login));
    $result = $req->fetch();

    return password_verify($password,$result['pswrd']);
}

/**
 * @param $conn PDO
 * @param $login String
 * @return int
 * change le mode de passe d'un utilisateur avec une valeur aléatoire comprise entre 10 000 000 et 99 999 999.
 */
function updatePassword($conn, $login){
    $newPassword = rand(10000000,99999999);
    $req = $conn->prepare("UPDATE Utilisateur SET pswrd=? WHERE login=?");
    $password = password_hash($newPassword, PASSWORD_DEFAULT);
    $req->execute(array($password,$login));
    return $newPassword;
}

/**
 * @param $conn PDO
 * @param $login String
 * @return string
 * @throws Exception
 * Initialise un token.
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
    echo "token de la requête non hashée : ".$tokenHash;
    return $tokenHash;
}

/**
 * @param $conn PDO
 * @param $tokenHash
 * @return mixed
 * A partir du token recherche l'utilisateur.
 */
function tokenSearch($conn,$tokenHash){
    $sql = 'SELECT * FROM Utilisateur 
            WHERE token = ?
           ';
    $req = $conn->prepare($sql);
    $req->execute(array($tokenHash));
    $result = $req->fetch();
    echo $result;
    return $result;
}

?>