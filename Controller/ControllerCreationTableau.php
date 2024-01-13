
<?php

//TODO faire le controller pour pouvoir crée un tableau de bord dans la bdd quand théo aura fini
//TODO faire le code qui ajoute le tableau de bord à l'utilisateur et à tout les roles (attention il ne faut pas que le user est 2 fois le même erreurs)
require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";

if(isset($_POST["title"]) and isset($_POST['idDashboard'])) {

    if(isset($_POST['validate'])){
        //code ou appel pour crée un dashbaord de base
        ControllerCreateNewDashBoard($_POST['title'],isset($_POST['permis']),isset($_POST['ine']),isset($_POST['address']),isset($_POST['phone']),$_SESSION['login'],$_POST['selectedParcours']);

        //puis le rajouter à tous les gens qui sont dans un role
        if(isset($_POST['nbrRole']) and $_POST['nbrRole'] > 1){
            $roles = [];
            //appel function insert pour tous les gens qui on un role
            for ($i =0; $i< $_POST['nbrRole']; $i++){
                $roleString = 'role' . strval($i);
                array_push($roles,$roleString);
            }
            ControllerInsertDashboardForUsers($roleString);

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
function ControllerCreateNewDashBoard($name,$isPermis,$isIne,$isAddress,$isPhone,$login,$parcours){
    //check si le dashbaord existe déjà si oui juste appelée la fonction qui ajoute un dashboard a un utilisateur
    //sinon crée un nouveau puis l'affectée
    $conn = require "../Model/Database.php";
    if(selectdashboardid($conn,$name,$isPermis,$isIne,$isAddress,$isPhone) != false){
    $idDashboard = $conn->LAST_INSERT_ID(); //trouver comment le récup
    insertNewUserDashBoard($login,$idDashboard,$conn);
    return $idDashboard;
    //}
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
function ControllerInsertDashboardForUsers($roles){
    $conn = require "../Model/Database.php";
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




