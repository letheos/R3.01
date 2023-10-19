<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>creationTableauDeBord</title>
</head>
<body>
<section class="parametre">
    <section class="choixTotal">
        <div>
            <form method="post" action="../Controller/controllerCreationTableau.php">
            <section class="menuDeroulFormation">
                <div>
                    <label>formation :</label>
                    <select name="formations" title="formations" >
                        <!-- faire un script js qui ajoute multiple -->
                        <option value="formations" selected>formations</option>
                        <option>but 1</option>
                    </select>
                </div>
            </section>
                <br>
            <section class="menuDeroulAnnee">
                <div>
                    <label>annee </label>
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
                    <label>Etudiant actif ?</label>
                    <select name="parcours" title="parcours">
                        <option value="parcours" selected>parcours</option>
                        <option>but a</option>
                        <option>but d</option>
                        <option>but c</option>
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

                <section>
                    <label> ville</label>
                    <button >ajouter une ville +</button>
                    <div id="city">
                        <select name="city">
                            <option value="Lille">Lille</option>
                            <option value="Valenciennes">Valenciennes</option>
                        </select>
                    </div>

                    <div class="slidecontainer">
                        <input type="range" min="1" max="100" value="50" class="slider" id="myRange">
                    </div>
                </section>
        </div>
    </section>

    <h2> valeur pour l'affichage</h2>

    <section class="affichageEtu">
        <div>
            <label>
                <input type="checkbox" id="ine" value="ine" />
                ine affiché
            </label>
        </div>
        <br>
        <label>
            <input type="checkbox" id="address"  value="address" />
            adresse affiché
        </label>
        </div>

        <div class="permisB">
            <label>adresse affiché</label>
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
            <label>Couleurs du fond</label>
            <input type="color" name="colorText">
        </div>
    </section>
</section>
</body>
</html>

<?php
