<?php
session_start();

//TODO adapter la bdd pour remettre la formation en clé étrangére et faire le code pour avoir automatiquement les formations

require "../Model/ModelCreationCompte.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);




//Champs obligatoire
if ($_POST["lastName"] == null || $_POST["firstName"]  == null || $_POST["address"] == null || $_POST["city"] = null) {
    $_SESSION['error'] = 'Veuillez remplir tout les champs obligatoires';
    header('Location: ../View/PageCreationCompte.php');
    exit();
}



//INE
if ($_POST["INE"] == null ) {
    $INE = null;
} else {
    $INE = $_POST["INE"];
}




























/**
 * @param $coon PDO
 * @param $INE String
 * @param $lastName String
 * @param $firstName String
 * @param $address String
 * @param $city String
 * @param $radius int
 * @param $permisB bool
 * @param $formation String
 * @param $typeEntrepriseRecherche String
 * @return void
 * crée un candidat
 */
/*
function insert($INE,$lastName,$firstName,$address,$city,$radius,$permisB,$formation,$typeEntrepriseRecherche){
    if (isset($_POST['envoyer'])) {
        // Récupération des valeurs du formulaire
        $INE = strtoupper($_POST['INE']);
        $lastName = $_POST['lastName'];
        $firstName = $_POST['firstName'];
        $address = $_POST['address'];
        $formation = intval($_POST['formation']);
        $typeEntrepriseRecherche = $_POST['typeEntreprises'];
        $permisB = $_POST['permisB'];
        $cv = $_POST['cv'];
        $coord = $_POST['Ville'];
        $radius = $_POST['radius'];

        $messageErreur = "";
        $messageSucces = "";

    } elseif (preg_match('/[^A-Za-z0-9"\'\,\;]/', $lastName
    )) {
        $messageErreur = "Le nom contient un caractère spécial";

    } elseif (preg_match("/[0-9]/", $lastName
    )) {
        $messageErreur = "Le nom contient un chiffre";

    } elseif (preg_match('/[^A-Za-z0-9"\'\,\;]/', $city
    )) {
        $messageErreur = "La ville contient un caractère spécial";

    } elseif (preg_match("/[0-9]/", $city
    )) {
        $messageErreur = "La ville contient un chiffre";

    }elseif (preg_match('/[^A-Za-z0-9"\'\,\;]/', $firstName
    )) {
        $messageErreur = "Le prénom contient un caractère spécial";

    } elseif (preg_match("/[0-9]/", $firstName
    )) {
        $messageErreur = "Le prénom contient un chiffre";

    }elseif ($radius > 1 || $radius<101){
        $messageErreur = "le radius doit être compris entre 1 à 100";
    }
    elseif ( $lastName == null || $INE == null || $firstName == null || $address == null || $formation == null || $typeEntrepriseRecherche === null || $permisB === null || $city === null || $radius === null) {
        $messageErreur = "Tous les champs de texte doivent être remplis";
    } else {
        $messageSucces = "Enregistré avec succès";
    }
    if ($messageErreur != null) {
        return $messageErreur;
    } else {
        return $messageSucces;
    }

}
*/
?>

<?php
/*
if (isset($_POST['envoyer'])) {

    header("../View/PageCreationCopmpte.php");
}
*/


