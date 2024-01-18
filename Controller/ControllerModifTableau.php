<?php
require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";




if(isset($_POST["title"]) and isset($_POST['idDashboard'])) {
    if(isset($_POST['validate'])){

        ControllerUpdateParametreDashBoard($_POST['title'],isset($_POST['permis']),isset($_POST['ine']),isset($_POST['address']),isset($_POST['phone']),$_POST['idDashboard'],isset($_POST['graphe']));
        ControllerUpdateParcoursDashBoard($_POST['selectedParcours'],$_POST['idDashboard'],$_POST['choix']);
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

/**
 * @param $name string
 * @param $isPermis bool
 * @param $isIne bool
 * @param $isAddress bool
 * @param $isPhone bool
 * @param $idDashBoard int
 * @param $isHeadcount bool
 * @return void
 * send to the function UpdateParametreDashBoard the value usefull to modify his parameters
 */
function ControllerUpdateParametreDashBoard($name,$isPermis,$isIne,$isAddress,$isPhone,$idDashBoard,$isHeadcount){
    $conn = require "../Model/Database.php";
    upadteParametreDashBoard($name,$isPermis,$isIne,$isAddress,$isPhone,$idDashBoard,$conn,$isHeadcount);

}

/**
 * @param $parcoursSelected Array
 * @param $idDashboard int
 * @return void
 * send to the function UpdateParcoursDashBoard the formations selected and the id of the dashbaord
 */
function ControllerUpdateParcoursDashBoard($parcoursSelected,$idDashboard,$year){
    $conn = require "../Model/Database.php";
    UpdateParcoursDashBoard($parcoursSelected,$idDashboard,$year,$conn);
}
































