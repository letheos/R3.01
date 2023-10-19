<?php
session_start();

//TODO adapter la bdd pour remettre la formation en clé étrangére et faire le code pour avoir automatiquement les formations

require "../Model/ModelCreationCompte.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

$success = 0;
$msg = "Erreur (script)";

$formation = json_decode($_POST["formationOrder"]);


//INE non obligatoire
if (empty($_POST["INE"])) {
    $INE = null;
} else {
    $INE = $_POST["INE"];
}

//Champs obligatoire sinon envoie une erreur
if (empty($_POST["firstName"]) || empty($_POST["lastName"]) || empty($_POST["city"]) || empty($_POST["address"]) || count($formation) == 0){
    $msg = "Veuillez remplir les champs obligatoires";
} else {
    $success = 1;
    $msg = "Candidat crée";
    $name = $_POST["firstName"];
    $firstName = $_POST["lastName"];
    $city = $_POST["city"];
    $address = $_POST["address"];

}

//Envoie des résultats des traitements
echo json_encode(["success" => $success, "msg" => $msg]);




























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
?>

<?php
if (isset($_POST['envoyer'])) {

    header("../View/PageCreationCopmpte.php");
}


