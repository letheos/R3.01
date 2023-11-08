<?php
    $conn = require "../Model/Database.php";

/**
 * @param $conn
 * @param $login
 * @return bool|Exception|PDOException
 * Cette fonction renvoie true si une alerte doit etre rappelée
 */


function hasPastAlert($conn,$login){
    $req = $conn->prepare("SELECT COUNT(idalert) FROM alert JOIN ALERTUTILISATEUR WHERE login = ? AND remindAT<CURRENT_DATE and seen= false");
    try {
        $req->execute(array($login));
        $result = $req->fetchAll();
    }
    catch (PDOException $e){
        return $e;
    }
    return $result[0][0]!=0;
}


/**
 * @param $conn
 * @param $login
 * @return Exception|mixed|PDOException
 * Fonction qui récupère toutes les alertes passées et les met en "seen" concernant un utilisateur donné
 */
function selectPastAlert($conn, $login){
    try {
        $sql = 'SELECT note,remindAt,idAlert FROM Alert JOIN ALERTUTILISATEUR USING (IDALERT) WHERE login = ? AND remindAT<CURRENT_TIMESTAMP' ;
        $req = $conn->prepare($sql);
        $req->execute(array($login));
    }
    catch (PDOException $e){
        return $e;
    }
    foreach ($req as $row){
        setAlertSeen($conn,$row[2]);
    }
    return $req->fetchAll();
}

/**
 * @param $conn
 * @param $login
 * @param $future
 * @return Exception|mixed|PDOException
 * Selectionne la liste des alertes d'un utilisateurs selon un parametre future determinant si l'on filtre les anlertes futures ou non
 */
function selectAlert($conn,$login,$future){
    try {
        $sql = "SELECT IDAlert,note,remindAt FROM alert join AlertUTILISATEUR USING (IDALERT) WHERE login = ? ";
        if(!$future) {
            $sql=$sql . "AND remindAt<=Current_DATE ";
        }
        $sql=$sql. "ORDER BY RemindAt DESC";
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
function setAlertSeen($conn,$idAlert,$login){
    try {
        $sql = "UPDATE alertUtilisateur set seen=true WHERE idalert = ? and login=?";
        $req = $conn->prepare($sql);
        $req->execute(array($idAlert,$login));
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
function addAlert($conn,$login,$remindAt,$note)
{
    try {

        $date = date('Y-m-d', strtotime($remindAt));
        $requete = "Insert into alert (remindAt,note) VALUES (?,?);";
        $resultat = $conn->prepare($requete);
        $resultat->execute(array($date, $note));
        $requete2 = "SELECT idAlert from Alert ORDER BY idAlert DESC LIMIT 1;";
        $resultat2 = $conn->prepare($requete2);
        $resultat2->execute();
        $id=$resultat2->fetchcolumn();

        if($login=="global"){

            //vilaine tentative
            $requete3 = "SELECT LOGIN from UTILISATEUR;";
            $resultat3 = $conn->prepare($requete3);
            $resultat3->execute();
            foreach ($resultat3 as $row){
                $requete4 = "INSERT INTO ALERTUTILISATEUR VALUES (?,?,false);";
                $resultat4 = $conn->prepare($requete4);
                $resultat4->execute(array($id,$row[0]));
            }
        }
        else{
            $requete5 = "INSERT INTO ALERTUTILISATEUR VALUES (?,?,false);";
            $resultat5 = $conn->prepare($requete5);
            $resultat5->execute(array($id,$login));
        }
    } catch (PDOException $e) {
        return $e;
    }
}

/**
 * @param $conn
 * @param $id
 * @return Exception|PDOException|void
 * Cette fonction permet de supprimer une alerte
 */
function deleteAlert($conn,$id,$login){
    try {
        $requete = "DELETE from AlertUtilisateur WHERE idalert = ? and login = ?;";
        $resultat = $conn->prepare($requete);
        $resultat->execute(array($id,$login));

    } catch (PDOException $e) {
        return $e;
    }
}


?>

