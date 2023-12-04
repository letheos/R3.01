<?php
/**
 * @param $conn
 * @param $isNotActive
 * @return mixed
 * Requête de selection des candidats actifs
 */
function selectCandidatesActives($conn, $isNotActive){
    $sql = "SELECT * FROM infoCandidate 
         WHERE isInActiveSearch = ?";

    $req = $conn->prepare($sql);
    $req->execute(array($isNotActive));
    return $req->fetchAll();
}

/**
 * @param $conn
 * @param $choixFormation
 * @param $isActive
 * @return mixed
 * Requête de selection des candidats par formation
 */
function selectCandidatesByFormation($conn, $choixFormation, $isActive){
    $sql = "SELECT * FROM infoCandidate 
         WHERE nameFormation = ? AND isInActiveSearch = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($choixFormation,$isActive));
    return $req->fetchAll();
}


/**
 * @param $conn
 * @param $choixFormation
 * @param $choixNom
 * @param $isActive
 * @return mixed
 * Requête de selection des candidats en fonction du nom et de la formation
 */
function selectCandidatesByNameAndFormation($conn, $choixFormation, $choixNom, $isActive){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND name LIKE ? AND nameFormation = ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $choixNomPattern,  $choixFormation));
    return $req->fetchAll();
}

function selectCandidateByFormationAndParcours($conn, $choixFormation, $parcours, $isActive){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND nameParcours = ? AND nameFormation = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $parcours,  $choixFormation));
    return $req->fetchAll();
}

/**
 * @param $conn
 * @param $choixNom
 * @param $isActive
 * @return mixed
 * Requête de selection des candidats en fonction du nom
 */

function selectCandidatesByName($conn, $choixNom, $isActive){
    $sql = "SELECT * FROM infoCandidate
            WHERE isInActiveSearch = ? AND name LIKE ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $choixNomPattern));
    return $req->fetchAll();
}

function selectCandidatesByParcours($conn, $parcours, $isActive){
    $sql = "SELECT * FROM infoCandidate
            WHERE isInActiveSearch = ? AND nameParcours = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $parcours));
    return $req->fetchAll();
}

function selectCandidatesByNameAndParcours($conn, $parcours, $choixNom, $isActive){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND name LIKE ? AND nameParcours = ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $choixNomPattern,  $parcours));
    return $req->fetchAll();
}

function selectCandidatesByNameFormationAndParcours($conn, $parcours, $choixNom, $choixFormation, $isActive){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND name LIKE ? AND nameParcours = ? AND nameFormation = ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $choixNomPattern,  $parcours, $choixFormation));
    return $req->fetchAll();
}


/**
 * @param $conn
 * @return mixed
 * Requête de selection des formations pour la liste déroulante
 */
function allFormation($conn){
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

function selectCandidatById($conn,$id){
    $sql = "
SELECT
    ic.idCandidate,
    ic.INE,
    ic.name,
    ic.firstName,
    ic.phoneNumber,
    ic.candidateMail,
    ic.nameParcours,
    f.nameFormation,
    ic.yearOfFormation,
    ic.isInActiveSearch,
    ic.permisB,
    ic.typeCompanySearch,
    ic.cv,
    ic.remarks,
    GROUP_CONCAT(DISTINCT CONCAT(candidateaddress.CP, ', ', candidateaddress.addressLabel, ', ', candidateaddress.city) SEPARATOR '; ') AS addresses,
    GROUP_CONCAT(DISTINCT CONCAT(candidatezone.cityName, ' (Rayon: ', candidatezone.radius, ' km)') SEPARATOR ', ') AS zones
FROM infocandidate ic
LEFT JOIN candidateaddress ON ic.idCandidate = candidateaddress.idCandidate
LEFT JOIN candidatezone ON ic.idCandidate = candidatezone.idCandidate
LEFT JOIN parcours p ON ic.nameParcours = p.nameParcours
LEFT JOIN formation f ON p.nameFormationParcours = f.nameFormation
WHERE ic.idCandidate = ?
GROUP BY ic.idCandidate;
";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return $req->fetch();
}

function isInActiveSearch($conn,$id){
    $sql = "Select isInActiveSearch from candidate where idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return $req->fetch();
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

function isPhoneNumberAlreadyExist($conn, $phone): bool
{
    $sql = "SELECT * from Candidate WHERE phoneNumber = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($phone));
    $result = $req->fetch();
    return !empty($result);
}

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
