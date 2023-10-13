<?php
    $conn = require "../Model/Database.php";
    $conn2 = new PDO("mysql:host=localhost;dbname=localDatabaseTest2", "root", "root");


function hasPastAlert($conn,$login){
    $req = $conn->prepare("SELECT id FROM Alerte WHERE login = ? AND remindAT<CURRENT_TIMESTAMP");
    try {
        $req->execute(array($login));
        $result = $req->fetch();
    }
    catch (PDOException $e){
        return $e;
    }
    return $result != null;
}

function selectPastAlert($conn, $login){
    try {
        $sql = "SELECT id,note FROM Alerte WHERE login = ? AND remindAT<CURRENT_TIMESTAMP ";
        $req = $conn->prepare($sql);
        $req->execute(array($login));
    }
    catch (PDOException $e){
        return $e;
    }
    return $req->fetchAll();
}

function selectAlert($conn,$login,$future){
    try {
        $sql = "SELECT id,note,remindAt FROM Alerte WHERE login = ?";
        if(!$future) {
            $sql=$sql."AND remindAt<CurrentTimestamp();";
        }
        else{
            $sql=sql.";";
        }
        $req = $conn->prepare($sql);
        $req->execute(array($login));
    }
    catch (PDOException $e){
        return $e;
    }
    return $req->fetchAll();
}



function alertSeen($conn,$id){
    try {
        $sql = "UPDATE Alert set seen=true WHERE id = ?";
        $req = $conn->prepare($sql);
        $req->execute(array($id));
    }catch (PDOException $e){
        return $e;
    }
    return $req->fetchAll();
}

function ajouterAlerte($conn,$login,$remindAt,$note)
{
    try {
        $requete = "Insert into Alert VALUES (?,?,?)";
        $resultat = $conn->prepare($requete);
        $resultat->execute(array($login, $remindAt, $note));
    } catch (PDOException $e) {
        return $e;
    }
}
?>

