
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
    //problème vient quand je mes des conditions
    $sql = "SELECT * FROM candidate join candidateaddress USING(idCandidate) WHERE yearOfFormation =(?) AND isInActiveSearch =(?)  AND permisB =(?)";
    $req = $conn->prepare($sql);
    $req->execute($year,$isActif,$isPermis);
    return $req->fetchall();
    //AND city =(?) AND radius >=(?)
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

function getAllFormation($conn){
    $sql = "SELECT * FROM formation";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchall();
}

