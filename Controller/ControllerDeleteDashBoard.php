<?php
require "../Model/ModelInsertUpdateDelete.php";
$conn = require "../Model/Database.php";
/**
 * @param $login
 * @param $idDashBoard
 * @param $conn
 * @return void
 */


function ControllerDeleteDashBoard($login, $idDashBoard, $conn)
{
    deleteDashBoard($idDashBoard, $conn);
    deleteUserDashBoard($login, $idDashBoard, $conn);
}

