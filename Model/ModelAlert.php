<?php
    $conn = require "../Model/Database.php";

/**
 * @param PDO $conn  The db connection
 * @param string $login    The login of a user
 * @return bool|Exception|PDOException
 * This function returns true if the user has at least one alert that needs reminder
 */


function hasPastAlert(PDO $conn, string $login){
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
 * @param PDO $conn   The db connection
 * @param string $login    The login of a user
 * @return array|Exception|false|PDOException
 * This function set all the alert for a user that needs a reminder to 'seen', meaning he saw them and don't need any more reminder.
 */
function selectPastAlert(PDO $conn, string $login){
    try {
        $sql = 'SELECT note,remindAt,idAlert FROM Alert JOIN ALERTUTILISATEUR USING (IDALERT) WHERE login = ? AND remindAT<CURRENT_TIMESTAMP' ;
        $req = $conn->prepare($sql);
        $req->execute(array($login));
    }
    catch (PDOException $e){
        return $e;
    }
    foreach ($req as $row){
        setAlertSeen($conn,$row[2],$login);
    }
    return $req->fetchAll();
}

/**
 * @param PDO $conn   The db connection
 * @param string $login The login of a user
 * @param boolean $future   A boolean, on which depends if all user's alert are shown or only the outdated ones
 * @return array|Exception|false|PDOException
 * This function put in an array all the alert for a user (depending on the future param)
 */
function selectAlert(PDO $conn, string $login, bool $future){
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
 * @param PDO $conn   The db connection
 * @param int $idAlert   The id of an alert
 * @param string $login The login of a user
 * @return array|Exception|false|PDOException
 * This function set a specific alert at 'seen' for a given user
 */
function setAlertSeen(PDO $conn, int $idAlert, string $login){
    try {
        $sql = "UPDATE alertUtilisateur set seen=true WHERE idalert = ? and login = ?";
        $req = $conn->prepare($sql);
        $req->execute(array($idAlert,$login));
    }catch (PDOException $e){
        return $e;
    }
    return $req->fetchAll();
}

/**
 * @param PDO $conn   The db connection
 * @param string $login  The login of a user
 * @param string $remindAt  A date
* @param string $note     A string
 * @return Exception|PDOException|void
 * This function add an alert to the given user, or to all users
 */
function addAlert(PDO $conn, string $login, string $remindAt, string $note)
{
    try {

        $date = date('Y-m-d', strtotime($remindAt));
        $request = "Insert into alert (remindAt,note) VALUES (?,?);";
        $result = $conn->prepare($request);
        $result->execute(array($date, $note));
        $id=$conn ->lastInsertId();

        if($login=="global"){

            $request2 = "SELECT LOGIN from UTILISATEUR;";
            $result2 = $conn->prepare($request2);
            $result2->execute();
            foreach ($result2 as $row){
                $request3 = "INSERT INTO ALERTUTILISATEUR VALUES (?,?,false);";
                $result3 = $conn->prepare($request3);
                $result3->execute(array($id,$row[0]));
            }
        }
        else{
            $request4 = "INSERT INTO ALERTUTILISATEUR VALUES (?,?,false);";
            $result4 = $conn->prepare($request4);
            $result4->execute(array($id,$login));
        }
    } catch (PDOException $e) {
        return $e;
    }
}

/**
 * @param PDO $conn   The db connection
 * @param int $id   The id of an alert
 * @param string $login  The login of a user
 * @return Exception|PDOException|void
 * This function delete an alert for a user, then search if this alert is still link with other users, if not it delete it globally
 */
function deleteAlert(PDO $conn, int $id, string $login){
    try {
        $request = "DELETE from AlertUtilisateur WHERE idalert = ? and login = ?;";
        $result = $conn->prepare($request);
        $result->execute(array($id,$login));

        $request2="SELECT idalert from Alert LEFT JOIN AlertUtilisateur using (idalert) group by idalert HAVING count(login)=0;";
        $result2 = $conn->prepare($request2);
        $result2->execute();

        foreach ($result2 as $row){
            $request3="DELETE from Alert where idalert = ?;";
            $result3 = $conn->prepare($request3);
            $result3->execute(array($row[0]));
        }
    } catch (PDOException $e) {
        return $e;
    }
}




