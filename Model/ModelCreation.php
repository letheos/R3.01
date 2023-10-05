<?php
include '../Model/Database.php';
function verfication($conn,$mail,$login){
try {

    $requete0 = "Select email,login from utilisateur where email = ? OR login = ?";

    $requete1 = "Insert into Role VALUES (
    1,'Chef de département'
                        );";/*
    $requete2 = "Insert into InternUser Values(
   'Parent','Theo','nintendoplayeraddict@gmail.com','theos',1,'azerty2430'               
                             );";
    $requete3 = "DELETE From InternUser Where name = 'Parent'";
    $requete4 = "Delete From Role Where idRole = 1";

    $conn-> exec($requete3);
    $conn->exec($requete4);
    $conn->exec($requete1);
    $conn->exec($requete2);
    */
    $resultat = $conn->prepare($requete0);
    $resultat->execute(array($mail,$login));
    if ($resultat->rowCount() == 0){
        return false;
    } else{
        return true;
    }
}
catch (PDOException $e){
        return $e;
}
}
function existe($mail,$login)
{

    $conn = laconnexion();
    $existence = verfication($conn, $mail, $login);

    //$existence = verfication($conn,$_POST['email'],$_POST['login']);
    return $existence;


}

function ajouter($pswrd,$lastname,$firsname,$email, $login,$role,$formation){

        $conn = laconnexion();
        $requete = "Insert into utilisateur VALUES (?,?,?,?,?,?,?,?,?)";
        $resultat = $conn->prepare($requete);
        $newpswrd = password_hash($pswrd,PASSWORD_DEFAULT);

    try {
        $resultat->execute(array($lastname,$firsname,$email,$login,$newpswrd,$role,$formation,null,null));
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }

        return $resultat;
}

?>

