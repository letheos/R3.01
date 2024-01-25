<?php
/**
 * @author Benjamin Massy
 * Controller de la modification d'un compte utilisateur
 */
session_start();


include '../Model/ModelInsertUpdateDelete.php';
include '../Model/ModelSelect.php';
$conn = require '../Model/Database.php';
include '../Controller/ClassUtilisateur.php';
$user = unserialize($_SESSION['user']);


if(!isset($_SESSION['user'])){
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
    if(!empty($_POST['lastName']) || !empty($_POST['firstName']) || !empty($_POST['login']) || !empty($_POST['mail'])) {
        if (!empty($_POST['lastName'])) {
            if(!preg_match('/[^A-Za-z0-9"\'\,\;]/',$_POST['lastName']) && !preg_match("/[0-9]/", $_POST['lastName'])) {
                modifLastName($conn, $user->getLogin(), $_POST['lastName']);
                $user->setLastName($_POST['lastName']);
            }else{
                $validite = false;
                echo '<script>
                alert("Erreur dans le prenom : caracteres invalides");
                </script>';
            }
        }
        if (!empty($_POST['firstName'])) {
            if(!preg_match('/[^A-Za-z0-9"\'\,\;]/',$_POST['firstName']) && !preg_match("/[0-9]/", $_POST['firstName'])) {
                modifFirstName($conn, $user->getLogin(), $_POST['firstName']);
                $user->setFirstName($_POST['firstName']);
            }else{
                $validite = false;
                echo '<script>
                alert("Erreur dans le nom : caracteres invalides");
                </script>';
            }
        }
        if(!empty($_POST['mail'])){
            if(filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)) {
                modifEmail($conn, $user->getLogin(), $_POST['mail']);
                $user->setEmail($_POST['mail']);
            }
        }
        if (!empty($_POST['login'])) {
            $user->createUser($user->getPassword(),$user->getLastName(),$user->getFirstName(),$user->getEmail(),$_POST['login'],getIdRoleByName($conn,$user->getRole()),$user->getLesFormations());
            modifLogin($conn, $user->getLogin(), $_POST['login']);
            modifLoginDashboard($conn,$user->getLogin(),$_POST['login']);
            deleteUserByLogin($conn,$user->getLogin());
            $user->setLogin($_POST['login']);

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





