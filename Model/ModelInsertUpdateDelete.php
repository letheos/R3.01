<?php
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