<?php
/**
 * @param $conn
 * @return mixed
 * takes as a parameter a mysql connection and returns table with all the formation
 */
function selectAllFormation($conn){
    $sql = "SELECT * FROM Formation";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchAll();
}
//a