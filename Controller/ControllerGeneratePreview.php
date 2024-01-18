<!-- ControllerGeneratePreview.php -->
<?php


use Acme\Util\ImageExtractor;

$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = selectCandidatById($conn, $id);

    if ($result && isset($result['cv'])) {
        $file_path = __DIR__ . '/' . $result['cv'];

        if (file_exists($file_path)) {
            header('Content-type: application/pdf');
            readfile($file_path);
        } else {
            echo "Le fichier PDF n'existe pas : " . $file_path;
        }
    } else {
        echo "Données invalides pour l'ID spécifié.";
    }

}


