<?php
/**
 * Fichier qui s'occupe de la gestion
 * @author Nathan Strady, Theo Parent
 */

$conn = require '../Model/Database.php';
require '../Model/ModelInsertUpdateDelete.php';

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

//On passe la valeur a null si elle n'existe pas
if(!isset($_SESSION["login"])){
    $_SESSION['login'] = null;
}
//On passe la valeur a null si elle n'existe pas
if(!isset($_SESSION["password"])){
    $_SESSION['password'] = null;
}
//Cette condition sert à verifier que la personne accedant a la page d'accueil
if ($_SESSION['login'] == null || $_SESSION['password'] == null) {
    //$_SESSION['provenance'] = 'Accueil';
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}