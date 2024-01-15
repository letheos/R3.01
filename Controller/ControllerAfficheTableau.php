<?php
//TODO efface quand meme si tu dis non
if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = "magS";
}
$User = $_SESSION['login'];

require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";


$conn = require "../Model/Database.php";


if (isset($_POST['idDashboard'])) {
    $idDashboardForDelette = $_POST['idDashboard'];
    echo $_POST['idDashboard'];


    ControllerDeleteDashBoard($idDashboardForDelette, $_SESSION['login']);
    crumbCollector($conn);
    ControllerDeleteDashBoard($idDashboardForDelette, $_SESSION['login']);
    header('location:../View/PageAfficheTableau.php');
}


/*
echo '<script>alert(" avant")</script>';
if(isset($_POST['idDashboard'])) {
    echo '<script>alert("après")</script>';

    if($_POST['validation'] == '1'){
        ControllerDeleteDashBoard($_POST['idDashboard'],  $_SESSION['login']);
        //crumbCollector($conn);
        echo '<script>alert(" validation")</script>';
    } else{
        echo '<script>alert("pas validation")</script>';
    }

    //$idDashboardForDelette = $_POST['idDashboard'];
    //echo $_POST['idDashboard'];


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

