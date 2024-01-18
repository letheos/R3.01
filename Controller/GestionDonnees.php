<?php
/**
 * Fonction regroupant les informations obtenu des champs cp, address, cityCandidates
 * @param $cp : le code postal du form récupèrer
 * @param $addr : l'adresse du form récupèrer
 * @param $city : la ville du form récypèrer
 * @return array : renvoie un tableau de tuple dans lequel chaque tuple contient (Code postal, Adresse, Ville) pour avoir l'adresse complète
 */

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
}

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
            "cityName" => $zone[$i],
            "radius" => $radius[$i],
        );
    }

    return $searchzone;

}