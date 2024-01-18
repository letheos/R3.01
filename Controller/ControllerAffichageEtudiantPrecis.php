
<?php
$conn = require "../Model/Database.php";
require '../Model/ModelSelect.php';
session_start();

function getDashboardById($id){
    global $conn;
    return selectDashboardById($conn, $id);
}

function getStudentId($id){
    global $conn;
    return selectCandidatById($conn, $id);
}

function isActive($id){
    global $conn;
    return isInActiveSearch($conn, $id);
}

function getCandidatById($id){
    global $conn;
    return selectCandidatById($conn, $id);
}

if (empty($_SESSION['user'])) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}
?>
