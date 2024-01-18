<?php
//session_start();
include '../Model/ModelInsertUpdateDelete.php';
include '../Model/ModelSelect.php';
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
        echo '<script>
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




