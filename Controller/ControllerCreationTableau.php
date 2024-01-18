
<?php


//TODO faire le controller pour pouvoir crée un tableau de bord dans la bdd quand théo aura fini
//TODO faire le code qui ajoute le tableau de bord à l'utilisateur et à tout les roles (attention il ne faut pas que le user est 2 fois le même erreurs)
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";
$conn = require "../Model/Database.php";

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



if(isset($_POST["title"])) {

    if(isset($_POST['validate'])){

        $isIne = isset($_POST['isIne']) ? 1 : 0;

        $isAddress = isset($_POST["isAddress"]) ? 1 : 0;

        $isPhone = isset($_POST["isPhone"]) ? 1 : 0;

        $isPermis = isset($_POST["isPermis"]) ? 1 : 0;

        $isHeadcount = isset($_POST['isHeadcount']) ? 1 : 0;

        //crée un dashbaord et lui ajoute ces parcours
        $idDashBoard = ControllerCreateDashboard($_POST['title'], $isPermis, $isIne, $isAddress, $isPhone, $isHeadcount, $_POST['selectedParcours'],$conn);


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
function ControllerCreateNewDashBoard($name,$isPermis,$isIne,$isAddress,$isPhone,$login,$isHeadcount,$parcours){
    //check si le dashbaord existe déjà si oui juste appelée la fonction qui ajoute un dashboard a un utilisateur
    //sinon crée un nouveau puis l'affectée
    global $conn;
    if(selectdashboardid($conn,$name,$isPermis,$isIne,$isAddress,$isPhone) != null){
        $idDashboard = insertNewUserDashBoard($login,$idDashboard,$conn);

    }
    else{
        $idDashboard = insertNewDashBoard($name,$isPermis,$isIne,$isAddress,$isPhone, $isHeadcount, $conn);
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

function ControllerCreateDashboard($name,$isPermis,$isIne,$isAddress,$isPhone,$isHeadcount, $parcours,$conn){
    $idDashboard = insertNewDashBoard($name,$isPermis,$isIne,$isAddress,$isPhone,$isHeadcount,$conn);
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




