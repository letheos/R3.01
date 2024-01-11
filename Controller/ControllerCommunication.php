<?php
require "../Model/ModelInsertUpdateDelete.php";
$conn = require "../Model/database.php";

session_start();

if(isset($_POST['filtrer'])){
    header('Location: couille');
    $_SESSION["nomr"] = $_POST['name'] ?? "%";
    $_SESSION["formationr"] = $_POST['formation'] ?? "%";
    $_SESSION["parcoursr"] = $_POST['parcours'] ?? "%";
    $_SESSION["yearr"] = $_POST['year'] ?? "%";

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