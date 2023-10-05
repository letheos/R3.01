<?php
$conn = require "../Model/Database.php";


function afficherEtudiant($conn,$name){
    $result = selectCandidat($conn,$name);
    if($result['permisB'] == 1 && $result['isInActiveSearch'] == 1) {
        echo '<p class="candidates"> INE : ' . $result['INE'] . "
                                  <br> " . 'Prénom : ' . $result['firstName'] . "
                                  <br> " . 'Nom de famille : ' . $result['name'] . "
                                  <br> " . 'Formation : ' . $result['nameFormation'] . "
                                  <br> " . 'Ville : ' . $result['ville'] . "
                                  <br> " . 'Adresse : ' .$result['address'] . "
                                  <br> " . "A obtenu le permis B" . "
                                  <br> " . " Type d'entreprise recherchée : " .$result['typeEntrepriseRecherchee'] . "
                                  <br> " . "Est en recherche active" . "
                                  <br> " . "<a href='../Model/Database.php' download> Télécharger le CV </a>" . '</p>';
    }
    elseif($result['permisB'] == 1 && $result['isInActiveSearch'] == 0){
        echo '<p class="candidates"> INE : ' . $result['INE'] . "
                                  <br> " . 'Prénom : ' . $result['firstName'] . "
                                  <br> " . 'Nom de famille : ' . $result['name'] . "
                                  <br> " . 'Formation : ' . $result['nameFormation'] . "
                                  <br> " . 'Ville : ' . $result['ville'] . "
                                  <br> " . 'Adresse : ' .$result['address'] . "
                                  <br> " . "A obtenu le permis B" . "
                                  <br> " . " Type d'entreprise recherchée : " .$result['typeEntrepriseRecherchee'] . "
                                  <br> " . "N'est pas en recherche active" . "
                                  <br> " . "<a href='../Model/Database.php' download> Télécharger le CV </a>" . '</p>';
    }
    elseif ($result['permisB'] == 0 && $result['isInActiveSearch'] == 1){
        echo '<p class="candidates"> INE : ' . $result['INE'] . "
                                  <br> " . 'Prénom : ' . $result['firstName'] . "
                                  <br> " . 'Nom de famille : ' . $result['name'] . "
                                  <br> " . 'Formation : ' . $result['nameFormation'] . "
                                  <br> " . 'Ville : ' . $result['ville'] . "
                                  <br> " . 'Adresse : ' .$result['address'] . "
                                  <br> " . "N'a pas obtenu le permis B" . "
                                  <br> " . " Type d'entreprise recherchée : " .$result['typeEntrepriseRecherchee'] . "
                                  <br> " . "Est pas en recherche active" . "
                                  <br> " . "<a href='../Model/Database.php' download> Télécharger le CV </a>" . '</p>';
    }
    elseif ($result['permisB'] == 0 && $result['isInActiveSearch'] == 0){
        echo '<p class="candidates"> INE : ' . $result['INE'] . "
                                  <br> " . 'Prénom : ' . $result['firstName'] . "
                                  <br> " . 'Nom de famille : ' . $result['name'] . "
                                  <br> " . 'Formation : ' . $result['nameFormation'] . "
                                  <br> " . 'Ville : ' . $result['ville'] . "
                                  <br> " . 'Adresse : ' .$result['address'] . "
                                  <br> " . "A obtenu le permis B" . "
                                  <br> " . " Type d'entreprise recherchée : " .$result['typeEntrepriseRecherchee'] . "
                                  <br> " . "N'est pas en recherche active" . "
                                  <br> " . "<a href='../Model/Database.php' download> Télécharger le CV </a>" . '</p>';
    }
}
?>