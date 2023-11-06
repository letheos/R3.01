<?php
/**
 * Fichier permettant l'affichage de la création d'un candidat
 * @author Nathan Strady
 */

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
    <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
    />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>


</head>

<body>

    <section>
            <div class="rounded-box">
                <form  id="inscription" method="post" action="../Controller/ControllerCreationCompte.php">
                <header>
                    <h1>
                        Création d'un Candidat
                    </h1>
                    <span class="text-danger">Champs obligatoire(*)</span>
                </header>
                    <?php
                    if(isset($_SESSION["message"])){
                        if ($_SESSION['success'] == 0) {?>
                            <div class="alert alert-danger">
                                <?php echo $_SESSION["message"]; ?>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-success">
                                <?php echo $_SESSION["message"]; ?>
                            </div>
                            <?php
                        }
                        unset($_SESSION["erreur"]);
                        session_destroy();
                    }
                    ?>


                <div class="rounded-box">
                    <header class="rounded-box-title">
                        Informations Candidat
                    </header>
                    <div class="ineForm">
                        <label> INE </label>
                        <input type="text" id="INE" name="INE" class="form-control" placeholder="INE : 123456789AB" pattern = "\d{9}[A-Z]{2}" >

                    </div>

                    <div class="lastNameForm">
                        <label for="lastName">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control no-special-chars" id="lastName" name="lastName" placeholder="Nom" required pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s\-']+" title="Saisissez un nom valide">
                        <div class="invalid-feedback">Saisie invalide. Veuillez utiliser uniquement des lettres, des espaces, des traits d'union et des apostrophes.</div>
                    </div>
                    <div class="firstNameForm">
                        <label for="firstName">Prénom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control no-special-chars" id="firstName" name="firstName" placeholder="Prénom" required pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s\-']+" title="Saisissez un prénom valide">
                        <div class="invalid-feedback">Saisie invalide. Veuillez utiliser uniquement des lettres, des espaces, des traits d'union et des apostrophes.</div>
                    </div>
                    <div class="candidateMailForm">
                        <label for="candidtateEmail">Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control no-special-chars" id="candidateEmail" name="candidateEmail" placeholder="Email"  title="Saisissez un email valide" required>
                    </div>
                    <div class="phoneNumberForm">
                            <label for="phoneNumber"> Téléphone </label>
                            <input type="tel" id="typePhone" name="typePhone" class="form-control" value="" placeholder="Télephone" required/>
                            <input type="hidden" id="formattedPhoneNumber" name="formattedPhoneNumber" value="">
                    </div>

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

                    <div class="permisBButton">
                        <label class="form-check-label" >Permis</label>
                        <input class="form-check-input" type="radio" name="permisB" id="permisNon" value="0" checked>
                        <label for="permisNon">Non</label>

                        <input class="form-check-input" type="radio" name="permisB" id="permisOui" value="1">
                        <label for="permisOui">Oui</label>
                    </div>
                </div>

                <div class="rounded-box">
                    <header class="rounded-box-title">
                        Adresse(s) d'habitation(s) du candidat <span class="text-danger">*</span>
                    </header>

                    <div class="adressForm">
                        <div class="adressFormTemplate">
                            <div class="form-group">
                                <input class="form-control" type="text" name="cp[]" placeholder="Code Postal" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="address[]" placeholder="Adresse d'habitation " required size="50">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="cityCandidate[]" placeholder="Ville" required>
                            </div>
                        </div>
                    </div>
                    <div class="adressButton">
                        <button id="addAddress" class="btn btn-outline-primary" type="button" onclick="addCompleteAddress()"> Ajout adresse </button>
                        <button id="delAddress" class="btn btn-outline-primary" type="button" onclick="delAdressInput()"> Supprimer adresse</button>
                    </div>

                </div>

                <div class="rounded-box">
                    <header class="rounded-box-title">
                        Zone(s) de recherche <span class="text-danger">*</span>
                    </header>
                    <div class="cityForm">
                        <div id="citySearch1" name="citySearch1">
                            <input type="text" class="form-control " id="citySearch" name="citySearch[]" placeholder="Zone 1" required>
                            <label for="rayon">Rayon :</label>
                            <input type="number" id="rayon" name="rayon[]" min="0" step="1" required>
                            <span>Km</span>
                        </div>

                    </div>

                    <div class="buttonCityForm" >
                        <button class="btn btn-outline-primary" type="button" id="addCityForm" name="addCityForm" onclick="addResearchZone()"> Ajout zone de recherche </button>
                        <button class="btn btn-outline-primary" type="button" id="delCityForm" name="delCityForm" onclick="delReserchZone()"> Supprimer zone de recherche </button>
                    </div>
                </div>



                <div class="rounded-box">
                    <header class="rounded-box-title">
                        Formation actuelle du candidat <span class="text-danger">*</span>
                    </header>

                    <div class="choices-container">
                            <?php
                            displayDropdown($conn);
                            ?>

                    </div>

                    <div class="parcoursForm">
                        <select name="parcours" id="parcours" class="form-select" required>
                            <option value="AucuneOption" selected disabled> Choisir le département </option>
                        </select>
                    </div>

                    <div class="yearOfFormationForm">
                        <select name="yearOfFormation" class="form-select">
                            <option value="" selected disabled> Choisir l'année d'étude </option>
                            <option Value="1ère Année"> 1ère Année </option>
                            <option Value="2ème Année"> 2ème Année </option>
                            <option Value="3ème Année"> 3ème Année </option>
                        </select>
                    </div>
                </div>


                     <!-- Commentaire temporaire, demande avis client
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
                    -->


                <div class="rounded-box">
                    <header class="rounded-box-title">
                        Entreprises
                    </header>
                    <div class="typeCompanySearchForm">
                        <label for="typeCompanySearch">Type d'Entreprise Recherchées</label>
                        <textarea id="typeCompanySearch" name="typeCompanySearch" rows="4" cols="50" placeholder="Saisissez du texte ici"></textarea>
                    </div>

                    <div class="downloadButton">
                        <label for="cv">Inserer le cv ici</label>
                        <input type="file"  name="cv" accept=".pdf">
                    </div>
                </div>

                <div class="rounded-box">
                    <header class="rounded-box-title">
                        Remarques
                    </header>
                    <div class="remarks">
                        <textarea id="text-area" name="remarksText" rows="4" cols="50" placeholder="Saisissez du texte ici"></textarea>
                    </div>
                </div>



                <div class="submitButton">
                    <button class="btn btn-outline-primary" type="submit" id="inscription" name="inscription" >Inscription</button>
                </div>

                </form>
            </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <!-- <script src="../Controller/js/ControllerAjaxCreationCandidat.js"></script> -->
    <!-- <script src="../Controller/js/ControllerDrag&DropList.js"></script> -->
    <script src="../Controller/js/ControllerBoutonAjout.js"></script>
    <script src="../Controller/js/Ajax.js"></script>
    <script src="../Controller/js/processFormNumber.js"></script>
</body>
</html>

