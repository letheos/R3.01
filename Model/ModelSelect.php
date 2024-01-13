<?php
/**
 * @param $isActif bool
 * @param $isPermis bool
 * @param $year string
 * @param $formation string
 * @param $parcours string
 * @param $conn PDO
 * @param $ine bool
 * @param $address bool
 * @param $phone bool
 * @return String[]
 * this function do a request that can change if some param change like $ine, $address and $phone
 * return the result of the request
 */
function getStudentsWithConditions( $isPermis, $year, $formation, $parcours, $conn, $ine, $address, $phone): array
{

    if($year == "allYears"){

        $fin = " FROM infocandidate  WHERE permisB =(?)";

    } else{
        $fin = " FROM infocandidate  WHERE yearOfFormation =(?) AND permisB =(?)";
    }
    $deb = "SELECT name,firstName,nameFormation,nameParcours,yearOfFormation,isInActiveSearch";

    if ($ine) {
        //if the bool value $ine is true add INE in the SELECT
        $deb .= ",INE";
    }
    if ($address) {
        //if the bool value $address is true add AddressesIDs in the SELECT
        $deb .= ",AddressesIDs";
    }
    if ($phone) {
        //if the bool value $phone is true add phoneNumber in the SELECT
        $deb .= ",phoneNumber";
    }
    if ($formation != "allFormations") {
        //if the bool value $formation is true add nameFormation in the WHERE
        $fin .= " AND nameFormation = (?)";
    }
    if ($parcours != "allParcours") {
        //if the bool value $parcours is true add nameParcours in the WHERE
        $fin .= " AND nameParcours = (?)";
    }
    $sql = $deb .= $fin;
    if($year == "allYears"){
        return getStudentsWithoutYears($isPermis,$formation,$parcours,$conn,$sql);

    }
    echo $sql;
    //return $test;
    $req = $conn->prepare($sql);
    if ($parcours == "allParcours" && $formation == "allFormations") {
        //if $parcours has the value allParcours and $formation has the value allFormations
        //do the request

        $params = array($year, $isPermis);
        $req->execute($params);
        return $req->fetchall();
    }

    if ($parcours == "allParcours" && $formation != "allFormations") {
        //if $parcours has the value allParcours and $formation hasn't the value allFormations
        //do the request
        $params = array($year, $isPermis, $formation);
        $req->execute($params);
        return $req->fetchall();

    }
    if  ($parcours != "allParcours" && $formation == "allFormations") {
        //if $parcours hasn't the value allParcours and $formation has the value allFormations
        //do the request
        $params = array($year, $isPermis, $parcours);
        $req->execute($params);
        return $req->fetchall();

    } else{
        $params = array($year, $isPermis, $formation, $parcours);
        $req->execute($params);
        return $req->fetchall();
    }

}
/**
 * @param $isPermis bool
 * @param $formation string
 * @param $parcours string
 * @param $conn PDO
 * @param $sql string
 * @return string[]
 * this function is use by getStudentsWithConditions when $year == allYears,
 * take in parameters all the values and the request sql
 * return the result of the request
 */
function getStudentsWithoutYears( $isPermis, $formation, $parcours, $conn,$sql)
{
    echo '<script>alert("e")</script>';
    $req = $conn->prepare($sql);
    if ($parcours == "allParcours" && $formation == "allFormations") {
        //if $parcours has the value allParcours and $formation has the value allFormations
        //do the request

        $params = array($isPermis);
        $req->execute($params);
        return $req->fetchall();
    }
    if ($parcours != "allParcours" && $formation != "allFormations") {
        //if $parcours hasn't the value allParcours and $formation hasn't the value allFormations
        //do the request

        $params = array( $isPermis, $formation, $parcours);
        echo "<br>";

        $req->execute($params);
        return $req->fetchall();

    }
    if ($parcours == "allParcours" && $formation != "allFormations") {
        //if $parcours has the value allParcours and $formation hasn't the value allFormations
        //do the request
        $params = array($isPermis, $formation);
        $req->execute($params);
        return $req->fetchall();

    }
    if ($parcours != "allParcours" && $formation == "allFormations") {
        //if $parcours hasn't the value allParcours and $formation has the value allFormations
        //do the request
        $params = array( $isPermis, $parcours);
        $req->execute($params);
        return $req->fetchall();

    }
    $tableau = ["Élément 1", "Élément 2", "Élément 3", "Élément 4", "Élément 5", "Élément 6"];

    return $tableau;
}
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
 * @param $role int
 * @return array|false
 * get the login for all the user with an id give
 */
function getAllPeopleWithRole($conn, $role){
    $sql = "SELECT login FROM utilisateur where idRole = ? ";
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
 * @param $id int id of the dashboard
 * @param $conn PDO connection to a database
 * @return String[] the values of the dashboard
 * Take as parameters an ID for a dashboard and a connection to a database,
 * then return the value in the database for the given ID
 */
function getDashBoardPerId($id, $conn)
{
    $sql = "SELECT * FROM DashBoard WHERE idDashBoard = ?";
    $req = $conn->prepare($sql);
    $req->execute([$id]);
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
    $result = array();
    $idDashBoard = array();
    //get all the value in the database for some idDashBoard
    foreach ($dashBoards as $id) {
        //print_r($id);
        Array_push($idDashBoard, $id[0]);
        Array_push($result, getDashBoardPerId($id[0], $conn));
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
 * @param $conn
 * @param $nameFormation
 * @return mixed
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
function GetFormationForADashBoard($conn, $idDashBoard){
    $sql = "select * from dashboardparcours where idDashBoard = ?;";
    $req = $conn->prepare($sql);
    $req ->execute(array($idDashBoard));
    return $req->fetchAll();
}

function getderniertableau($conn){
    $sql = "SELECT idDashBoard FROM dashboard ORDER BY idDashBoard DESC LIMIT 1;" ;
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchall();


}

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

