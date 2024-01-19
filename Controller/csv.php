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
                while (($ligne = fgetcsv($fichier, 0, ';')) !== false) {

                    $ine = $ligne[$indexINE];
                    $nom = $ligne[$indexNom];
                    $prenom = $ligne[$indexPrenom];
                    $mail = $ligne[$indexMail];
                    $alternance = $ligne[$indexAlt];
                    $parcours = $ligne[$indexParcours];
                    $year = $ligne[$indexYear];
                    $phone = $ligne[$indexPhone];
                    $city = $ligne[$indexCity];
                    $postal = $ligne[$indexPostal];
                    $namestreet = $ligne[$indexNameStreet];
                    $numstreet = $ligne[$indexNumberStreet];
                    $project = $ligne[$indexProject];
                        /*
                        $nameFormation = $ineParts[7];
                        $yearFormationStart = $ineParts[8];
                        $etablissement = $ineParts[9];
                        $ecole = $ineParts[10];
                        $genre = $ineParts[11];
                        $dateNaissance = $ineParts[12];
                        $nomNaissance = $ineParts[13];
                        $lieuNaissance = $ineParts[14];
                        $codeDepartementNaissance = $ineParts[15];
                        $nationalite = $ineParts[16];
                        $situationFamiliale = $ineParts[17];
                        $handicap = $ineParts[18];
                        $rqth = $ineParts[19];
                        $numSecuSociale = $ineParts[20];
                        $projetEntreprise = $ineParts[21];
                        $boursierSecondaire = $ineParts[22];
                        $boursierSuperieur = $ineParts[23];
                        $codeDepartementPrecedentEtablissement = $ineParts[24];
                        $nomDernierDiplome = $ineParts[27];
                        $codeDernierDiplome = $ineParts[28];
                        $nomDernierDiplomePrepare = $ineParts[29];
                        $codeDernierDiplomePrepare = $ineParts[30];
                        $nomDerniereClasse = $ineParts[31];
                        $codeDerniereClasse = $ineParts[32];
                        $nomDerniereSituation = $ineParts[33];
                        $codeDerniereSituation = $ineParts[34];
                        $nomSituationAnneePrecedente = $ineParts[35];
                        $codeApprentiSituationAnneePrecedente = $ineParts[36];
                        $autreCodeSituationAnneePrecedente = $ineParts[37];
                        $prenomRepresentantLegal = $ineParts[38];
                        $nomRepresentantLegal = $ineParts[39];
                        $emailRepresentantLegal = $ineParts[40];
                        $paysAdressePersonnelle = $ineParts[41];
                        $villeAdressePersonnelle = $ineParts[42];
                        $codePostalAdressePersonnelle = $ineParts[43];
                        $codeInseeAdressePersonnelle = $ineParts[44];
                        $numRueAdressePersonnelle = $ineParts[45];
                        $nomRueAdressePersonnelle = $ineParts[46];
                        $localiteAdressePersonnelle = $ineParts[47];
                        $batimentAdressePersonnelle = $ineParts[48];
                        $appartementAdressePersonnelle = $ineParts[49];
                        $telFixeAdressePersonnelle = $ineParts[50];
                        $telPortableAdressePersonnelle = $ineParts[51];
                        $faxAdressePersonnelle = $ineParts[52];
                        $paysAdresseResidentielle = $ineParts[53];
                        $villeAdresseResidentielle = $ineParts[54];
                        $codePostalAdresseResidentielle = $ineParts[55];
                        $codeInseeAdresseResidentielle = $ineParts[56];
                        $numRueAdresseResidentielle = $ineParts[57];
                        $nomRueAdresseResidentielle = $ineParts[58];
                        $localiteAdresseResidentielle = $ineParts[59];
                        $batimentAdresseResidentielle = $ineParts[60];
                        $appartementAdresseResidentielle = $ineParts[61];
                        $telFixeAdresseResidentielle = $ineParts[62];
                        $telPortableAdresseResidentielle = $ineParts[63];
                        $faxAdresseResidentielle = $ineParts[64];
                        $paysAdresseRepresentantLegal = $ineParts[65];
                        $villeAdresseRepresentantLegal = $ineParts[66];
                        $codePostalAdresseRepresentantLegal = $ineParts[67];
                        $codeInseeAdresseRepresentantLegal = $ineParts[68];
                        $numRueAdresseRepresentantLegal = $ineParts[69];
                        $nomRueAdresseRepresentantLegal = $ineParts[70];
                        $localiteAdresseRepresentantLegal = $ineParts[71];
                        $batimentAdresseRepresentantLegal = $ineParts[72];
                        $appartementAdresseRepresentantLegal = $ineParts[73];
                        $telFixeAdresseRepresentantLegal = $ineParts[74];
                        $telPortableAdresseRepresentantLegal = $ineParts[75];
                        $faxAdresseRepresentantLegal = $ineParts[76];
*/
// Constructing the full address for the 'Adresse personnelle'
                        $addressStreet = $numstreet . ' ' . $namestreet;
                    echo "INE: $ine, Nom: $nom, Prenom: $prenom, Mail: $mail, Alternance: $alternance, Parcours: $parcours, Année: $year, Téléphone: $phone, Ville: $city, Code Postal: $postal, Nom de Rue: $namestreet, Numéro de Rue: $numstreet, Projet d'Entreprise: $project";
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