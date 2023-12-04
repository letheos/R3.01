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

function insertNewDashBoard1($isPermis, $year, $formation, $parcours, $isIne, $isAddress, $isPhone, $idUser, $conn){
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

//TODO changer le nom en insertNewDashBoard
function insertNewDashBoard2($isPermis, $year, $formation, $parcours, $isIne, $isAddress, $isPhone, $idUser,$conn){
    $user = getUserWithId($idUser, $conn);
    $sql = "INSERT INTO dashBoard (isPermis, yearOfFormation, formation, parcours, isIne, isAddress, isPhone) VALUES(?,?,?,?,?,?,?);";
    $req = $conn->prepare($sql);
$params = array( $isPermis, $year, $formation, $parcours, $isIne, $isAddress, $isPhone);
    $req->execute($params);
    //$req->execute($isPermis, $year, $formation, $parcours, $isIne, $isPhone);
    return $req->fetchall();
}

/**
 * @param $idDashBoard int
 * @param $conn PDO
 * @return string|void
 * take in parameter a login and an id of a dashBoard and a connection to a database
 * delete the dashboard in teh table dashboard
 */
function deleteDashBoard($idDashBoard,$conn){
    try{
        $sql = "DELETE FROM dashBoard WHERE idTableauDeBord = ?;";
        $req = $conn->prepare($sql);
        $req -> execute($idDashBoard);
    }Catch(PDOException $e){
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
function deleteUserDashBoard($login, $idDashBoard, $conn){
    try{
        $sql = "DELETE FROM userdashboard WHERE idTableauDeBord = ? AND login = ?";
        $req = $conn->prepare($sql);
        $req -> execute($idDashBoard,$login);

    } Catch(PDOException $e){
        return $e->getMessage();
    }
}