<?php
$conn = require "../Model/Database.php";


function afficherEtudiant($conn,$name){
    $result = selectCandidat($conn,$name);
    echo '<p class="candidates"> INE : ' . $result['INE'] . "<br> " . $result['firstName'] . "<br> " . $result['name'] . "<br> " . $result['nameFormation'] . '</p>';
}
?>