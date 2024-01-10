<?php
/**
 * Fonction insérant les addresses du candidat
 * @param $conn : Connexion à la bdd
 * @param $idCandidate : Le candidat
 * @param $cp : Le code postal
 * @param $addr : Le libellé de l'adresse
 * @param $city : La ville
 * @return void
 */
function insertAddr($conn, $idCandidate, $cp, $addr, $city){
    $sql = "INSERT INTO CandidateAddress (idCandidate, cp, addressLabel, city) VALUES (?,?,?,?)";
    $req = $conn->prepare($sql);
    $req->execute(array($idCandidate,$cp,$addr,$city));
}

/**
 * Fonction d'insertion des zones de recherches
 * @param $conn : Connection à la bdd
 * @param $idCandidate : Le candidat
 * @param $searchCity : La ville de recherche
 * @param $radius : Le rayon de recherche
 * @return void
 */
function insertSearchZone($conn, $idCandidate, $searchCity, $radius){
    $sql = "INSERT INTO CandidateZone (idCandidate, cityName, radius) VALUES (?,?,?)";
    $req = $conn->prepare($sql);
    $req->execute(array($idCandidate,$searchCity,$radius));
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
function insertCandidate($conn, $INE, $name, $firstName, $yearOfFormation, $email, $phoneNumber, $nameParcours, $permisB, $typeCompanySearch, $remark, $adresses, $searchZone, $cvPath) {
    $sql = "INSERT INTO Candidate (INE, name, firstName,  candidateMail, phoneNumber, nameParcours, yearOfFormation, isInActiveSearch, permisB, typeCompanySearch, cv, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?)";
    $req = $conn->prepare($sql);
    $req->execute(array($INE, $name, $firstName, $email, $phoneNumber, $nameParcours, $yearOfFormation, $permisB, $typeCompanySearch, $cvPath, $remark));
    $idCandidate = $conn->lastInsertId();


    foreach ($adresses as $adressData){
        $cp = $adressData['CP'];
        $addr = $adressData['Address'];
        $city = $adressData['City'];
        insertAddr($conn, $idCandidate, $cp, $addr, $city);

    }

    foreach ($searchZone as $zone){
        $search = $zone["SearchCity"];
        $radius = $zone["RadiusCity"];
        insertSearchZone($conn, $idCandidate, $search, $radius);

    }
}

function addbdd($conn,$pswrd,$lastname,$firstname,$email, $login,$role,$formation)
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
    $req = $conn->prepare("UPDATE Utilisateur SET login = ? WHERE login = ?");
    $req->execute(array($newLogin,$oldLogin));
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

function setEtatTrue($conn,$id)
{
    $sql = "UPDATE Candidate SET isInActiveSearch = 1 WHERE idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return true;
}


function setEtatFalse($conn,$id)
{
    $sql = "UPDATE Candidate SET isInActiveSearch = 0 WHERE idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return true;

}

function deleteCandidate($conn, $id){
    $sqlReq1="DELETE FROM CandidateAddress WHERE idCandidate = ?"; //Suppression des adresses
    $sqlReq2="DELETE FROM CandidateZone WHERE idCandidate = ?"; //Suppression des Zones
    $sqlReq3="DELETE FROM Candidate WHERE idCandidate = ?"; //Suppression des autres information candidats

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

