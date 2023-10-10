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

<?php
$bdd = require "../Model/Database.php";

$sql = "Select ine,name,firstname,address,isInActiveSearch from Candidates";
$requete = $bdd->prepare($sql);

$requete->execute();
$id = 0;

while ($row = $requete->fetch(PDO::FETCH_ASSOC)) {

    $id+=1;

    echo '<div class = "rounded-box">';

    echo '<p> INE : '.$row['ine']." "."Prénom : ".$row['firstname']." "."Nom : ".$row['name'].'</p>';

    $activ = $row['activaccount'];

    if($activ === true){

        //code pour faire un bouton pour désactiver le compte
        echo " le profil est actif";
        echo " le profil n'est pas actif";
        echo "<form action ='../Model/modelDesactiverCompte.php' method='get' >";
        echo '<input type="hidden" name="ine" value="' . $row['ine'] . '">';
        echo '<input type="hidden" name="typeBouton" value="boutonRouge">';
        echo "<button id= $id type='submit' class='bouton-rouge'>desactivation</button>";
        echo "</form>";



    } else{
        //code pour activer le compte
        echo " le profil n'est pas actif";
        echo "<form action ='../Model/modelDesactiverCompte.php' method='get' >";
        echo '<input type="hidden" name="ine" value="' . $row['ine'] . '">';
        echo '<input type="hidden" name="typeBouton" value="boutonVert">';
        echo "<button id= $id type='submit' class='bouton-vert'>activation</button>";
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

