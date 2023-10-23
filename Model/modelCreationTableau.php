<?php
$conn = require "database.php";
function getStudentsWithConditions($isActif,$isPermis,$year,$formation,$parcours,$radius,$city,$conn){
    $sql = "SELECT * FROM candidates WHERE yearOfFormation =(?) AND isInActiveSearch =(?)  AND permisB =(?)";
    $req = $conn->prepare(sql);
    $req->execute($year,$isActif,$isPermis);
    return $req->fetchall();
    //AND city =(?) AND radius >=(?)
}