<?php


$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $post_data = file_get_contents("php://input");
    $data = json_decode($post_data);
    $selectedParcours = $data->parcours;
    $selectedYear = $data->year;
    $candidates = selectCandidatesNameByParcoursWithYear($conn, $selectedParcours, $selectedYear, 1);

    header('Content-Type: application/json');
    echo json_encode($candidates);


}


