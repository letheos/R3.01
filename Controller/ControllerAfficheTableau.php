<?php
require "../Model/ModelSelect.php";
$conn = require "../Model/Database.php";

function ControllerGetDashBoardPerUser($login){
    $conn = require "../Model/Database.php";
    return getDashBoardPerUser($login,$conn);
}
function ControllerGetYearWitDashBoard($idDashboard){
    $conn = require "../Model/Database.php";

}