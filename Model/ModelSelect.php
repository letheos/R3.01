<?php

/*
function getStudentTest($isActif, $isPermis, $year, $formation, $parcours, $conn, $ine)
{
    if ($isPermis) {
        $sql = "SELECT () FROM candidate join candidateaddress USING(idCandidate) WHERE yearOfFormation =(?) AND isInActiveSearch =(?)  AND permisB =(?)";
    }
    //problème vient quand je mes des conditions
    $sql = "SELECT * FROM candidate join candidateaddress USING(idCandidate) WHERE yearOfFormation =(?) AND isInActiveSearch =(?)  AND permisB =(?)";
    $req = $conn->prepare($sql);
    $params = array($year, $isActif, $isPermis);
    $req->execute($params);
    return $req->fetchall();

}

*/
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

//faire avec condition

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
 * return
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

//TODO faire fonction qui enlève les formations à un dashboard
//TODO faire fonction qui ajoute les formations à un dashboard

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
 * Requête de sélection des candidats par formation
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
 * Requête de sélection des candidats en fonction du nom et de la formation
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
 * Requête de sélection des candidats en fonction du nom
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
 * Cette fonction sélectionne les parcours en fonction des formations et des parcours sélectionnés.
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

function isInActiveSearch($conn, $id)
{
    $sql = "Select isInActiveSearch from candidate where idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return $req->fetch();
}

/**
 * Fonction qui vérifie l'existance d'un email dans la base de donnée
 * @param $conn : Connexion à la bdd
 * @param $email : Email du candidat
 * @return bool Renvoie un boulean contenant le résultat
 */

function isEmailAlreadyExist($conn, $email): bool
{
    $sql = "SELECT * from Candidate WHERE candidateMail = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($email));
    $result = $req->fetch();
    return !empty($result);
}

function isEmailAlreadyExistWithIdVerification($conn, $email, $id): bool
{
    $sql = "SELECT * from Candidate WHERE candidateMail = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($email));
    $result = $req->fetch();
    return !empty($result) && $result['idCandidate'] != $id;
}

function isPhoneNumberAlreadyExist($conn, $phone): bool
{
    $sql = "SELECT * from Candidate WHERE phoneNumber = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($phone));
    $result = $req->fetch();
    return !empty($result);
}

function isPhoneNumberAlreadyExistWithIdVerification($conn, $phone, $id): bool
{
    $sql = "SELECT * from Candidate WHERE phoneNumber = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($phone));
    $result = $req->fetch();
    return !empty($result) && $result['idCandidate'] != $id;
}


function selectAllFormation($conn)
{
    $sql = "SELECT * FROM Formation";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchAll();
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

function isCandidateExistWithIneWithIdVerification($conn, $INE, $id): bool
{
    $sql = "SELECT * from Candidate WHERE INE = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($INE));
    $result = $req->fetch();
    return !empty($result) && $result['idCandidate'] != $id;

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
    $req->execute(array($name, $firstName));
    $result = $req->fetch();
    return !empty($result);

}


function verfication($conn, $mail, $login)
{
    //on vérifie que la personne existe bien dans l'adresse
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

function exist($conn, $mail, $login)
{

    $existence = verfication($conn, $mail, $login);
    //$existence = verfication($conn,$_POST['email'],$_POST['login']);
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
