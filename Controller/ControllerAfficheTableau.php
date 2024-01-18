<?php
require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";
include "../Controller/ClassUtilisateur.php";
$conn = require "../Model/Database.php";

session_start();

$user = unserialize($_SESSION['user']);

if (isset($_POST['idDashboard'])) {
    $idDashboardForDelette = $_POST['idDashboard'];
    ControllerDeleteDashBoard($idDashboardForDelette, $user->getLogin());
    ControllerDeletteAllDashbaord();
    header('location:../View/PageAfficheTableau.php');
}


/**
 * @param $login String
 * @return String[]
 */
function ControllerGetDashBoardPerUser(string $login): array
{
    global $conn;
    return getDashBoardPerUser($login, $conn);
}

/**
 * @param $idDashboard int
 * @return void
 */
function ControllerGetYearWitDashBoard($idDashboard)
{
    $conn = require "../Model/Database.php";
}

/**
 * @param $idDashboard int
 * @param $login String
 * @return void
 * this function use deleteUserDashBoard and remove a dashboard for a login pass in parameter
 */
function ControllerDeleteDashBoard($idDashboard, $login)
{
    $conn = require "../Model/Database.php";
    deleteUserDashBoard($login, $idDashboard, $conn);
}



function getDashboardById($id){
    global $conn;
    return selectDashboardById($conn, $id);
}

/**
 * @return void
 * this function call a other function that has for gool to remove all the dashbaord that are own by nobody
 */
function ControllerDeletteAllDashbaord(){
    global $conn;
    deleteAllOldDashBoard($conn);
}

