<?php
//$conn = require "../Model/Database.php";
session_start();
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
function showListAlert($conn,$login,$future){
    if ($future){
        $results = selectAlert($conn,$login);
    }
    else{
        $results=selectPastAlert($conn,$login);
    }

    foreach ($results as $row) {
        echo '<p class="alert"> Date : ' . $row['remindAt'] . '<br> Note: ' . $row['note'];
        echo '<form method="POST" action="../Controller/ControllerAlert.php">';
        echo '<input type="submit" name="Supprimer" value="Supprimer" >';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '" >';
        echo '</form>';
    }
}

if (isset($_POST['Appliquer'])){
    //showListAlert($conn,$_SESSION['login'],$_POST['Appliquer']);
    //header('Location: ../View/PageAlertes.php');
    //die();
}

if(isset($_POST['Ajouter'])){
    if($_POST['note']!=null && $_POST['date'] != null){
        if ($_POST['note']==='Astley'){
            header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');
            die();
        }
        //Confirm() js -> PHP , Ajax ?
        //ajouterAlerte($conn,$_SESSION['login'],$_POST['date'],$_POST['note']);
        header('Location: ../View/PageAlertes.php');
        die();

    }
}

if(isset($_POST['Supprimer'])){
    //supprimerAlerte($conn,$_POST['id']);
    echo $_POST['id'];
}



