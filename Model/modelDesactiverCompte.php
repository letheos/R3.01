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
<form action ='../View/pageVueEtudiant.php'  >
    <button>retour</button>
</form>
</body>
</html>

<?php
$bdd = require "../Model/Database.php";

/**
 * @param $ine string
 * @param $bdd PDO
 * @return void
 * prend en paramètre une connection mysql et un ine de type string
 * change l'état boolean de la isInActiveSearch en true
 */
function chagenEtatTrue($ine,$bdd){

    $sql = "UPDATE Candidates SET isInActiveSearch = true WHERE INE = (?)";
    $req = $bdd->prepare($sql);
    $req->execute(array($ine));

}
/**
 * @param $ine
 * @param $bdd
 * @return void
 * prend en paramètre une connection mysql et un ine de type string
 * change l'état boolean de la isInActiveSearch en false
 */
function chagenEtatFalse($ine,$bdd){

    $sql = "UPDATE Candidates SET isInActiveSearch = false WHERE INE = (?)";
    $req = $bdd->prepare($sql);
    $req->execute(array($ine));

}

$ine = $_GET['ine'];
$bouton = $_GET['typeBouton'];
if($bouton === "boutonVert"){
    changeEtatTrue($ine);
} elseif ($bouton === "boutonRouge"){
    changeEtatFalse($ine);
}

