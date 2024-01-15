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
function getUserWithId($idUser,$conn)
{
    $sql = "SELECT * FROM Utilisateur WHERE login = ?";
    $req = $conn->prepare($sql);
    $req->execute($idUser);
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

/**
 * @param PDO $conn
 * @param array $selectedFormations
 * @param array $selectedParcours
 * @return array
 * This function selects the parcours based on the training and courses selected.
 */
function selectParcoursByFormationsAndParcours($conn, $selectedFormations, $selectedParcours)
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
 * @return mixed
 * this function return all the values form the table Parcours
 */
function allParcours($conn)
{
    $sql = "SELECT Parcours.*
            FROM Parcours
            ";
    $req = $conn->prepare($sql);
    $req->execute();
    $results = $req->fetchAll();
    return $results;
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

/**
 * Function that checks the existence of an email in the database
 * @param $conn : Connection to the database
 * @param $email : candidate's email
 * @return bool
 * This function check if an email is already in the database
 */

function isEmailAlreadyExist($conn, $email): bool
{
    $sql = "SELECT * from Candidate WHERE candidateMail = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($email));
    $result = $req->fetch();
    return !empty($result);
}

/**
 * @param $conn PDO
 * @param $email String
 * @param $id int
 * @return bool
 * This function check if an email already exist in the database with an id of verification
 */
function isEmailAlreadyExistWithIdVerification($conn, $email, $id): bool
{
    $sql = "SELECT * from Candidate WHERE candidateMail = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($email));
    $result = $req->fetch();
    return !empty($result) && $result['idCandidate'] != $id;
}

/**
 * @param $conn PDO
 * @param $phone string
 * @return bool
 * this function check if a phone number already exist in the database
 */
function isPhoneNumberAlreadyExist($conn, $phone): bool
{
    $sql = "SELECT * from Candidate WHERE phoneNumber = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($phone));
    $result = $req->fetch();
    return !empty($result);
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
 * Function which tests the presence of the candidate in the database with his INE
 * @param $conn : database's connection
 * @param $INE : candidate's ine
 * @return bool : return the existence of the result in the database
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
 * Function which tests the presence of the candidate in the database with his last name or first name
 * @param $conn : database's connection
 * @param $name : Candidate's name
 * @param $firstName : Candidate's first name
 * @return bool : return the existence of the result in the database
 */
function isCandidateExistWithNameAndFirstname($conn, $name, $firstName): bool
{
    $sql = "SELECT * from Candidate WHERE name = ? AND firstName = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($name, $firstName));
    $result = $req->fetch();
    return !empty($result);

}

/**
 * @param $conn PDO database's connection
 * @param $mail string
 * @param $login string
 * @return bool|Exception|PDOException
 * check if the mail pass in parameter is the mail of the user pass in parameter
 */
function verfication($conn, $mail, $login)
{
    try {
        $request0 = "Select email,login from utilisateur where email = ? OR login = ?";

        $res = $conn->prepare($request0);
        $res->execute(array($mail, $login));
        if ($res->rowCount() == 0) {
            return false;
        } else {
            return true;
        }
    } catch (PDOException $e) {
        return $e;
    }
}

/**
 * @param $conn PDO
 * @param $mail string
 * @param $login string
 * @return bool|Exception|PDOException
 * return the value that verification return with his parameter
 */
function exist($conn, $mail, $login)
{

    $existence = verfication($conn, $mail, $login);

    return $existence;

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
