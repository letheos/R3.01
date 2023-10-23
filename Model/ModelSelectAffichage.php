<?php
$conn = require "Database.php";


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

function selectCandidatById($conn,$id){
    $sql = "SELECT
    infoCandidate.idCandidate,
    infoCandidate.INE,
    infoCandidate.name,
    infoCandidate.firstName,
    infoCandidate.yearOfFormation,
    infoCandidate.nameFormation,
    infoCandidate.nameParcours,
    infoCandidate.isInActiveSearch,
    infoCandidate.permisB,
    infoCandidate.typeCompanySearch,
    infoCandidate.cv,
    infoCandidate.remarks,
    GROUP_CONCAT(DISTINCT CONCAT(candidateaddress.CP,', ', candidateaddress.addressLabel,', ', candidateaddress.city) SEPARATOR '; ') AS addresses,
    GROUP_CONCAT(DISTINCT CONCAT(candidatezone.cityName, ' (Rayon: ', candidatezone.radius, ' km)') SEPARATOR ', ') AS zones
    FROM infoCandidate
    JOIN candidateaddress ON infoCandidate.idCandidate = candidateaddress.idCandidate
    JOIN candidatezone ON infoCandidate.idCandidate = candidatezone.idCandidate
    WHERE infoCandidate.idCandidate = ?
    GROUP BY
    infoCandidate.idCandidate,
    infoCandidate.INE,
    infoCandidate.name,
    infoCandidate.firstName,
    infoCandidate.yearOfFormation,
    infoCandidate.nameFormation,
    infoCandidate.nameParcours,
    infoCandidate.isInActiveSearch,
    infoCandidate.permisB,
    infoCandidate.typeCompanySearch,
    infoCandidate.cv,
    infoCandidate.remarks;
";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return $req->fetch();
}








