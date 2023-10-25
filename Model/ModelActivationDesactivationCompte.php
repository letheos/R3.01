<?php
$conn = require "Database.php";


/**
 * @param $name string
 * @param $firstname string
 * @return void
 * takes as a parameter a name and a firstname of type string
 * change the state of the boolean isInActiveSearch in true
 */
function setEtatTrue($name, $firstname)
{

    $conn = require "Database.php";
    $sql = "UPDATE Candidates SET isInActiveSearch = 1 WHERE name = (?) and firstname = (?)";
    $req = $conn->prepare($sql);
    $req->execute(array($name, $firstname));


}

/**
 * @param $name string
 * @param $firstname string
 * @return void
 * takes as a parameter a name and a firstname of type string
 * change the state of the boolean isInActiveSearch in false
 */
function setEtatFalse($name, $firstname)
{
    echo "je vais set en false" . $name . " " . $firstname;
    $conn = require "Database.php";
    $sql = "UPDATE Candidates SET isInActiveSearch = 0 WHERE name = (?) and firstname = (?)";
    $req = $conn->prepare($sql);
    $req->execute(array($name, $firstname));


}

/**
 * with a mysql connection do a select all(*) request of the database
 * @return mixed
 */
function getAllStudents()
{
    $conn = require "Database.php";
    $sql = "SELECT * FROM Candidates";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return $requete->fetchall();

}

/**
 * @return mixed
 * return all the formation from the database
 */
function getAllFormation()
{
    $conn = require "Database.php";
    $sql = "SELECT * FROM formation";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return $requete->fetchall();
}

