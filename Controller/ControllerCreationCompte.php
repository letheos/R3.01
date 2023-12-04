<?php
/**
 * Controller de la page Creation Candidat
 * @author : Nathan Strady
 */

require "../Model/ModelSelect.php";
require "../Model/ModelInsertUpdateDelete.php";


$conn = require "../Model/Database.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);


$msg = "erreur script";
$success = 1;
$directory = '../upload/';

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
    $ine = !empty($_POST['INE']) ? $_POST['INE'] : null;
    $typeCompanySearch = !empty($_POST['typeCompanySearch']) ? $_POST['typeCompanySearch'] : null;
    $remark = !empty($_POST['remarksText']) ? $_POST['remarksText'] : null;
    $cv = $_FILES['cvFile'];

    $name = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $nameParcours = $_POST['parcours'];
    $yearOfFormation = $_POST['yearOfFormation'];
    $email = $_POST['candidateEmail'];

    $phone = $_POST['typePhone'];

    if ($_POST['permisB']) {
        $permisB = 1;
    } else {
        $permisB = 0;
    }

    $adresses = regroupAdresses($_POST['cp'], $_POST['address'], $_POST['cityCandidate']);
    $searchZone = regroupSearchZone($_POST['citySearch'], $_POST['rayon']);


    // Vérifiez s'il y a une erreur lors du téléchargement
    if ($cv['error'] === UPLOAD_ERR_OK) {
        // Le fichier a été téléchargé avec succès
        $uploadFile = $directory . basename($cv['name']);
        $extensions = array(".pdf", ".jpeg", ".jpg", ".png");
        $extension = strrchr($cv['name'], '.');

        if (!in_array($extension, $extensions)) {
            $msg = "Vous devez uploader un fichier de type pdf, jpeg, jpg ou png";
            $success = 0;
        }

        if ($success == 1) {
            if (!move_uploaded_file($cv['tmp_name'], $uploadFile)) {
                // Il y a eu une erreur lors du déplacement du fichier
                $msg = "Erreur lors du déplacement du fichier";
                $success = 0;
            }
        } else {
            // Il y a eu une erreur lors du téléchargement du fichier
            $msg = "Erreur lors du téléchargement du fichier : " . $cv['error'];
            $success = 0;
        }
    }



    // Vérifications supplémentaires
    if ($success === 1) {
        // Vos vérifications existantes
        if (isCandidateExistWithNameAndFirstname($conn, $name, $firstName)) {
            $msg = "Candidat déjà présent";
            $success = 0;
        } elseif (isEmailAlreadyExist($conn, $email)) {
            $msg = "Email déjà présent";
            $success = 0;
        } elseif (isPhoneNumberAlreadyExist($conn, $phone)) {
            $msg = "Numéro de téléphone déjà présent";
            $success = 0;
        } else {
            // Insertion du candidat si toutes les vérifications passent
            insertCandidate($conn, $ine, $name, $firstName, $yearOfFormation, $email, $phone, $nameParcours, $permisB, $typeCompanySearch, $remark, $adresses, $searchZone, $uploadFile);
            $msg = "Candidat inscrit";
            $success = 1;
        }
    }



    session_start();
    $_SESSION['message'] = $msg;
    $_SESSION['success'] = $success;
    header("Location: ../View/PageCreationCompte.php");

}