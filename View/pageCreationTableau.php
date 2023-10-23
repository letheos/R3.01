<!--
TODO pour tout les input de type option, avoir les données de manières dynamique et non fixe
TODO relier au controller qui relie au model
-->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="stylePageCreationTableau.css">
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


<form class="parametre" method="post" action="../Controller/controllerCreationTableau.php">

    <div>

        <section class="menuDeroulFormation">
            <div>
                <label>formation :</label>
                <select name="formations" title="formations">
                    <!-- faire un script js qui ajoute multiple -->
                    <option value="allFormations" selected>toutes les formations</option>
                    <option value="but info">but informatique</option>
                </select>
            </div>
        </section>
        <br>

        <section class="menuDeroulAnnee">
            <div>
                <label>Année </label>
                <select name="formAnnee" title="formAnnee">
                    <option value="all" selected>toutes les années</option>
                    <option value="1">1er</option>
                    <option value="2">2er</option>
                    <option value="3">3er</option>
                </select>
            </div>
        </section>
        <br>

        <section class="menuDeroulParcours">
            <div>
                <label>Parcours de l'étudiant</label>
                <select name="parcours" title="parcours">
                    <option value="allParcours" selected>tous les parcours</option>
                    <option>parcours A</option>
                    <option>parcours B</option>
                    <option>parcours C</option>
                </select>
            </div>
        </section>
        <br>

        <section class="menuDeroulActif">
            <label>Etudiant actif ?</label>
            <div>
                <select name="isActif" title="isActif">
                    <option value="1">oui</option>
                    <option value="0">non</option>
                </select>
            </div>
        </section>

        <section class="menuDeroulPermis">
            <label>Permis</label>
            <div>
                <select name="isPermis" title="isPermis">
                    <option value="1">oui</option>
                    <option value="0">non</option>
                </select>
            </div>
        </section>

        <section>
            <div id="city"> ville
                <label for="city">
                    <select name="city">
                        <option value="allCity">toutes les villes</option>
                        <option value="Lille">Lille</option>
                        <option value="Valenciennes">Valenciennes</option>
                    </select>
                </label>
            </div>

            <div class="slidecontainer">
                <label for="myRange">Distance de recherche :</label>
                <input type="range" min="1" max="100" value="50" class="slider" id="myRange">
                <p>Distance en km : <span id="valeurSlider">50</span></p>

            </div>

            <div class="addCity">
                <label> Ajouter une page de paramètres</label>
                <button type="button" name="addCity">+</button>
            </div>
        </section>
    </div>

    <section>
        <div>

            <button type="submit">
                valider paramètres
            </button>

        </div>
    </section>
</form>


<form method="post" action="../Controller/controllerCreationTableau.php">
    <h2 class="titreAffichage"> valeur pour l'affichage</h2>

    <section class="displayData">
        <div id="checkBoxIne">
            <label for="ine">
                <input type="checkbox" id="ine" value="1"/>
                ine affiché (par défault non)
            </label>
        </div>

        <div id="checkBoxAddress">
            <label>
                <input type="checkbox" id="address" value="1"/>
                adresse affiché (par défault non)
            </label>
        </div>

        <div class="checkBoxPhone">
            <label>
                <input type="checkbox" id="phone" value="1"/>
                numéro de téléphone (par défault non)
            </label>
        </div>
    </section>

    <section class="couleur">
        <div class="colorFond">
            <label for="colorFond">Couleurs du fond</label>
            <input type="color" name="colorFond" id="colorFond">
        </div>
        <div class="colorText">
            <label for="colorText">Couleurs du text</label>
            <input type="color" name="colorText" id="colorText">
        </div>
    </section>
        <button type="submit" id="valider" name="valider">Valider les paramètres</button>
</form>


<section class="bas">

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

</section>

</body>
</html>

<?php
