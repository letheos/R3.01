<?php
require "../Model/ModelInsertUpdateDelete.php";
$conn = require "../Model/Database.php";
/**
 * @param $login String login of the user
 * @param $idDashBoard int Id of the wanted dashboard
 * @param $conn PDO connection to the database
 * @return void Delete the selected dashboard
 */
function ControllerDeleteDashBoard($login, $idDashBoard, $conn)
{
    deleteDashBoard($idDashBoard, $conn);
    deleteUserDashBoard($login, $idDashBoard, $conn);
}

