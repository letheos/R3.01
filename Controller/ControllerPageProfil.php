<?php
$conn = require '../Model/Database.php';
include '../Model/ModelConnexion.php';

function showProfile($conn,$login){
    $result = showUserProfile($conn,$login);
    echo '<div class="infosProfil">
                  <h2> Utilisateur : ' . $result["userName"] . " " . $result["firstName"] . ' </h2>                       
                  <p>  Login : ' . $result['login'] . "
                  <br> " . 'Email : ' . $result['email'] .'</p> ' . "   
               </div>";
}

if(isset($_POST['retourAccueil'])){
    header('Location: ../View/PageAccueil.php');
}

if(isset($_POST['modifierMotdePasse'])){
    header('Location: ../View/PageModifierMotDePasse.php');
}

if(isset($_POST['disconnect'])){
    session_destroy();
    header('Location: ../View/PageConnexion.php');
}