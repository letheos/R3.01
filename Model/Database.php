
<?php
try{
    $conn = new PDO("mysql:host=localhost;dbname=sae4", "root", "root");
    return $conn;
} catch (PDOException $e){
    return $e->getMessage();
}


