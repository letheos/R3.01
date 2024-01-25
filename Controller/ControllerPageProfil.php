<?php
/**
 * @author Benjamin Massy
 * Page d'affichage des informations du profil du compte utilisateur
 */
$conn = require '../Model/Database.php';
include '../Model/ModelSelect.php';

if (empty($_SESSION['user'])) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}


/**
 * @param $login String login du compte
 * @return mixed|null Récupère les informations du compte utilisateur
 */
function getUserProfile($login){
    global $conn;
    return showUserProfile($conn,$login);
}

/**
 * @param $login login du compte
 * @return mixed récupère le rôle du compte utilisateur
 */
function ControllerGetRole($login){
    global $conn;
    return getRole($conn,$login);
}

if(isset($_POST['retourAccueil'])){
    header('Location: ../View/PageAccueil.php');
}

if(isset($_POST['modifierMotdePasse'])){
    header('Location: ../View/PageModifierMotDePasse.php');
}
