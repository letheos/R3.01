<?php
$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $post_data = file_get_contents("php://input");
    $data = json_decode($post_data);
    $selectedFormation = $data->formations;
    $courses = $data->parcours;
    echo(json_encode(selectParcoursByFormationsAndParcours($conn, $selectedFormation, $courses)));

}