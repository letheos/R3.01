<?php
/**
 
Fichier qui s'occupe de la gestion
@author Nathan Strady, Theo Parent
*/

$conn = require '../Model/Database.php';
require '../Model/ModelInsertUpdateDelete.php';


if(isset($_POST['activate'])){
    $id = $_POST['idValue'];
    setEtatTrue($conn, $id);
    header("Location: ../View/PageAffichageEtudiantPrecis.php?id=$id");
}

if (isset($_POST['desactivate'])){
    $id = $_POST['idValue'];
    setEtatFalse($conn, $id);
    header("Location: ../View/PageAffichageEtudiantPrecis.php?id=$id");
}
