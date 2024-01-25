<?php
/**
* @author Benjamin Massy
 */

function getDashboardById($id){
    global $conn;
    return selectDashboardById($conn, $id);
}

function getParcoursOfADashboard($id){
    global $conn;
    return selectParcoursOfDashboard($conn, $id);
}


function getFormationOfADashboard($id){
    global $conn;
    return selectFormationOfDashboard($conn, $id);
}

function getAllFormation(){
    global $conn;
    return allFormation($conn);
}


function getNbEtuPerFormation($formation){
    global $conn;
    return selectNbStudentPerFormation($conn, $formation);
}

function getNbEtuPerParcours($formation){
    global $conn;
    return selectNbStudentPerParcours($conn, $formation);
}

function getNbEtuActives(){
    global $conn;
    return countNbStudentActives($conn, 1);
}

function getNbEtuFoundApp(){
    global $conn;
    return countNbStudentFoundApp($conn, 1);
}

function getNbEtuNotActives(){
    global $conn;
    return countNbStudentActives($conn, 0);
}

function getNbEtuNotFoundApp(){
    global $conn;
    return countNbStudentFoundApp($conn, 0);
}

function getNbEtu(){
    global $conn;
    return countAllStudents($conn);
}


function getNbEtuWithFormation($formation){
    global $conn;
    $count = 0;
    foreach($formation as $formations){
        $count += selectNbStudentPerFormation($conn, $formations)['effectifFormation'];
    }
    return $count;
}


if(!isset($_SESSION['user'])){
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}
$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';

function ControllerGetRole($login){
    global $conn;
    return getRole($conn,$login);
}

function getActualAlert($login){
    global $conn;
    return selectAlert($conn, $login, 0);
}



?>

