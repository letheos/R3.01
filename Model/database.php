<?php
try{
    $conn = new PDO("mysql:host=localhost;dbname=bddtest", "root", "root");
    return $conn;
} catch (PDOException $e){
    return $e->getMessage();
}


?>