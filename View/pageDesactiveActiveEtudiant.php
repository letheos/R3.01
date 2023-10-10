<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="PageCreationcss.css">
    <title>afficheLesEtudiants</title>
</head>

<header>
    <p>
        blalbaeza
    </p>
</header>


<body>
<section id="donnees">

</section>

<?php
$bdd = require "../Model/Database.php";

$sql = "SELECT ine,name,firstname,address,isInActiveSearch FROM Candidates";

$requete = $bdd->prepare($sql);

$requete->execute();


while ($row = $requete->fetch(PDO::FETCH_ASSOC)) {



    echo '<div class = "rounded-box">';

    echo '<p> INE : '.$row['ine']." "."Prénom : ".$row['firstname']." "."Nom : ".$row['name'].'</p>';

    $activ = $row['activaccount'];

    if($activ === true){

        //code pour faire un bouton pour désactiver le compte
        echo " le profil est actif";
        echo " le profil n'est pas actif";
        echo "<form action ='../Controller/ControllerCreationCompte.php' method='post' >";
        echo '<input type="hidden" name="ine" value="' . $row['ine'] . '">';
        echo '<input type="hidden" name="typeButton" value="redButton">';
        echo "<button type='submit' class='bouton-rouge'>desactivation</button>";
        echo "</form>";



    } else{
        //code pour activer le compte
        echo " le profil n'est pas actif";
        echo "<form action ='../Controller/ControllerCreationCompte.php' method='post' >";
        echo '<input type="hidden" name="ine" value="' . $row['ine'] . '">';
        echo '<input type="hidden" name="typeBouton" value="greenButton">';
        echo "<button type='submit' class='bouton-vert'>activation</button>";
        echo "</form>";

    }

    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '</div>';
}
?>

</body>
</html>

