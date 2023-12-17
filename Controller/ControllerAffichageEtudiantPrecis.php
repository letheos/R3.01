<?php

use Acme\Util\ImageExtractor;

$conn = require "../Model/Database.php";
require '../Model/ModelSelect.php';

function afficherEtudiant($conn, $id)
{
    $result = selectCandidatById($conn, $id);

    $enteteBoxHTML = '
        <div class="enteteBox">
            <h2> Candidat : ' . $result["firstName"] . " " . $result["name"] . ' </h2>                       
            <p class="candidates">Email : ' . $result["candidateMail"] . ' 
            <br> Numéro de téléphone : ' . $result['phoneNumber'] . ' </br>
            <br> Formation : ' . $result['nameFormation'] . "
            <br> Parcours : " . $result['nameParcours'] . "
            <br> Année de formation : " . $result['yearOfFormation'] . '</br>
        </div>';

    $informationBoxHTML = '
        <div class="informationBox">
            <p>
                <br> ' . (isset($result['INE']) ? 'INE : ' . $result['INE'] : 'INE non disponible') . "
                <br> Type d'entreprise recherchée : " . $result['typeCompanySearch'] . "
                <br> Adresse : " . $result['addresses'] . "
                <br> Zone : " . $result['zones'] . "
                <br> " . ($result['permisB'] ? "A obtenu le permis B" : "N'a pas obtenu le permis B") . "
                <br> " . ($result['isInActiveSearch'] ? "Est en recherche active" : "N'est pas en recherche active") . "
               <br> " . (isset($result['cv']) ? "<a href='../Controller/ControllerGeneratePreview.php?id=$id' target='_blank'> Voir le CV </a>" : "CV non disponible") . '
            </p>
        </div>';


    echo $enteteBoxHTML . $informationBoxHTML;
}
?>