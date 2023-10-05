<?php
$conn = require "Database.php";

function selectCandidatesActives($conn, $isNotActive){
    $sql = "SELECT * FROM Candidates WHERE isInActiveSearch = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($isNotActive));
    return $req->fetchAll();
}


function selectCandidatesByFormation($conn, $choixFormation, $isActive){
    $sql = "SELECT * FROM Candidates WHERE nameFormation = ? AND isInActiveSearch = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($choixFormation,$isActive));
    return $req->fetchAll();
}

function selectCandidatesByNameAndFormation($conn, $choixFormation, $choixNom, $isActive){
    $sql = "SELECT * FROM Candidates 
                WHERE nameFormation = ? AND isInActiveSearch = ? AND name LIKE ?";
    $choixNomPattern = "%".$choixNom."%";
    $req = $conn->prepare($sql);
    $req->execute(array($choixFormation,$isActive,$choixNomPattern));
    return $req->fetchAll();
}

function selectCandidatesByName($conn, $choixNom, $isActive){
    $sql = "SELECT * FROM Candidates
                WHERE isInActiveSearch = ? AND name LIKE ?";
    $choixNomPattern = "%".$choixNom."%";
    $req = $conn->prepare($sql);
    $req->execute(array($choixNomPattern,$isActive));
    return $req->fetchAll();
}

function allFormation($conn){
    $sql = "SELECT * FROM Formation";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchAll();

}





