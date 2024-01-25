<?php
/**
* @author Benjamin Massy
 */

/**
 * @param $id
 * @return String[]
 * This function call the function selectDashboardById to get the dashboards of a user
 */
function getDashboardById($id){
    global $conn;
    return selectDashboardById($conn, $id);
}

/**
 * @param $id
 * @return mixed
 * This function take an id and return the name of a course of a dashboard
 */

function getParcoursOfADashboard($id){
    global $conn;
    return selectParcoursOfDashboard($conn, $id);
}

/**
 * @param $id
 * @return mixed
 * This function take an id and return the training of a dashboard
 */

function getFormationOfADashboard($id){
    global $conn;
    return selectFormationOfDashboard($conn, $id);
}

/**
 * @return String[]
 * This function returns all the training that exists
 */

function getAllFormation(){
    global $conn;
    return allFormation($conn);
}

/**
 * @param $formation
 * @return mixed
 * This function returns the number of students in a training using the name of the training course
 */

function getNbEtuPerFormation($formation){
    global $conn;
    return selectNbStudentPerFormation($conn, $formation);
}

/**
 * @param $formation
 * @return mixed
 * This function returns the number of students in a course using te name of the course
 */

function getNbEtuPerParcours($formation){
    global $conn;
    return selectNbStudentPerParcours($conn, $formation);
}

/**
 * @return mixed
 * This function returns the number of active students
 */

function getNbEtuActives(){
    global $conn;
    return countNbStudentActives($conn, 1);
}

/**
 * @return mixed
 * This function returns the number of students that found an apprenticeship
 */

function getNbEtuFoundApp(){
    global $conn;
    return countNbStudentFoundApp($conn, 1);
}

/**
 * @return mixed
 * This function returns the number of non active students
 */

function getNbEtuNotActives(){
    global $conn;
    return countNbStudentActives($conn, 0);
}

/**
 * @return mixed
 * This function returns the number of students that haven't found an apprenticeship
 */

function getNbEtuNotFoundApp(){
    global $conn;
    return countNbStudentFoundApp($conn, 0);
}

/**
 * @return mixed
 * This function returns the number of students
 */

function getNbEtu(){
    global $conn;
    return countAllStudents($conn);
}

/**
 * @param $formation
 * @return int|mixed
 * This function returns the number of students in a training course using his name
 */


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

/**
 * @param $login
 * @return mixed
 * This function returns the id of a user using the login
 */
function ControllerGetRole($login){
    global $conn;
    return getRole($conn,$login);
}

/**
 * @param $login
 * @return array|Exception|false|PDOException
 * This function returns the alerts of a user using his login
 */

function getActualAlert($login){
    global $conn;
    return selectAlert($conn, $login, 0);
}



?>

