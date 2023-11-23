<?php
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
 * this funtion insert à new tableau de bord in the database is link it whit an user
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