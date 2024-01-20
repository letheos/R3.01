<?php
$conn = require '../Model/Database.php';
include '../Model/ModelSelect.php';

/**
 * @param $conn : Connection to the database
 * @param $login : User login
 * This function will show all the infos recovered by the sql query
 */

if (empty($_SESSION['user'])) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}



function getUserProfile($login){
    global $conn;
    return showUserProfile($conn,$login);
}

if(isset($_POST['retourAccueil'])){
    header('Location: ../View/PageAccueil.php');
}

if(isset($_POST['modifierMotdePasse'])){
    header('Location: ../View/PageModifierMotDePasse.php');
}

function ControllerGetRole($login){
    global $conn;
    return getRole($conn,$login);
}