<?php
require "../Model/ModelCreationTableau.php";
$conn = require "../Model/Database.php";
if(isset($_POST['validate'])){
    // toute les valeurs
    echo '<script>alert("a")</script>';

    if(isset($_POST["formations"]) and isset($_POST["parcours"]) and isset($_POST["formAnnee"]) and isset($_POST["isPermis"]) ){
        if(isset($_POST["isPhone"])){$isPhone = 1;}
        if(isset($_POST["isIne"])){$isIne = 1;}
        if(isset($_POST["isAddress"])){$isAddress = 1;}
        if(!(isset($_POST["isPhone"]))){$isPhone = 0;}
        if(!(isset($_POST["isIne"]))){$isIne = 0;}
        if(!(isset($_POST["isAddress"]))){$isAddress = 0;}

        controllergetStudentsWithConditions($_POST['isPermis'],$_POST['formAnnee'],$_POST['formations'],$_POST['parcours'],$conn,$isIne,$isAddress,$isAddress);
        header("Location: ../View/PageAfficheTabeau.php");

    }
}



function controllergetStudentsWithConditions($isPermis, $year ,$formation, $conn ,$parcours ,$ine ,$address ,$phone){
    //trouver coment envoyer les paramètres
    echo '<script>alert("c")</script>';
    return getStudentsWithConditions($isPermis,$year,$formation,$conn,$parcours,$ine,$address,$phone);
}
return getStudentsWithConditions($_POST['isPermis'],$_POST['formAnnee'],$_POST['formations'],$_POST['parcours'],$conn,$_POST['isIne'],$_POST['isIne'],$_POST['isPhone']);

