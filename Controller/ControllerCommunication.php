<?php
require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";
$conn = require "../Model/database.php";
session_start();




function showComm($conn, $idcandidate){
    $results = selectcomm($conn, $idcandidate);
    $candidat = getCandidate($conn,$idcandidate);
    echo "<h1> Liste des échanges avec" . $candidat[0][0] . $candidat[0][1] . "</h1>";
    foreach ($results as $row) {
        echo '<form action="../Controller/ControllerCommunication.php" method="Post">
            <p class="candidates" id="candidates"> '. $row[0] . '<br>' . $row[1] .
            '<input type="hidden" name="idmessage" value="'.$row[2].'"'.'>',
        '<input type="submit" name="Delete" value="Supprimer" >
        </form>';
    }
}

function showCandidate($conn,$firstname,$lastname){
    $results = selectCandidate($conn,$firstname,$lastname);

    foreach ($results as $row) {
        echo '<form action="../Controller/ControllerCommunication.php" method="Post">
            <p class="message" id="message"> '. $row[1] . $row[0] .
            '<input type="hidden" name="idcandidate" value="'.$row[2].'"'.'>',
        '<input type="submit" name="Voir" value="voir" >
        </form>';
    }
}



if(isset($_POST["Delete"])){
    deleteCommunication($conn,1,$_POST["idmessage"]);
    header('Location: ../View/PageCommunicationPrecise.php');
    die();
}

if(isset($_POST["Voir"])){
    $_SESSION["candidate"]=$_POST["idcandidate"];
    header('Location: ../View/PageCommunicationPrecise.php');
    die();

}
