
<?php
/**
 * @author Loick Morneau
 * Page gérant la création de tableau de bord
 */
session_start();

require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";
include "../Controller/ClassUtilisateur.php";
$conn = require "../Model/Database.php";

$userObject = unserialize($_SESSION['user']);


if(isset($_POST["title"])) {

    if(isset($_POST['validate'])){

        $isIne = isset($_POST['isIne']) ? 1 : 0;

        $isAddress = isset($_POST["isAddress"]) ? 1 : 0;

        $isPhone = isset($_POST["isPhone"]) ? 1 : 0;

        $isPermis = isset($_POST["isPermis"]) ? 1 : 0;

        $isHeadcount = isset($_POST['isHeadcount']) ? 1 : 0;

        $isEmail   = isset($_POST['email']) ? 1 : 0;

        $isformParcours = isset($_POST['formParcours']) ? 1 : 0;

        $isYear = isset($_POST['year']) ? 1 : 0;

        $isSchEntreprise = isset($_POST['schEntreprise']) ? 1 : 0;

        $isZone = isset($_POST['zone']) ? 1 : 0;

        $isActiv = isset($_POST['schEntreprise']) ? 1 : 0;


        //crée un dashbaord et lui ajoute ces parcours
        $idDashBoard = ControllerCreateDashboard($_POST['title'], $isPermis, $isIne, $isAddress, $isPhone, $isHeadcount, $_POST['selectedParcours'],$conn,$isEmail,$isformParcours,$isYear,$isSchEntreprise,$isZone,$isActiv);

        //rajoute le dashbaord uniquement à l'utilisateur connecté
        ControllerAddDashBoardForUser($conn,$idDashBoard,$userObject->getLogin());
         header('location:../View/PageAfficheTableau.php');
    }

}

/**
 * @return int id of the last dashboard inserted
 */
function ControlerLastInsert(){
    global $conn;
    return getLastIdDashBoard($conn);
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


/**
 * @param $roles Array
 * @return void
 * get the last dashboard insert and then get all the users that have one of the roles pass in parameter
 * then add to these users the dashboard
 */
function ControllerInsertDashboardForUsers($roles,$conn){

    $idDashboard = $conn->LAST_INSERT_ID();
    $users = [];
    foreach ($roles as $role){
        $user = getAllPeopleWithRole($conn,$role);
        if(! empty($user)) {
            array_push( $users,$user);
        }
    }
    foreach ($user as $userROle){
        foreach ($userROle as $gens){
            insertDashboardForUsers($conn,$gens,$idDashboard);
        }
    }

}

/**
 * @param $name
 * @param $isPermis
 * @param $isIne
 * @param $isAddress
 * @param $isPhone
 * @param $isHeadcount
 * @param $parcours
 * @param $conn
 * @return int
 * Function that creates a dashboard with all the parameters necessary
 */
function ControllerCreateDashboard($name,$isPermis,$isIne,$isAddress,$isPhone,$isHeadcount, $parcours,$conn,$isEmail,$isformParcours,$isYear,$isSchEntreprise,$isZone,$isActiv){
    $idDashboard = insertNewDashBoard($name ,$isPermis, $isIne, $isAddress, $isPhone, $isHeadcount,$isEmail,$isformParcours,$isYear,$isSchEntreprise,$isZone,$isActiv,$conn);
    foreach ($parcours as $parcour){
        addFormationNewDashboard($parcour,$conn,$idDashboard);
    }
    return $idDashboard;
}

/**
 * @param $users array
 * @param $idDashBoard int
 * @param $conn PDO
 * @return void
 */
function ControllerAddDashBoardUser($users,$idDashBoard,$conn){
    insertDashboardForUsers($conn,$users,$idDashBoard);
}

/**
 * @param $conn PDO
 * @param $idDashBoard int
 * @param $login string
 * @return void
 * add a dashboard pass in parameter to the user pass in parameter
 */
function ControllerAddDashBoardForUser($conn,$idDashBoard,$login)
{
    addDashBoardForUser($conn,$idDashBoard,$login);
}

/**
 * @param $role array
 * @param $conn PDO
 * @return array
 * return the value that getAllPeopleWithRole return with a list of role and a connection to a database pass in parameter
 */
function ControllerGetAllPeopleWithRole($role,$conn){
    return getAllPeopleWithRole($conn,$role);
}




