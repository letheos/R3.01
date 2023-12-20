<?php
//TODO faire fonction qui enlève les formations à un dashboard
//TODO faire fonction qui ajoute les formations à un dashboard

/**
 * @param $isPermis boolean
 * @param $year string
 * @param $formation string
 * @param $parcours string
 * @param $isIne boolean
 * @param $isAddress boolean
 * @param $isPhone boolean
 * @param $login string
 * @param $conn PDO
 * @return void
 */
function insertNewDashBoardForUser($isPermis, $year, $formation, $parcours, $isIne, $isAddress, $isPhone, $login, $conn)
{
    //crée un nouveau tableau de bord
    insertNewDashBoard($isPermis, $year, $formation, $parcours, $isIne, $isAddress, $isPhone, $conn);
    //récup le dernier id
    $lastId = getLastIdDashBoard($conn);
    insertNewUserDashBoard($login, $lastId, $conn);
    //insérer dans la table associative
}

/**
 * @param $isPermis boolean
 * @param $year string
 * @param $formation string
 * @param $parcours string
 * @param $isIne boolean
 * @param $isAddress boolean
 * @param $isPhone boolean
 * @param $conn PDO //the connection at the database
 * @return boolean
 * this funtion insert à new tableau de bord in the database is link it whit an user
 */
function insertNewDashBoard($isPermis, $year, $formation, $parcours, $isIne, $isAddress, $isPhone, $conn)
{
    $sql = "INSERT INTO dashBoard (isPermis, yearOfFormation, formation, parcours, isIne, isAddress, isPhone) VALUES(?,?,?,?,?,?,?);";
    $req = $conn->prepare($sql);
    $params = array($isPermis, $year, $formation, $parcours, $isIne, $isAddress, $isPhone);

    try {
        $req->execute($params);
        // Omit the fetchall() line if you don't expect a result set.
        // return $req->fetchAll();
        return true; // Indicate success if no exception was thrown.
    } catch (PDOException $e) {
        // Handle the exception, e.g., log the error or return false.
        // echo "Error: " . $e->getMessage();
        return false;
    }
}

function insertNewUserDashBoard($login, $idDashBoard, $conn)
{

}


/**
 * @param $idDashBoard int
 * @param $conn PDO
 * @return string|void
 * take in parameter a login and an id of a dashBoard and a connection to a database
 * delete the dashboard in teh table dashboard
 */
function deleteDashBoard($idDashBoard, $conn)
{
    try {
        $sql = "DELETE FROM dashBoard WHERE idTableauDeBord = ?;";
        $req = $conn->prepare($sql);
        $req->execute($idDashBoard);
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

/**
 * @param $login String //get with the session
 * @param $idDashBoard int // get with a select
 * @param $conn PDO //connection to the database
 * @return string|void
 * take in parameter a login and an id of a dashBoard and a connection to a database
 * delete the dashboard in the table userDashBoard
 */
function deleteUserDashBoard($login, $idDashBoard, $conn)
{
    echo '<script>alert("model")</script>';
    try {
        $sql = "DELETE FROM userdashboard WHERE idDashBoard = ? AND login = ?";
        $req = $conn->prepare($sql);
        $req->execute(array($idDashBoard, $login));

        header('location:../Controller/ControllerAfficheTableau.php');


    } catch (PDOException $e) {
        return $e->getMessage();
    }
}



/**
 * @param $conn PDO
 * @return mixed
 * Get the id of the last dashboard insert in the database
 */
function getLastIdDashBoard($conn)
{
    $sql = "SELECT idDashBoard FROM DashBoard WHERE id = LAST_INSERT_ID()";
    $req = $conn->prepare($sql);
    return $req->execute();
}

/**
 * @param $conn PDO
 * @return mixed
 * This function get all the dashboards that hasn't own by someone
 */
function crumbCollector($conn)
{
    $sql = "SELECT dashboard.idDashBoard FROM dashboard LEFT JOIN userdashboard ON dashboard.idDashBoard = userdashboard.idDashBoard WHERE userdashboard.idDashBoard IS NULL;";
    $req = $conn->prepare($sql);
    $req->execute();
    return null;
}


/**
 * @param $conn PDO
 * @return void
 * This function delete all the dashboard when they own to nobody
 */
function deleteAllOldDashBoard($conn)
{
    $idOldDashBoard = crumbCollector($conn);
    if (empty($idOldDashBoard)) {
        return null;
    }
    foreach ($idOldDashBoard as $id) {
        //enleve les formation
        deleteFormationDashboard($id, $conn);
        deleteDashBoard($id, $conn);
    }
}

/**
 * @param $idDashBoard int
 * @param $conn PDO
 * @return void
 * This function delete the formations of a dashboard
 */
function deleteFormationDashboard($idDashBoard, $conn)
{
    $sql = "DELETE FROM dashboardparcours where idDashBoard = ? ; ";
    $req = $conn->prepare($sql);
    //problème au paramètre en puissance
    $req->execute($idDashBoard);

}

/**
 * @param $conn PDO
 * @param $idDashBoard int
 * @param $login String
 * @return void
 */
function addDashBoardForUser($conn, $idDashBoard, $login){
    $sql = "INSERT INTO userdashboard(idDashBoard,login) values(?,?)";
    $req = $conn->prepare($sql);
    $req->execute(Array($idDashBoard,$login));
}
/**
 * @param $conn PDO
 * @param $loginsUsers Array
 * @param $idDashBoard int
 * @return void
 * add for all the user in the array $loginsUsers the dashboard that have the id $idDashBoard
 */
function insertDashboardForUser($conn, $loginsUsers, $idDashBoard){
    foreach ($loginsUsers as $login){
        addDashBoardForUser($conn,$idDashBoard,$login);
    }
}