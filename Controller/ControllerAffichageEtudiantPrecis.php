<?php
$conn = require "../Model/Database.php";



function afficherEtudiant($conn,$id){
    $result = selectCandidatById($conn,$id);
    if($result['permisB'] == 1 && $result['isInActiveSearch'] == 1) {
        echo '<div class="enteteBox">
                  <h2> Candidat : ' . $result["firstName"] . " " . $result["name"] . ' </h2>                       
                  <p class="candidates">  Formation : ' . $result['nameFormation'] . "
                  <br> " . 'Parcours : temp ' . "         
                  <br> ". ' Année de formation : ' . $result['yearOfFormation'].'</p> ' . "   
               </div>
                  
               <div class='informationBox'>
                  <p>   
                  <br> " . 'INE : ' . $result['INE'] . "
                  <br> " . " Type d'entreprise recherchée : " .$result['typeCompanySearch'] . "
                  <br> " . 'Adresse : ' .$result['address'] . "
                  <br> " . "A obtenu le permis B" . "
                  <br> " . "Est en recherche active" . "
                  <br> " . "<a href='../Model/Database.php' download> Télécharger le CV </a>" . '</p>' .'</div> ';
    }
    elseif($result['permisB'] == 1 && $result['isInActiveSearch'] == 0){
        echo '<div class="enteteBox">
                  <h2> Candidat : ' . $result["firstName"] . " " . $result["name"] . ' </h2>                       
                  <p class="candidates">  Formation : ' . $result['nameFormation'] . "
                  <br> " . 'Parcours : temp ' . "         
                  <br> ". ' Année de formation : ' . $result['yearOfFormation'].'</p> ' . "
               </div>
                  
               <div class='informationBox'>
                  <p>   
                  <br> " . 'INE : ' . $result['INE'] . "
                  <br> " . " Type d'entreprise recherchée : " .$result['typeCompanySearch'] . "
                  <br> " . 'Adresse : ' .$result['address'] . "
                  <br> " . "A obtenu le permis B" . "
                  <br> " . "N'est pas en recherche active" . "
                  <br> " . "<a href='../Model/Database.php' download> Télécharger le CV </a>" . '</p>' .'</div> ';
    }
    elseif ($result['permisB'] == 0 && $result['isInActiveSearch'] == 1){
        echo '<div class="enteteBox">
                  <h2> Candidat : ' . $result["firstName"] . " " . $result["name"] . ' </h2>                       
                  <p class="candidates">  Formation : ' . $result['nameFormation'] . "
                  <br> " . 'Parcours : temp ' . "         
                  <br> ". ' Année de formation : ' . $result['yearOfFormation'].'</p> ' . "
               </div>
                  
               <div class='informationBox'>
                  <p>   
                  <br> " . 'INE : ' . $result['INE'] . "
                  <br> " . " Type d'entreprise recherchée : " .$result['typeCompanySearch'] . "
                  <br> " . 'Adresse : ' .$result['address'] . "
                  <br> " . "N'a pas obtenu le permis B" . "
                  <br> " . "Est en recherche active" . "
                  <br> " . "<a href='../Model/Database.php' download> Télécharger le CV </a>" . '</p>' .'</div> ';
    }
    elseif ($result['permisB'] == 0 && $result['isInActiveSearch'] == 0){
        echo '<div class="enteteBox">
                  <h2> Candidat : ' . $result["firstName"] . " " . $result["name"] . ' </h2>                    
                  <p class="candidates">  Formation : ' . $result['nameFormation'] . "
                  <br> " . 'Parcours : temp ' . "         
                  <br> ". ' Année de formation : ' . $result['yearOfFormation'].'</p> ' . " 
               </div>
                  
               <div class='informationBox'>
                  <p>   
                  <br> " . 'INE : ' . $result['INE'] . "
                  <br> " . " Type d'entreprise recherchée : " .$result['typeCompanySearch'] . "
                  <br> " . 'Adresse : ' .$result['address'] . "
                  <br> " . "N'a pas obtenu le permis B" . "
                  <br> " . "N'est pas en recherche active" . "
                  <br> " . "<a href='../Model/Database.php' download> Télécharger le CV </a>" . '</p>' .'</div> ';
    }
}
?>