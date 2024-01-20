<?php
$conn = require "../Model/database.php";
require "../Model/ModelInsertUpdateDelete.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



//On passe la valeur a null si elle n'existe pas

if(!isset($_SESSION["login"])){
    $_SESSION['login'] = null;
}
//On passe la valeur a null si elle n'existe pas
if(!isset($_SESSION["password"])){
    $_SESSION['password'] = null;
}
//Cette condition sert à verifier que la personne accedant a la page d'accueil
if ($_SESSION['login'] == null || $_SESSION['password'] == null) {
    //$_SESSION['provenance'] = 'Accueil';
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['fichierCSV']) && $_FILES['fichierCSV']['error'] === UPLOAD_ERR_OK) {
            $cheminFichierTemporaire = $_FILES['fichierCSV']['tmp_name'];

            $fichier = fopen($cheminFichierTemporaire, 'r');

            // Vérifier si le fichier est ouvert avec succès
            if ($fichier !== false) {
                $entete = fgetcsv($fichier, 0, ';');

                $indexINE = array_search('INE', $entete);
                $indexNom = array_search('Nom d\'usage', $entete);
                $indexPrenom = array_search('Prénom', $entete);
                $indexMail = array_search('Adresse e-mail', $entete);
                $indexAlt = array_search('Alternance', $entete);  //depends de ce qu'il y a dans alternance
                $indexParcours = array_search('Nom du parcours', $entete);
                $indexYear = array_search('Année du parcours', $entete);
                $indexPhone = array_search('Adresse personnelle : téléphone portable', $entete);
                $indexCity = array_search('Adresse personnelle : ville', $entete);
                $indexPostal = array_search('Adresse personnelle : code postal', $entete);
                $indexNameStreet = array_search('Adresse personnelle : nom de rue', $entete);
                $indexNumberStreet = array_search('Adresse personnelle : numéro de rue', $entete);
                $indexProject = array_search("Projet d'entreprise", $entete);
                while (($ligne = fgetcsv($fichier, 0, ',')) !== false) {
                    $ine = $ligne[0];
                    $nom = $ligne[1];
                    $prenom = $ligne[2];
                    $mail = $ligne[3];
                    $alternance = $ligne[4];
                    $parcours = $ligne[5];
                    $parcours = recreateParcours($parcours);
                    $year = $ligne[8];
                    $phone = $ligne[49];
                    $city = $ligne[40];
                    $postal = $ligne[41];
                    $namestreet = $ligne[44];
                    $numstreet = $ligne[43];
                    $project = $ligne[21];


                    $addressStreet = $numstreet . ' ' . $namestreet;
                    $adress = array(array(
                        "CP" => $postal,
                        "Address" => $addressStreet,
                        "City" => $city,
                    )
                    );

                    $zone = array(array(
                        "cityName" => $city,
                        "radius" => 10,
                    ));
                    if ($ine != "") {

                        insertCandidate($conn, $ine, $nom, $prenom, $year, $mail, $phone, $parcours, 0, 'azz', $project, $adress, $zone, null);
                    }

                }
            }
            fclose($fichier);
        }

    }

    function recreateParcours($parcours)
    {
        $tab = array();

        for ($i = 0; $i < strlen($parcours); $i++) {
            $char = $parcours[$i];
            $tab[$i] = ord($char);
        }

        $str = "";

        for ($i = 0; $i < count($tab) - 2; $i++) {
            if ($tab[$i] == 226 && $tab[$i + 1] == 128 && $tab[$i + 2] == 147) {
                $str .= chr(45);
                $i += 2;
            } else {
                $str .= chr($tab[$i]);
            }
        }

        return $str;
    }
}