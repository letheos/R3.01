
<?php

//TODO faire le controller pour pouvoir crée un tableau de bord dans la bdd quand théo aura fini
//TODO faire le code qui ajoute le tableau de bord à l'utilisateur et à tout les roles (attention il ne faut pas que le user est 2 fois le même erreurs)
require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";
$conn = require "../Model/Database.php";

if(isset($_POST["title"]) and isset($_POST['idDashboard'])) {

    if(isset($_POST['validate'])){
        //crée un dashbaord et lui ajoute ces parcours
        $idDashBoard = ControllerCreateDashboard($_POST['title'],isset($_POST['permis']),isset($_POST['ine']),isset($_POST['address']),isset($_POST['phone']),$_POST['selectedParcours'],$conn);


        $roles = [];
        //vérifie que un des role est selectionner au moins
        if(isset($_POST['secretaire']) or isset($_POST['Admin']) or isset($_POST['role2']) or isset($_POST['role3']) ){
            if (isset($_POST['secretaire'])) {
                array_push($roles, 2);
            } elseif (isset($_POST['Admin'])) {
                array_push($roles, 1);
            } elseif (isset($_POST['role2'])) {
                array_push($roles, 3);
            } elseif (isset($_POST['role3'])) {
                array_push($roles, 4);
            }
            //recup tous les users qui on le role
            $users = ControllerGetAllPeopleWithRole($roles,$conn);
            foreach ($users as $user){
                //leur ajoute le dashbaord
                ControllerAddDashBoardForUser($conn,$idDashBoard,$user);
            }


        } else{
            //rajoute le dashbaord uniquement à l'utilisateur connecté
            ControllerAddDashBoardForUser($conn,$idDashBoard,$_SESSION['login']);
        }
         header('location:../View/PageAfficheTableau.php');
    }

}



/**
 * @return int
 */
function ControlerLastInsert(){
    $conn = require "../Model/Database.php";
    return getLastIdDashBoard($conn);
}

/**
 * @param $conn PDO
 * @return mixed
 * take a PDO connection and return the values of getAllParcours
 */
function controllerGetAllParcours(){
    $conn = require "../Model/Database.php";
    return getAllParcours($conn);
}

/**
 * @param $conn PDO
 * @return String[]
 * take a PDO connection and return the values of getAllFormation
 */
function controllerGetAllFormations( ): array
{
    $conn = require "../Model/Database.php";
    return getAllFormation($conn);
}

/**
 * @param $conn PDO
 * @return String[]
 * tkae a PDO connection and return the values of getAllRole
 */
function controllerGetAllRole(){
    $conn = require "../Model/Database.php";
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
function ControllerCreateNewDashBoard($name,$isPermis,$isIne,$isAddress,$isPhone,$login,$parcours){
    //check si le dashbaord existe déjà si oui juste appelée la fonction qui ajoute un dashboard a un utilisateur
    //sinon crée un nouveau puis l'affectée
    $conn = require "../Model/Database.php";
    if(selectdashboardid($conn,$name,$isPermis,$isIne,$isAddress,$isPhone) != null){
        $idDashboard = $conn->LAST_INSERT_ID(); //trouver comment le récup
        insertNewUserDashBoard($login,$idDashboard,$conn);

    }
    else{
        insertNewDashBoard($name,$isPermis,$isIne,$isAddress,$isPhone,$conn);
        $idDashboard = $conn->LAST_INSERT_ID();
        foreach ($parcours as $parcour){
            addFormationNewDashboard($parcour,$conn);
        }
        addDashBoardForUser($conn,$idDashboard,$login);
        return 0;

    }
    //insertNewDashBoardForUser($isPermis,);
    //TODO empecher de prendre deux fois le meme nom de dashbaord dans la bdd
    //insertNewParcoursforDashboard($)
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

function ControllerCreateDashboard($name,$isPermis,$isIne,$isAddress,$isPhone,$parcours,$conn){
    insertNewDashBoard($name,$isPermis,$isIne,$isAddress,$isPhone,$conn);
    $idDashboard = $conn->LAST_INSERT_ID();
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




