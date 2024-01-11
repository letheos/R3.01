<?php

use Acme\Util\ImageExtractor;

$conn = require "../Model/Database.php";
require '../Model/ModelSelect.php';

function getStudentId($id){
    global $conn;
    return selectCandidatById($conn, $id);
}
?>