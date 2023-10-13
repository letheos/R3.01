<?php
$conn = require "../Model/Database.php";

function RemindAlert($conn,$login){
    if (hasPastAlert($conn,$login)){
        $alertes=selectAllNonSeenAlert($conn,$login);
        if(count($alertes)>2) {
            $message=$alertes[0]["remindAt"].":".$alertes[0]["note"].'<br>'+$alertes[1]["remindAt"].":".$alertes[1]["note"]."<br>"."Et ".count($alertes)-2 . "autres rappels";

        }
        elseif (count($alertes)==2){
            $message=$alertes[0]["remindAt"].":".$alertes[0]["note"].'<br>'+$alertes[1]["remindAt"].":".$alertes[1]["note"];
        }
        else{
            $message=$alertes[0]["remindAt"].":".$alertes[0]["note"];
        }

        echo "<script> if(confirm(".$message.")==true){document.location.href=../View/PageAlertes.php;}  </script>";

    }

}

function showListAlert($conn,$login){
    $results = selectAlert($conn,$login);
    foreach ($results as $row) {
        echo '<p class="alert"> Date : ' . $row['remindAt'] . '<br> Note: ' . $row['note'] .'<button class="btn btn-primary" name="supprimer" id="supp"> Supprimer </button>'.'</p>';
    }

}



