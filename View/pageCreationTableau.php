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
    <h1 class="TexteProfil">
        Création de tableau de bord
    </h1>
    <button class="btn btn-light" type="submit" name="retourAccueil"
            onclick="window.location.href='PageAccueil.php'">Retour à l'accueil
    </button>
</header>


<section class="parametre">
    <section class="choixTotal">
        <div>
            <form method="post" action="../Controller/controllerCreationTableau.php">
                <section class="menuDeroulFormation">
                    <div>
                        <label>formation :</label>
                        <select name="formations" title="formations">
                            <!-- faire un script js qui ajoute multiple -->
                            <option value="formations" selected>formations</option>
                            <option>but 1</option>
                        </select>
                    </div>
                </section>
                <br>

                <section class="menuDeroulAnnee">
                    <div>
                        <label>Année </label>
                        <select name="formAnnee" title="formAnnee">
                            <option value="year" selected>annee</option>
                            <option>1er</option>
                            <option>2er</option>
                            <option>3er</option>
                        </select>
                    </div>
                </section>
                <br>

                <section class="menuDeroulParcours">
                    <div>
                        <label>Parcours de l'étudiant</label>
                        <select name="parcours" title="parcours">
                            <option value="parcours" selected>parcours</option>
                            <option>parcours a</option>
                            <option>parcours d</option>
                            <option>parcours c</option>
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
                    <div class="addCity">
                    <label> AJouter une ville</label>
                    <button type="button" name="addCity">+</button>
                    </div>

                    <div id="city"> ville
                        <label for="city">
                            <select name="city">
                                <option value="Lille">Lille</option>
                                <option value="Valenciennes">Valenciennes</option>
                            </select>
                        </label>
                    </div>

                    <div class="slidecontainer" >
                        <label for="myRange">Distance de recherche :</label>
                        <input type="range" min="1" max="100" value="50" class="slider" id="myRange">
                        <p>Valeur : <span id="valeurSlider">50</span></p>

                    </div>
                </section>
        </div>

        <section>
            <div>
                <form method="post" action="../Controller/controllerCreationTableau.php">
                    <button type="submit">
                        valider paramètres
                    </button>
                </form>
            </div>
        </section>

    </section>

    <h2 class="titreAffichage"> valeur pour l'affichage</h2>

    <section class="affichageEtu">
        <div>
            <label>
                <input type="checkbox" id="ine" value="ine"/>
                ine affiché
            </label>
        </div>
        <br>
        <label>
            <input type="checkbox" id="address" value="address"/>
            adresse affiché
        </label>
        </div>

        <div class="permisB">
            <label for="">adresse affiché</label>
            <select name="permis">
                <option value="avecPermis">oui</option>
                <option value="sansPermis">non</option>
            </select>


        </div>
    </section>

    <section class="couleur">
        <div class="colorFond">
            <label>Couleurs du fond</label>
            <input type="color" name="colorFond">
        </div>
        <div class="colorText">
            <label>Couleurs du text</label>
            <input type="color" name="colorText">
        </div>
    </section>
</section>

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
