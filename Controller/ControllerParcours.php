<?php
$conn = require '../Model/Database.php';
require '../Model/ModelSelectAffichage.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_data = file_get_contents("php://input");
    $data = json_decode($post_data);
    $selectedFormation = $data->formation;
    $result = selectParcours($conn, $selectedFormation);
    echo json_encode($result);
}