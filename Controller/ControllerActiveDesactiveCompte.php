<?php
require "../Model/ModelActivationDesactivationCompte.php";

$typeButton = $_POST['typeBouton'];
$ine = $_POST['ine'];

if($typeButton ==="greenButton"){
    changeEtatTrue($ine);
} else{
    changeEtatFalse($ine);
}

function()