<?php
/**
 * Fichier permettant l'affichage de la création d'un candidat
 * @author Nathan Strady
 */

session_start();

include '../Controller/ClassUtilisateur.php';
require "../Controller/ControllerAffichagePage.php";
$user = unserialize($_SESSION['user']);





?>
    <!DOCTYPE html>

    <?php
    $candidat = getCandidatById($_GET['id']);
    $adresses = explode('; ', $candidat['addresses']);
    $zones = explode(', ', $candidat['zones']);


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
            <form  id="inscription" method="post" action="../Controller/ControllerModifierCandidat.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <header>
                    <h1>
                        Modifier le Candidat
                    </h1>
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
                    unset($_SESSION["message"]);

                }
                ?>


                <div class="rounded-box">
                    <header class="rounded-box-title">
                        Informations Candidat
                    </header>
                    <div class="ineForm">
                        <label> INE </label>
                        <input type="text" id="INE" name="INE" class="form-control" value="<?php echo $candidat['INE'] ?>" placeholder="INE : 123456789AB" pattern = "\d{9}[A-Z]{2}" >

                    </div>

                    <div class="lastNameForm">
                        <label for="lastName">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control no-special-chars" id="lastName" name="lastName" value="<?php echo $candidat['name'] ?>" placeholder="Nom"  pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s\-']+" title="Saisissez un nom valide">
                        <div class="invalid-feedback">Saisie invalide. Veuillez utiliser uniquement des lettres, des espaces, des traits d'union et des apostrophes.</div>
                    </div>
                    <div class="firstNameForm">
                        <label for="firstName">Prénom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control no-special-chars" id="firstName" name="firstName" value="<?php echo $candidat['firstName'] ?>" placeholder="Prénom"  pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s\-']+" title="Saisissez un prénom valide">
                        <div class="invalid-feedback">Saisie invalide. Veuillez utiliser uniquement des lettres, des espaces, des traits d'union et des apostrophes.</div>
                    </div>
                    <div class="candidateMailForm">
                        <label for="candidtateEmail">Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control no-special-chars" id="candidateEmail" name="candidateEmail" value="<?php echo $candidat['candidateMail'] ?>" placeholder="Email"  title="Saisissez un email valide" >
                    </div>
                    <div class="phoneNumberForm">
                        <label for="phoneNumber"> Téléphone </label>
                        <input type="tel" id="typePhone" name="typePhone" class="form-control" value="<?php echo $candidat['phoneNumber'] ?>" placeholder="Télephone" />
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
                        <input class="form-check-input" type="radio" name="permisB" id="permisNon" value="0" <?php echo $candidat['permisB'] == 0 ? 'checked' : '' ?>>
                        <label for="permisNon">Non</label>

                        <input class="form-check-input" type="radio" name="permisB" id="permisOui" value="1" <?php echo $candidat['permisB'] == 1 ? 'checked' : '' ?>>
                        <label for="permisOui">Oui</label>
                    </div>
                </div>

                <div class="rounded-box">
                    <header class="rounded-box-title">
                        Adresse(s) d'habitation(s) du candidat <span class="text-danger">*</span>
                    </header>

                    <div class="adressForm">
                        <?php foreach ($adresses as $adresse): ?>
                            <div class="adressFormTemplate">
                                <?php
                                list($cp, $addressLabel, $city) = explode(', ', $adresse);
                                ?>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="cp[]" placeholder="Code Postal"  value="<?= $cp ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="address[]" placeholder="Adresse d'habitation"  size="50" value="<?= $addressLabel ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="cityCandidate[]" placeholder="Ville"  value="<?= $city ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
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
                        <?php foreach ($zones as $zone): ?>
                            <?php
                            // Divisez la chaîne pour obtenir le nom de la ville et le rayon
                            list($cityName, $rayon) = explode(' (Rayon: ', $zone);
                            // Retirez le " km)" de la valeur du rayon
                            $rayon = rtrim($rayon, ' km)');
                            ?>
                            <div id="citySearch1" name="citySearch1">
                                <input type="text" class="form-control" name="citySearch[]" placeholder="Zone 1"  value="<?= $cityName ?>">
                                <label for="rayon">Rayon :</label>
                                <input type="number" id="rayon" name="rayon[]" min="0" step="1"  value="<?= $rayon ?>">
                                <span>Km</span>
                            </div>
                        <?php endforeach; ?>
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
                        listAffichageSelectUpdate($conn, $candidat);
                        ?>
                    </div>

                    <div class="parcoursForm">
                        <select name="parcours" id="parcours" class="form-select" >
                        </select>
                    </div>

                    <div class="yearOfFormationForm">
                        <select name="yearOfFormation" class="form-select">
                            <option value="" selected disabled> Choisir l'année d'étude </option>
                            <option Value="1ère Année" <?php echo $candidat['yearOfFormation'] === '1ère Année' ? 'selected' : '' ?>> 1ère Année </option>
                            <option Value="2ème Année" <?php echo $candidat['yearOfFormation'] === '2ème Année' ? 'selected' : '' ?>> 2ème Année </option>
                            <option Value="3ème Année" <?php echo $candidat['yearOfFormation'] === '3ème Année' ? 'selected' : '' ?>> 3ème Année </option>
                        </select>
                    </div>
                </div>
                <div class="rounded-box">
                    <header class="rounded-box-title">
                        Entreprises
                    </header>
                    <div class="typeCompanySearchForm">
                        <label for="typeCompanySearch">Type d'Entreprise Recherchées</label>
                        <textarea id="typeCompanySearch" name="typeCompanySearch" rows="4" cols="50" placeholder="Saisissez du texte ici"> <?php echo $candidat['typeCompanySearch'] ?></textarea>
                    </div>

                    <div class="downloadButton">
                        <label for="cv">Inserer le cv ici</label>
                        <input type="file" name="cvFile" id="cv" accept=".pdf, .png, .jpg, .jpeg">
                    </div>

                </div>

                <div class="rounded-box">
                    <header class="rounded-box-title">
                        Remarques
                    </header>
                    <div class="remarks">
                        <textarea id="text-area" name="remarksText" rows="4" cols="50" placeholder="Saisissez du texte ici"> <?php echo $candidat['remarks'] ?></textarea>
                    </div>
                </div>

                <div class="submitButton">
                    <button class="btn btn-outline-primary" type="submit" id="inscription" name="inscription" >Modifier</button>
                </div>

            </form>
        </div>

        <script>
            // Appel initial de la fonction lors du chargement de la page
            document.addEventListener('DOMContentLoaded', function () {
                // Récupère la formation préalablement sélectionnée (si elle existe)
                var selectedFormation = document.getElementById("formation").value;
                var selectedParcours = <?php echo json_encode($candidat['nameParcours']); ?>;
                // Appelle la fonction avec la formation préalablement sélectionnée et le parcours sélectionné
                onChangeUpdateDisplayParcours('../Controller/ControllerParcoursAffichage.php', selectedFormation, selectedParcours);
            });
        </script>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="../Controller/js/ControllerBoutonAjout.js"></script>
    <script src="../Controller/js/Ajax.js"></script>
    <script src="../Controller/js/processFormNumber.js"></script>
    </body>
    </html>

