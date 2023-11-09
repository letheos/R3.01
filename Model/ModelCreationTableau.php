
<?php
$conn = require "Database.php";
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
 * @return string
 */
function getStudentsWithConditions($isActif,$isPermis,$year,$formation,$parcours,$conn,$ine,$address,$phone){
    $deb = "SELECT name,firstName,nameFormation,nameParcours,yearOfFormation,isInActiveSearch";
    $fin = " FROM infocandidate  WHERE yearOfFormation =(?) AND isInActiveSearch =(?)  AND permisB =(?)";
    if($ine){
        $deb.= ",INE";
    } if($address){
        $deb.= ",AddressesIDs";
    } if($phone){
        $deb.=",phone";
    } if($formation != "allFormations"){
        $fin.= " AND nameFormation LIKE '%(?)%'";
    } if($parcours != "allParcours"){
        $fin.= " AND nameParcours LIKE '%(?)%'";
    }
    $sql = $deb.=$fin;
    echo $sql;
    //return $test;
    $req = $conn->prepare($sql);
    if($parcours== "allParcours" && $formation == "allFormations"){
        //code pour exec avec tout

        $params = array($year, $isActif, $isPermis);
        $req->execute($params);
        return $req->fetchall();
    }if($parcours != "allParcours" && $formation != "allFormations"){
        //code pour exec avec tout différent

        $params = array($year, $isActif, $isPermis,$formation,$parcours);
        $req->execute($params);
        return $req->fetchall();

    } if($parcours == "allParcours" && $formation != "allFormations"){
        //code pour exec avec seulement formation à chercher
        $params = array($year, $isActif, $isPermis,$formation);
        $req->execute($params);
        return $req->fetchall();

    } if($parcours != "allParcours" && $formation == "allFormations"){
        //code pour exec avec seulement parcours à chercher
        $params = array($year, $isActif, $isPermis,$parcours);
        $req->execute($params);
        return $req->fetchall();

    }
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

