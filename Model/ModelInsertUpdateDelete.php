<?php
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
        $search = $zone["cityName"];
        $radius = $zone["radius"];
        insertSearchZone($conn, $idCandidate, $search, $radius);

    }
}

function updateAddr($conn, $idAddr, $cp, $addr, $city){
    $sql = "UPDATE CandidateAddress SET cp = ?, addressLabel = ?, city = ? WHERE idAddr = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($cp, $addr, $city, $idAddr));
}

function updateZone($conn, $idZone, $city, $radius){
    $sql = "UPDATE CandidateZone SET cityName = ?, radius = ? WHERE idZone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($city, $radius, $idZone));
}

function updateNameCandidate($conn, $id, $name){
    $sql = "UPDATE Candidate SET name = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($name, $id));
    return true;
}

function updateFirstNameCandidate($conn, $id, $firstName){
    $sql = "UPDATE Candidate SET firstName = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($firstName, $id));
    return true;
}

function updateMailCandidate($conn, $id, $candidateMail){
    $sql = "UPDATE Candidate SET candidateMail = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($candidateMail, $id));
    return true;
}


function updatePhoneNumberCandidate($conn, $id, $phone){
    $sql = "UPDATE Candidate SET phoneNumber = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($phone, $id));
    return true;
}

function updateParcoursCandidate($conn, $id, $parcours){
    $sql = "UPDATE Candidate SET nameParcours = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($parcours, $id));
    return true;
}

function updateYearOfFormationCandidate($conn, $id, $yearOfFormation){
    $sql = "UPDATE Candidate SET yearOfFormation = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($yearOfFormation, $id));
    return true;
}

function updateDriverLicenceCandidate($conn, $id, $driverLicence){
    $sql = "UPDATE Candidate SET yearOfFormation = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($driverLicence, $id));
    return true;
}


function updateTextAreaCandidate($conn, $id, $textArea){
    $sql = "UPDATE Candidate SET typeCompanySearch = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($textArea, $id));
    return true;
}

function updateRemarksCandidate($conn, $id, $remarks){
    $sql = "UPDATE Candidate SET remarks = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($remarks, $id));
    return true;
}

function updateIneCandidate($conn, $id, $ine){
    $sql = "UPDATE Candidate SET INE = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($ine, $id));
    return true;
}

function updateCVCandidate($conn, $id, $cvPath){
    $sql="UPDATE Candidate SET cv = ? WHERE idCandidate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($cvPath, $id));
    return true;
}


function deleteAddr($conn, $idAddr){
    $sql = "DELETE FROM candidateaddress WHERE idAddr = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($idAddr));
    return true;
}

function deleteZone($conn, $idZone){
    $sql = "DELETE FROM candidatezone WHERE idZone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($idZone));
    return true;
}

function addbdd($conn,$pswrd,$lastname,$firstname,$email, $login,$role,$formation){


    $requete = "Insert into utilisateur VALUES (?,?,?,?,?,?,?,?,?)";
    $res = $conn->prepare($requete);
    $newpswrd = password_hash($pswrd,PASSWORD_DEFAULT);

    try {
        $res->execute(array($login,$newpswrd,$firstname,$lastname,$role,$formation,$email,null,null));

    }
    catch (PDOException $e){
        echo $e->getMessage();
    }

    return $res;
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
