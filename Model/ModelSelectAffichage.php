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

/**
 * Fonction qui supprime un candidat et toute ses informations.
 * @param $conn : Connection à la base de donnée
 * @param $id : Id du candidat à supprimer
 * @return void : Ne renvoie rien, supprime juste le candidat
 */
function deleteCandidate($conn, $id){
    $sqlReq1="DELETE FROM CandidateAddress WHERE idCandidate = ?"; //Suppression des adresses
    $sqlReq2="DELETE FROM CandidateZone WHERE idCandidate = ?"; //Suppression des Zones
    $sqlReq3="DELETE FROM Candidate WHERE idCandidate = ?"; //Suppression des autres information candidats

    //Activation de la requête supression des adresses
    $sqlReq1 = $conn->prepare($sqlReq1);
    $sqlReq1->execute(array($id));

    //Activation de la requête supression des zones de recherche
    $sqlReq2 = $conn->prepare($sqlReq2);
    $sqlReq2->execute(array($id));

    //Activation de la requête supression du candidat
    $sqlReq3 = $conn->prepare($sqlReq3);
    $sqlReq3->execute(array($id));
}
function getbyid($conn,$id){
    $sql = "Select isInActiveSearch from candidate where idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));
    return $req->fetch();
}



function setEtatTrue($conn,$id)
{
    $sql = "UPDATE Candidate SET isInActiveSearch = 1 WHERE idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));

}


function setEtatFalse($conn,$id)
{
    $sql = "UPDATE Candidate SET isInActiveSearch = 0 WHERE idCandidate=?";
    $req = $conn->prepare($sql);
    $req->execute(array($id));

}



