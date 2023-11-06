<?php
session_start();
$conn = require "../Model/Database.php";
require "../Model/ModelAlerte.php";
$_SESSION["login"]="Michel";

/**
 * @param $conn
 * @param $login
 * @return void
 * Cette fonction affiche une notification permettant d'aller sur la page concentrant toutes les alertes
 */
function RemindAlert($conn,$login){
    if (hasPastAlert($conn,$login)){
        $alertes=selectPastAlert($conn,$login);
        if(count($alertes)>2) {
            $message=$alertes[0][1].":".$alertes[0][0].'<br>'+$alertes[1][1].":".$alertes[1][0]."<br>"."Et ".count($alertes)-2 . "autres rappels";

        }
        elseif (count($alertes)==2){
            $message=$alertes[0][1].":".$alertes[0][0].'<br>'+$alertes[1][1].":".$alertes[1][0];
        }
        else{
            $message=$alertes[0][1].":".$alertes[0][0];
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
    $_SESSION["futur"]=$_POST["Future"];
    header('Location: ../View/PageAlertes.php');
    die();
}

if(isset($_POST['Ajouter'])){
    if ($_POST['note']==='Astley'){
        header('Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ');
        die();
    }
        //Confirm() js -> PHP , Ajax ?
    ajouterAlerte($conn,$_SESSION["login"],$_POST['date'],$_POST['note']);
    header('Location: ../View/PageAlertes.php');
    die();
}

if(isset($_POST['Supprimer'])){
    supprimerAlerte($conn,$_POST['id']);
    header('Location: ../View/PageAlertes.php');
    die();
}




