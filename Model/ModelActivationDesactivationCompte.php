<?php
$conn = require "Database.php";
/*
* @param $ine string
* @return void
* prend en paramètre une connection mysql et un ine de type string
* change l'état boolean de la isInActiveSearch en true
 */

if (isset($_POST['activer'])){
    setEtatTrue($_POST['name'],$_POST['firstname']);
    echo $_POST['name'];
    echo '<script> alert("j ai bien activé le compte ")</script>';
}
if (isset($_POST['desactiver'])){
    setEtatTrue($_POST['name'],$_POST['firstname']);
    echo '<script> alert("j ai bien desactivé le compte")</script>';
}
function setEtatTrue($name,$firstname){
    echo'<script> alert("setEtatTrue")';
    $conn = require "Database.php";
    $sql = "UPDATE Candidates SET isInActiveSearch = 1 WHERE name = (?) and firstname = (?)";
    $req = $conn->prepare($sql);
    $req->bind(1,$name);
    $req->bind(2,$firstname);

    $req->execute();

}

/**
 * @param $ine
 * @return void
 * prend en paramètre une connection mysql et un ine de type string
 * change l'état boolean de la isInActiveSearch en false
*/
function setEtatFalse($name,$firstname){
    echo'<script> alert("setEtatFalse")';
    $conn = require "Database.php";
    $sql = "UPDATE Candidates SET isInActiveSearch = 0 WHERE name = (?) and firstname = (?)";
    $req = $conn->prepare($sql);
    $req->bind(1,$name);
    $req->bind(2,$firstname);
    $req->execute();

}

/**
 * @return array
 */
function recup(){
    //revoie la liste de tout les candidats
    $conn = require "Database.php";
    $sql = "SELECT * FROM Candidates";

    $requete = $conn->prepare($sql);

    $requete->execute();
    $candidates = array();
    return $requete->fetchall();
    /*
    while ($row = $requete->fetch(PDO::FETCH_ASSOC)) {
        $candidates[] = array($row['ine'],$row['name'],$row['firstname'],$row['address'],$row['isInActiveSearch']);
    }

    return $candidates;
*/
    }

