<?php
$conn = require "../Model/Database.php";
require '../Model/ModelSelect.php';

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
?>
