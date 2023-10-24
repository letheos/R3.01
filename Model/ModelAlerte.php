<?php
    $conn = require "../Model/Database.php";

/**
 * @param $conn
 * @param $login
 * @return bool|Exception|PDOException
 * Cette fonction renvoie true si une alerte doit etre rappelée
 */


function hasPastAlert($conn,$login){
    $req = $conn->prepare("SELECT COUNT(idalert) FROM alert WHERE login = ? AND remindAT<CURRENT_DATE");
    try {
        $req->execute(array($login));
        $result = $req->fetchAll();
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
/*function selectPastAlert($conn, $login){
    try {
        $sql = 'SELECT idAlert,note FROM Alert WHERE login = ? AND remindAT<CURRENT_TIMESTAMP' ;
        $req = $conn->prepare($sql);
        $req->execute(array($login));
    }
    catch (PDOException $e){
        return $e;
    }
    return $req->fetchAll();
}*/

function selectAlert($conn,$login,$future){
    try {
        $sql = "SELECT IDAlert,note,remindAt FROM alert WHERE login = ? ";
        if(!$future) {
            $sql=$sql . "AND remindAt<=Current_DATE;";
        }
        $req = $conn->prepare($sql);
        $req->execute(array($login));
        $res =$req->fetchAll();
    }
    catch (PDOException $e){
        return $e;
    }

    return $res;
}


/**
 * @param $conn
 * @param $id
 * @return Exception|mixed|PDOException
 * Cette fonction passe le parametre "seen" en true, indiquant qu'une alerte n'a plus besoin d'être rappelée
 */
function setAlertSeen($conn,$idAlert){
    try {
        $sql = "UPDATE alert set seen=true WHERE idalert = ?";
        $req = $conn->prepare($sql);
        $req->execute(array($idAlert));
    }catch (PDOException $e){
        return $e;
    }
    $res =$req->fetchAll();
    return $res;
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
        $date = date('Y-m-d', strtotime($remindAt));
        $requete = "Insert into alert (remindAt,seen,note,login) VALUES (?,false,?,?);";
        $resultat = $conn->prepare($requete);
        $resultat->execute(array($date, $note,$login));
    } catch (PDOException $e) {
        return $e;
    }
    return 1;
}

function supprimerAlerte($conn,$id){
    try {
        $requete = "DELETE from alert WHERE idalert=?";
        $resultat = $conn->prepare($requete);
        $resultat->execute(array($id));
    } catch (PDOException $e) {
        return $e;
    }
}
?>

