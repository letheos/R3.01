<?php
session_start();

//TODO adapter la bdd pour remettre la formation en clé étrangére et faire le code pour avoir automatiquement les formations

$conn = require "../Model/Database.php";
require "../Model/ModelCreation.php";

function displayCheckboxes($conn){
    $result = selectAllFormation($conn);

    foreach ($result as $rows){
        $formationName = $rows['nameFormation'];

        echo '<label class="choices">';
        echo '<input class="choices-formation"type="checkbox" id="' . $formationName . '" name="'. $formationName .'" value="' . $formationName . '">';
        echo $formationName;
        echo '</label>';
    };
}


















/**
 * @param $coon PDO
 * @param $INE String
 * @param $lastName String
 * @param $firstName String
 * @param $address String
 * @param $ville String
 * @param $radius int
 * @param $permisB bool
 * @param $formation String
 * @param $typeEntrepriseRecherche String
 * @return void
 * crée un candidat
 */
function insert($coon,$INE,$lastName,$firstName,$address,$ville,$radius,$permisB,$formation,$typeEntrepriseRecherche){
    $sql = "insert into students values (?,?,?,?,?,?,?,?,?,true);";

    $req = $coon->prepare($sql);
    $req->bindValue(1, $INE);
    $req->bindValue(2, $lastName);
    $req->bindValue(3, $firstName);
    $req->bindValue(4, $address);
    $req->bindValue(5, $ville);
    $req->bindValue(6, $radius);
    $req->bindValue(7,$permisB);
    $req->bindValue(8, $formation);
    $req->bindValue(9, $typeEntrepriseRecherche);

    $req->execute();
}


