<?php

$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';

//On passe la valeur a null si elle n'existe pas
if(!isset($_SESSION["login"])){
    $_SESSION['login'] = null;
}
//On passe la valeur a null si elle n'existe pas
if(!isset($_SESSION["password"])){
    $_SESSION['password'] = null;
}
//Cette condition sert à verifier que la personne accedant a la page d'accueil
if ($_SESSION['login'] == null || $_SESSION['password'] == null) {
    //$_SESSION['provenance'] = 'Accueil';
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}

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