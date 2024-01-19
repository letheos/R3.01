<?php

/**
 * @param $conn PDO
 * @return String[]
 * take a PDO connection and return all the date in Parcours
 */
function getAllParcours($conn)
{
    $sql = "SELECT * FROM parcours";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchall();
}



/**
 * @param $conn PDO
 * @param $parcours String
 * @return String[]
 * take a PDO connexion and an educative parcours and return all the parcours in the database that correspond
 */
function getParcoursWithConditions($conn, $parcours)
{
    $sql = "SELECT * FROM parcours WHERE nameParcours LIKE(?)";
    $req = $conn->prepare($sql);
    $req->execute($parcours);
    return $req->fetchall();
}

/**
 * @param $conn PDO
 * @return String[]
 * take a PDO connexion and return all the formation in the databse
 */
function allFormation($conn)
{
    $sql = "SELECT * FROM formation";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchall();
}


/**
 * @param $conn PDO
 * @param $formation String
 * @return Array[String]
 * return the values in the database where the name of the formation is like a string pass in parameter
 */
function getFormationWithCoditions($conn, $formation)
{
    $sql = "SELECT * FROM formation WHERE nameFormation LIKE(?)";
    $req = $conn->prepare($sql);
    $req->execute($formation);
    return $req->fetchall();
}

/**
 * @param $idUser String
 * @param $conn PDO
 * @return mixed
 * this function take in parameter the id of a user and a connection to the database
 * return the user
 */
function getUserWithId($idUser, $conn)
{
    $sql = "SELECT * FROM Utilisateur WHERE login = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($idUser));
    return $req->fetchall();
}


/**
 * @param $conn PDO
 * @param $role array
 * @return array|false
 * get the login for all the user with an id give
 */
function getAllPeopleWithRole($conn, $role){
    $sql = "SELECT login FROM utilisateur where idRole = ? ";
    for($i = 0;$i<sizeof($role)-1;$i++){
        $sql.="AND idRole = ? ";
    }
    $req = $conn->prepare($sql);
    $req->execute($role);
    return $req->fetchall();
}

/**
 * @param $conn PDO
 * @return array|false
 * Return all the idRole that are in the database
 */
function getAllRole($conn){
    $sql = "SELECT * FROM role ";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchall();
}

/**
 * @param $login String id of the user
 * @param $conn PDO connection to a database
 * @return String[]
 *Take as parameters a login for a user and a connection to a database,
 * then return all values that his dashboard contains
 */
function getDashBoardPerUser($login, $conn)
{

    $sql = "SELECT idDashBoard FROM UserDashBoard WHERE login = ?";
    $req = $conn->prepare($sql);
    $params = array($login);
    $req->execute($params);


    $dashBoards = $req->fetchall();
    //get the idDashBoard for a login pass in parameter
    $result = [];
    //get all the value in the database for some idDashBoard
    foreach ($dashBoards as $dashBoard) {
        $result[] = selectDashboardById($conn, $dashBoard["idDashBoard"]);
    }
    return $result;
}

/**
 * @param $login String
 * @param $conn PDO
 * @return mixed
 * this function take in parameter the login of a user and a connection to the database
 * return the user
 */

function getUserWithLogin($login, $conn)
{
    $sql = "SELECT login FROM Utilisateur WHERE login = ?";
    $req = $conn->prepare($sql);
    $params = array($login);
    $req->execute($params); // Pass the parameter as an array
    return $req->fetch();
}

/**
 * @param $conn PDO
 * @param $formation String
 * @return Array[String]
 * return
 */
function getFormationWithConditions($conn, $formation)
{
    $sql = "SELECT * FROM formation WHERE nameFormation LIKE(?)";
    $req = $conn->prepare($sql);
    $params = array($formation);
    $req->execute($params);
    return $req->fetchall();
}

/**
 * @param $conn PDO
 * @param $nameFormation String
 * @return mixed
 * This function will get all the studies of a formation, by using the name of the formation in a sql query
 */
function SelectParcours($conn, $nameFormation){
    $sql = "SELECT Parcours.nameParcours
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
    $req = $conn->prepare("SELECT COUNT(idalert) FROM alert JOIN ALERTUTILISATEUR WHERE login = ? AND remindAT<=CURRENT_DATE and seen= false");
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
    $idRole = $reqObtenirIdRole->fetchColumn();

    $reqObtenirNomRole = $conn->prepare("SELECT nameRole FROM Role WHERE idRole=?");
    $reqObtenirNomRole->execute(array((int)$idRole));
    $result = $reqObtenirNomRole->fetchColumn();

    return $result;
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
}

/**
 * @param $conn PDO
 * @param $idDashBoard Int
 * @return mixed
 * This function pick up all the informations of a dashboard, by using his id
 */
function GetFormationForADashBoard($conn, $idDashBoard){
    $sql = "select * from dashboardparcours where idDashBoard = ?;";
    $req = $conn->prepare($sql);
    $req ->execute(array($idDashBoard));
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

 * @param $conn PDO
 * @return mixed
 * This function get the last dashboard created
 */
function getderniertableau($conn){
    $sql = "SELECT idDashBoard FROM dashboard ORDER BY idDashBoard DESC LIMIT 1;" ;
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchall();


}



/**
 * @param $conn PDO
 * @param $isNotActive boolean
 * @param $isFound boolean
 * @return mixed
 * This function selects all the candidates that are not in active search and have a specific alternance status
 */
function selectCandidatesActives($conn, $isNotActive, $isFound) {
    $sql = "SELECT * FROM infoCandidate 
         WHERE isInActiveSearch = ? AND foundApp = ?";

    $req = $conn->prepare($sql);
    $req->execute(array($isNotActive, $isFound));
    return $req->fetchAll();
}

function selectCandidatesActivesComm($conn) {
    $sql = "SELECT * FROM infoCandidate";

    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchAll();
}


function selectCandidatesActivesByParcours($conn, $parcours, $isNotActive, $isFound) {
    $sql = "SELECT * FROM infoCandidate 
         WHERE isInActiveSearch = ? AND foundApp = ? AND nameParcours = ?";

    $req = $conn->prepare($sql);
    $req->execute(array($isNotActive, $isFound, $parcours));
    return $req->fetchAll();
}

function selectCandidatesActivesByParcoursComm($conn, $parcours) {
    $sql = "SELECT * FROM infoCandidate 
         WHERE nameParcours = ?";

    $req = $conn->prepare($sql);
    $req->execute(array($parcours));
    return $req->fetchAll();
}

/**
 * @param $conn
 * @param $choixFormation
 * @param $isActive
 * @param $isFound
 * @return mixed
 * Request for selection of candidates by training
 */
function selectCandidatesByFormation($conn, $choixFormation, $isActive, $isFound){
    $sql = "SELECT * FROM infoCandidate 
         WHERE nameFormation = ? AND isInActiveSearch = ? AND foundApp = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($choixFormation, $isActive, $isFound));
    return $req->fetchAll();
}

function selectCandidatesByFormationComm($conn, $choixFormation){
    $sql = "SELECT * FROM infoCandidate 
         WHERE nameFormation = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($choixFormation));
    return $req->fetchAll();
}

/**
 * @param $conn
 * @param $choixFormation
 * @param $choixNom
 * @param $isActive
 * @param $isFound
 * @return mixed
 * du nom et de la formation
 * ​
 * 72 / 5 000
 * Résultats de traduction
 * Résultat de traduction
 * Request for selection of candidates based on candidate's name and formation's name
 */
function selectCandidatesByNameAndFormation($conn, $choixFormation, $choixNom, $isActive, $isFound){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND foundApp = ? AND name LIKE ? AND nameFormation = ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $isFound, $choixNomPattern, $choixFormation));
    return $req->fetchAll();
}

function selectCandidatesByNameAndFormationComm($conn, $choixFormation, $choixNom){
    $sql = "SELECT * FROM infoCandidate
                WHERE name LIKE ? AND nameFormation = ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($choixNomPattern, $choixFormation));
    return $req->fetchAll();
}

/**
 * @param $conn PDO
 * @param $choixFormation String
 * @param $parcours String
 * @param $isActive boolean
 * @param $isFound boolean
 * @return mixed
 * This function selects the candidates by using the name of the formation,
 * the name of the study and only if they are in active search and found
 */
function selectCandidateByFormationAndParcours($conn, $choixFormation, $parcours, $isActive, $isFound){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND foundApp = ? AND nameParcours = ? AND nameFormation = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $isFound, $parcours, $choixFormation));
    return $req->fetchAll();
}

function selectCandidateByFormationAndParcoursComm($conn, $choixFormation, $parcours){
    $sql = "SELECT * FROM infoCandidate
                WHERE nameParcours = ? AND nameFormation = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($parcours, $choixFormation));
    return $req->fetchAll();
}

/**
 * @param $conn
 * @param $choixNom
 * @param $isActive
 * @param $isFound
 * @return mixed
 * Query to select candidates based on name
 */
function selectCandidatesByName($conn, $choixNom, $isActive, $isFound){
    $sql = "SELECT * FROM infoCandidate
            WHERE isInActiveSearch = ? AND foundApp = ? AND name LIKE ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $isFound, $choixNomPattern));
    return $req->fetchAll();
}

function selectCandidatesByNameComm($conn, $choixNom){
    $sql = "SELECT * FROM infoCandidate
            WHERE name LIKE ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($choixNomPattern));
    return $req->fetchAll();
}

/**
 * @param $conn PDO
 * @param $parcours String
 * @param $isActive boolean
 * @param $isFound boolean
 * @return mixed
 * This function selects the candidates by using the name of the study and only if they are in active search and found
 */
function selectCandidatesByParcours($conn, $parcours, $isActive, $isFound){
    $sql = "SELECT * FROM infoCandidate
            WHERE isInActiveSearch = ? AND foundApp = ? AND nameParcours = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $isFound, $parcours));
    return $req->fetchAll();
}

function selectCandidatesByParcoursComm($conn, $parcours){
    $sql = "SELECT * FROM infoCandidate
            WHERE nameParcours = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($parcours));
    return $req->fetchAll();
}

/**
 * @param $conn PDO
 * @param $parcours String
 * @param $choixNom String
 * @param $isActive boolean
 * @param $isFound boolean
 * @return mixed
 * This function selects the candidates by using the name of the study,
 * the name of the candidate and only if they are in active search and found
 */
function selectCandidatesByNameAndParcours($conn, $parcours, $choixNom, $isActive, $isFound){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND foundApp = ? AND name LIKE ? AND nameParcours = ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $isFound, $choixNomPattern, $parcours));
    return $req->fetchAll();
}

function selectCandidatesByNameAndParcoursComm($conn, $parcours, $choixNom){
    $sql = "SELECT * FROM infoCandidate
                WHERE name LIKE ? AND nameParcours = ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($choixNomPattern, $parcours));
    return $req->fetchAll();
}

/**
 * @param $conn PDO
 * @param $parcours String
 * @param $choixNom String
 * @param $choixFormation String
 * @param $isActive boolean
 * @param $isFound boolean
 * @return mixed
 * This function selects the candidates by using the name of the formation,
 * the name of the study, the name of the candidate and only if they are in active search and found
 */
function selectCandidatesByNameFormationAndParcours($conn, $parcours, $choixNom, $choixFormation, $isActive, $isFound){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND foundApp = ? AND name LIKE ? AND nameParcours = ? AND nameFormation = ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $isFound, $choixNomPattern, $parcours, $choixFormation));
    return $req->fetchAll();
}

function selectCandidatesByNameFormationAndParcoursComm($conn, $parcours, $choixNom, $choixFormation){
    $sql = "SELECT * FROM infoCandidate
                WHERE name LIKE ? AND nameParcours = ? AND nameFormation = ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($choixNomPattern, $parcours, $choixFormation));
    return $req->fetchAll();
}

/**
 * @param PDO $conn
 * @param array $selectedFormations
 * @param array $selectedParcours
 * @return array
 * This function selects the parcours based on the training and courses selected.
 */
function selectParcoursByFormationsAndParcours($conn, $selectedFormations, $selectedParcours): array
{
    $parcours = [];

    foreach ($selectedFormations as $formation) {
        $parcoursDatas = selectParcours($conn, $formation);

        foreach ($parcoursDatas as $parcoursItem) {
            if (in_array($parcoursItem['nameParcours'], $selectedParcours)) {
                $parcours[] = $parcoursItem;
            }
        }
    }
    return $parcours;
}


/**
 * @param $conn PDO
 * @param $id int
 * @return mixed
 * this function return a candidate by his address pass in parameter with his id
 */
function selectIdAddrByCandidate($conn, $id)
{
    $sql = "
         SELECT idAddr FROM infocandidate ic 
         LEFT JOIN candidateaddress ca ON ic.idCandidate = ca.idCandidate
         WHERE ic.idCandidate = ?
         ";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($id));
    return $stmt->fetchAll();
}
/**
 * @param $conn PDO
 * @param $id int
 * @return mixed
 * this function return candidates by their search zone pass in parameter with his id
 */
function selectIdZoneByCandidate($conn, $id)
{
    $sql = "
         SELECT idZone FROM infocandidate ic 
         LEFT JOIN candidatezone cz ON ic.idCandidate = cz.idCandidate
         WHERE ic.idCandidate = ?
         ";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($id));
    return $stmt->fetchAll();
}

/**
 * @param $conn PDO
 * @param $id int
 * @return mixed
 * return the value form a candidate search with his id
 */
function selectCandidatById($conn, $id)
{
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
    ic.foundApp,
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


/**
 * @param $conn PDO
 * @param $id int
 * @return mixed
 * return the candidate pass in parameter if it's in active search
 */
function isInActiveSearch($conn, $id)
{
    $sql = "Select isInActiveSearch from candidate where idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return $req->fetch();
}

function selectComm($conn,$idCandidate){
    $sql = "Select note,dateCommunication,idmessage,img from communication where idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($idCandidate));
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
    return $req->fetch();
}


function selectCandidatesByFormationWithParcoursWithYear($conn, $name, $formation, $parcours, $yearOfFormation) {
    $sql = "SELECT name, firstname, idCandidate FROM infoCandidate
            WHERE (name LIKE ? OR firstname LIKE ?) AND nameParcours LIKE ? AND yearOfFormation LIKE ? AND nameformation LIKE ?;";
    $req = $conn->prepare($sql);
    $req->execute(array('%'.$name.'%', '%'.$name.'%', '%'.$parcours.'%', '%'.$yearOfFormation.'%', '%'.$formation.'%'));
    return $req->fetchAll();
}

/**
 * @param $conn PDO
 * @param $email String
 * @param $id int
 * @return bool
 * This function check if an email already exist in the database with an id of verification
 */

function isEmailAlreadyExistWithIdVerification($conn, $email, $id): bool {
    $sql = "SELECT * from Candidate WHERE candidateMail = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($email));
    $result = $req->fetch();
    return !empty($result) && $result['idCandidate'] != $id;
}


/**
 * @param $conn PDO
 * @param $phone string
 * @param $id int
 * @return bool
 * This function check if a phone number already exist in the database with an id of verification
 */
function isPhoneNumberAlreadyExistWithIdVerification($conn, $phone, $id): bool
{
    $sql = "SELECT * from Candidate WHERE phoneNumber = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($phone));
    $result = $req->fetch();
    return !empty($result) && $result['idCandidate'] != $id;
}

/**
 * @param $conn PDO
 * @return mixed
 * return all the value in the table formation of the database
 */
function selectAllFormation($conn)
{
    $sql = "SELECT * FROM Formation";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchAll();
}


/**
 * @param $conn PDO
 * @param $INE String
 * @param $id int
 * @return bool
 * Function which tests the presence of the candidate in the database with his INE and with an id of verification
 */
function isCandidateExistWithIneWithIdVerification($conn, $INE, $id): bool
{
    $sql = "SELECT * from Candidate WHERE INE = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($INE));
    $result = $req->fetch();
    return !empty($result) && $result['idCandidate'] != $id;

}








/**
 * @param $id int id of the dashboard
 * @param $conn PDO connection to a database
 * @return String[] the values of the dashboard
 * Take as parameters an ID for a dashboard and a connection to a database,
 * then return the value in the database for the given ID
 */
function selectDashboardById($conn, $id){
    $sql = "
           SELECT * FROM dashboard WHERE idDashboard = ?
           ";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return $req->fetch();
}

/**
 * @param $conn PDO Connection to the database
 * @param $id int Id of the dashboard
 * @return mixed All the courses of the dashboard
 *  Take as parameters an ID for a dashboard and a connection to a database,
 *  then return the courses of the selected dashboard
 */
function selectParcoursOfDashboard($conn, $id){
    $sql = "
           SELECT dp.nameParcours
           FROM dashboard d
           JOIN dashboardparcours dp ON d.idDashBoard = dp.idDashBoard
           JOIN parcours p USING (nameParcours)
           JOIN formation f ON p.nameFormationParcours = f.nameFormation
           WHERE d.idDashboard = ?;
           ";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return $req->fetchAll();
}

/**
 * @param $conn PDO Connection to the database
 * @param $id int Id of the dashboard
 * @return mixed All the formations of the dashboard
 *  Take as parameters an ID for a dashboard and a connection to a database,
 *  then return the formations of a selected dashboard
 */
function selectFormationOfDashboard($conn, $id){
    $sql = "
           SELECT DISTINCT f.nameFormation
           FROM dashboard d
           JOIN dashboardparcours dp ON d.idDashBoard = dp.idDashBoard
           JOIN parcours p USING (nameParcours)
           JOIN formation f ON p.nameFormationParcours = f.nameFormation
           WHERE d.idDashboard = ?;
           ";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return $req->fetchAll();
}

function selectNbStudentPerFormation($conn, $formation){
    $sql = "SELECT effectifFormation, alternants, non_alternants, actifs, inactifs 
            FROM effectif_formation 
            WHERE nameFormationParcours = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($formation));
    return $req->fetch();
}

function selectNbStudentPerParcours($conn, $formation){
    $sql = "SELECT ep.nameParcours, ep.nombreetudiants, ep.alternants, ep.non_alternants, ep.actifs, ep.inactifs
            FROM effectifsparcours ep
            JOIN parcours p USING (nameParcours)
            JOIN formation f ON p.nameFormationParcours = f.nameFormation
            WHERE f.nameFormation = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($formation));
    return $req->fetchAll();
}

/**
 * @param $conn PDO
 * @param $parcours string
 * @return mixed
 * return the number of studiant, alternant, no alternant, actif and no actif for a parcour pass in parameter
 */
function selectParcoursNumber($conn, $parcours){
    $sql = "SELECT * FROM effectifsparcours WHERE nameParcours = ?; ";
    $req = $conn->prepare($sql);
    $req->execute(array($parcours));
    return $req->fetchAll();
}

function countNbStudentFoundApp($conn, $isFound){
    $sql="SELECT COALESCE(count(*),0) as nbFoundApp 
          FROM infocandidate
          WHERE foundApp = ?";
    $req = $conn->prepare($sql);
    $req->execute([$isFound]);
    return $req->fetch();

}

function countNbStudentActives($conn, $isActive){
    $sql="SELECT COALESCE(COUNT(*), 0) AS nbActives
          FROM infocandidate
          WHERE isInActiveSearch = ?";
    $req = $conn->prepare($sql);
    $req->execute([$isActive]);
    return $req->fetch();

}

function countAllStudents($conn){
    $sql="SELECT COALESCE(COUNT(*), 0) AS nbEtu
          FROM effectif_formation;";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetch();
}

function getFormationByLoginUtilisateur($conn,$login){
    $sql = "
            SELECT * FROM formationsutilisateurs WHERE loginutilisateur = ?
            ";
    $req = $conn->prepare($sql);
    $req->execute(array($login));
    return $req->fetchAll();
}

function getFormationOfUser($conn, $login)
{
    $sql = "SELECT formationname FROM formationsutilisateurs WHERE loginutilisateur = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($login));
    return $req->fetchall();
}

function getIdRoleByName($conn,$nameRole){
    $sql = "SELECT idRole FROM role WHERE nameRole = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($nameRole));
    return $req->fetchColumn();
}

function selectCandidatesByParcoursWithYear($conn, $parcours, $yearOfFormation, $isActive)
{
    $sql = "SELECT idCandidate, candidatemail, cv FROM infoCandidate
            WHERE isInActiveSearch = ? AND nameParcours = ? AND yearOfFormation = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $parcours, $yearOfFormation));
    return $req->fetchAll();
}


function selectCandidatesNameByParcoursWithYear($conn, $parcours, $yearOfFormation, $isActive)
{
    $sql = "SELECT idCandidate, name, firstName, typeCompanySearch, cv FROM infoCandidate
            WHERE isInActiveSearch = ? AND nameParcours = ? AND yearOfFormation = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $parcours, $yearOfFormation));
    return $req->fetchAll();
}

function selectCvById($conn, $idCandidate)
{
    $sql = "
           SELECT cv FROM infoCandidate
           WHERE idCandidate = ? 
           ";
    $req = $conn->prepare($sql);
    $req->execute(array($idCandidate));
    return $req->fetchAll();
}






