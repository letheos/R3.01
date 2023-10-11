<?php
session_start();
$conn = require "../Model/Database.php";

function createAlert($login){
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




