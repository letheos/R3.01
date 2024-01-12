<?php
/**
 * @author : Nathan Strady
 */

/**
 * Fonction qui envoie toute les formations de la bdd
 * @param $conn : Connection à la bdd
 * @return mixed : Renvoie le résultat de la requête sql
 */
function selectAllFormation($conn){
    $sql = "SELECT * FROM Formation";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchAll();
}

function selectParcours($conn, $nameFormation){
    $sql = "SELECT Parcours.*
            FROM Parcours
            JOIN Formation ON Parcours.nameFormationParcours = Formation.nameFormation
            WHERE Formation.nameFormation = ?;
            ";
    $req = $conn->prepare($sql);
    $req->execute(array($nameFormation));
    $results = $req->fetchAll();
    return $results;
}

function allParcours($conn){
    $sql = "SELECT Parcours.*
            FROM Parcours
            ";
    $req = $conn->prepare($sql);
    $req->execute();
    $results = $req->fetchAll();
    return $results;
}

/**
 * Fonction qui test la présence du candidat dans la bdd via son INE
 * @param $conn : Connection à la bdd
 * @param $INE : INE du candidat
 * @return bool : Renvoie du résultat de l'existance dans la bdd
 */
function isCandidateExistWithIne($conn, $INE): bool
{
    $sql = "SELECT * from Candidate WHERE INE = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($INE));
    $result = $req->fetch();
    return !empty($result);

}

/**
 * Fonction qui test la présence du candidat dans la bdd via son nom ou son prénom
 * @param $conn : Connexion à la bdd
 * @param $name : Nom du candidat
 * @param $firstName : Prenom du candidat
 * @return bool : Renvoie le résultat de l'existance dans la bdd
 */
function isCandidateExistWithNameAndFirstname($conn, $name, $firstName): bool
{
    $sql = "SELECT * from Candidate WHERE name = ? AND firstName = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($name,$firstName));
    $result = $req->fetch();
    return !empty($result);

}

/**
 * Fonction qui vérifie l'existance d'un email dans la base de donnée
 * @param $conn : Connexion à la bdd
 * @param $email : Email du candidat
 * @return bool Renvoie un boulean contenant le résultat
 */
function isEmailAlreadyExist($conn, $email): bool {
    $sql = "SELECT * from Candidate WHERE candidateMail = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($email));
    $result = $req->fetch();
    return !empty($result);
}

function isPhoneNumberAlreadyExist($conn, $phone): bool {
    $sql = "SELECT * from Candidate WHERE phoneNumber = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($phone));
    $result = $req->fetch();
    return !empty($result);
}

function verfication($conn,$mail,$login)
{
    //on vérifie que la personne existe bien dans l'adresse

    $request0 = "Select email,login from utilisateur where email = ? OR login = ?";

    $res = $conn->prepare($request0);
    $res->execute(array($mail, $login));
    if ($res->rowCount() == 0) {
        return false;
    } else {
        return true;
    }
}


    /**
 * @param PDO $conn  The db connection
 * @param string $login    The login of a user
 * @return bool|Exception|PDOException
 * This function returns true if the user has at least one alert that needs reminder
 */


function hasPastAlert(PDO $conn, string $login){
    $req = $conn->prepare("SELECT COUNT(idalert) FROM alert JOIN ALERTUTILISATEUR WHERE login = ? AND remindAT<CURRENT_DATE and seen= false");
    try {
        $req->execute(array($login));
        $result = $req->fetchAll();
    }
    catch (PDOException $e){
        return $e;
    }
}
function exist($conn,$mail,$login)
{

    $existence = verfication($conn, $mail, $login);
    //$existence = verfication($conn,$_POST['email'],$_POST['login']);
    return $existence;
}


//This is used to setup the timezone of PHPStorm as the Europe/Paris one
date_default_timezone_set('Europe/Paris');
/**
 * @param $conn : Connection to the database
 * @param $login : User login
 * @return bool
 * This function verify if the login already exists in the database
 */
function isLoginExist($conn, $login){
    $req = $conn->prepare("SELECT login FROM Utilisateur WHERE login = ?");
    $req->execute(array($login));
    $result = $req->fetch();
    return $result != null;
}

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

function getInfosLogin($conn,$login){
    $req = $conn->prepare("SELECT * FROM Utilisateur WHERE login=?");
    $req->execute(array($login));
    $result = $req->fetch();
    return $result;
}

function getRole($conn,$login){
    $reqObtenirIdRole = $conn->prepare("SELECT idRole FROM Utilisateur WHERE login=?");
    $reqObtenirIdRole->execute(array($login));
    $idRole = $reqObtenirIdRole->fetch();

    $reqObtenirNomRole = $conn->prepare("SELECT nameRole FROM Role WHERE idRole=?");
    $reqObtenirNomRole->execute(array((int)$idRole));
    $result = $reqObtenirNomRole->fetch();
    return $result;

    return $result[0][0]!=0;
}


/**
 * @param PDO $conn   The db connection
 * @param string $login    The login of a user
 * @return array|Exception|false|PDOException
 * This function set all the alert for a user that needs a reminder to 'seen', meaning he saw them and don't need any more reminder.
 */
function selectPastAlert(PDO $conn, string $login){
    try {
        $sql = 'SELECT note,remindAt,idAlert FROM Alert JOIN ALERTUTILISATEUR USING (IDALERT) WHERE login = ? AND remindAT<CURRENT_TIMESTAMP' ;
        $req = $conn->prepare($sql);
        $req->execute(array($login));
    }
    catch (PDOException $e){
        return $e;
    }
    foreach ($req as $row){
        setAlertSeen($conn,$row[2],$login);
    }
    return $req->fetchAll();
}

/**
 * @param PDO $conn   The db connection
 * @param string $login The login of a user
 * @param boolean $future   A boolean, on which depends if all user's alert are shown or only the outdated ones
 * @return array|Exception|false|PDOException
 * This function put in an array all the alert for a user (depending on the future param)
 */
function selectAlert(PDO $conn, string $login, bool $future){
    try {
        $sql = "SELECT IDAlert,note,remindAt FROM alert join AlertUTILISATEUR USING (IDALERT) WHERE login = ? ";
        if(!$future) {
            $sql=$sql . "AND remindAt<=Current_DATE ";
        }
        $sql=$sql. "ORDER BY RemindAt DESC";
        $req = $conn->prepare($sql);
        $req->execute(array($login));
        $res =$req->fetchAll();
    }
    catch (PDOException $e){
        return $e;
    }

    return $res;
}

/**
 * @param $conn
 * @param $isNotActive
 * @return mixed
 * Requête de selection des candidats actifs
 */
function selectCandidatesActives($conn, $isNotActive){
    $sql = "SELECT * FROM infoCandidate 
         WHERE isInActiveSearch = ?";

    $req = $conn->prepare($sql);
    $req->execute(array($isNotActive));
    return $req->fetchAll();
}

/**
 * @param $conn
 * @param $choixFormation
 * @param $isActive
 * @return mixed
 * Requête de selection des candidats par formation
 */
function selectCandidatesByFormation($conn, $choixFormation, $isActive){
    $sql = "SELECT * FROM infoCandidate 
         WHERE nameFormation = ? AND isInActiveSearch = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($choixFormation,$isActive));
    return $req->fetchAll();
}


/**
 * @param $conn
 * @param $choixFormation
 * @param $choixNom
 * @param $isActive
 * @return mixed
 * Requête de selection des candidats en fonction du nom et de la formation
 */
function selectCandidatesByNameAndFormation($conn, $choixFormation, $choixNom, $isActive){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND name LIKE ? AND nameFormation = ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $choixNomPattern,  $choixFormation));
    return $req->fetchAll();
}

function selectCandidateByFormationAndParcours($conn, $choixFormation, $parcours, $isActive){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND nameParcours = ? AND nameFormation = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $parcours,  $choixFormation));
    return $req->fetchAll();
}

/**
 * @param $conn
 * @param $choixNom
 * @param $isActive
 * @return mixed
 * Requête de selection des candidats en fonction du nom
 */

function selectCandidatesByName($conn, $choixNom, $isActive){
    $sql = "SELECT * FROM infoCandidate
            WHERE isInActiveSearch = ? AND name LIKE ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $choixNomPattern));
    return $req->fetchAll();
}

function selectCandidatesByParcours($conn, $parcours, $isActive){
    $sql = "SELECT * FROM infoCandidate
            WHERE isInActiveSearch = ? AND nameParcours = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $parcours));
    return $req->fetchAll();
}

function selectCandidatesByNameAndParcours($conn, $parcours, $choixNom, $isActive){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND name LIKE ? AND nameParcours = ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $choixNomPattern,  $parcours));
    return $req->fetchAll();
}

function selectCandidatesByNameFormationAndParcours($conn, $parcours, $choixNom, $choixFormation, $isActive){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND name LIKE ? AND nameParcours = ? AND nameFormation = ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $choixNomPattern,  $parcours, $choixFormation));
    return $req->fetchAll();
}


/**
 * @param $conn
 * @return mixed
 * Requête de selection des formations pour la liste déroulante
 */
function allFormation($conn){
    $sql = "SELECT * FROM Formation";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchAll();

}

function selectCandidatById($conn,$id){
    $sql = "
SELECT
    ic.idCandidate,
    ic.INE,
    ic.name,
    ic.firstName,
    ic.phoneNumber,
    ic.candidateMail,
    ic.nameParcours,
    f.nameFormation,
    ic.yearOfFormation,
    ic.isInActiveSearch,
    ic.permisB,
    ic.typeCompanySearch,
    ic.cv,
    ic.remarks,
    GROUP_CONCAT(DISTINCT CONCAT(candidateaddress.CP, ', ', candidateaddress.addressLabel, ', ', candidateaddress.city) SEPARATOR '; ') AS addresses,
    GROUP_CONCAT(DISTINCT CONCAT(candidatezone.cityName, ' (Rayon: ', candidatezone.radius, ' km)') SEPARATOR ', ') AS zones
FROM infocandidate ic
LEFT JOIN candidateaddress ON ic.idCandidate = candidateaddress.idCandidate
LEFT JOIN candidatezone ON ic.idCandidate = candidatezone.idCandidate
LEFT JOIN parcours p ON ic.nameParcours = p.nameParcours
LEFT JOIN formation f ON p.nameFormationParcours = f.nameFormation
WHERE ic.idCandidate = ?
GROUP BY ic.idCandidate;
";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return $req->fetch();
}

function isInActiveSearch($conn,$id){
    $sql = "Select isInActiveSearch from candidate where idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return $req->fetch();
}

function selectComm($conn,$idcandidate){
    $sql = "Select note,dateCommunication,idmessage,img from communication where idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($idcandidate));
    return $req->fetchall();
}

function selectCandidatewithName($conn,$firstname,$lastname){
    $sql = "Select name,firstname,idcandidate from Candidate where firstname ILIKE ? or Candidate.name ILIKE ?;";
    $req = $conn->prepare($sql);
    $req->execute(array($firstname,$lastname));
    return $req->fetchall();
}

function selectCandidatewithId($conn,$idcandidate){
    $sql = "Select name,firstname from Candidate where idcandidate = ?;";
    $req = $conn->prepare($sql);
    $req->execute(array($idcandidate));
    return $req->fetchall();
}



function selectCandidatesByFormationWithParcoursWithYear($conn,$name,$formation, $parcours, $yearOfFormation){
    $sql = "SELECT name,firstname,idCandidate FROM infoCandidate
            WHERE (name ilike ? or firstname ilike ?)  AND nameParcours like ? AND yearOfFormation like ? and nameformation like ?;";
    $req = $conn->prepare($sql);
    $req->execute(array($name,$name, $parcours, $yearOfFormation,$formation));
    return $req->fetchAll();
}


