<?php
/**
 * Fichier qui s'occupe de la gestion
 * @author Nathan Strady, Theo Parent
 */

$conn = require '../Model/Database.php';
require '../Model/ModelInsertUpdateDelete.php';

if (empty($_SESSION['user'])) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}

$id = $_POST['idValue'];


if(isset($_POST['activate'])){
    setEtatTrue($conn, $id);
    header("Location: ../View/PageAffichageEtudiantPrecis.php?id=$id");
}

if (isset($_POST['desactivate'])){
    setEtatFalse($conn, $id);
    header("Location: ../View/PageAffichageEtudiantPrecis.php?id=$id");
}

if(isset($_POST['alternance'])){
    setAppTrue($conn, $id);
    header("Location: ../View/PageAffichageEtudiantPrecis.php?id=$id");
}

if (isset($_POST['noalternance'])){
    setAppFalse($conn, $id);
    header("Location: ../View/PageAffichageEtudiantPrecis.php?id=$id");
}
