<?php
    $conn = require "../Model/Database.php";
    $conn2 = new PDO("mysql:host=localhost;dbname=localDatabaseTest2", "root", "root");

/**
 * @param $conn
 * @param $login
 * @return bool|Exception|PDOException
 * Cette fonction renvoie true si une alerte doit etre rappelée
 */
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

/**
 * @param $conn
 * @param $login
 * @return Exception|mixed|PDOException
 * Fonction qui récupère toutes les alertes concernant un utilisateur donné
 */
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


/**
 * @param $conn
 * @param $id
 * @return Exception|mixed|PDOException
 * Cette fonction passe le parametre "seen" en true, indiquant qu'une alerte n'a plus besoin d'être rappelée
 */
function setAlertSeen($conn,$idAlert){
    try {
        $sql = "UPDATE Alert set seen=true WHERE id = ?";
        $req = $conn->prepare($sql);
        $req->execute(array($idAlert));
    }catch (PDOException $e){
        return $e;
    }
    return $req->fetchAll();
}

/**
 * @param $conn
 * @param $login
 * @param $remindAt
 * @param $note
 * @return Exception|PDOException|void
 * Cette fonction permet d'ajouter une alerte
 */
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

function supprimerAlerte($conn,$id){
    try {
        $requete = "DELETE from Alert WHERE id=?";
        $resultat = $conn->prepare($requete);
        $resultat->execute(array($id));
    } catch (PDOException $e) {
        return $e;
    }
}
?>

