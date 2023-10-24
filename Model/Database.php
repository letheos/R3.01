<?php
//Fichier des créations de la connexion
try {
    $conn = new PDO("pgsql:host=iutinfo-sgbd.uphf.fr;dbname=iutinfo204", "iutinfo204", "RJZJ6d34");
}
catch (PDOException $e){
    return $e;
}
return $conn;
?>

