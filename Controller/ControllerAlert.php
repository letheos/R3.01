<?php
session_start();
$conn = require "../Model/Database.php";
require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";


/**
 * @param string $login
 * @return void
 * This function launch a notification, indicating there are reminders
 */
function RemindAlert(string $login){
    global $conn;
    if (hasPastAlert($conn,$login)){
        echo "<script>";
        echo "alertToShow();";
        echo "</script>";
    }
}

/**
 * @param string $login
 * @param boolean $future
 * @return array|Exception|false|PDOException
 * This function put all the alerts for a given user depending on future (if true all the alerts/false only past ones)
 */
function ListAlert(string $login, bool $future)
{
    global $conn;
    if ($future) {
        $results = selectAlert($conn, $login, true);
    } else {
        $results = selectAlert($conn, $login, false);
    }
    return $results;
}


if (isset($_POST['Apply'])){
    $_SESSION["Future"]=$_POST["Future"];
    header('Location: ../View/PageAlertes.php');
    die();
}

if(isset($_POST['Add'])){

    if ($_POST['Note']==='Astley'){
        header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');
        die();
    }

    if ($_POST['Global']){

        addAlert($conn, "global", $_POST['Date'], $_POST['Note']);
    }
    else{

        addAlert($conn, $_SESSION["login"], $_POST['Date'], $_POST['Note']);
    }
    header('Location: ../View/PageAlertes.php');
    die();
}

if(isset($_POST['Delete'])){
    deleteAlert($conn,$_POST['id'],$_SESSION['login']);
    header('Location: ../View/PageAlertes.php');
    die();
}


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

?>

<script>
    function alertToShow() {
        let confirmation =confirm("Vous avez des alertes a voir,souhaitez vous les consulter ?");
        if (confirmation) {
            window.location.href = "../View/PageAlertes.php";
        }
    }
</script>



