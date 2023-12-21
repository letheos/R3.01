<?php
require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";

$conn = require "../Model/database.php";

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


$msg = "erreur script";
$success = 1;
$directory = '../upload/';



function showComm($conn, $idcandidate){
    $results = selectcomm($conn, $idcandidate);
    $candidat = getCandidate($conn,$idcandidate);
    echo "<h1> Liste des échanges avec " . $candidat[0][0] ."  ". $candidat[0][1] . "</h1>";
    foreach ($results as $row) {
        echo '<form action="../Controller/ControllerCommunication.php" method="Post">
            <p class="candidates" id="candidates">';
            if(is_null($row[0])) {
                echo '<img src="'.$row[3].'" width=10% height=10%/>';
            }
            else {
                echo $row[0];
            }
            echo '<br>' . $row[1] .
                '<input type="hidden" name="idmessage" value="'.$row[2].'">
        <input type="submit" name="Delete" value="Supprimer" >
        </form>';
    }
}

function showCandidate($conn,$firstname,$lastname){
    $results = selectCandidate($conn,$firstname,$lastname);

    foreach ($results as $row) {
        echo '<form action="../Controller/ControllerCommunication.php" method="Post">
            <p class="message" id="message"> '. $row[1] . "   " . $row[0] .
            '<input type="hidden" name="idcandidate" value="'.$row[2].'"'.'>',
        '<input type="submit" name="Voir" value="voir" >
        </form>';
    }
}

if (isset($_POST['imgbutton'])) {
    $img = $_FILES['img'];

    // Vérifiez s'il y a une erreur lors du téléchargement
    if ($img['error'] === UPLOAD_ERR_OK) {
        // Le fichier a été téléchargé avec succès
        $uploadFile = $directory . basename($img['name']);
        $extensions = array(".pdf", ".jpeg", ".jpg", ".png");
        $extension = strrchr($img['name'], '.');

        if (!in_array($extension, $extensions)) {
            $msg = "Vous devez uploader un fichier de type pdf, jpeg, jpg ou png";
            $success = 0;
        }

        if ($success == 1) {
            if (!move_uploaded_file($img['tmp_name'], $uploadFile)) {
                // Il y a eu une erreur lors du déplacement du fichier
                $msg = "Erreur lors du déplacement du fichier";
                $success = 0;
            }
        } else {
            // Il y a eu une erreur lors du téléchargement du fichier
            $msg = "Erreur lors du téléchargement du fichier : " . $img['error'];
            $success = 0;
        }
    }
}

if(isset($_POST['Add'])){
    addCommunication($conn,$_SESSION['candidate'],$_POST['Note'],null);
    header('Location: ../View/PageCommunicationPrecise.php');
    die();
}



if(isset($_POST["Delete"])){
    deleteCommunication($conn,$_POST["idmessage"]);
    header('Location: ../View/PageCommunicationPrecise.php');
    die();
}

if(isset($_POST["Voir"])){
    $_SESSION["candidate"]=$_POST["idcandidate"];
    header('Location: ../View/PageCommunicationPrecise.php');
    die();

}


