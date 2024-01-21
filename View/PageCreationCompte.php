<?php
/**
 * Fichier permettant l'affichage de la création d'un candidat
 * @author Nathan Strady
 */
session_start();
include "../Controller/ClassUtilisateur.php";
require "../Controller/ControllerCreationCompte.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);




if (empty($_SESSION['user'])) {
    echo '<script>
        alert("Veuillez vous connecter");
        window.location.href = "../View/PageConnexion.php";
        </script>';
}

$user = unserialize($_SESSION['user']);


if ($user->getRole() == "Chef de service") {
    $formations = getAllFormation();
} else {
    $formations = $user->getLesFormations();
}


?>
<!DOCTYPE html>


<html lang="en">
<head>
    <title>Creation Candidat</title> <!-- Supprimez cette ligne si vous avez déjà une balise <title> plus haut -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="StyleCreationCompte.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <script>
        /**
         * Code qui permet de générer les drapeaux de sélection du numéro
         * @type {Element} Récupère les input qui enregistre le numéro de téléphone
         * Code repris du site : https://www.twilio.com/fr/blog/saisie-numeros-telephone-internationaux-html-javascript
         */
        const phoneInputField = document.querySelector("#typePhone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            preferredCountries: ["fr"],
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    </script>
    <style>
        .bg-custom {
            background-color: #0f94b4;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>


<body>

<header class="banner bg-custom text-white text-center py-4">
    <h1 class="mb-0">
        Nouveau Candidat
    </h1>
    <form action="PageAccueil.php" class="mt-3">
        <button class="btn btn-light" type="submit" name="retourAccueil">Retour à l'accueil</button>
    </form>

    <form action="csv.php">
        <button class="btn btn-light" type="submit">Inserer plusieurs étudiants grace à un CSV</button>
    </form>
</header>

<section class="container mt-5">
    <div class="rounded-box">
        <form id="inscription" method="post" action="../Controller/ControllerCreationCompte.php" enctype="multipart/form-data">
            <header class="mb-3">
                <span class="text-danger">Champs obligatoire(*)</span>
            </header>

            <?php
            if (isset($_SESSION["message"])) {
                if ($_SESSION['success'] == 0) { ?>
                    <div class="alert alert-danger">
                        <?php echo $_SESSION["message"]; ?>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION["message"]; ?>
                    </div>
                    <?php
                }
                unset($_SESSION["message"]);
            }
            ?>


            <div class="container mt-4">
                <div class="card rounded">
                    <div class="card-header bg-custom text-white">
                        Informations du candidat
                    </div>

                    <div class="card-body">
                        <div class="col-md-4">
                            <label> INE </label>
                            <input type="text" id="INE" name="INE" class="form-control" placeholder="INE: 123456789AB" pattern="\d{9}[A-Z]{2}">
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <div class="lastNameForm">
                                    <label for="lastName">Nom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control no-special-chars" id="lastName" name="lastName" placeholder="Nom" required pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s\-']+" title="Saisissez un nom valide">
                                    <div class="invalid-feedback">Saisie invalide. Veuillez utiliser uniquement des lettres, des espaces, des traits d'union et des apostrophes.</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="firstNameForm">
                                    <label for="firstName">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control no-special-chars" id="firstName" name="firstName" placeholder="Prénom" required pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s\-']+" title="Saisissez un prénom valide">
                                    <div class="invalid-feedback">Saisie invalide. Veuillez utiliser uniquement des lettres, des espaces, des traits d'union et des apostrophes.</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="candidateMailForm">
                                    <label for="candidtateEmail">Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control no-special-chars" id="candidateEmail" name="candidateEmail" placeholder="Email"  title="Saisissez un email valide" required>
                                </div>
                            </div>


                                <div class="form-group">
                                    <div class="phoneNumberForm">
                                        <label for="phoneNumber"> Téléphone </label>
                                        <input type="tel" id="typePhone" name="typePhone" class="form-control" value="" placeholder="Télephone" required/>
                                        <input type="hidden" id="formattedPhoneNumber" name="formattedPhoneNumber" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="permisBButton">
                                        <label class="form-check-label" >Permis</label>
                                        <input class="form-check-input" type="radio" name="permisB" id="permisNon" value="0" checked>
                                        <label for="permisNon">Non</label>

                                        <input class="form-check-input" type="radio" name="permisB" id="permisOui" value="1">
                                        <label for="permisOui">Oui</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            <div class="container mt-4">
                <div class="card rounded">
                    <div class="card-header bg-custom text-white">
                        Adresse(s) d'habitation(s) du candidat <span class="text-danger">*</span>
                    </div>

                    <div class="card-body">
                        <div class="adressForm">
                            <p> Adresse 1 </p>
                            <div class="adressFormTemplate">
                                <div class="form-row">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="cp[]" id="cp" placeholder="Code Postal" required>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="address[]" id="address" placeholder="Adresse d'habitation" required>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="cityCandidate[]" id="city" placeholder="Ville" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="adressButton mt-3">
                            <button id="addAddress" class="btn btn-outline-primary" type="button" onclick="addCompleteAddress()"> Ajout adresse </button>
                            <button id="delAddress" class="btn btn-outline-primary" type="button" onclick="delAdressInput()"> Supprimer adresse</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-4">
                <div class="card rounded">
                    <div class="card-header bg-custom text-white">
                        Zone(s) de recherche <span class="text-danger">*</span>
                    </div>

                    <div class="card-body">
                        <div class="form-group cityForm">
                            <div id="citySearch1" name="citySearch1">
                                <label for="citySearch" class="form-label">Zone 1</label>
                                <input type="text" class="form-control" id="citySearch" name="citySearch[]" placeholder="Zone 1" required>

                                <div class="input-group">
                                    <input type="number" id="rayon" name="rayon[]" class="form-control" min="0" step="1" placeholder="Rayon en km" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Km</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group buttonCityForm mt-3">
                            <button class="btn btn-outline-primary" type="button" id="addCityForm" name="addCityForm" onclick="addResearchZone()"> Ajout zone de recherche </button>
                            <button class="btn btn-outline-primary" type="button" id="delCityForm" name="delCityForm" onclick="delReserchZone()"> Supprimer zone de recherche </button>
                        </div>
                    </div>
                </div>
            </div>



            <div class="container mt-4">
                <div class="card rounded">
                    <div class="card-header bg-custom text-white">
                        Les informations de parcours du candidat <span class="text-danger">*</span>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="formation" class="form-label">Choisir le département</label>
                            <select class="form-select" name="formation" id="formation" onchange="onChangeUpdateDisplayParcours('../Controller/ControllerParcoursAffichage.php')">
                                <option value="" selected disabled>Choisir le département</option>
                                <?php
                                $selected = '';
                                $selectedFormation = (isset($_POST['formation'])) ? $_POST['formation'] : '';
                                foreach ($formations as $formation) {
                                    $selected = ($selectedFormation == $formation[0]) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $formation[0]; ?>" <?php echo $selected ?>> <?php echo $formation[0]; ?></option>
                                <?php } ?>
                                <option value="Aucune Option">Aucune Option</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="parcours" class="form-label">Choisir le parcours</label>
                            <select name="parcours" id="parcours" class="form-select" required>
                                <option value="AucuneOption" selected disabled>Choisir le parcours</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="yearOfFormation" class="form-label">Choisir l'année d'étude</label>
                            <select name="yearOfFormation" class="form-select">
                                <option value="" selected disabled>Choisir l'année d'étude</option>
                                <option value="1ère Année">1ère Année</option>
                                <option value="2ème Année">2ème Année</option>
                                <option value="3ème Année">3ème Année</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container mt-4">
                <div class="card rounded">
                    <div class="card-header bg-custom text-white">
                        Type d'Entreprise Recherchées <span class="text-danger">*</span>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="typeCompanySearchForm">
                                    <label for="typeCompanySearch">Type d'Entreprise Recherchées</label>
                                    <textarea id="typeCompanySearch" name="typeCompanySearch" rows="4" class="form-control" placeholder="Saisissez du texte ici"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="downloadButton">
                                    <label for="cv">Insérer le CV ici</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="cv" name="cvFile" accept=".pdf, .png, .jpg, .jpeg">
                                        <label class="custom-file-label" for="cv">Choisir un fichier</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-4">
                <div class="card rounded">
                    <div class="card-header bg-custom text-white">
                        Remarques
                    </div>

                    <div class="card-body">
                        <div class="remarks">
                            <textarea id="text-area" name="remarksText" rows="4" class="form-control" placeholder="Saisissez du texte ici"></textarea>
                        </div>
                    </div>
                </div>
            </div>



            <div class="submitButton mt-4">
                <button class="btn btn-primary" type="submit" id="inscription" name="inscription">Inscription</button>
            </div>
        </form>
    </div>
</section>


<footer class="bg-custom text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div>
                    <p>
                        Timothée Allix, Nathan Strady, Theo Parent, Benjamin Massy, Loïck Morneau
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <p>
                        2023/2024 UPHF
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <!-- <script src="../Controller/js/ControllerAjaxCreationCandidat.js"></script> -->
    <!-- <script src="../Controller/js/ControllerDrag&DropList.js"></script> -->
    <script src="../Controller/js/ControllerBoutonAjout.js"></script>
    <script src="../Controller/js/Ajax.js"></script>

</body>
</html>

