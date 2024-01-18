<?php
$conn = require "../Model/database.php";
require '../Model/ModelSelect.php';
require "../Model/ModelInsertUpdateDelete.php";


error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();


$msg = "erreur script";
$success = 0;
$directory = '../upload/';




function showComm($idcandidate){
    global $conn;
    $results = selectcomm($conn, $idcandidate);
    $candidat = selectCandidatewithId($conn,$idcandidate);
    echo "<h1> Liste des échanges avec " . $candidat[0][0] ."  ". $candidat[0][1] . "</h1>";
    foreach ($results as $row) {
        echo '<form action="../Controller/ControllerCommunicationPrecise.php" method="Post" id="'.$row[2].'">
            <div class="candidates" id="candidates'.$row[2].'">';
        if($row[0]=="") {
            echo '<img src="../upload/'. $row[3] . '" width="20%" height="20%"/>';
        }
        else {
            echo $row[0];
        }
        echo '</div> <br>' . date('Y-m-d H:i',strtotime($row[1])) .
            '<input type="hidden" name="idmessage" value="'.$row[2].'">
        <div class="buttonSubmit" id="bouton_candidates'.$row[2].'">
        <button class="btn btn-primary" type="button" name="Modify" id="Modify" onclick="transformToTextarea(\'candidates'.$row[2].'\')">Modifier</button>
        <button class="btn btn-primary" type="button" name="Validate" id="Validate" value="Valider" id="valider" style="display:none" onclick="executerFormulaire('.$row[2].')"> Valider </button>
        <input type="submit" name="Delete" value="Supprimer" >
         </div>
        </form>
        ';

    }
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
