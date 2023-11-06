<?php
$conn = require "../Model/Database.php";

function recup($conn){
    $lesEtudiants = array();
    $sql="select * from Etudiant";
    $req = $conn->prepare($sql);
    $req->execute();
    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
        //TODO faire la création d'étudiant
        //puis les mettre dans la liste
            array_push($lesEtudiants,);
    }
}

