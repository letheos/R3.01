<script src ="jsActivationDesactivationCompte.js"></script>
<?php
include "../Model/ModelActivationDesactivationCompte.php";

/**
 * Create a dropdown list with the values in the database.
 */
//Fonction d'affichage des candidats
function listAffichageSelect(){

    $results = getAllStudents();

    foreach($results as $row)
    {
        echo '<div class = "rounded-box">';
        echo '<p>' , "nom ", $row['name']  ," ","prenom ", $row[3] ," ",'</p>';
        echo '<form method="post" action="../Controller/ControllerActiveDesactiveCompte.php">';
        echo '<input name="name" type="hidden" value="'.$row['name'].'" ></input> ';
        echo '<input name="firstname" type="hidden" value="'.$row[3].'" ></input> ';

        if($row[7] == 1){

            echo '<p>',"est en recherche active",'</p>';
            echo '<input name="effect" type="hidden" value="nop" > ';
            //echo'<input type="hidden" name="desactiver" value="valeur_invisible">';
            echo '<button  id="desactive" name="bool"  value="0" type="submit"> désactive </button>';
            echo '<button id="delete" name = "delete">supprimer</button>';
            echo '</form>';

        }else {
            echo '<p>',"n'est pas en recherche active",'</p>';
            echo '<input name="effect" type="hidden" value="active" > ';
            echo '<button id="active" name="bool" value="1" type="submit"> active </button>';
            echo '<button id="delete" name = "delete">supprimer</button>';
            echo '</form>';
        }
        echo'<br>';

        echo '</div>';

    }

}

if (isset($_POST['supprimer'])) {
}

if(isset($_POST['effect'])) {
    echo "je suis la ";
    echo "je vais faire l'action avec ".$_POST['name']." ".$_POST['firstname'];
    if ($_POST['effect'] == "active") {
        setEtatTrue($_POST['name'], $_POST['firstname']);
        header('Location: ../View/pageDesactiveActiveEtudiant.php');


    } else {
        setEtatFalse($_POST['name'], $_POST['firstname']);

        header('Location: ../View/pageDesactiveActiveEtudiant.php');
    }
}


