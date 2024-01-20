<?php
require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";

$conn = require "../Model/Database.php";




if(isset($_POST["title"]) and isset($_POST['idDashboard'])) {
    if(isset($_POST['validate'])){
        ControllerUpdateParametreDashBoard($_POST['title'],isset($_POST['isPermis']),isset($_POST['isIne']),isset($_POST['isAddress']),isset($_POST['isPhone']),$_POST['idDashboard'],isset($_POST['isHeadcount']));
        ControllerUpdateParcoursDashBoard($_POST['selectedParcours'],$_POST['idDashboard'],$_POST['choix']);
        header('location:../View/PageAfficheTableau.php');
    }

}





/**
 * @param $conn PDO
 * @return mixed
 * take a PDO connection and return the values of getAllParcours
 */
function controllerGetAllParcours(){
    global $conn;
    return getAllParcours($conn);
}

/**
 * @param $formation
 * @return mixed
 * Return the value of selectParcours
 */
function controllerGetParcours($formation){
    global $conn;
    return selectParcours($conn, $formation);
}

/**
 * @param $conn PDO
 * @return String[]
 * take a PDO connection and return the values of getAllFormation
 */
function controllerGetAllFormations(): array
{
    global $conn;
    return selectAllFormation($conn);
}

/**
 * @param $conn PDO
 * @return String[]
 * tkae a PDO connection and return the values of getAllRole
 */
function controllerGetAllRole(){
    global $conn;
    return getAllRole($conn);
}

/**
 * @param $idDashBoard
 * @return Array
 * this function return the value that GetFormationForADashBoard return with the parameter idDashBoard
 */
function ControllerGetFormationForADashBoard($idDashBoard): array
{
    global $conn;
    return GetFormationForADashBoard($conn,$idDashBoard);
}

function ControllerGetDashboard($idDashboard){
    global $conn;
    return selectDashboardById($conn, $idDashboard);
}

/**
 * @param $login String
 * @return String[]
 * get the value from the function getDashBoardPerUser that gave al the dashboard that a user have
 */
function ControllerGetDashBoardPerUser(string $login): array
{
    global $conn;
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
    global $conn;
    upadteParametreDashBoard($name,$isPermis,$isIne,$isAddress,$isPhone,$idDashBoard,$conn,$isHeadcount);

}

/**
 * @param $parcoursSelected Array
 * @param $idDashboard int
 * @return void
 * send to the function UpdateParcoursDashBoard the formations selected and the id of the dashbaord
 */
function ControllerUpdateParcoursDashBoard($parcoursSelected,$idDashboard,$year){
    global $conn;
    UpdateParcoursDashBoard($parcoursSelected,$idDashboard,$year,$conn);
}


function ControllerGetParcoursDashboard($idDashboard){
    global $conn;
    return selectParcoursOfDashboard($conn,$idDashboard);

}

function getNbEtuPerParcours($parcour){
    global $conn;
    return selectParcoursNumber($conn, $parcour);
}

function controllerGetFormationDashboard($idDashboard){
    global $conn;
    return GetFormationDashboard($conn, $idDashboard);
}



function getNbEtuFoundApp(){
    global $conn;
    return countNbStudentFoundApp($conn, 1);
}

function getNbEtuNotActives(){
    global $conn;
    return countNbStudentActives($conn, 0);
}

function getNbEtuNotFoundApp(){
    global $conn;
    return countNbStudentFoundApp($conn, 0);
}

function getNbEtu(){
    global $conn;
    return countAllStudents($conn);
}


function getNbEtuWithFormation($formation){
    global $conn;
    $count = 0;
    foreach($formation as $formations){
        $count += selectNbStudentPerFormation($conn, $formations)['effectifFormation'];
    }
    return $count;
}

function getNbEtuPerFormation($formation){
    global $conn;
    return selectNbStudentPerFormation($conn, $formation);
}


function getDashboardById($id){
    global $conn;
    return selectDashboardById($conn, $id);
}
























