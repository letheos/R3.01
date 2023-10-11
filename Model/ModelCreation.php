<?php

$conn = require "../Model/Database.php";


function selectAllFormation($conn){
    $sql = "SELECT * FROM Formation";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchAll();
}
function verfication($conn,$mail,$login){
    //on vérifie que la personne existe bien dans l'adresse
    try {
        $request0 = "Select email,login from utilisateur where email = ? OR login = ?";

        $res = $conn->prepare($request0);
        $res->execute(array($mail,$login));
        if ($res->rowCount() == 0){
            return false;
        } else{
            return true;
        }
    }
    catch (PDOException $e){
        return $e;
    }
}
function exist($conn,$mail,$login)
{

    $existence = verfication($conn, $mail, $login);
    //$existence = verfication($conn,$_POST['email'],$_POST['login']);
    return $existence;


}

function addbdd($conn,$pswrd,$lastname,$firsname,$email, $login,$role,$formation){


    $requete = "Insert into utilisateur VALUES (?,?,?,?,?,?,?,?,?)";
    $res = $conn->prepare($requete);
    $newpswrd = password_hash($pswrd,PASSWORD_DEFAULT);

    try {
        $res->execute(array($lastname,$firsname,$email,$login,$newpswrd,$role,$formation,null,null));

    }
    catch (PDOException $e){
        echo $e->getMessage();
    }

    return $res;
}
?>

