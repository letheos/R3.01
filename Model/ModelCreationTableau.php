<?php
//$conn = require "Database.php";
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
function getStudentsWithConditions( $isPermis, $year, $formation, $parcours, $conn, $ine, $address, $phone)
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
        //a retravailler
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
    if ($parcours != "allParcours" && $formation != "allFormations") {
        //if $parcours hasn't the value allParcours and $formation hasn't the value allFormations
        //do the request

        $params = array($year, $isPermis, $formation, $parcours);


        $req->execute($params);
        return $req->fetchall();

    }
    if (($parcours == "allParcours" && $formation != "allFormations") || ($parcours != "allParcours" && $formation == "allFormations")) {
        // If $parcours has for value "allParcours" and $formation hasn't the value "allFormations"
        // ro if $parcours hasn't the value "allParcours" and $formation has the value "allFormations"

        // Déterminer la valeur à utiliser dans la requête en fonction des conditions
        $value = ($parcours == "allParcours") ? $formation : $parcours;


        $params = array($year, $isPermis, $value);
        $req->execute($params);

        return $req->fetchAll();
    }
    $tableau = ["Élément 1", "Élément 2", "Élément 3", "Élément 4", "Élément 5", "Élément 6"];

    return $tableau;
}
/**
 * @param $isActif bool
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
    //$tableau = ["Élément 1", "Élément 2", "Élément 3", "Élément 4", "Élément 5", "Élément 6"];

    return null;
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
 * @return String[]
 * take a PDO connexion and return all the formation in the databse
 */
function getAllFormation($conn)
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
 * @param $isPermis boolean
 * @param $year string
 * @param $formation string
 * @param $parcours string
 * @param $isIne boolean
 * @param $isAddress boolean
 * @param $isPhone boolean
 * @param $idUser string //a trouver comment récupérer l'user pour pouvoir l'enregistré dans la bdd
 * @param $conn PDO //the connection at the database
 * @return boolean
 * this function insert a new dash board in the database for a user
 */
function insertNewDashBoard($isPermis, $year, $formation, $parcours, $isIne, $isAddress, $isPhone, $idUser, $conn){
    $user = getUserWithId($idUser, $conn);
    $sql = "INSERT INTO dashBoard (isPermis, yearOfFormation, formation, parcours, isIne, isAddress, isPhone) VALUES(?,?,?,?,?,?,?);";
    $req = $conn->prepare($sql);
    $params = array($isPermis, $year, $formation, $parcours, $isIne, $isAddress, $isPhone);

    try {
        $req->execute($params);
        // Omit the fetchall() line if you don't expect a result set.
        // return $req->fetchAll();
        return true; // Indicate success if no exception was thrown.
    } catch (PDOException $e) {
        // Handle the exception, e.g., log the error or return false.
        // echo "Error: " . $e->getMessage();
        return false;
    }
}

/*
function insertNewDashBoard($isPermis, $year, $formation, $parcours, $isIne, $isAddress, $isPhone, $idUser,$conn){
    $user = getUserWithId($idUser, $conn);
    $sql = "INSERT INTO dashBoard (isPermis, yearOfFormation, formation, parcours, isIne, isAddress, isPhone) VALUES(?,?,?,?,?,?,?);";
    $req = $conn->prepare($sql);
$params = array( $isPermis, $year, $formation, $parcours, $isIne, $isAddress, $isPhone);
    $req->execute($params);
    //$req->execute($isPermis, $year, $formation, $parcours, $isIne, $isPhone);
    return $req->fetchall();
}
*/
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
    $req->execute([$login]); // Pass the parameter as an array
    $value = $req->fetch();
    return $value;
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