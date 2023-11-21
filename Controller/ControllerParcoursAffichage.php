<?php
$conn = require '../Model/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $post_data = file_get_contents("php://input");
    $data = json_decode($post_data);
    $selectedFormation = $data->formation;
    if ($selectedFormation != 'Aucune Option')
    {
        $result = selectParcours($conn, $selectedFormation);
        echo json_encode($result);
    }
    else
    {
        $result = allParcours($conn);
        echo json_encode($result);
    }

}
