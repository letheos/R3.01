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


function adduserbdd($conn,$pswrd,$lastname,$firstname,$email, $login,$role){

    $requete = "Insert into utilisateur VALUES (?,?,?,?,?,?,?,?)";
    $res = $conn->prepare($requete);
    $newpswrd = password_hash($pswrd,PASSWORD_DEFAULT);

    try {
        $res->execute(array($login,$newpswrd,$lastname,$firstname,$role,$email,null,null));
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }

    return $res;
}


/**
 * @param $conn PDO
 * @param $login string
 * @param $formations string
 * @return void
 *
 *fonction qui associe dans la bdd un utilisateur à un rôle via une table associative
 *
 */
function addrolesbdd($conn,$login,$formations)
{
    $requete = "Insert into formationsutilisateurs values (?,?)";
    $res = $conn->prepare($requete);
    try{
        for ($x = 0; $x < count($formations); $x++) {
            $res->execute(array($login, $formations[$x]));
        }}
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}