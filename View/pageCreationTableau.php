<!--
TODO pour tout les input de type option, avoir les données de manières dynamique et non fixe
TODO relier au controller qui relie au model
-->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Consider avoiding viewport values that prevent users from resizing documents. from w3 validator-->
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="StylePageCreationTableau.css">
    <title>creationTableauDeBord</title>
    <script src="../Controller/jsCreationTableau.js"></script>
</head>
<body>

<header class="banner">
    <form>
        <h1 class="TexteProfil">
            Création de tableau de bord
        </h1>
        <button class="btn btn-light" type="submit" name="retourAccueil"
                onclick="window.location.href='PageAccueil.php'">Retour à l'accueil
        </button>
    </form>
</header>




        <section class="settingsData" id="settingsData">
            <form class="parametre" method="post" action="../Controller/controllerCreationTableau.php">
            <h2> Paramètres des données à afficher dans le tableau de bord</h2>
           <!-- section générale des paramètre de données -->

            <div class="menuDeroulFormation">
                <label for="formations">formation :</label>
                <select name="formations" title="formations" id="formations">
                    <!-- faire un script js qui ajoute multiple -->
                    <option value="allFormations" selected>toutes les formations</option>
                    <option value="but info">but informatique</option>
                </select>
            </div>

        <br>

            <div class="menuDeroulAnnee">
                <label for="formAnnee"> Année </label>
                <select name="formAnnee" title="formAnnee" id="formAnnee">
                    <option value="all" selected>toutes les années</option>
                    <option value="1">1er</option>
                    <option value="2">2er</option>
                    <option value="3">3er</option>
                </select>
            </div>

        <br>


            <div class="menuDeroulParcours">
                <label for="parcours">Parcours de l'étudiant</label>
                <select name="parcours" title="parcours" id="parcours">
                    <option value="allParcours" selected>tous les parcours</option>
                    <option>parcours A</option>
                    <option>parcours B</option>
                    <option>parcours C</option>
                </select>
            </div>
        <br>



            <div class="menuDeroulActif">
                <label for="idActif">Etudiant actif ?</label>
                <select name="isActif" title="isActif" id="idActif">
                    <option value="1">oui</option>
                    <option value="0">non</option>
                </select>
            </div>


        <div class="menuDeroulPermis">
            <label for="idPermis">Permis</label>
                <select name="isPermis" title="isPermis" id="idPermis">
                    <option value="1">oui</option>
                    <option value="0">non</option>
                </select>
            </div>



            <div class="cityForm">
                <label for="city"> Ville </label>
                    <select name="city" id="city">
                        <option value="allCity">toutes les villes</option>
                        <option value="Lille">Lille</option>
                        <option value="Valenciennes">Valenciennes</option>
                    </select>

            </div>

            <div class="slidecontainer">
                <label for="myRange">Distance de recherche :</label>
                <input type="range" min="1" max="100" value="50" class="slider" id="myRange">
                <p>Distance en km : <span id="valeurSlider">50</span></p>

            </div>

                <div class="addParams">
                    <label for="addParmas"> Ajouter une page de paramètres</label>
                    <button type="button" name="addParmas" id="addParmas" >+</button>
                    <p>nombre de paramètres <span id="nuberSettingsData">1/4</span></p>
                </div>







            </form>
        </section>

<div class="buttonFinishDataSettings">
    <label for="finish">Valider les paramètres de données</label>
    <button type="submit" id="finish">
        valider paramètres
    </button>
</div>

<section class="settingsDisplay">

    <h2 class="titreAffichage"> valeur pour l'affichage</h2>

<form method="post" action="../Controller/controllerCreationTableau.php">

        <div id="checkBoxIne">
            <label for="ine">ine affiché (par défault non)</label>
                <input type="checkbox" id="ine" value="1">
        </div>

        <div id="checkBoxAddress">
            <label for="address"> Adresse affiché (par défault non)</label>
                <input type="checkbox" id="address" value="1">
        </div>

        <div class="checkBoxPhone">
            <label for="phone"> numéro de téléphone (par défault non) </label>
                <input type="checkbox" id="phone" value="1">
        </div>

        <button type="submit" id="valider" name="valider">Valider les paramètres</button>
</form>

</section>

    <footer>
        <div class="nomFooter">
            <p>
                Timothée Allix, Nathan Strady, Theo Parent, Benjamin Massy, Loïck Morneau

            </p>
        </div>
        <div class="origineFooter">
            <p>
                2023/2024 UPHF
            </p>
        </div>
    </footer>



</body>
</html>


