<?php
require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";
$conn = require "../Model/Database.php";

session_start();

if (isset($_POST['idDashboard'])) {
    $idDashboardForDelette = $_POST['idDashboard'];
    ControllerDeleteDashBoard($idDashboardForDelette, $_SESSION['login']);
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

//On passe la valeur a null si elle n'existe pas
if(!isset($_SESSION["login"])){
    $_SESSION['login'] = null;
}
//On passe la valeur a null si elle n'existe pas
if(!isset($_SESSION["password"])){
    $_SESSION['password'] = null;
}
//Cette condition sert à verifier que la personne accedant a la page d'accueil
if ($_SESSION['login'] == null || $_SESSION['password'] == null) {
    //$_SESSION['provenance'] = 'Accueil';
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}
