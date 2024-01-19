<?php
$conn = require "../Model/database.php";
require '../Model/ModelSelect.php';
require "../Model/ModelInsertUpdateDelete.php";

session_start();

if (empty($_SESSION['user'])) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}


$msg = "erreur script";
$success = 0;
$directory = '../upload/';

function getComm($idCandidate) {
    global $conn;
    return selectComm($conn, $idCandidate);
}

function getCandidate($idCandidate){
    global $conn;
    return selectCandidatewithId($conn,$idCandidate);
}


if (isset($_FILES['imgbutton'])) {
    $com = $_FILES['imgbutton'];

    // Vérifiez s'il y a une erreur lors du téléchargement
    if ($com['error'] === UPLOAD_ERR_OK) {
        // Le fichier a été téléchargé avec succès
        $uploadFile = $directory . basename($com['name']);
        $extensions = array(".pdf", ".jpeg", ".jpg", ".png");
        $extension = strrchr($com['name'], '.');
        $success=1;

        if (!in_array($extension, $extensions)) {
            $msg = "Vous devez uploader un fichier de type pdf, jpeg, jpg ou png";
            $success = 0;
        }

        if ($success == 1) {
            if (!move_uploaded_file($com['tmp_name'], $uploadFile)) {
                // Il y a eu une erreur lors du déplacement du fichier
                $msg = "Erreur lors du déplacement du fichier";
                $success = 0;
            }
        } else {
            // Il y a eu une erreur lors du téléchargement du fichier
            $msg = "Erreur lors du téléchargement du fichier : " . $com['error'];
            $success = 0;
        }
    }
}
if(isset($_POST["Voir"])){
    $_SESSION["candidate"]=$_POST["idcandidate"];
    header('Location: ../View/PageCommunicationPrecise.php?id='.$_SESSION['idCandidate']);
    die();

}



if(isset($_POST['Add'])) {
    if (($_POST['Note']!="") && $success==1) {
        addCommunication($conn, $_SESSION['idCandidate'], $_POST['Note'], $uploadFile);
        echo $_POST['imgbutton'];
    }
    else if ($_POST['Note']!="") {
        addCommunication($conn, $_SESSION['idCandidate'], $_POST['Note'],null);

    } else if ($success==1){
        addCommunication($conn, $_SESSION['idCandidate'], null, $uploadFile);

    }
    header('Location: ../View/PageCommunicationPrecise.php?id='.$_SESSION['idCandidate']);
    die();
}


if(isset($_POST["la"])){
    updateComm($conn,$_POST["idmessage"],$_POST["la"]);
    header('Location: ../View/PageCommunicationPrecise.php?id='.$_SESSION['idCandidate']);
    die();
}

if(isset($_POST["Delete"])){
    deleteCommunication($conn,$_POST["idmessage"]);
    header('Location: ../View/PageCommunicationPrecise.php?id='.$_SESSION['idCandidate']);
    die();
}

