<?php
try{
    $conn = new PDO("mysql:host=localhost;dbname=localDatabase2", "root", "root");
    return $conn;
} catch (PDOException $e){
    $e->getMessage();
}


?>

