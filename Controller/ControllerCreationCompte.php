<?php
/**
 * Controller de la page Creation Candidat
 * @author : Nathan Strady
 */

require "../Model/ModelCreationCompte.php";


$conn = require "../Model/Database.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);


$msg = "erreur script";
$success = 0;

/*
TODO LIST :
TODO : Faire la récupération DONE
TODO : Faire la gestion et l'affichage des erreurs du form DONE
TODO : Faire l'utilisation des fonctions dans le model pour insérer les données en cas de réussite DONE
*/


/**
 * Fonction regroupant les informations obtenu des champs cp, address, cityCandidates
 * @param $cp : le code postal du form récupèrer
 * @param $addr : l'adresse du form récupèrer
 * @param $city : la ville du form récypèrer
 * @return array : renvoie un tableau de tuple dans lequel chaque tuple contient (Code postal, Adresse, Ville) pour avoir l'adresse complète
 */
function regroupAdresses($cp, $addr, $city){
    $adresses = array();

    for ($i = 0 ; $i < count($cp); $i++){
        $adresses[] = array(
            "CP" => $cp[$i],
            "Address" => $addr[$i],
            "City" => $city[$i]
        );

    }
    return $adresses;

}

/**
 * Fonction regroupant les informations obtenus des champs citySearch, Rayon
 * @param $zone : Ville de recherche du candidat
 * @param $radius : Rayon de recherche autour de la ville
 * @return array : Renvoie un tableau de tuple dans lequel chaque tuple contient (Ville, Rayon) pour avoir la zone complète
 */
function regroupSearchZone($zone,$radius){
    $searchzone = array();

    for ($i = 0 ; $i < count($zone); $i++){
        $searchzone[] = array(
            "SearchCity" => $zone[$i],
            "RadiusCity" => $radius[$i],
        );
    }

    return $searchzone;

}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Récupération des données
    if (empty($_POST['INE']) && empty($_POST['typeCompanySearch']) && empty($_POST['remarksText']) && empty($_POST['typePhone'])){
        $ine = null;
        $typeCompanySearch = null;
        $remark = null;
    } else {
        $ine = $_POST['INE'];
        $typeCompanySearch = $_POST['typeCompanySearch'];
        $remark = $_POST['remarksText'];
    }

    $name = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $nameParcours = $_POST['parcours'];
    $yearOfFormation = $_POST['yearOfFormation'];
    $email = $_POST['candidateEmail'];

    $phone = $_POST['typePhone'];

    if ($_POST['permisB']){
        $permisB = 1;
    } else {
        $permisB = 0;
    }

    $adresses = regroupAdresses($_POST['cp'],$_POST['address'],$_POST['cityCandidate']);
    $searchZone = regroupSearchZone($_POST['citySearch'], $_POST['rayon']);


    if (empty($ine)){
        if (isCandidateExistWithNameAndFirstname($conn, $name, $firstName))
        {
            $msg = "Candidat déjà présent";
        }
        else if (isEmailAlreadyExist($conn, $email))
        {
            $msg = "Email déjà présent";
        }
        else if (isPhoneNumberAlreadyExist($conn, $phone))
        {
            $msg = "Numéro de téléphone déjà présent";
        }
        else
        {
            insertCandidate($conn, null, $name, $firstName, $yearOfFormation, $email, $phone, $nameParcours,$permisB,$typeCompanySearch, $remark, $adresses, $searchZone);
            $success = 1;
            $msg = "Candidat Inscrit";
        }

    }
    else
    {
        if (isCandidateExistWithIne($conn, $ine) || isCandidateExistWithNameAndFirstname($conn, $name, $firstName))
        {
            $msg = "Candidat déjà présent";
        }
        else if (isEmailAlreadyExist($conn, $email))
        {
            $msg = "Email déjà présent";
        }
        else if (isPhoneNumberAlreadyExist($conn, $phone))
        {
            $msg = "Numéro de téléphone déjà présent";
        }
        else
        {
            insertCandidate($conn, $ine, $name, $firstName, $yearOfFormation, $email, $phone, $nameParcours,$permisB,$typeCompanySearch, $remark, $adresses, $searchZone);
            $success = 1;
            $msg = "Candidat Inscrit";
        }
    }

    session_start();
    $_SESSION['message'] = $msg;
    $_SESSION['success'] = $success;
    header("Location: ../View/PageCreationCompte.php");

}
