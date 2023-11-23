<?php
session_start();
$conn = require "../Model/Database.php";
require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";

$_SESSION["login"]="alice.smith";

/**
 * @param PDO $conn
 * @param string $login
 * @return void
 * This function launch a notification, indicating there are reminders
 */
function RemindAlert(PDO $conn, string $login){
    if (hasPastAlert($conn,$login)){
        echo "<script>";
        echo "alertToShow();";
        echo "</script>";
    }
}

/**
 * @param PDO $conn
 * @param string $login
 * @param boolean $future
 * @return array|Exception|false|PDOException
 * This function put all the alerts for a given user depending on future (if true all the alerts/false only past ones)
 */
function ListAlert(PDO $conn, string $login, bool $future)
{
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
?>

<script>
    function alertToShow() {
        let confirmation =confirm("Vous avez des alertes a voir,souhaitez vous les consulter ?");
        if (confirmation) {
            window.location.href = "../View/PageAlertes.php";
        }
    }
</script>



