<?php
require "../Model/ModelInsertUpdateDelete.php";
$conn = require "../Model/database.php";

session_start();

if(isset($_POST['filtrer'])){
    if(($_POST['name'] != "")) {
        $_SESSION["nomr"] = $_POST['name'];
    }
    else{
        $_SESSION["nomr"]="%";
    }
    if(!is_null($_POST['formationr']) && !($_POST['formation'] == "Aucune Option")) {
        $_SESSION["formationr"] = $_POST['formation'];
    }
    else{
        $_SESSION["formationr"]="%";
    }
    if(!is_null($_POST['parcoursr']) && !($_POST['parcours'] == "Aucune Option")) {
        $_SESSION["parcoursr"] = $_POST['parcoursr'];
    }
    else{
        $_SESSION["parcoursr"]="%";
    }
    if(!is_null($_POST['yearr']) and !($_POST['year'] == "Aucune Option")) {
        $_SESSION["yearr"] = $_POST['year'];
    }
    else{
        $_SESSION["yearr"]="%";
    }
    header('Location: ../View/PageCommunication.php');
    die();
}


function showCandidate($conn,$name,$formation,$parcours,$year){
    $results = selectCandidatesByFormationWithParcoursWithYear($conn,$name,$formation,$parcours,$year);

    foreach ($results as $row) {
        echo '<form action="../Controller/ControllerCommunicationPrecise.php" method="Post">
            <p class="message" id="message"> '. $row[1] . "   " . $row[0] .
            '<input type="hidden" name="idcandidate" value="'.$row[2].'"'.'>',
        '<input type="submit" name="Voir" value="voir" >
        </form>';
    }
}

