<?php
/**
 * Controller de la page Creation Candidat
 * @author : Nathan Strady
 */
session_start();

//TODO adapter la bdd pour remettre la formation en clé étrangére et faire le code pour avoir automatiquement les formations

require "../Model/ModelCreationCompte.php";

//TODO enlever debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

/*
TODO LIST :
TODO : Faire la récupération DONE
TODO : Faire la gestion et l'affichage des erreurs du form W.I.P
TODO : Faire l'utilisation des fonctions dans le model pour insérer les données en cas de réussite W.I.P
*/


/**
 * Fonction regroupant les informations obtenu des champs cp, address, cityCandidates
 * @param $cp : le code postal du form récupèrer
 * @param $addr : l'adresse du form récupèrer
 * @param $city : la ville du form récypèrer
 * @return array : renvoie un tableau de tuple dans lequel chaque tuple contient (Code postal, Adresse, Ville) pour avoir l'adresse complète
 */
function regroupAdresses($cp, $addr, $city){
    $adresses = array();

    for ($i = 0 ; $i < count($cp); $i++){
        $adresses[] = array(
            "CP" => $cp[$i],
            "Address" => $addr[$i],
            "City" => $city[$i]
        );

    }
    return $adresses;

}

/**
 * Fonction regroupant les informations obtenus des champs citySearch, Rayon
 * @param $zone : Ville de recherche du candidat
 * @param $radius : Rayon de recherche autour de la ville
 * @return array : Renvoie un tableau de tuple dans lequel chaque tuple contient (Ville, Rayon) pour avoir la zone complète
 */
function regroupSearchZone($zone,$radius){
    $searchzone = array();

    for ($i = 0 ; $i < count($zone); $i++){
        $searchzone[] = array(
            "SearchCity" => $zone[$i],
            "RadiusCity" => $radius[$i],
        );
    }

    return $searchzone;

}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['INE']) && empty($_POST['text'])){
        $ine = null;
        $text = null;
    } else {
        $ine = $_POST['INE'];
        $text = $_POST['text'];
    }

    $adresses = regroupAdresses($_POST['cp'],$_POST['address'],$_POST['cityCandidate']);
    $searchZone = regroupSearchZone($_POST['citySearch'], $_POST['rayon']);


    print_r($adresses);
    print_r($searchZone);
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
}