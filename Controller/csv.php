<?php
$conn = require "../Model/database.php";
require "../Model/ModelInsertUpdateDelete.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/*

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
}*/

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
           // if ($indexINE !== false && $indexNom !== false && $indexPrenom !== false) {
                echo '<script>alert("après if")</script>';
                while (($ligne = fgetcsv($fichier, 0, ',')) !== false) {
                    $ine = $ligne[0];
                    $nom = $ligne[1];
                    $prenom = $ligne[2];
                    $mail = $ligne[3];
                    $alternance = $ligne[4];
                    $parcours = $ligne[5];
                    $year = $ligne[8];
                    $phone = $ligne[49];
                    $city = $ligne[40];
                    $postal = $ligne[41];
                    $namestreet = $ligne[44];
                    $numstreet = $ligne[43];
                    $project = $ligne[21];
                    echo "INE: $ine<br>";
                    echo "Nom: $nom<br>";
                    echo "Prénom: $prenom<br>";
                    echo "Adresse e-mail: $mail<br>";
                    echo "Alternance: $alternance<br>";
                    echo "Nom du parcours: $parcours<br>";
                    echo "Année du parcours: $year<br>";
                    echo "Téléphone: $phone<br>";
                    echo "Ville: $city<br>";
                    echo "Code Postal: $postal<br>";
                    echo "Nom de Rue: $namestreet<br>";
                    echo "Numéro de Rue: $numstreet<br>";
                    echo "Projet d'Entreprise: $project<br>";


// Constructing the full address for the 'Adresse personnelle'
                        $addressStreet = $numstreet . ' ' . $namestreet;
                    //echo "INE: $ine, Nom: $nom, Prenom: $prenom, Mail: $mail, Alternance: $alternance, Parcours: $parcours, Année: $year, Téléphone: $phone, Ville: $city, Code Postal: $postal, Nom de Rue: $namestreet, Numéro de Rue: $numstreet, Projet d'Entreprise: $project";
                    if($ine != ""){
// Now you can use these variables in your insertCandidate function
                     insertCandidate($conn,$ine,$nom,$prenom,$year,$mail,$phone,$parcours,0,'azz',$project,$addressStreet,null,null);
                    }

                }
            }
       # }
        fclose($fichier);
    }

}