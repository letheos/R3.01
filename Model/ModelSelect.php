<?php
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