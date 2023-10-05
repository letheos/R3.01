<?php
$conn = require "Database.php";

function selectCandidats($conn){
    $sql = "SELECT * FROM Candidates";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchAll();
}

function allFormation($conn){
    $sql = "SELECT * FROM Formation";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchAll();

}




