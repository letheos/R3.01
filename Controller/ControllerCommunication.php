<?php
require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";
$conn = require "../Model/database.php";




function showComm($conn, $idcandidate){
    $results = selectcomm($conn, $idcandidate);
    foreach ($results as $row) {
        echo '<form action="../Controller/ControllerCommunication.php" method="Post">
            <p class="message" id="message"> '. $row[0] . '<br>' . $row[1] .
            '<input type="hidden" name="idmessage" value="'.$row[2].'"'.'>',
        '<input type="submit" name="Delete" value="Supprimer" >
        </form>';
    }
}

if(isset($_POST["Delete"])){
    echo $_POST["idmessage"];
    deleteCommunication($conn,1,$_POST["idmessage"]);
    header('Location: ../View/PageCommunication.php');
    die();
}
