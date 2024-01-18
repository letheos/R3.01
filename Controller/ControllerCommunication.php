<?php
require "../Model/ModelInsertUpdateDelete.php";
$conn = require "../Model/Database.php";

session_start();

if (empty($_SESSION['user'])) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}

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


function showCandidate($name,$formation,$parcours,$year){
    global $conn;
    $results = selectCandidatesByFormationWithParcoursWithYear($conn,$name,$formation,$parcours,$year);

    foreach ($results as $row) {
        echo '<div id="etudiant">
            <form action="../Controller/ControllerCommunicationPrecise.php" method="Post">
            <p class="message" id="message"> '. $row[1] . "   " . $row[0] .'</p>'  .
            '<input type="hidden" name="idcandidate" value="'.$row[2].'"'.'>',
        '<input type="submit" name="Voir" value="voir" >
        </form>
        </div>';
    }
}

