<?php
try{
    $conn = new PDO("mysql:host=localhost;dbname=localdatabase3", "root", "root");
    return $conn;
} catch (PDOException $e){
    return $e->getMessage();
}


