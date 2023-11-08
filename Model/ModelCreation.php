<?php
$conn = require 'Database.php';
function verfication($conn,$mail,$login){
    try {

        $requete0 = "Select email,login from utilisateur where email = ? OR login = ?";

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
function existe($conn, $mail,$login)
{
    $existence = verfication($conn, $mail, $login);

    //$existence = verfication($conn,$_POST['email'],$_POST['login']);
    return $existence;


}

function ajouter($conn, $pswrd,$lastname,$firsname,$email, $login,$role,$formation){

    $requete = "Insert into utilisateur VALUES (?,?,?,?,?,?,?,?,?)";
    $resultat = $conn->prepare($requete);
    $newpswrd = password_hash($pswrd,PASSWORD_DEFAULT);

    try {
        $resultat->execute(array($login, $newpswrd,$lastname,$role,$formation,$firsname,$email,null,null));

    }
    catch (PDOException $e){
        echo $e->getMessage();
    }

    return $resultat;
}

?>