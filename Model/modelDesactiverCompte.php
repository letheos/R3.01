<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action ='../View/pageVueEtudiant.php' method='get' >
    <button>retour</button>
</form>
</body>
</html>

<?php


$bdd = require "../Model/Database.php";

/*
function chageEtatTrue($ine){
    $bdd = require "../Model/Database.php";

    $sql = "Select ine,name,firstname,address,phonenumber,activaccount from students";
    $requete = $bdd->prepare($sql);

    $sql = "UPDATE Candidates SET isInActiveSearch = true WHERE INE = (?)";
    $req = $bdd->prepare($sql);
    $req->bindParam(1, false, PDO::PARAM_BOOL);
    $req->bindParam(2, $ine);
    $req->execute();

}
*/
/**
 * @param $ine
 * a enlever utilise l'ancienne bdd
 * @return void
 */
function chageEtatTrueOld($ine){
    $bdd = require "../Model/Database.php";



    $sql = "UPDATE students SET activaccount = true WHERE INE = (?)";
    $req = $bdd->prepare($sql);
    $req->execute(array($ine));

}

/*
function chageEtatFalse($ine){
    $bdd = require "../Model/Database.php";

    $sql = "UPDATE students SET activaccount = false WHERE INE = (?)";
    $req = $bdd->prepare($sql);
    $req->execute(array($ine));

}
*/
/**
 * @param $ine
 * a enlever utilise l'ancienne bdd
 * @return void
 */
function chageEtatFalseOld($ine){
    $bdd = require "../Model/Database.php";

    $sql = "UPDATE students SET activaccount = false WHERE INE = (?)";
    $req = $bdd->prepare($sql);
    $req->execute(array($ine));

}
$ine = $_GET['ine'];
$bouton = $_GET['typeBouton'];
if($bouton === "boutonVert"){
    chageEtatTrueOld($ine);
} elseif ($bouton === "boutonRouge"){
    chageEtatFalseOld($ine);
}

