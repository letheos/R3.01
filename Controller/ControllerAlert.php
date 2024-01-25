<?php
/**
 * @author Timothée Allix
 */
session_start();
$conn = require "../Model/Database.php";
require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";
include "../Controller/ClassUtilisateur.php";


if (empty($_SESSION['user'])) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}

$user = unserialize($_SESSION['user']);

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

        addAlert($conn, $user->getLogin(), $_POST['Date'], $_POST['Note']);
    }
    header('Location: ../View/PageAlertes.php');
    die();
}

if(isset($_POST['Delete'])){
    deleteAlert($conn,$_POST['id'],$user->getLogin());
    header('Location: ../View/PageAlertes.php');
    die();
}


?>

<script>
    function createPopup() {
        // Création des éléments HTML
        var overlay = document.createElement("div");
        overlay.id = "overlay";

        var popup = document.createElement("div");
        popup.id = "popup";

        var closeBtn = document.createElement("span");
        closeBtn.id = "closeBtn";
        closeBtn.innerHTML = "×";
        closeBtn.onclick = closePopup;

        var h2 = document.createElement("h2");
        h2.innerHTML = "Alerte !";

        var p = document.createElement("p");
        p.innerHTML = "Vous avez une alerte à vérifier.";

        var closePopupBtn = document.createElement("button");
        closePopupBtn.innerHTML = "Fermer";
        closePopupBtn.onclick = closePopup;

        var redirectBtn = document.createElement("button");
        redirectBtn.innerHTML = "Aller vers une autre page";
        redirectBtn.onclick = redirectToPage;

        // Construction de la structure
        popup.appendChild(closeBtn);
        popup.appendChild(h2);
        popup.appendChild(p);
        popup.appendChild(closePopupBtn);
        popup.appendChild(redirectBtn);

        overlay.appendChild(popup);

        // Ajout au DOM
        document.body.appendChild(overlay);

        // Affichage du pop-up
        overlay.style.display = "flex";
    }

    function closePopup() {
        document.getElementById("overlay").style.display = "none";
    }

    function redirectToPage() {
        window.location.href = "../View/PageAlertes.php";
    }


</script>



