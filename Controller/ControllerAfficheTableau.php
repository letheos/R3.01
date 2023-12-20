<?php
//TODO efface quand meme si tu dis non
if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = "user1";
}
$User = $_SESSION['login'];

require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";


$conn = require "../Model/Database.php";


if (isset($_POST['idDashboard'])) {
    $idDashboardForDelette = $_POST['idDashboard'];
    echo $_POST['idDashboard'];

    //ControllerDeleteDashBoard($idDashboardForDelette, $_SESSION['login']);
    header('location:../View/PageAfficheTableau.php');
}

/**
 * @param $login String
 * @return String[]
 */
function ControllerGetDashBoardPerUser($login)
{
    $conn = require "../Model/Database.php";
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
 */
function ControllerDeleteDashBoard($idDashboard, $login)
{
    $conn = require "../Model/Database.php";
    deleteUserDashBoard($login, $idDashboard, $conn);
}