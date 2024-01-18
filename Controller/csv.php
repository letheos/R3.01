<?php
$conn = require "../Model/database.php";
require "../Model/ModelInsertUpdateDelete.php";

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
            if ($indexINE !== false && $indexNom !== false && $indexPrenom !== false) {
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
                    $nameStreet = $ligne[$indexNameStreet];
                    $numberStreet = $ligne[$indexNumberStreet];
                    $project = $ligne[$indexProject];


                    $addressStreet = $numberStreet . ' ' . $nameStreet;

                    insertCandidate($conn,$ine,$nom,$prenom,$year,$mail,$phone,$parcours,null,null,$project,$addressStreet,null,null);

                }
            }
        }
            fclose($fichier);
        }

}