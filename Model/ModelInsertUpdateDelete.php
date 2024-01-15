<?php
//TODO faire fonction qui enlève les formations à un dashboard
//TODO faire fonction qui ajoute les formations à un dashboard
//TODO faire implémenté les année des étudiants et les ajoutés
//TODO si on crée un dashboard faire des fonction qui récupère le last insert id
//TODO fonction qui ajoute un dashboard a un utilisateur
//TODO fonction qui ajoute un dashboard a des utilisateur pour un role donner


//userdashboard bon insertNewUserDashBoard
//create dashbaord  insertNewDashBoard
// ajout un dashboard a des utilisateur insertDashboardForUser avec un idDashbaord et des login


/**
 * @param $nameDashboard string
 * @param $isPermis boolean
 * @param $isIne boolean
 * @param $isAddress boolean
 * @param $isPhone boolean
 * @param $conn PDO //the connection at the database
 * @return null
 * this funtion insert à new dashboard in the database then a second function add it to the users
 */
function insertNewDashBoard($nameDashboard ,$isPermis, $isIne, $isAddress, $isPhone, $conn)
{
    $sql = "INSERT INTO dashBoard (nameOfDashBoard, isPermis,isIne, isAddress, isPhone) VALUES(?,?,?,?,?);";
    $req = $conn->prepare($sql);
    $params = array($nameDashboard ,$isPermis, $isIne, $isAddress, $isPhone);
    $req->execute($params);
    return $conn->lastInsertId();
}

/**
 * @param $login string
 * @param $idDashBoard int
 * @param $conn
 * @return void
 * add a dashboard give in parameter with his id to a user give in parameter also
 */
function insertNewUserDashBoard($login, $idDashBoard, $conn)
{
    $sql = " INSERT INTO userdashboard(idDashBoard,login) VALUES(?,?); ";
    $req = $conn->prepare($sql);
    $req->execute(array($idDashBoard,$login));
}

/**
 * @param $idRole int
 * @param $idDashboard int
 * @param $conn PDO
 * @return void
 * add the dashboard give in parameter for all the users that have the role give in parameter
 */
function insertDashboardForRole($idRole,$idDashboard,$conn){
    $peoples = getAllPeopleWithRole($conn,$idRole);
    insertDashboardForUser($conn,$peoples,$idDashboard);
}

/**
 * @param $idDashBoard int
 * @param $conn PDO
 * @return string|void
 * take in parameter a login and an id of a dashBoard and a connection to a database
 * delete the dashboard in teh table dashboard
 */
function deleteDashBoard($idDashBoard, $conn)
{
    try {
        $sql = "DELETE FROM dashBoard WHERE idTableauDeBord = ?;";
        $req = $conn->prepare($sql);
        $req->execute($idDashBoard);
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

/**
 * @param $login String //get with the session
 * @param $idDashBoard int // get with a select
 * @param $conn PDO //connection to the database
 * @return string|void
 * take in parameter a login and an id of a dashBoard and a connection to a database
 * delete the dashboard in the table userDashBoard
 */
function deleteUserDashBoard($login, $idDashBoard, $conn)
{

    try {
        $sql = "DELETE FROM userdashboard WHERE idDashBoard = ? AND login = ?";
        $req = $conn->prepare($sql);
        $req->execute(array($idDashBoard, $login));

        header('location:../Controller/ControllerAfficheTableau.php');


    } catch (PDOException $e) {
        return $e->getMessage();
    }
}



/**
 * @param $conn PDO
 * @return mixed
 * Get the id of the last dashboard insert in the database
 */
function getLastIdDashBoard($conn)
{
    $sql = "SELECT idDashBoard FROM DashBoard WHERE id = LAST_INSERT_ID()";
    $req = $conn->prepare($sql);
    return $req->execute();
}

/**
 * @param $conn PDO
 * @return mixed
 * This function get all the dashboards that hasn't own by someone
 */
function crumbCollector($conn)
{
    $sql = "SELECT dashboard.idDashBoard FROM dashboard LEFT JOIN userdashboard ON dashboard.idDashBoard = userdashboard.idDashBoard WHERE userdashboard.idDashBoard IS NULL;";
    $req = $conn->prepare($sql);
    $req->execute();
    return null;
}


/**
 * @param $conn PDO
 * @return void
 * This function delete all the dashboard when they own to nobody
 */
function deleteAllOldDashBoard($conn)
{
    $idOldDashBoard = crumbCollector($conn);
    if (empty($idOldDashBoard)) {
        return null;
    }
    foreach ($idOldDashBoard as $id) {
        //enleve les formation
        deleteFormationDashboard($id, $conn);
        deleteDashBoard($id, $conn);
    }
}

/**
 * @param $idDashBoard int
 * @param $conn PDO
 * @return void
 * This function delete the formations of a dashboard
 */
function deleteFormationDashboard($idDashBoard, $conn)
{
    $sql = "DELETE FROM dashboardparcours where idDashBoard = ? ; ";
    $req = $conn->prepare($sql);
    //problème au paramètre en puissance
    $req->execute($idDashBoard);

}

/**
 * @param $conn PDO
 * @param $idDashBoard int
 * @param $login String
 * @return void
 */
function addDashBoardForUser($conn, $idDashBoard, $login){
    $sql = "INSERT INTO userdashboard(idDashBoard,login) values(?,?)";
    $req = $conn->prepare($sql);
    $req->execute(Array($idDashBoard,$login));
}
/**
 * @param $conn PDO
 * @param $loginsUsers Array
 * @param $idDashBoard int
 * @return void
 * add for all the user in the array $loginsUsers the dashboard that have the id $idDashBoard
 */
function insertDashboardForUsers($conn, $loginsUsers, $idDashBoard){
    foreach ($loginsUsers as $login){
        addDashBoardForUser($conn,$idDashBoard,$login);
    }
}

/**
 * @param $idDashboard int
 * @param $conn PDO
 * @return void
 * Delete all the parcours of a dashboard
 */
function suprAllParcourDashboard($idDashboard,$conn){
    $sql = "DELETE FROM dashboardparcours WHERE idDashBoard = ?";
    $req = $conn ->prepare($sql);
    $req -> execute(array($idDashboard));
}

/**
 * @param $selectedParcours Array
 * @param $idDashBard int
 * @param $conn PDO
 * @return void
 * Add all the parcours that are in selectedParcours
 */
function UpdateParcoursDashBoard($selectedParcours,$idDashBard,$year,$conn){
    //remove all the formation of a dashboard
    suprAllParcourDashboard($idDashBard, $conn);
    //for each parcours add it to the dashboard
    foreach ($selectedParcours as $parcour){
        addParcourDashboard($idDashBard,$parcour,$year,$conn);
    }
}

/**
 * @param $parcours string
 * @param $idDashBard int
 * @param $conn PDO
 * @return bool
 * Check if a dashboard have a formation
 */
function aDejaLeParcours($parcours,$idDashBard,$conn){
    $sql ="SELECT * FROM dashboardparcours where idDashBoard = ? and nameParcours = ?;";
    $req = $conn ->prepare($sql);
    $req -> execute(array($idDashBard, $parcours));
    $result = $req->fetch();
    if(empty($result)){
        return false;
    } else{
        return true;
    }

}

/**
 * @param $idDashbaord int
 * @param $parcour String
 * @param $conn PDO
 * @return void
 * Add a formation give in parameter and a year give to a dashboard
 */
function addParcourDashboard($idDashbaord,$parcour,$year,$conn){
    $sql = "INSERT INTO dashboardparcours(idDashBoard,nameParcours,yearOfFormation) VALUES(?,?,?)";
    $req = $conn->prepare($sql);
    $req-> execute(array($idDashbaord,$parcour,$year));
}

/**
 * @param $parcour String
 * @param $conn PDO
 * @return void
 * Add a formation for a new dashboard
 */
function addFormationNewDashboard($parcour,$conn,$idDashBoard){

    $sql = "INSERT INTO dashboardParcours(idDashBoard,nameParcours,yearOfFormation) VALUES(?,?,'1er')";
    $req = $conn->prepare($sql);
    $req-> execute(array($idDashBoard,$parcour));
}

/**
 * @param $name String
 * @param $isPermis bool
 * @param $isIne bool
 * @param $isAddress bool
 * @param $isPhone bool
 * @param $idDashBoard int
 * @param $conn PDO
 * @return void
 * change the value of a dashboard's information with his id give in parameter
 */
function upadteParametreDashBoard(string $name, bool $isPermis, bool $isIne, bool $isAddress, bool $isPhone, int $idDashBoard, PDO $conn){
    $sql = "UPDATE dashboard
            SET nameOfDashBoard = ?, isPermis = ?, isIne = ?, isAddress = ?, isPhone = ?
            WHERE idDashBoard = ?";
    if($isPermis){
        $isPermis = 1;
    } else{
        $isPermis = 0;
    } if($isIne){
        $isIne = 1;
    } else{
        $isIne = 0;
    }if($isAddress){
        $isAddress = 1;
    } else{
        $isAddress = 0;
    }if($isPhone){
        $isPhone = 1;
    } else{
        $isPhone = 0;
    }
    $req = $conn->prepare($sql);
    return $req->execute(array($name,$isPermis,$isIne,$isAddress,$isPhone,$idDashBoard));


}


function setEtatTrue($conn, $id)
{
    $sql = "UPDATE Candidate SET isInActiveSearch = 1 WHERE idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return true;
}


function setEtatFalse($conn, $id)
{
    $sql = "UPDATE Candidate SET isInActiveSearch = 0 WHERE idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return true;

}

function setAppTrue($conn, $id)
{
    $sql = "UPDATE Candidate SET foundApp = 1 WHERE idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return true;
}

function setAppFalse($conn, $id)
{
    $sql = "UPDATE Candidate SET foundApp = 0 WHERE idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return true;
}

function deleteCandidate($conn, $id)
{
    $sqlReq1 = "DELETE FROM CandidateAddress WHERE idCandidate = ?"; //Suppression des adresses
    $sqlReq2 = "DELETE FROM CandidateZone WHERE idCandidate = ?"; //Suppression des Zones
    $sqlReq3 = "DELETE FROM Candidate WHERE idCandidate = ?"; //Suppression des autres information candidats

    //Activation de la requête supression des adresses
    $sqlReq1 = $conn->prepare($sqlReq1);
    $sqlReq1->execute(array($id));

    //Activation de la requête supression des zones de recherche
    $sqlReq2 = $conn->prepare($sqlReq2);
    $sqlReq2->execute(array($id));

    //Activation de la requête supression du candidat
    $sqlReq3 = $conn->prepare($sqlReq3);
    $sqlReq3->execute(array($id));
}

/**
 * Fonction insérant les addresses du candidat
 * @param $conn : Connexion à la bdd
 * @param $idCandidate : Le candidat
 * @param $cp : Le code postal
 * @param $addr : Le libellé de l'adresse
 * @param $city : La ville
 * @return void
 */
function insertAddr($conn, $idCandidate, $cp, $addr, $city)
{
    $sql = "INSERT INTO CandidateAddress (idCandidate, cp, addressLabel, city) VALUES (?,?,?,?)";
    $req = $conn->prepare($sql);
    $req->execute(array($idCandidate, $cp, $addr, $city));
}

/**
 * Fonction d'insertion des zones de recherches
 * @param $conn : Connection à la bdd
 * @param $idCandidate : Le candidat
 * @param $searchCity : La ville de recherche
 * @param $radius : Le rayon de recherche
 * @return void
 */
function insertSearchZone($conn, $idCandidate, $searchCity, $radius)
{
    $sql = "INSERT INTO CandidateZone (idCandidate, cityName, radius) VALUES (?,?,?)";
    $req = $conn->prepare($sql);
    $req->execute(array($idCandidate, $searchCity, $radius));
}

/**
 * Insère toute les informations du candidat dans la bdd
 * @param $conn : Connection à la bdd
 * @param $INE : INE du candidat
 * @param $name : Nom du candidat
 * @param $firstName : Prenom du candidat
 * @param $yearOfFormation : Année de formation
 * @param $nameFormation : La Formation du candidat
 * @param $nameParcours : Le nom du Parcours
 * @param $permisB : Le permis
 * @param $typeCompanySearch : Le type d'entreprise recherché
 * @param $adresses : Les adresses du candidat
 * @param $searchZone : Les zones de recherches du candidats
 * @return void
 */
function insertCandidate($conn, $INE, $name, $firstName, $yearOfFormation, $email, $phoneNumber, $nameParcours, $permisB, $typeCompanySearch, $remark, $adresses, $searchZone, $cvPath)
{
    $sql = "INSERT INTO Candidate (INE, name, firstName,  candidateMail, phoneNumber, nameParcours, yearOfFormation, isInActiveSearch, permisB, typeCompanySearch, cv, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?)";
    $req = $conn->prepare($sql);
    $req->execute(array($INE, $name, $firstName, $email, $phoneNumber, $nameParcours, $yearOfFormation, $permisB, $typeCompanySearch, $cvPath, $remark));
    $idCandidate = $conn->lastInsertId();


    foreach ($adresses as $adressData) {
        $cp = $adressData['CP'];
        $addr = $adressData['Address'];
        $city = $adressData['City'];
        insertAddr($conn, $idCandidate, $cp, $addr, $city);

    }

    foreach ($searchZone as $zone) {
        $search = $zone["cityName"];
        $radius = $zone["radius"];
        insertSearchZone($conn, $idCandidate, $search, $radius);

    }
}

function updateAddr($conn, $idAddr, $cp, $addr, $city)
{
    $sql = "UPDATE CandidateAddress SET cp = ?, addressLabel = ?, city = ? WHERE idAddr = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($cp, $addr, $city, $idAddr));
}

function updateZone($conn, $idZone, $city, $radius)
{
    $sql = "UPDATE CandidateZone SET cityName = ?, radius = ? WHERE idZone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($city, $radius, $idZone));
}

function updateNameCandidate($conn, $id, $name)
{
    $sql = "UPDATE Candidate SET name = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($name, $id));
    return true;
}

function updateFirstNameCandidate($conn, $id, $firstName)
{
    $sql = "UPDATE Candidate SET firstName = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($firstName, $id));
    return true;
}

function updateMailCandidate($conn, $id, $candidateMail)
{
    $sql = "UPDATE Candidate SET candidateMail = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($candidateMail, $id));
    return true;
}


function updatePhoneNumberCandidate($conn, $id, $phone)
{
    $sql = "UPDATE Candidate SET phoneNumber = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($phone, $id));
    return true;
}

function updateParcoursCandidate($conn, $id, $parcours)
{
    $sql = "UPDATE Candidate SET nameParcours = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($parcours, $id));
    return true;
}

function updateYearOfFormationCandidate($conn, $id, $yearOfFormation)
{
    $sql = "UPDATE Candidate SET yearOfFormation = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($yearOfFormation, $id));
    return true;
}

function updateDriverLicenceCandidate($conn, $id, $driverLicence)
{
    $sql = "UPDATE Candidate SET yearOfFormation = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($driverLicence, $id));
    return true;
}


function updateTextAreaCandidate($conn, $id, $textArea)
{
    $sql = "UPDATE Candidate SET typeCompanySearch = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($textArea, $id));
    return true;
}

function updateRemarksCandidate($conn, $id, $remarks)
{
    $sql = "UPDATE Candidate SET remarks = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($remarks, $id));
    return true;
}

function updateIneCandidate($conn, $id, $ine)
{
    $sql = "UPDATE Candidate SET INE = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($ine, $id));
    return true;
}

function updateCVCandidate($conn, $id, $cvPath)
{
    $sql = "UPDATE Candidate SET cv = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($cvPath, $id));
    return true;
}


function deleteAddr($conn, $idAddr)
{
    $sql = "DELETE FROM candidateaddress WHERE idAddr = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($idAddr));
    return true;
}

function deleteZone($conn, $idZone)
{
    $sql = "DELETE FROM candidatezone WHERE idZone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($idZone));
    return true;
}

function addbdd($conn, $pswrd, $lastname, $firstname, $email, $login, $role, $formation)
{


    $requete = "Insert into utilisateur VALUES (?,?,?,?,?,?,?,?,?)";
    $res = $conn->prepare($requete);
    $newpswrd = password_hash($pswrd, PASSWORD_DEFAULT);

    try {
        $res->execute(array($login, $newpswrd, $firstname, $lastname, $role, $formation, $email, null, null));

    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    return $res;
}




