<?php
/**
 * @param $conn PDO
 * @param $isNotActive boolean
 * @param $isFound boolean
 * @return mixed
 * This function selects all the candidates that are not in active search and have a specific alternance status
 */
function selectCandidatesActives($conn, $isNotActive, $isFound) {
    $sql = "SELECT * FROM infoCandidate 
         WHERE isInActiveSearch = ? AND foundApp = ?";

    $req = $conn->prepare($sql);
    $req->execute(array($isNotActive, $isFound));
    return $req->fetchAll();
}

function selectCandidatesActivesByParcours($conn, $parcours, $isNotActive, $isFound) {
    $sql = "SELECT * FROM infoCandidate 
         WHERE isInActiveSearch = ? AND foundApp = ? AND nameParcours = ?";

    $req = $conn->prepare($sql);
    $req->execute(array($isNotActive, $isFound, $parcours));
    return $req->fetchAll();
}

/**
 * @param $conn
 * @param $choixFormation
 * @param $isActive
 * @param $isFound
 * @return mixed
 * Request for selection of candidates by training
 */
function selectCandidatesByFormation($conn, $choixFormation, $isActive, $isFound){
    $sql = "SELECT * FROM infoCandidate 
         WHERE nameFormation = ? AND isInActiveSearch = ? AND foundApp = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($choixFormation, $isActive, $isFound));
    return $req->fetchAll();
}

/**
 * @param $conn
 * @param $choixFormation
 * @param $choixNom
 * @param $isActive
 * @param $isFound
 * @return mixed
 * du nom et de la formation
 * ​
 * 72 / 5 000
 * Résultats de traduction
 * Résultat de traduction
 * Request for selection of candidates based on candidate's name and formation's name
 */
function selectCandidatesByNameAndFormation($conn, $choixFormation, $choixNom, $isActive, $isFound){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND foundApp = ? AND name LIKE ? AND nameFormation = ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $isFound, $choixNomPattern, $choixFormation));
    return $req->fetchAll();
}

/**
 * @param $conn PDO
 * @param $choixFormation String
 * @param $parcours String
 * @param $isActive boolean
 * @param $isFound boolean
 * @return mixed
 * This function selects the candidates by using the name of the formation,
 * the name of the study and only if they are in active search and found
 */
function selectCandidateByFormationAndParcours($conn, $choixFormation, $parcours, $isActive, $isFound){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND foundApp = ? AND nameParcours = ? AND nameFormation = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $isFound, $parcours, $choixFormation));
    return $req->fetchAll();
}

/**
 * @param $conn
 * @param $choixNom
 * @param $isActive
 * @param $isFound
 * @return mixed
 * Query to select candidates based on name
 */
function selectCandidatesByName($conn, $choixNom, $isActive, $isFound){
    $sql = "SELECT * FROM infoCandidate
            WHERE isInActiveSearch = ? AND foundApp = ? AND name LIKE ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $isFound, $choixNomPattern));
    return $req->fetchAll();
}

/**
 * @param $conn PDO
 * @param $parcours String
 * @param $isActive boolean
 * @param $isFound boolean
 * @return mixed
 * This function selects the candidates by using the name of the study and only if they are in active search and found
 */
function selectCandidatesByParcours($conn, $parcours, $isActive, $isFound){
    $sql = "SELECT * FROM infoCandidate
            WHERE isInActiveSearch = ? AND foundApp = ? AND nameParcours = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $isFound, $parcours));
    return $req->fetchAll();
}

/**
 * @param $conn PDO
 * @param $parcours String
 * @param $choixNom String
 * @param $isActive boolean
 * @param $isFound boolean
 * @return mixed
 * This function selects the candidates by using the name of the study,
 * the name of the candidate and only if they are in active search and found
 */
function selectCandidatesByNameAndParcours($conn, $parcours, $choixNom, $isActive, $isFound){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND foundApp = ? AND name LIKE ? AND nameParcours = ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $isFound, $choixNomPattern, $parcours));
    return $req->fetchAll();
}

/**
 * @param $conn PDO
 * @param $parcours String
 * @param $choixNom String
 * @param $choixFormation String
 * @param $isActive boolean
 * @param $isFound boolean
 * @return mixed
 * This function selects the candidates by using the name of the formation,
 * the name of the study, the name of the candidate and only if they are in active search and found
 */
function selectCandidatesByNameFormationAndParcours($conn, $parcours, $choixNom, $choixFormation, $isActive, $isFound){
    $sql = "SELECT * FROM infoCandidate
                WHERE isInActiveSearch = ? AND foundApp = ? AND name LIKE ? AND nameParcours = ? AND nameFormation = ?";
    $choixNomPattern = '%'.$choixNom.'%';
    $req = $conn->prepare($sql);
    $req->execute(array($isActive, $isFound, $choixNomPattern, $parcours, $choixFormation));
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

function selectIdAddrByCandidate($conn, $id){
    $sql="
         SELECT idAddr FROM infocandidate ic 
         LEFT JOIN candidateaddress ca ON ic.idCandidate = ca.idCandidate
         WHERE ic.idCandidate = ?
         ";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($id));
    return $stmt->fetchAll();
}

function selectIdZoneByCandidate($conn, $id){
    $sql="
         SELECT idZone FROM infocandidate ic 
         LEFT JOIN candidatezone cz ON ic.idCandidate = cz.idCandidate
         WHERE ic.idCandidate = ?
         ";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($id));
    return $stmt->fetchAll();
}

function selectCandidatById($conn, $id)
{
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
    ic.foundApp,
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

function isEmailAlreadyExistWithIdVerification($conn, $email, $id): bool {
    $sql = "SELECT * from Candidate WHERE candidateMail = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($email));
    $result = $req->fetch();
    return !empty($result) && $result['idCandidate'] != $id;
}

function isPhoneNumberAlreadyExist($conn, $phone): bool
{
    $sql = "SELECT * from Candidate WHERE phoneNumber = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($phone));
    $result = $req->fetch();
    return !empty($result);
}

function isPhoneNumberAlreadyExistWithIdVerification($conn, $phone, $id): bool
{
    $sql = "SELECT * from Candidate WHERE phoneNumber = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($phone));
    $result = $req->fetch();
    return !empty($result) && $result['idCandidate'] != $id;
}


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

function isCandidateExistWithIneWithIdVerification($conn, $INE, $id): bool
{
    $sql = "SELECT * from Candidate WHERE INE = ?";
    $req = $conn->prepare($sql);
    $req->execute(array($INE));
    $result = $req->fetch();
    return !empty($result) && $result['idCandidate'] != $id;

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
