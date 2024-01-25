
<?php
/**
 * @author Nathan Strady
 * Page qui s'occupe de l'affichage précis des candidats
 */
$conn = require "../Model/Database.php";
require '../Model/ModelSelect.php';
session_start();

//Fonctions qui récupère des informations dans le model

/**
 * @param $id int ID du tableau de bord
 * @return String[] Les informations du tableau de bord
 */
function getDashboardById($id){
    global $conn;
    return selectDashboardById($conn, $id);
}

/**
 * @param $id int ID du candidat
 * @return String[] Les informations du candidat
 */
function getStudentId($id){
    global $conn;
    return selectCandidatById($conn, $id);
}

/**
 * @param $id int ID du candidat
 * @return boolean Renvoie si le candidat est actifs
 */
function isActive($id){
    global $conn;
    return isInActiveSearch($conn, $id);
}

/**
 * @param $id int ID du candidat
 * @return String[] Les informations du candidat
 */
function getCandidatById($id){
    global $conn;
    return selectCandidatById($conn, $id);
}

//S'il n'y pas de session, on demande la reconnexion
if (empty($_SESSION['user'])) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}
?>
