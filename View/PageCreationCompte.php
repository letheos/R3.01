<?php
session_start();
?>
<!DOCTYPE html>

<?php
$conn = require '../Model/Database.php';
require '../Controller/ControllerAffichagePage.php';
?>


<html lang="en">
<head>
    <title>Creation Candidat</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Document</title>

    <link rel="stylesheet" href="StyleCreationCompte.css">


</head>

<body>

    <section>
            <div class="rounded-box">+
                <form method="post" action="../Controller/ControllerCreationCompte.php">
                <header>
                    <h1>
                        Création d'un Candidat
                    </h1>
                </header>

                <div class="ineForm">
                    <label for="INE">INE</label>
                    <input type="text" id="INE" name="INE" placeholder="123456789AB" pattern = "\d{9}[A-Za-z]{2}">
                </div>

                <div class="lastNameForm">
                    <label for="lastName">Nom</label>
                    <input type="text" id="lastName" name="lastName" placeholder="nom">
                </div>

                <div class="firstNameForm">
                    <label for="firstName">Prenom</label>
                    <input type="text" id="firstName" name="firstName" placeholder="Prénom">

                </div>

                <div class="adressForm">
                    <label for="address">Adresse</label>
                    <input type="text" id="address" name="address" placeholder="26 rue Girard 59220" >

                </div>

                <div class="cityForm">
                    <label for="City">Ville</label>
                    <input type="text" id="city" name="city" placeholder="Ville">

                </div>

                <div class="radiusSelection">
                    <label for="radius">Rayon de mobilité</label>
                    <input type="range" min="1" max="100" name="radius" id="radius">
                </div>

                <div class="typeCompanySearchForm">
                    <label for="typeCompanyRecherche">Type d'Entreprise Recherchées</label>
                    <textarea id="text-area" name="text" rows="4" cols="50" placeholder="Saisissez du texte ici"></textarea>
                </div>

                <div class="rounded-box">
                    <header class="rounded-box-title">
                        Formation
                    </header>
                    <div class="choices-container">
                            <?php
                            displayCheckboxes($conn);
                            ?>
                    </div>

                    <div class=select-all-container">
                         <label class="label-select-all">
                             <input class="select-all" type="checkbox" id="select-all" name="select-all"> Sélectionner tout
                         </label>
                    </div>

                    <div class="rounded-box formation-list-zone" style="display: none;">
                        <header>Ordre des formations</header>
                        <ol id="formation-list" draggable="true" style="display: none;">
                        </ol>
                    </div>
                </div>

                <div class="parcoursForm">
                    <label for="parcoursForm">Parcours</label>
                    <select name="parcours">
                        <!--A COMPLETER -->
                    </select>
                </div>

                <div class="permisBButton">
                    <label for="permisB">Permis</label>
                    <select name="permisB" size="1">
                        <option value="false">non</option>
                        <option value="true" >oui</option>
                    </select>
                </div>

                <div class="downloadButton">
                    <label for="cv">Inserer le cv ici</label>
                    <input type="file" name="cv" accept=".pdf">

                </div>
                <?php
                error_log($_SESSION["error"]);
                if(isset($_SESSION["error"])){
                    ?>

                    <div class="alert alert-danger">
                        <?php echo $_SESSION["error"]; ?>
                    </div>

                    <?php
                    unset($_SESSION["error"]);
                    session_destroy();
                }
                ?>
                <div class="submitButton">
                    <button  class="btn btn-outline-primary" type="submit" id="submit" name="submit" >Inscription</button>
                </div>
                </form>
            </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="../Controller/orderOfCheck.js"></script>
</body>
</html>
    <?php

/*
    if (isset($_POST['envoyer'])) {
        // Récupération des valeurs du formulaire
        $INE = strtoupper($_POST['INE']);
        $lastName = $_POST['lastName'];
        $firstName = $_POST['firstName'];
        $address = $_POST['address'];
        $ville = $_POST['Ville'];
        $formation = intval($_POST['formation']);
        $typeEntrepriseRecherche = $_POST['typeEntreprises'];
        $permisB = $_POST['permisB'];
        $cv = $_POST['cv'];
        $coord = $_POST['Ville'];
        $radius = $_POST['radius'];





        if (preg_match('/[^A-Za-z0-9"\';]/', $lastName
        )) {
            echo('<div class="alert alert-warning" role="alert">
        le nom contient un caractère spécial
      </div>');
        } elseif (preg_match("/[0-9]/", $lastName
        )) {
            echo('<div class="alert alert-warning" role="alert">
                le nom contient un chiffre
          </div>');
        } elseif (preg_match('/[^A-Za-z0-9"\';]/', $firstName
        )) {
            echo('<div class="alert alert-warning" role="alert">
        le prénom contient un caractère spécial
      </div>');
        } elseif (preg_match("/[0-9]/", $firstName
        )) {
            echo('<div class="alert alert-warning" role="alert">
                le prénom contient un chiffre
          </div>');
        } elseif (preg_match('/^\d{9}[A-Z-a-z]{2}$/', $INE)) {
            // L'INE n'est pas valide
            echo('<div class="alert alert-warning" role="alert">
                Un INE est composé de 9 chiffres suivie de 2 lettres
            </div>');
        }elseif (
            $firstName == null || $lastName == null || $INE == null || $formation == null || $formation == null || $coord == null) {
            echo('<div class="alert alert-warning" role="alert">
        tout les champs de texte doivent être remplis
        </div>');

        }


        //TODO adapter la bdd pour remettre la formation en clé étrangére et faire le code pour avoir automatiquement les formations


    }

*/
?>
