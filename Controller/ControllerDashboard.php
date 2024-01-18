<?php

if (empty($_SESSION)) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}

echo "Formation : ";
echo var_dump($_POST["formation"]);
echo "\n Parcours :";
echo var_dump($_POST['parcours']);