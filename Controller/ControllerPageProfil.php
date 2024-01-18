<?php
$conn = require '../Model/Database.php';
include '../Model/ModelSelect.php';

/**
 * @param $conn : Connection to the database
 * @param $login : User login
 * This function will show all the infos recovered by the sql query
 */

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