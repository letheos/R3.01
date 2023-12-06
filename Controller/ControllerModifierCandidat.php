<?php
$conn = require "../Model/Database.php";
require "../Model/ModelInsertUpdateDelete.php"; // Assurez-vous d'inclure le fichier contenant vos fonctions de mise à jour
require "../Model/ModelSelect.php";
require "GestionDonnees.php";

$msg = "erreur script";
$success = 1;
$directory = './upload/';


error_reporting(E_ALL);
ini_set('display_errors', 1);


// Vérifiez si l'ID est présent dans l'URL
if (isset($_POST['id'])) {
    // Récupérez l'ID depuis l'URL
    $id=$_POST['id'];
} else {
    // Gérez le cas où l'ID n'est pas présent dans le formulaire
    exit("ID non spécifié dans le formulaire");
}




if ($_SERVER["REQUEST_METHOD"] == "POST" && $success == 1) {
    //Les zones et adresses du candidat dans la base de donnée
    $adresses = regroupAdresses($_POST['cp'], $_POST['address'], $_POST['cityCandidate']);
    $searchZone = regroupSearchZone($_POST['citySearch'], $_POST['rayon']);

    //Verification de la présence des informations pour modification
    if (isset($_POST["INE"])){
        if (!isCandidateExistWithIne($conn, $_POST["INE"])) {
            updateIneCandidate($conn, $id, $_POST["INE"]);
        } else {
            exit("Arrête");
            /*
            echo '
                  <script>
                  alert("INE DEJA EXISTANT");
                  document.location.href = "../View/PageModificationCandidat.php?id='. $id .'"; 
                  </script> 
                 ';
            */
        }
    }

    if (isset($_POST["lastName"])) {
        updateNameCandidate($conn, $id, $_POST["lastName"]);
    }

    if (isset($_POST["firstName"])) {
        updateFirstNameCandidate($conn, $id, $_POST["firstName"]);
    }

    if (isset($_POST['canditateEmail'])){
        updateMailCandidate($conn, $id, $_POST['canditateEmail']);
    }

    if (isset($_POST['typePhone'])){
        updatePhoneNumberCandidate($conn, $id, $_POST['typePhone']);
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

    if (isset($_FILES['cvFile'])){
        $cv = $_FILES['cvFile'];
        $uploadFile = $directory . basename($cv['name']);
        updateCVCandidate($conn, $id, $uploadFile);

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
            $currentAddr = $address['idAddr'] ?? null;
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
            $currentAddr = $zone['idZone'] ?? null;
            if ($currentAddr !== null) {
                updateZone($conn, $currentAddr, $city, $radius);
            } else {
                insertSearchZone($conn, $id, $city, $radius);
            }
        }
    }

    header("Location: ../View/PageAffichageEtudiantPrecis.php?id=$id");




} else {
    $success = 0;
    $msg = "Problème lors de l'envoie de la demande de moficiation";
    header("Location: ../View/PageAffichageEtudiantPrecis.php?id=$id");
}
