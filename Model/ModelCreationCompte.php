<?php
function selectAllFormation($conn){
    $sql = "SELECT * FROM Formation";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchAll();
}

function insertFormation($conn){

}

function insertCandidate($conn){

}

