<?php
require "../Controller/ControllerCreationTableau.php";
$conn = require "../Model/Database.php";
?>

<!--
TODO pour tout les input de type option, avoir les données de manières dynamique et non fixe*
TODO formation dynamique : en cours
TODO relier au controller qui relie au model
TODO faire un input qui passe avec une api pour la ville
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
        <button type="submit" id="validate" name="validate">Valider les paramètres</button>
    </form>
</header>

<div class=container>
    <div class=column>
        <div class=rounded-box>
            <section class="settingsData" id="settingsData">
                <form class="parametre" method="post" action="../Controller/ControllerAfficheTableau.php">
                    <h2> Paramètres des données à afficher dans le tableau de bord</h2>
                    <!-- section générale des paramètre de données -->
                    <div class="formation">
                        <div class="menuDeroulFormation">
                            <div class="rounded-box">
                                <label for="formations">formation :</label>
                                <select name="formation "
                                        onchange="onChangeUpdateDisplayParcours('/Controller/ControllerParcoursjs.php','formations0','parcours0')"
                                        title="formations" id="formations0">

                                    <option value="allFormations" selected>toutes les formations</option>
                                    <?php
                                    $formations = controllerGetAllFormations($conn);
                                    foreach ($formations as $formation) { ?>
                                        <option value="<?= $formation[0] ?>"><?= $formation[0] ?></option>
                                    <?php } ?>
                                </select>
                                <br>
                                <div class="menuDeroulParcours">
                                    <label for="parcours">Parcours de l'étudiant</label>
                                    <select name="parcours" title="parcours" id="parcours0" onchange="updateYearsOptions('formAnnee0','parcours0')">
                                        <option value="allParcous" selected>tout les parcours</option>
                                    </select>
                                </div>
                                <div class="menuDeroulAnnee">
                                    <label for="formAnnee"> Année</label>
                                  <select name="formAnnee" title="formAnnee" id="formAnnee0">
                                        <option value="allYears" selected>toutes les années</option>
                                        <option value="1">1er</option>
                                        <option value="2">2e</option>
                                        <option value="3">3e</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    for ($x = 1; $x < 4; $x++) {
                        ?>
                        <div class="formation" id="formation<?= $x ?>" style="display: none">
                            <div class="menuDeroulFormation">
                                <div class="rounded-box">
                                    <label>formation :</label>
                                    <select name="formations" title="formations" id="formations<?= $x?>" onchange="onChangeUpdateDisplayParcours('/Controller/ControllerParcoursjs.php', 'formations<?php echo $x ?>', 'parcours<?php echo $x ?>')">
                                        <option value="allFormations" selected>toutes les formations</option>
                                        <?php
                                        $formations = controllerGetAllFormations($conn);
                                        foreach ($formations as $formation) { ?>
                                            <option value="<?php echo $formation[0];?>"><?php echo $formation[0]; ?></option>

                                        <?php } ?>
                                    </select>

                                    <br>
                                    <div class="menuDeroulParcours">
                                        <label>Parcours de l'étudiant</label>
                                        <select name="parcours"
                                                title="parcours"
                                                id="parcours<?= $x?>"
                                                onchange="updateYearsOptions('<?= "formAnnee".$x ?>','<?= "parcours".$x?> ')">
                                            <option value="allParcours" selected> tout les parcours</option>


                                        </select>

                                    </div>
                                    <div class="menuDeroulAnnee">
                                        <label for="formAnnee"> Année </label>
                                        <select name="formAnnee" title="formAnnee" id="formAnnee<?= $x?>">
                                            <option value="allYears" selected>toutes les années</option>
                                            <option value="1">1er</option>
                                            <option value="2">2e</option>
                                            <option value="3">3e</option>
                                        </select>
                                    </div>
                                    <button type="button" onclick="hideformation('formation<?= $x?>')"
                                            id="boutondelete<?= $x?>">supprimer
                                    </button>

                                </div>

                            </div>

                        </div>
                        <?php
                    }
                    ?>
                    <div class="addFormation">
                        <label for="addFormation"> Ajouter une formation</label>
                        <button type="button" name="addFormation" id="addFormation" onclick="">+</button>

                    </div>

                    <br>
                    <br>

                    <div class="menuDeroulPermis">
                        <label for="idPermis">Permis</label>
                        <select name="isPermis" title="isPermis" id="idPermis">
                            <option value="1">oui</option>
                            <option value="0">non</option>
                        </select>
                    </div>
                </form>
            </section>

        </div>
    </div>
    <!--bonnes fermetures de balises -->

    <div class=column>
        <div class=rounded-box>
            <h2 class="titreAffichage"> valeur pour l'affichage</h2>


            <div id="checkBoxIne">
                <input type="checkbox" id="ine" name="isIne" value="1" >
                <label for="ine">ine affiché (par défault non)</label>

                <input hidden="hidden" type="checkbox" id="ine" name="isIne" value="0">
            </div>


            <script>
                function updateValue(checkbox) {
                    var inputElement = document.getElementById('ine');

                    // Si la case à cocher est cochée, utilisez la valeur '1', sinon utilisez une autre valeur
                    var newValue = checkbox.checked ? '1' : 'valeur_alternative';

                    inputElement.value = newValue;

                    console.log("Nouvelle valeur de la case à cocher : " + newValue);
                }
            </script>

            <div id="checkBoxAddress">
                <input type="checkbox" id="address" name="isAddress" value="1">
                <label for="address"> Adresse affichée (par défaut non)</label>

            </div>

            <div class="checkBoxPhone">
                <input type="checkbox" id="phone" name="isPhone" value="1">
                <label for="phone"> numéro de téléphone (par défaut non) </label>

            </div>



        </div>
        <form method="post" action="../Controller/ControllerCreationTableau.php">
        <div class="rounded-box">
            <h2>Role à inclure dans la création du tableau de bord</h2>
            <?php
            $roles = controllerGetAllRole($conn);
            $id=0;
            foreach ($roles as $role){
                $id+=1;

                ?>
            <input type="checkbox" id="<?= 'role'.$id ?>" name="<?= $role[1] ?>" value="1">
            <label for="<?= 'role'.$id ?>"> inclure <?php echo $role[1] ?></label>
                <br>
            <?php
            } ?>
        </form>
        </div>
    </div>

    <div class=column>
        <div class="rounded-box">
            <h2 class="titreAffichage">Paramètres diagrammes</h2>
            <input type="checkbox" id="histo" name="histo" value="1">
            <label for="histo">afficher histogramme</label>
            <br>
            <input type="checkbox" id="graphe" name="graphe" value="1">
            <label for="graphe">afficher graphe effectifs
            </label>
        </div>
    </div>
</div>
    <footer class="bottomBanner">
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

<script src="../Controller/JsCreationTableau.js"></script>
</body>

</html>


