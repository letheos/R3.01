
<?php
$conn = require "Database.php";
/**
 * @param $isActif
 * @param $isPermis
 * @param $year
 * @param $formation
 * @param $parcours
 * @param $radius
 * @param $city
 * @param $conn
 * @return mixed
 */
function getStudentsWithConditions($isActif,$isPermis,$year,$formation,$parcours,$conn){
    if()
    //problème vient quand je mes des conditions
    $sql = "SELECT * FROM candidate join candidateaddress USING(idCandidate) WHERE yearOfFormation =(?) AND isInActiveSearch =(?)  AND permisB =(?)";
    $req = $conn->prepare($sql);
    $params = array($year, $isActif, $isPermis);
    $req->execute($params);
    return $req->fetchall();
    //AND city =(?) AND radius >=(?)
}

function getStudentTest($isActif,$isPermis,$year,$formation,$parcours,$conn,$ine){
    if($isPermis){
        $sql = "SELECT () FROM candidate join candidateaddress USING(idCandidate) WHERE yearOfFormation =(?) AND isInActiveSearch =(?)  AND permisB =(?)";
    }
        //problème vient quand je mes des conditions
        $sql = "SELECT * FROM candidate join candidateaddress USING(idCandidate) WHERE yearOfFormation =(?) AND isInActiveSearch =(?)  AND permisB =(?)";
    $req = $conn->prepare($sql);
    $params = array($year, $isActif, $isPermis);
    $req->execute($params);
    return $req->fetchall();

}


/**
 * @param $conn PDO
 * @return mixed
 * take a PDO connection and return all the date in Parcours
 */
function getAllParcours($conn){
    $sql = "SELECT * FROM parcours";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchall();
}
//faire avec condition

/**
 * @param $conn PDO
 * @param $parcours String
 * @return mixed
 * take a PDO connexion and an educative parcours and return all the parcours in the database that correspond
 */
function getParcoursWithConditions($conn,$parcours){
    $sql = "SELECT * FROM parcours WHERE nameParcours LIKE(?)";
    $req = $conn->prepare($sql);
    $req->execute($parcours);
    return $req->fetchall();
}

/**
 * @param $conn PDO
 * @return mixed
 * take a PDO connexion and return all the formation in the databse
 */
function getAllFormation($conn){
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
function getFormationWithCoditions($conn, $formation){
    $sql = "SELECT * FROM formation WHERE nameFormation LIKE(?)";
    $req = $conn->prepare($sql);
    $req->execute($formation);
    return $req->fetchall();
}

