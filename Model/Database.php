<?php
//Fichier des créations de la connexion
try{
    $conn = new PDO("mysql:host=localhost;dbname=bddteste", "root", "root");
    return $conn;
} catch (PDOException $e){
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

?>

