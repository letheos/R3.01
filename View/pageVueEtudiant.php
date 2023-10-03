<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../Model/PageCreationcss.css">
    <title>afficheLesEtudiants</title>
</head>
<body>

<?php
$bdd = require "../Model/Database.php";

$sql = "Select ine,name,firstname,address,phonenumber,activaccount from students";
$requete = $bdd->prepare($sql);

$requete->execute();

while ($row = $requete->fetch(PDO::FETCH_ASSOC)) {
    echo '<div class = "rounded-box">';
    echo "Etudiant n°";
    echo $row['ine'];
    $ine = $row['ine'];
    echo '<br>';
    echo "s'appelle  ";
    echo $row['name'];
    echo "   ";
    echo $row['firstname'];
    echo " ";
    echo '<br>';
    echo " habite a  ";
    echo $row['address'];
    echo '<br>';
    echo " numéro de téléphone =  ";
    echo $row['phonenumber'];
    echo '<br>';
    $activ = $row['activaccount'];
    if($activ === true){

        //code pour faire un bouton pour désactiver le compte
        echo " le profil est actif";
        echo "<button class='bouton-rouge'>desactiver</button>";
        /*
        $sql = "UPDATE Candidates SET isInActiveSearch = (?) WHERE INE = (?)";
        $req = $bdd->prepare($sql);
        $req->bindParam(1, false, PDO::PARAM_BOOL);
        $req->bindParam(2, $ine);
        $req->execute();
        */
    } else{
        //code pour activer le compte
        echo " le profil n'est pas actif";
        echo "<button class='bouton-vert'>activation</button>";
    }

    echo '<br>';
    echo '</div>';

}
?>

</body>
</html>

