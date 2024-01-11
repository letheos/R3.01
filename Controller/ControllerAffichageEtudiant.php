<?php

require '../Model/ModelSelect.php';


/**
 * Controller de la page affichage étudiant
 * @author : Nathan Strady
 */

/**
 * @param $conn
 * @return void
 * Créer la liste déroulante dynamiquement en fonction des formations.
 */
//Fonction d'affichage des candidats
function listAffichageSelect($conn){
    $selected = '';
    $selectedFormation = (isset($_POST['formation'])) ? $_POST['formation'] : '';
    $results = allFormation($conn);
    echo '<select class="form-select" name="formation" id="formation" onchange="onChangeUpdateDisplayParcours(\'../Controller/ControllerParcoursjs.php\')">', "\n";
    echo '<option value="" selected="selected" disabled> Choisir la formation </option>';
    foreach($results as $row)
    {
        $optionValue = $row['nameFormation'];
        $selected = ($selectedFormation == $optionValue) ? 'selected' : '';
        echo "\t", '<option value="', $optionValue, '"', $selected, '>', $optionValue, '</option>', "\n";
    }
    echo '<option value="Aucune Option" > Aucune Option </option>';
    echo '</select>',"\n";
}


/**
 * @param $conn
 * @param $choixFormation
 * @param $isActive
 * @return void
 * Affiche dans le php les candidats en fonction du filtrage
 */
//Fonction d'affichage des candidats en fonction d'un filtrage
function choiceAllOptionWithActive($conn, $isActive){
    $results = selectCandidatesActives($conn, $isActive);
    foreach ($results as $row) {
        // Utilisez un lien vers la page des détails du candidat
        echo '
        <p class="candidates" id="candidats"> '. $row['firstName'] . " " . $row['name'] . " " . $row['nameParcours'] .'<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id='.$row["idCandidate"].'">Détail</a>'.'
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" '.  $row['idCandidate'] .' " onclick="showAlert(this)">Supprimer</button> ';
        if ($isActive){
            echo '<input type="checkbox" name="checkboxActif[]" value="'.$row['idCandidate'].'"> Rendre Inactif';
        } else {
            echo '<input type="checkbox" name="checkboxNonActif[]" value=" '.$row['idCandidate'].' "> Rendre Actif';
        }
    }
}



/**
 * @param $conn
 * @param $choixFormation
 * @param $isActive
 * @return void
 * Affiche dans le php les candidats en fonction du filtrage sur la formation
 */
//Fonction d'affichage des candidats en fonction d'un filtrage sur la formation
function choiceAllCandidatesByFormation($conn, $choixFormation,  $isActive){
    $results = selectCandidatesByFormation($conn, $choixFormation,  $isActive);
    foreach ($results as $row) {
        echo '
        <p class="candidates" id="candidats"> '. $row['firstName'] . " " . $row['name'] . " " . $row['nameParcours'] .'<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id='.$row["idCandidate"].'">Détail</a>'.'
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" '.  $row['idCandidate'] .' " onclick="showAlert(this)">Supprimer</button> ';
        if ($isActive){
            echo '<input type="checkbox" name="checkboxActif[]" value="'.$row['idCandidate'].'"> Rendre Inactif';
        } else {
            echo '<input type="checkbox" name="checkboxNonActif[]" value=" '.$row['idCandidate'].' "> Rendre Actif';
        }
    }

}

function choiceAllCandidatesByParcours($conn, $parcours, $isActive){
    $results = selectCandidatesByParcours($conn, $parcours,  $isActive);
    foreach ($results as $row) {
        echo '
        <p class="candidates" id="candidats"> '. $row['firstName'] . " " . $row['name'] . " " . $row['nameParcours'] .'<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id='.$row["idCandidate"].'">Détail</a>'.'
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" '.  $row['idCandidate'] .' " onclick="showAlert(this)">Supprimer</button> ';
        if ($isActive){
            echo '<input type="checkbox" name="checkboxActif[]" value="'.$row['idCandidate'].'"> Rendre Inactif';
        } else {
            echo '<input type="checkbox" name="checkboxNonActif[]" value=" '.$row['idCandidate'].' "> Rendre Actif';
        }
    }

}

/**
 * Fonction qui affiche les candidats en fonction du nom et du parcours
 * @param $conn : Connection à la base de donnée
 * @param $choixNom : Choix du nom
 * @param $parcours : Choix du parcours
 * @param $isActive : Si le candidat est actif
 * @return void :
 */
function choiceAllCandidatesByNameAndParcours($conn, $choixNom,$parcours, $isActive){
    $results = selectCandidatesByNameAndParcours($conn, $choixNom,$parcours,  $isActive);
    foreach ($results as $row) {
        echo '
        <p class="candidates" id="candidats"> '. $row['firstName'] . " " . $row['name'] . " " . $row['nameParcours'] .'<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id='.$row["idCandidate"].'">Détail</a>'.'
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" '.  $row['idCandidate'] .' " onclick="showAlert(this)">Supprimer</button> ';
        if ($isActive){
            echo '<input type="checkbox" name="checkboxActif[]" value="'.$row['idCandidate'].'"> Rendre Inactif';
        } else {
            echo '<input type="checkbox" name="checkboxNonActif[]" value=" '.$row['idCandidate'].' "> Rendre Actif';
        }
    }

}

/**
 * Fonction qui affiche les candidats en fonction du nom et de la formation
 * @param $conn : Connection à la base de donnée
 * @param $choixFormation : Choix de la formation
 * @param $choixNom : Choix du nom
 * @param $isActive : Si le candidat est actif
 * @return void Modifie l'affichage de la page
 */
//Fonction d'affichage des candidats en fonction d'un filtrage sur la formation et le nom
function choiceAllCandidatesByNameAndFormation($conn, $choixFormation,  $isActive, $choixNom){
    $results = selectCandidatesByNameAndFormation($conn, $choixFormation, $choixNom, $isActive);
    foreach ($results as $row) {
        echo '
        <p class="candidates" id="candidats"> '. $row['firstName'] . " " . $row['name'] . " " . $row['nameParcours'] .'<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id='.$row["idCandidate"].'">Détail</a>'.'
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" '.  $row['idCandidate'] .' " onclick="showAlert(this)">Supprimer</button> ';
        if ($isActive){
            echo '<input type="checkbox" name="checkboxActif[]" value="'.$row['idCandidate'].'"> Rendre Inactif';
        } else {
            echo '<input type="checkbox" name="checkboxNonActif[]" value=" '.$row['idCandidate'].' "> Rendre Actif';
        }
    }
}

/**
 * Fonction qui affiche les candidats en fonction du nom
 * @param $conn : Connection à la base de donnée
 * @param $choixFormation : Choix de la formation
 * @param $isActive : Si le candidat est actif
 * @return void Modifie l'affichage de la page
 */
//Fonction d'affichage des candidats en fonction d'un filtrage sur le nom
function choiceAllCandidatesByName($conn, $isActive, $choixNom){
    $results = selectCandidatesByName($conn, $choixNom,  $isActive);
    foreach ($results as $row) {
        echo '
        <p class="candidates" id="candidats"> '. $row['firstName'] . " " . $row['name'] . " " . $row['nameParcours'] .'<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id='.$row["idCandidate"].'">Détail</a>'.'
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" '.  $row['idCandidate'] .' " onclick="showAlert(this)">Supprimer</button> ';
        if ($isActive){
            echo '<input type="checkbox" name="checkboxActif[]" value="'.$row['idCandidate'].'"> Rendre Inactif';
        } else {
            echo '<input type="checkbox" name="checkboxNonActif[]" value=" '.$row['idCandidate'].' "> Rendre Actif';
        }
    }
}

/**
 * Fonction qui affiche les candidats en fonction de la formation et du parcours
 * @param $conn : Connection à la base de donnée
 * @param $choixFormation : Choix de la formation
 * @param $parcours : Choix du parcours
 * @param $isActive : Si le candidat est actif
 * @return void Modifie l'affichage de la page
 */
function choiceAllCandidatesByFormationAndParcours($conn, $choixFormation, $parcours, $isActive){
    $results = selectCandidateByFormationAndParcours($conn, $choixFormation, $parcours, $isActive);
    foreach ($results as $row) {
        echo '
        <p class="candidates" id="candidats"> ' . $row['firstName'] . " " . $row['name'] . " " . $row['nameParcours'] . '<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id=' . $row["idCandidate"] . '">Détail</a>' . '
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" ' . $row['idCandidate'] . ' " onclick="showAlert(this)">Supprimer</button> ';
        if ($isActive){
            echo '<input type="checkbox" name="checkboxActif[]" value=" ' . $row['idCandidate'] . ' "> Rendre Inactif';
        } else {
            echo '<input type="checkbox" name="checkboxNonActif[]" value=" '.$row['idCandidate'].' "> Rendre Actif';
        }
    }
}

/**
 * Fonction qui affiche les candidats en fonction de leur nom, formation et parcours
 * @param $conn : Connection à la base de donnée
 * @param $choixNom : Choix du nom
 * @param $choixFormation : Choix de la formation
 * @param $parcours : Choix du parcours
 * @param $isActive : Si le candidat est actif
 * @return void : Modifie l'affichage de la page
 */
function choiceAllCandidatesByNameFormationAndParcours($conn, $choixNom, $choixFormation, $parcours, $isActive){
    $results = selectCandidatesByNameFormationAndParcours($conn, $parcours, $choixNom, $choixFormation, $isActive);
    foreach ($results as $row) {
        echo '
        <p class="candidates" id="candidats"> '. $row['firstName'] . " " . $row['name'] . " " . $row['nameParcours'] .'<br> <a class="btn btn-primary" href="./PageAffichageEtudiantPrecis.php?id='.$row["idCandidate"].'">Détail</a>'.'
        <button id="delete" class="btn btn-outline-danger" name="delete" type="submit" data-id=" '.  $row['idCandidate'] .' " onclick="showAlert(this)">Supprimer</button> ';
        if ($isActive){
            echo '<input type="checkbox" name="checkboxActif[]" value="'.$row['idCandidate'].'"> Rendre Inactif';
        } else {
            echo '<input type="checkbox" name="checkboxNonActif[]" value=" '.$row['idCandidate'].' "> Rendre Actif';
        }

    }
}


/**
 * Fonction qui gère le filtrage pour afficher des candidats en fonction de critères précis
 * @param $conn : Connection à la base de donnée
 * @return void Modifie l'affichage en fonction d'un filtrage
 */
function filtrage($conn)
{
    if (isset($_POST["submit"])) {
        $choixFormation = $_POST["formation"];
        $choixNom = $_POST["nameCandidates"];
        $parcours = $_POST['parcours'];
    }


    //Traitement de la checkbox
    if (isset($_POST["isActive"])) {
        $isActive = 0;
    } else {
        $isActive = 1;
    }

    $hasFormationFilter = !empty($choixFormation) && $choixFormation !== "Aucune Option";
    $hasNomFilter = !empty($choixNom);
    $hasParcoursFilter = !empty($parcours);


    // Exécuter les requêtes en fonction des critères de filtrage
    if ($hasFormationFilter && $hasNomFilter && $hasParcoursFilter) {
        // Filtrage par formation, nom et parcours
        choiceAllCandidatesByNameFormationAndParcours($conn,  $choixNom, $choixFormation, $parcours, $isActive);
    } elseif ($hasFormationFilter && $hasNomFilter) {
        // Filtrage par formation et nom
        choiceAllCandidatesByNameAndFormation($conn, $choixFormation, $isActive, $choixNom);
    } elseif ($hasFormationFilter && $hasParcoursFilter) {
        // Filtrage par formation et parcours
        choiceAllCandidatesByFormationAndParcours($conn, $choixFormation, $parcours, $isActive);
    } elseif ($hasNomFilter && $hasParcoursFilter) {
        // Filtrage par nom et parcours
        choiceAllCandidatesByNameAndParcours($conn, $choixNom, $parcours, $isActive);
    } elseif ($hasFormationFilter) {
        // Filtrage par formation uniquement
        choiceAllCandidatesByFormation($conn, $choixFormation, $isActive);
    } elseif ($hasNomFilter) {
        // Filtrage par nom uniquement
        choiceAllCandidatesByName($conn, $isActive, $choixNom);
    } elseif ($hasParcoursFilter) {
        // Filtrage par parcours uniquement
        choiceAllCandidatesByParcours($conn, $parcours, $isActive);
    } else {
        // Aucun critère de filtrage sélectionné, afficher tous les candidats
        choiceAllOptionWithActive($conn, $isActive);
    }
}








