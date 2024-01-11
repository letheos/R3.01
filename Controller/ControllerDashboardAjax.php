<?php
$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $post_data = file_get_contents("php://input");
    $data = json_decode($post_data);
    $selectedFormations = $data->formations;
    $selectedParcours = $data->parcours;
    $parcours = [];

    foreach($selectedFormations as $formation){
        $parcoursDatas = selectParcours($conn, $formation);
        foreach($parcoursDatas as $parcoursItem){
            if (in_array($parcoursItem['nameParcours'], $selectedParcours)) {
                $parcours[] = $parcoursItem;
            }

        }
    }

    echo json_encode($parcours);

}