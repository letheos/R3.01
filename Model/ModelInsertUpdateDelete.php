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
 * @param $isHeadcount boolean
 * @param $conn PDO //the connection at the database
 * @return null
 * this funtion insert à new dashboard in the database then a second function add it to the users
 */
function insertNewDashBoard($nameDashboard ,$isPermis, $isIne, $isAddress, $isPhone, $isHeadcount, $conn)
{
    $sql = "INSERT INTO dashBoard (nameOfDashBoard, isPermis,isIne, isAddress, isPhone, isHeadcount) VALUES(?,?,?,?,?,?);";
    $req = $conn->prepare($sql);
    $params = array($nameDashboard ,$isPermis, $isIne, $isAddress, $isPhone, $isHeadcount);
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
        $sql = "DELETE FROM dashBoard WHERE idDashBoard = ?;";
        $req = $conn->prepare($sql);
        $req->execute(array($idDashBoard));
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
    return $req->fetchAll();
}


/**
 * @param $conn PDO
 * @return void
 * This function delete all the dashboard when they own to nobody
 */
function deleteAllOldDashBoard($conn)
{
    $idOldDashBoard = crumbCollector($conn);
    //get all the id's dashbaord that nobody own
    if (empty($idOldDashBoard)) {
        return null;
    }
    foreach ($idOldDashBoard as $id) {
        //if it has at least one formation connect to it, remove it
        if(hasParcours($id['idDashBoard'], $conn)){
            suprAllParcourDashboard($id['idDashBoard'], $conn);
        }
        //delete it
        deleteDashBoard($id['idDashBoard'], $conn);
    }
}

/**
 * @param $idDashbaord
 * @param $conn
 * @return bool
 * This function return true if the dashbaord pass in parameter has at least one parcours connect at it
 */
function hasParcours($idDashbaord,$conn){
    $sql = "SELECT COUNT(nameParcours) FROM dashboardparcours WHERE idDashBoard = ? GROUP BY idDashBoard";
    $req = $conn->prepare($sql);
    $req->execute(array($idDashbaord));
    if($req->fetchAll() > 0){
        return true;}
    else{
        return false;
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

    $sql = "INSERT INTO dashboardparcours(idDashBoard,nameParcours,yearOfFormation) VALUES(?,?,'1er')";
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
 * @param $isHeadcount bool
 * @return void
 * change the value of a dashboard's information with his id give in parameter
 */
function upadteParametreDashBoard(string $name, bool $isPermis, bool $isIne, bool $isAddress, bool $isPhone, int $idDashBoard, PDO $conn, bool $isHeadcount){
    $sql = "UPDATE dashboard
            SET nameOfDashBoard = ?, isPermis = ?, isIne = ?, isAddress = ?, isPhone = ?, isHeadcount = ?
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
    } if($isHeadcount){
        $isHeadcount = 1;
    } else{
        $isHeadcount = 0;
    }
    $req = $conn->prepare($sql);
    return $req->execute(array($name,$isPermis,$isIne,$isAddress,$isPhone,$isHeadcount,$idDashBoard));


}

/**
 * @param $conn PDO
 * @param $id int
 * @return true
 * set the state of candidate to true
 */
function setEtatTrue($conn, $id)
{
    $sql = "UPDATE Candidate SET isInActiveSearch = 1 WHERE idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return true;
}

/**
 * @param $conn PDO
 * @param $id int
 * @return false
 * set the state of candidate to false
 */
function setEtatFalse($conn, $id)
{
    $sql = "UPDATE Candidate SET isInActiveSearch = 0 WHERE idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return true;

}

/**
 * @param $conn
 * @param $id
 * @return true
 * Set the state about the apprenticeship to True
 */
function setAppTrue($conn, $id)
{
    $sql = "UPDATE Candidate SET isInActiveSearch = 0, foundApp = 1 WHERE idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return true;
}

/**
 * @param $conn
 * @param $id
 * @return true
 * Set the state about the apprenticeship to False
 */
function setAppFalse($conn, $id)
{
    $sql = "UPDATE Candidate SET isInActiveSearch = 1, foundApp = 0 WHERE idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return true;
}

/**
 * @param $conn PDO
 * @param $id int
 * @return void
 * this function take in parameter a PDO connexion and an id of a candidate then remove it and all the values link to him
 */
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

 * @param $conn : Connection to the database
 * @param $idCandidate : The id of the candidate
 * @param $cp : Postal code
 * @param $addr : The address
 * @param $city : The city
 * @return void
 * Function that insert the addresses of a candidate
 */
function insertAddr($conn, $idCandidate, $cp, $addr, $city)
{
    $sql = "INSERT INTO CandidateAddress (idCandidate, cp, addressLabel, city) VALUES (?,?,?,?)";
    $req = $conn->prepare($sql);
    $req->execute(array($idCandidate, $cp, $addr, $city));
}

/**
 * @param $conn : Connection to the database
 * @param $idCandidate : Id of the candidate
 * @param $searchCity : City of search
 * @param $radius : Radius of search
 * @return void
 * Search zone insertion function
 */
function insertSearchZone($conn, $idCandidate, $searchCity, $radius)
{
    $sql = "INSERT INTO CandidateZone (idCandidate, cityName, radius) VALUES (?,?,?)";
    $req = $conn->prepare($sql);
    $req->execute(array($idCandidate, $searchCity, $radius));
}

/**
 * Insert all the candidate's information in the database
 * @param $conn : Connection à la bdd
 * @param $INE : Ine of the candidate
 * @param $name : Name of the candidate
 * @param $firstName : Firstname of the candidate
 * @param $yearOfFormation : Year of formation
 * @param $nameFormation : Formation of the candidate
 * @param $nameParcours : Name of the courses
 * @param $permisB : Driver license
 * @param $typeCompanySearch : Type of company
 * @param $adresses : Addresses of the candidate
 * @param $searchZone : Search zone of the candidate
 * @return void
 */
function insertCandidate($conn, $INE, $name, $firstName, $yearOfFormation, $email, $phoneNumber, $nameParcours, $permisB, $typeCompanySearch, $remark, $adresses, $searchZone, $cvPath)
{
    $sql = "INSERT INTO Candidate (INE, name, firstName,  candidateMail, phoneNumber, nameParcours, yearOfFormation, isInActiveSearch, permisB, typeCompanySearch, cv, remarks, foundApp) VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?, 0)";
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

/**
 * @param $conn PDO
 * @param $idAddr int
 * @param $cp int
 * @param $addr string
 * @param $city string
 * @return void
 * This function take in parameter a PDO connection to a database, an id of an address, a postal code and an address
 * then update the value of the postal code, city and address to the address already gave by his id.
 */
function updateAddr($conn, $idAddr, $cp, $addr, $city)
{
    $sql = "UPDATE CandidateAddress SET cp = ?, addressLabel = ?, city = ? WHERE idAddr = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($cp, $addr, $city, $idAddr));
}

/**
 * @param $conn
 * @param $idZone
 * @param $city
 * @param $radius
 * @return void
 *  This function take in parameter a PDO connexion to a database, an id of an address, a postal code and an address
 *  then update the value of the postal code, city and address to the address already gave by his id.
 */
function updateZone($conn, $idZone, $city, $radius)
{
    $sql = "UPDATE CandidateZone SET cityName = ?, radius = ? WHERE idZone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($city, $radius, $idZone));
}

/**
 * @param $conn
 * @param $id int
 * @param $name String
 * @return true
 * this function update the name of a candidate with his id give in parameter with a string pass in parameter
 */
function updateNameCandidate($conn, $id, $name)
{
    $sql = "UPDATE Candidate SET name = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($name, $id));
    return true;
}

/**
 * @param $conn
 * @param $id
 * @param $firstName
 * @return true
 * this function update the first name of a candidate using his id,gave in parameter with a string pass in parameter
 */
function updateFirstNameCandidate($conn, $id, $firstName)
{
    $sql = "UPDATE Candidate SET firstName = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($firstName, $id));
    return true;
}

/**
 * @param $conn PDO
 * @param $id int
 * @param $candidateMail string
 * @return true
 * Change the mail of a candidate
 */
function updateMailCandidate($conn, $id, $candidateMail)
{
    $sql = "UPDATE Candidate SET candidateMail = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($candidateMail, $id));
    return true;
}

/**
 * @param $conn PDO
 * @param $id int
 * @param $phone string
 * @return true
 * Change the phone number of a candidate
 */
function updatePhoneNumberCandidate($conn, $id, $phone)
{
    $sql = "UPDATE Candidate SET phoneNumber = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($phone, $id));
    return true;
}

/**
 * @param $conn PDO
 * @param $id int
 * @param $parcours string
 * @return true
 * Change the parcours of a candidate
 */
function updateParcoursCandidate($conn, $id, $parcours)
{
    $sql = "UPDATE Candidate SET nameParcours = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($parcours, $id));
    return true;
}

/**
 * @param $conn
 * @param $id
 * @param $yearOfFormation
 * @return true
 * Change the year of formation that a candidate have
 * exemple: michel robert 1st year -> michel robert 2nd year
 */
function updateYearOfFormationCandidate($conn, $id, $yearOfFormation)
{
    $sql = "UPDATE Candidate SET yearOfFormation = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($yearOfFormation, $id));
    return true;
}

/**
 * @param $conn PDO
 * @param $id int
 * @param $driverLicence bool
 * @return true
 * Set the boolean permisB has true or false as the value $driverLicence
 */
function updateDriverLicenceCandidate($conn, $id, $driverLicence)
{
    $sql = "UPDATE Candidate SET permisB = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($driverLicence, $id));
    return true;
}

/**
 * @param $conn PDO
 * @param $id int
 * @param $textArea string
 * @return true
 * Change the type of company that a candidate search with a string value
 */
function updateTextAreaCandidate($conn, $id, $textArea)
{
    $sql = "UPDATE Candidate SET typeCompanySearch = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($textArea, $id));
    return true;
}

/**
 * @param $conn PDO
 * @param $id int
 * @param $remarks String
 * @return true
 * Update the remarks that a candidate have
 */
function updateRemarksCandidate($conn, $id, $remarks)
{
    $sql = "UPDATE Candidate SET remarks = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($remarks, $id));
    return true;
}

/**
 * @param $conn PDO
 * @param $id int
 * @param $ine String
 * @return true
 * Update the INE that a candidate have with a new value pass in parameter
 */
function updateIneCandidate($conn, $id, $ine)
{
    $sql = "UPDATE Candidate SET INE = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($ine, $id));
    return true;
}

/**
 * @param $conn PDO
 * @param $login String
 * @param $formations Array
 * @return void
 * This function insert all the formations with th correct login
 */
function addrolesbdd($conn,$login,$formations)
{
    $requete = "Insert into formationsutilisateurs values (?,?)";
    $res = $conn->prepare($requete);
    try{
        for ($x = 0; $x < count($formations); $x++) {
            $res->execute(array($login, $formations[$x]));
        }}
    catch (Exception $e) {
        echo '<script>
            alert("Veuillez vous reconnecter");
            window.location.href = "../Controller/logout.php";
            </script>';
    }
}


/**
 * @param $conn PDO
 * @param $id int
 * @param $cvPath String
 * @return true
 * Change the path that represent his cv in the database by a new path pass in parameter
 */
function updateCVCandidate($conn, $id, $cvPath)
{
    $sql = "UPDATE Candidate SET cv = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($cvPath, $id));
    return true;
}

/**
 * @param $conn PDO
 * @param $idAddr int
 * @return true
 * Delete a candidateaddress in database with his id.
 */
function deleteAddr($conn, $idAddr)
{
    $sql = "DELETE FROM candidateaddress WHERE idAddr = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($idAddr));
    return true;
}

/**
 * @param $conn PDO
 * @param $idZone int
 * @return true
 * Delete a candidatezone in database with his id.
 */
function deleteZone($conn, $idZone)
{
    $sql = "DELETE FROM candidatezone WHERE idZone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($idZone));
    return true;
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

function modifLastName($conn,$login,$lastName){
    $req = $conn->prepare("UPDATE Utilisateur SET userName = ? WHERE login = ?");
    $req->execute(array($lastName,$login));
}

function modifFirstName($conn,$login,$firstName){
    $req = $conn->prepare("UPDATE Utilisateur SET firstName = ? WHERE login = ?");
    $req->execute(array($firstName,$login));
}

function modifLogin($conn,$oldLogin,$newLogin){
    $req = $conn->prepare("UPDATE formationsutilisateurs SET loginutilisateur = ? WHERE loginutilisateur = ?");
    $req->execute(array($newLogin,$oldLogin));
}

function modifLoginDashboard($conn,$oldLogin,$newLogin){
    $req = $conn->prepare("UPDATE userdashboard SET login = ? WHERE login = ?");
    $req->execute(array($newLogin,$oldLogin));
}

function deleteUserByLogin($conn,$login){
    $req = $conn->prepare("DELETE FROM utilisateur WHERE login = ?");
    $req->execute(array($login));
}

function modifEmail($conn,$login,$mail)
{
    $req = $conn->prepare("UPDATE Utilisateur SET email = ? WHERE login = ?");
    $req->execute(array($mail, $login));
}
/**
 * @param PDO $conn   The db connection
 * @param string $login  The login of a user
 * @param string $remindAt  A date
 * @param string $note     A string
 * @return Exception|PDOException|void
 * This function add an alert to the given user, or to all users
 */
function addAlert(PDO $conn, string $login, string $remindAt, string $note)
{
    try {

        $date = date('Y-m-d', strtotime($remindAt));
        $request = "Insert into alert (remindAt,note) VALUES (?,?);";
        $result = $conn->prepare($request);
        $result->execute(array($date, $note));
        $id=$conn ->lastInsertId();

        if($login=="global"){

            $request2 = "SELECT LOGIN from UTILISATEUR;";
            $result2 = $conn->prepare($request2);
            $result2->execute();
            foreach ($result2 as $row){
                $request3 = "INSERT INTO ALERTUTILISATEUR VALUES (?,?,false);";
                $result3 = $conn->prepare($request3);
                $result3->execute(array($id,$row[0]));
            }
        }
        else{
            $request4 = "INSERT INTO ALERTUTILISATEUR VALUES (?,?,false);";
            $result4 = $conn->prepare($request4);
            $result4->execute(array($id,$login));
        }
    } catch (PDOException $e) {
        return $e;
    }
}

/**
 * @param PDO $conn   The db connection
 * @param int $id   The id of an alert
 * @param string $login  The login of a user
 * @return Exception|PDOException|void
 * This function delete an alert for a user, then search if this alert is still link with other users, if not it delete it globally
 */
function deleteAlert(PDO $conn, int $id, string $login){
    try {
        $request = "DELETE from AlertUtilisateur WHERE idalert = ? and login = ?;";
        $result = $conn->prepare($request);
        $result->execute(array($id,$login));

        $request2="SELECT idalert from Alert LEFT JOIN AlertUtilisateur using (idalert) group by idalert HAVING count(login)=0;";
        $result2 = $conn->prepare($request2);
        $result2->execute();

        foreach ($result2 as $row){
            $request3="DELETE from Alert where idalert = ?;";
            $result3 = $conn->prepare($request3);
            $result3->execute(array($row[0]));
        }
    } catch (PDOException $e) {
        return $e;
    }
}




/**
 * @param $conn
 * @param $id
 * @param $note
 * @param $img
 * @return Exception|PDOException|void
 * this function adds a communication
 */
function addCommunication($conn,$id,$note,$img){
    try {
        if(is_null($img)) {

            $sql = "INSERT INTO Communication (idcandidate,dateCommunication,note) VALUES (?,current_timestamp,?)";
            $req = $conn->prepare($sql);
            $req->execute(array($id, $note));
        }
        else{
            $sql = "INSERT INTO Communication (idcandidate,dateCommunication,img) VALUES (?,current_timestamp,?)";
            $req = $conn->prepare($sql);
            $req->execute(array($id, $img));
        }
    }
    catch (PDOException $e) {
        return $e;
    }
}

/**
 * @param $conn
 * @param $commid
 * @return Exception|PDOException|void
 * this function delete every sign of a communication
 */
function deleteCommunication($conn,$commid){
    try {
        $sql = "DELETE FROM Communication WHERE idmessage = ?";
        $req = $conn->prepare($sql);
        $req->execute(array($commid));
    }
    catch (PDOException $e) {
        return $e;
    }
}

/**
 * @param $conn
 * @param $commid
 * @param $newmsg
 * @return Exception|PDOException|void
 This function update a communication (only a text, not a picture)
 */
function updateComm($conn,$commid,$newmsg)
{
    try{
        $sql = "UPDATE Communication SET note = ? , dateCommunication = current_timestamp where idmessage = ?";
        $req = $conn->prepare($sql);
        $req->execute(array($newmsg,$commid));
    }
    catch (PDOException $e) {
        return $e;
    }
}




function adduserbdd($conn,$pswrd,$lastname,$firstname,$email,$login,$role){

    $requete = "Insert into utilisateur VALUES (?,?,?,?,?,?,null,null)";
    $newpswrd = password_hash($pswrd,PASSWORD_DEFAULT);
    $res = $conn->prepare($requete);

    try{
        $res->execute(array($login,$newpswrd,$lastname,$firstname,$role,$email));
    }catch (PDOException $e) {
        header('Location: ../Model/Database.php');
        echo "Erreur de requête SQL : " . $e->getMessage();
    }
}


