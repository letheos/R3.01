<?php
/**
 * @author : Nathan Strady
 */



function selectParcours($conn, $nameFormation){
    $sql = "SELECT Parcours.*
            FROM Parcours
            JOIN Formation ON Parcours.nameFormationParcours = Formation.nameFormation
            WHERE Formation.nameFormation = ?;
            ";
    $req = $conn->prepare($sql);
    $req->execute(array($nameFormation));
    $results = $req->fetchAll();
    return $results;
}

function allParcours($conn){
    $sql = "SELECT Parcours.*
            FROM Parcours
            ";
    $req = $conn->prepare($sql);
    $req->execute();
    $results = $req->fetchAll();
    return $results;
}

/**
 * Fonction qui test la présence du candidat dans la bdd via son INE
 * @param $conn : Connection à la bdd
 * @param $INE : INE du candidat
 * @return bool : Renvoie du résultat de l'existance dans la bdd
 */
function isCandidateExistWithIne($conn, $INE): bool
{
    $sql = "SELECT * from Candidate WHERE INE = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($INE));
    $result = $req->fetch();
    return !empty($result);

}

/**
 * Fonction qui test la présence du candidat dans la bdd via son nom ou son prénom
 * @param $conn : Connexion à la bdd
 * @param $name : Nom du candidat
 * @param $firstName : Prenom du candidat
 * @return bool : Renvoie le résultat de l'existance dans la bdd
 */
function isCandidateExistWithNameAndFirstname($conn, $name, $firstName): bool
{
    $sql = "SELECT * from Candidate WHERE name = ? AND firstName = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($name,$firstName));
    $result = $req->fetch();
    return !empty($result);

}

/**
 * Fonction qui vérifie l'existance d'un email dans la base de donnée
 * @param $conn : Connexion à la bdd
 * @param $email : Email du candidat
 * @return bool Renvoie un boulean contenant le résultat
 */
function isEmailAlreadyExist($conn, $email): bool {
    $sql = "SELECT * from Candidate WHERE candidateMail = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($email));
    $result = $req->fetch();
    return !empty($result);
}

function isPhoneNumberAlreadyExist($conn, $phone): bool {
    $sql = "SELECT * from Candidate WHERE phoneNumber = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($phone));
    $result = $req->fetch();
    return !empty($result);
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

/**
 * @param $conn PDO
 * @return mixed
 * Fonction qui renvoie toutes les formations de la bdd
 */
function selectAllFormation($conn){
    $sql = "SELECT * FROM Formation";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchAll();
}

/**
 * @param $conn PDO
 * @return mixed
 *fonction qui renvoie tout les noms de formations de la bdd
 */
function selectAllFormationnames($conn)
{$sql = "SELECT nameFormation FROM Formation";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchAll();
}

/**
 * @param $conn PDO
 * @param $nameformation string
 * @return mixed
 * fonction qui renvoie tout les parcours
 */
function selectallstudies($conn, $nameformation){
    $sql = "SELECT nameParcours FROM parcours WHERE nameFormationParcours = ?";
    $res = $conn->prepare($sql);
    $res->execute(array($nameformation));
    if ($res->rowCount() == 0) {
        return array();}
    return $res->fetchAll();
}


/**
 * @param $conn PDO
 * @param $parcours string
 * @return mixed
 * fonction qui renvoie le nombre de candidats dans un parcours
 */
function countstudentsstudies($conn,$parcours){
    $sql = "SELECT count(idCandidate) from candidate where nameParcours = ?";
    $res = $conn->prepare($sql);
    $res->execute(array($parcours));
    return $res->fetchColumn();
}

/**
 * @param $conn PDO
 * @param $parcours string
 * @return mixed
 * fonction qui renvoie le nombre d'étudiants actifs dans un parcours.
 */
function countstudentstudiesactive($conn,$parcours){
    $sql = "SELECT count(idCandidate) from candidate where nameParcours = ? and isInActiveSearch = 1";
    $res = $conn->prepare($sql);
    $res->execute(array($parcours));
    return $res->fetchColumn();
}

/**
 * @param $conn PDO
 * @param $formation string
 * @return int|mixed
 * fonction qui renvoie le nombre de gens dans une formation
 */

function countformation($conn,$formation){
    $total = 0;
    $parcours = selectallstudies($conn,$formation);
    foreach ($parcours as $p){
        $total += countstudentsstudies($conn,$p["nameParcours"]);
    }
    return $total;
}

/**
 * @param $conn PDO
 * @param $formation string
 * @return int|mixed
 * fonction qui renvoie le nombre de personnes dans une formation
 */
function countformationactive($conn,$formation){
    $total = 0;
    $parcours = selectallstudies($conn,$formation);
    foreach ($parcours as $p){
        //on compte dans le total le nombre de personne dans chaque parcours de la formation en question
        $total += countstudentstudiesactive($conn,$p["nameParcours"]);
    }
    return $total;
}
