<?php
/**
 * @author : Nathan Strady
 */

/**
 * Fonction qui envoie toute les formations de la bdd
 * @param $conn : Connection à la bdd
 * @return mixed : Renvoie le résultat de la requête sql
 */
function selectAllFormation($conn){
    $sql = "SELECT * FROM Formation";
    $req = $conn->prepare($sql);
    $req->execute();
    return $req->fetchAll();
}

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