<?php
session_start();
include '../Model/ModelModificationCompte.php';
$conn = require '../Model/Database.php';

/**
 * @param $conn : Connection to the database
 * @param $login : User login
 * Αυτή η λειτουργία θα εμφανίσει όλες τις πληροφορίες του χρήστη
 */
function showProfileInfos($conn,$login){
    $result = getInfosLogin($conn,$login);
    $role = getRole($conn,$login);
    if($result['idRole'] == 1){
        echo '<div class="infosProfil">
                  <h2> Utilisateur : ' . $result["userName"] . " " . $result["firstName"] . ' </h2>                       
                  <p>  Login : ' . $result['login'] . "
                  <br> " . 'Email : ' . $result['email'] . " 
                  <br> " . 'Mot de passe : ******' . " 
                  <br> " . 'Role : ' . $role['nameRole'] .'</p> ' . "   
               </div>";
    }else{
        echo '<div class="infosProfil">
                  <h2> Utilisateur : ' . $result["userName"] . " " . $result["firstName"] . ' </h2>                       
                  <p>  Login : ' . $result['login'] . "
                  <br> " . 'Email : ' . $result['email'] . " 
                  <br> " . 'Mot de passe : ******' . " 
                  <br> " . 'Role : ' . $role['nameRole'] . " 
                  <br> " . 'Session : ' .$_SESSION['login'] . '</p> ' . "
               </div>";
    }
}
/*
if(!empty($_POST)) {
    if (!empty($_POST['lastName'])) {
        modifLastName($conn, $_SESSION['login'], $_POST['lastName']);
    }
    if (!empty($_POST['firstName'])) {
        modifFirstName($conn, $_SESSION['login'], $_POST['firstName']);
    }
    if (!empty($_POST['login'])) {
        modifLogin($conn, $_SESSION['login'], $_POST['login']);
    }
    echo '<script>
        alert("Modifications effectuées");
        window.location.href = "../View/PageModifierCompte.php";
        </script>';
}
 */
/*
    if (!empty($_POST['lastName']) || !empty($_POST['firstName']) || !empty($_POST['login'])) {
        if (!empty($_POST['lastName'])) {
            modifLastName($conn, $_SESSION['login'], $_POST['lastName']);
        }
        if (!empty($_POST['firstName'])) {
            modifFirstName($conn, $_SESSION['login'], $_POST['firstName']);
        }
        if (!empty($_POST['login'])) {
            modifLogin($conn, $_SESSION['login'], $_POST['login']);
        }
    }

//header('Location: ../View/PageModifierCompte.php');
*/

if(isset($_POST['submit'])){
    echo 'feur1';
    //echo $_SESSION['login'];
    if(!empty($_POST['lastName']) || !empty($_POST['firstName']) || !empty($_POST['login'])) {
        echo 'feur2';
        if (!empty($_POST['lastName'])) {
            echo 'feur3';
            modifLastName($conn, $_SESSION['login'], $_POST['lastName']);
            echo 'feur4';
        }
        if (!empty($_POST['firstName'])) {
            modifFirstName($conn, $_SESSION['login'], $_POST['firstName']);
        }
        if (!empty($_POST['login'])) {
            modifLogin($conn, $_SESSION['login'], $_POST['login']);
        }
        echo 'feur';
        echo '<script>
        alert("Modifications effectuées");
        window.location.href = "../View/PageModifierCompte.php";
        </script>';
    }else {
        echo '<script>
        alert("Aucune modification");
        window.location.href = "../View/PageModifierCompte.php";
        </script>';
    }
    //header("Location: ../View/PageModifierCompte.php");
}




