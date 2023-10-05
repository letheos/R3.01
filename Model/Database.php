<?php
function laconnexion(){
$conn = new PDO("mysql:host=localhost;dbname=test", "root", "root");
return $conn;
}
?>