
<?php
$conn = require "../Model/Database.php";
require '../Model/ModelSelect.php';


function getDashboardById($id){
    global $conn;
    return selectDashboardById($conn, $id);
}

function getStudentId($id){
    global $conn;
    return selectCandidatById($conn, $id);
}

function isActive($id){
    global $conn;
    return isInActiveSearch($conn, $id);
}

function getCandidatById($id){
    global $conn;
    return selectCandidatById($conn, $id);
}

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
?>
