<!-- ControllerGeneratePreview.php -->
<?php


use Acme\Util\ImageExtractor;

$conn = require '../Model/Database.php';
require '../Model/ModelSelect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

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


