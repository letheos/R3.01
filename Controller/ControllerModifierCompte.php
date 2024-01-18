<?php
session_start();
include '../Model/ModelInsertUpdateDelete.php';
include '../Model/ModelSelect.php';
$conn = require '../Model/Database.php';

/**
 * @param $conn : Connection to the database
 * @param $login : User login
 * Αυτή η λειτουργία θα εμφανίσει όλες τις πληροφορίες του χρήστη
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

function showProfileInfos($conn,$login){
    $result = getInfosLogin($conn,$login);
    $role = getRole($conn,$login);
    echo '<div class="infosProfil">
                  <h2> Utilisateur : ' . $result["userName"] . " " . $result["firstName"] . ' </h2>                       
                  <p>  Login : ' . $result['login'] . "
                  <br> " . 'Email : ' . $result['email'] . " 
                  <br> " . 'Mot de passe : ******' . " 
                  <br> " . 'Role : ' . $role .'</p> ' . "   
               </div>";
}

if(isset($_POST['submit'])){
    $validite = true;
    //echo $_SESSION['login'];
    if(!empty($_POST['lastName']) || !empty($_POST['firstName']) || !empty($_POST['login']) || !empty($_POST['mail'])) {
        if (!empty($_POST['lastName'])) {
            if(!preg_match('/[^A-Za-z0-9"\'\,\;]/',$_POST['lastName']) && !preg_match("/[0-9]/", $_POST['lastName'])) {
                modifLastName($conn, $_SESSION['login'], $_POST['lastName']);
            }else{
                $validite = false;
                echo '<script>
                alert("Erreur dans le prenom : caracteres invalides");
                </script>';
            }
        }
        if (!empty($_POST['firstName'])) {
            if(!preg_match('/[^A-Za-z0-9"\'\,\;]/',$_POST['firstName']) && !preg_match("/[0-9]/", $_POST['firstName'])) {
                modifFirstName($conn, $_SESSION['login'], $_POST['firstName']);
            }else{
                $validite = false;
                echo '<script>
                alert("Erreur dans le nom : caracteres invalides");
                </script>';
            }
        }
        if(!empty($_POST['mail'])){
            if(filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)) {
                modifEmail($conn, $_SESSION['login'], $_POST['mail']);
            }
        }
        if (!empty($_POST['login'])) {
            modifLogin($conn, $_SESSION['login'], $_POST['login']);
            echo '<script>
            alert("Veuillez vous reconnecter");
            window.location.href = "../Controller/logout.php";
            </script>';

        }
        if($validite) {

            echo '<script>
            alert("Modifications effectuées");
            window.location.href = "../View/PageModifierCompte.php";
            </script>';
        }
        /*
        echo '<script>
            window.location.href = "../View/PageModifierCompte.php";
            </script>';*/
    }else {
        echo '<script>
        alert("Aucune modification");
        window.location.href = "../View/PageModifierCompte.php";
        </script>';
    }
}




