<?php


function verfication($conn,$mail,$login){
    //on vérifie que la personne existe bien dans l'adresse
    try {
        $request0 = "Select email,login from utilisateur where email = ? OR login = ?";

        $res = $conn->prepare($request0);
        $res->execute(array($mail,$login));
        //si on ne trouve personne dans la requête sql alors on renvoie false sinon on renvoie true
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

/*
 * fonction qui appelle la fonction vérification et qui renvoie son resultat
 *
 */
function exist($conn,$mail,$login)
{

    $existence = verfication($conn, $mail, $login);
    //$existence = verfication($conn,$_POST['email'],$_POST['login']);
    return $existence;

}

/*
 * fonction qui ajoute un utilisateur à  une base de donnée
 */
function adduserbdd($conn,$pswrd,$lastname,$firstname,$email, $login,$role){

    $requete = "Insert into utilisateur VALUES (?,?,?,?,?,?,?,?)";
    $res = $conn->prepare($requete);
    $newpswrd = password_hash($pswrd,PASSWORD_DEFAULT);

    try {
        $res->execute(array($login,$newpswrd,$lastname,$firstname,$role,$email,null,null));
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }

    return $res;
}
/*$conn = require("../Model/Database.php");
adduserbdd($conn,"1234","Parent","Theo","nintendoplayeraddict@gmail.com","theos",1);*/


/**
 * @param $conn PDO
 * @param $login string
 * @param $formations string
 * @return void
 *
 *fonction qui associe dans la bdd un utilisateur à un rôle via une table associative
 *
 */
function addrolesbdd($conn,$login,$formations)
{
    $requete = "Insert into formationsutilisateurs values (?,?)";
    $res = $conn->prepare($requete);
    try{
    for ($x = 0; $x < count($formations); $x++) {
        $res->execute(array($login, $formations[$x]));
    }}
    catch (PDOException $e) {
        echo $e->getMessage();
    }
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



function deletedashboard($conn, $login, $idtableau) {
    $sql = "DELETE FROM dashboarduser WHERE login = ? AND idtableau = ?";
    $sql2 = "DELETE FROM dashboard WHERE idtableau = ?";

    try {
        $res = $conn->prepare($sql);
        $res->execute([$login, $idtableau]);

        $res2 = $conn->prepare($sql2);
        $res2->execute([$idtableau]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>

