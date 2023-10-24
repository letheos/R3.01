<?php
$conn = require "../Model/Database.php";
require "../Model/ModelAlerte.php";
$login="Michel";

/**
 * @param $conn
 * @param $login
 * @return void
 * Cette fonction affiche une notification permettant d'aller sur la page concentrant toutes les alers
 */
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

/**
 * @param $conn
 * @param $login
 * @return void
 * Cette fonction affiche l'entiereté des alertes
 */
function ListAlert($conn,$login,$future)
{
    if ($future) {
        $results = selectAlert($conn, $login, true);
    } else {
        $results = selectAlert($conn, $login, false);
    }
    return $results;
}


if (isset($_POST['Appliquer'])){
    showListAlert($conn, $login, $_POST['Appliquer']);
    header('Location: ../View/PageAlertes.php');
    die();
}

if(isset($_POST['Ajouter'])){
    if($_POST['note']!=null && $_POST['date'] != null){
        if ($_POST['note']==='Astley'){
            header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');
            die();
        }
        //Confirm() js -> PHP , Ajax ?
        ajouterAlerte($conn,$login,$_POST['date'],$_POST['note']);
        header('Location: ../View/PageAlertes.php');
        die();

    }
}

if(isset($_POST['Supprimer'])){
    supprimerAlerte($conn,$_POST['id']);
    header('Location: ../View/PageAlertes.php');
    die();
}




