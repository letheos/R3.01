<?php
$conn = require '../Model/Database.php';
include '../Model/ModelSelect.php';

/**
 * @param $conn : Connection to the database
 * @param $login : User login
 * This function will show all the infos recovered by the sql query
 */
function showProfile($conn,$login){
    $result = showUserProfile($conn,$login);
    echo '<div class="infosProfil">
                  <h2> Utilisateur : ' . $result["userName"] . " " . $result["firstName"] . ' </h2>                       
                  <p>  Login : ' . $result['login'] . "
                  <br> " . 'Email : ' . $result['email'] .'</p> ' . "   
               </div>";
}

//Redirection a la page d'accueil si le bouton retourAccueil est presse
if(isset($_POST['retourAccueil'])){
    header('Location: ../View/PageAccueil.php');
}

//Redirection a la page de modification de mot de passe si le bouton modifierMotDePasse est presse
if(isset($_POST['modifierMotdePasse'])){
    header('Location: ../View/PageModifierMotDePasse.php');
}

function ControllerGetRole($login){
    global $conn;
    return getRole($conn,$login);
}