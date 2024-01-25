<?php
/**
 * @author Nathan Strady
 * Controller du fichier de modification Candidat
 */
session_start();


if (empty($_SESSION['user'])) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}

//Appel des fichiers importants
$conn = require "../Model/Database.php";
require "../Model/ModelInsertUpdateDelete.php"; // Assurez-vous d'inclure le fichier contenant vos fonctions de mise à jour
require "../Model/ModelSelect.php";
require "GestionDonnees.php";

//Gestion des erreurs
$msg = "erreur script";
$success = 1;

//Fichier des cvs
$directory = '../upload/';


function getCandidatById($id){
    global $conn;
    return selectCandidatById($conn, $id);
}




//Récupère l'id dans l'url
if (isset($_POST['id'])) {
    $id=$_POST['id'];
} else {
    exit("ERREUR SERVEUR : ID non spécifié dans le formulaire");
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Les zones et adresses du candidat dans la base de donnée
    $adresses = regroupAdresses($_POST['cp'], $_POST['address'], $_POST['cityCandidate']);
    $searchZone = regroupSearchZone($_POST['citySearch'], $_POST['rayon']);

    //Verification de la présence des informations pour modification
    if (isset($_POST["INE"]) && $success == 1){
        if (!isCandidateExistWithIneWithIdVerification($conn, $_POST["INE"], $id)) {
            updateIneCandidate($conn, $id, $_POST["INE"]);
        } else {
            $success = 0;
            $msg = "INE DEJA EXISTANT";
        }
    }

    if (isset($_POST["lastName"])) {
        updateNameCandidate($conn, $id, $_POST["lastName"]);
    }

    if (isset($_POST["firstName"])) {
        updateFirstNameCandidate($conn, $id, $_POST["firstName"]);
    }

    if (isset($_POST['canditateEmail'])){
        if(!isEmailAlreadyExistWithIdVerification($conn, $_POST['canditateEmail'], $id)) {
            updateMailCandidate($conn, $id, $_POST['canditateEmail']);
        } else {
            $success = 0;
            $msg = "EMAIL DEJA EXISTANT";
        }
    }

    if (isset($_POST['typePhone']) && $success == 1) {
        if (!isPhoneNumberAlreadyExistWithIdVerification($conn, $_POST['typePhone'], $id)) {
            updatePhoneNumberCandidate($conn, $id, $_POST['typePhone']);
        } else {
            $success = 0;
            $msg = "NUMERO DE TELEPHOENE DEJA EXISTANT";
        }
    }

    if (isset($_POST['permisB'])){
        updateDriverLicenceCandidate($conn, $id, $_POST['permisB']);
    }

    if (isset($_POST['parcours'])){
        updateParcoursCandidate($conn, $id, $_POST['parcours']);
    }

    if (isset($_POST['yearOfFormation'])){
        updateYearOfFormationCandidate($conn, $id, $_POST['yearOfFormation']);
    }

    if (isset($_POST['typeCompanySearch'])){
        updateTextAreaCandidate($conn, $id, $_POST['typeCompanySearch']);
    }

    if (isset($_POST['remarks'])){
        updateRemarksCandidate($conn, $id, $_POST['remarks']);
    }

    if (isset($_FILES['cvFile']) && $_FILES['cvFile']['size'] > 0){
        $cv = $_FILES['cvFile'];
        $uploadFile = $directory . basename($cv['name']);
        updateCVCandidate($conn, $id, $uploadFile);
        $extensions = array(".pdf");
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
        }
    }

    if (isset($adresses)){
        $idAddr = selectIdAddrByCandidate($conn, $id);
        $existingAddr = array_column($adresses, 'idAddr');
        foreach ($idAddr as $dbAddress) {
            $dbIdAddr = $dbAddress['idAddr'];
            if (!in_array($dbIdAddr, $existingAddr)) {
                deleteAddr($conn, $dbIdAddr);
            }
        }

        foreach ($adresses as $address) {
            $cp = $address['CP'];
            $addr = $address['Address'];
            $city = $address['City'];
            $currentAddr = $address['idAddr'] ?? null; //Opération ternaire qui vérifie si on à bien l'élement ou non
            if ($currentAddr !== null) {
                updateAddr($conn, $currentAddr, $cp, $addr, $city);
            } else {
                insertAddr($conn, $id, $cp, $addr, $city);
            }
        }
    }

    if (isset($searchZone)){
        $idZone = selectIdZoneByCandidate($conn, $id);
        $existingZone = array_column($searchZone, 'idZone');
        foreach ($idZone as $dbZone) {
            $dbIdZone = $dbZone['idZone'];
            if (!in_array($dbIdZone, $existingZone)) {
                deleteZone($conn, $dbIdZone);
            }
        }

        foreach ($searchZone as $zone) {
            $city = $zone['cityName'];
            $radius = $zone['radius'];
            $currentAddr = $zone['idZone'] ?? null; //Opération ternaire qui vérifie si on à bien l'élement ou non
            if ($currentAddr !== null) {
                updateZone($conn, $currentAddr, $city, $radius);
            } else {
                insertSearchZone($conn, $id, $city, $radius);
            }
        }
    }

    if ($success == 1){
        $msg = "Modification(s) réalisée(s) avec succès ! ";
        $_SESSION['message'] = $msg;
        header("Location: ../View/PageAffichageEtudiantPrecis.php?id=$id");
    } else {
        echo '
              <script>
              alert("'. $msg .'");
              document.location.href = "../View/PageModifierCandidat.php?id='. $id .'"; 
              </script> 
             ';
    }
} else {
    exit("Problème lors de l'envoie");
}



