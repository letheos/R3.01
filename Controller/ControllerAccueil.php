<?php
if(!isset($_SESSION["login"])){
    $_SESSION['login'] == null;
}
if(!isset($_SESSION["password"])){
    $_SESSION['password'] == null;
}

//Cette condition sert à verifier que la personne accedant a la page d'accueil
if ($_SESSION['login'] == null || $_SESSION['password'] == null) {
    $_SESSION['provenance'] = 'Accueil';
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}
?>
