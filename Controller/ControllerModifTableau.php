<?php
require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";



//récup les données
//faire la modif
//remetre sur la page qui va bien

if(isset($_POST["title"]) and isset($_POST['idDashboard'])) {

    if(isset($_POST['validate'])){
        ControllerUpdateParametreDashBoard($_POST['title'],isset($_POST['permis']),isset($_POST['ine']),isset($_POST['address']),isset($_POST['phone']),$_POST['idDashboard']);
        //ControllerUpdateParcoursDashBoard($_POST['parcoursSelected'],$_POST['idDashboard']);
        header('location:../View/PageAfficheTableau.php');
    }

}





/**
 * @param $conn PDO
 * @return mixed
 * take a PDO connection and return the values of getAllParcours
 */
function controllerGetAllParcours($conn){
    return getAllParcours($conn);
}

/**
 * @param $conn PDO
 * @return String[]
 * take a PDO connection and return the values of getAllFormation
 */
function controllerGetAllFormations(PDO $conn): array
{
    return getAllFormation($conn);
}

/**
 * @param $conn PDO
 * @return String[]
 * tkae a PDO connection and return the values of getAllRole
 */
function controllerGetAllRole($conn){
    return getAllRole($conn);
}

/**
 * @param $idDashBoard
 * @return Array
 * this function return the value that GetFormationForADashBoard return with the parameter idDashBoard
 */
function ControllerGetFormationForADashBoard($idDashBoard): array
{
    $conn = require "../Model/Database.php";
    return GetFormationForADashBoard($conn,$idDashBoard);
}

/**
 * @param $login String
 * @return String[]
 * get the value from the function getDashBoardPerUser that gave al the dashboard that a user have
 */
function ControllerGetDashBoardPerUser(string $login): array
{
    $conn = require "../Model/Database.php";
    return getDashBoardPerUser($login, $conn);
}

function ControllerUpdateParametreDashBoard($name,$isPermis,$isIne,$isAddress,$isPhone,$idDashBoard){
    $conn = require "../Model/Database.php";
    upadteParametreDashBoard($name,$isPermis,$isIne,$isAddress,$isPhone,$idDashBoard,$conn);

}

function ControllerUpdateParcoursDashBoard($parcoursSelected,$idDashboard){
    $conn = require "../Model/Database.php";
    UpdateParcoursDashBoard($parcoursSelected,$idDashboard,$conn);
}
































