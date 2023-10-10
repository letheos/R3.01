<?php
$conn = require "Database.php";
/**
* @param $ine string
* @return void
* prend en paramètre une connection mysql et un ine de type string
* change l'état boolean de la isInActiveSearch en true
 */
function changeEtatTrue($ine){
    $conn = require "Database.php";
    $sql = "UPDATE Candidates SET isInActiveSearch = 1 WHERE INE = (?)";
    $req = $conn->prepare($sql);
    $req->execute(array($ine));

}
/**
 * @param $ine
 * @return void
 * prend en paramètre une connection mysql et un ine de type string
 * change l'état boolean de la isInActiveSearch en false
*/
function changeEtatFalse($ine){
    $conn = require "Database.php";
    $sql = "UPDATE Candidates SET isInActiveSearch = 0 WHERE INE = (?)";
    $req = $conn->prepare($sql);
    $req->execute(array($ine));

}

/**
 * @return array
 */
function recup($conn){


    $sql = "SELECT ine,name,firstname,address,isInActiveSearch FROM Candidates";

    $requete = $conn->prepare($sql);

    $requete->execute();
    $candidates = array();
    while ($row = $requete->fetch(PDO::FETCH_ASSOC)) {
        $candidates[] = array($row['ine'],$row['name'],$row['firstname'],$row['address'],$row['isInActiveSearch']);
    }

    return $candidates;
}

